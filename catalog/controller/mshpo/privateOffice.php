<?php
class ControllerMshpoPrivateOffice extends Controller {

	private $arrayOfOrders=array();
	private $arrayOfStats=array();//статусы заказов
	private $stat; // статус неактивности заказа
	
	public function index() {
		
		error_reporting(0);
		header("Content-Type: text/html; charset=utf-8");
		
		
		/*test data*/
		if($_GET["test"]) {
			$this->request->request['LOGIN'] = "sahalin9@mail.ru";
			$this->request->request['PASSWORD'] = "123321";
			$this->request->request['udid'] = "5432452453545g4546";
		}
		/**/
		
		$this->log->write($this->request->request); // write to log
		// $this->log->write($_POST); // write to log
		
		// if(!$this->request->request['udid'])
			// $this->arrayOfOrders["error"]["err7"] = "Error receiving udid";
		// else {
			
			if($this->request->request['LOGIN'])
				$this->request->request['LOGIN']=trim($this->request->request['LOGIN']);

			if($this->request->request['PASSWORD'])
				$this->request->request['PASSWORD']=trim($this->request->request['PASSWORD']);
				
		// }

		$this->load->model('account/customer');
		$this->load->model('account/order');
		$this->load->model('localisation/order_status');
		$this->load->language('account/order');
		
		$orderStates = $this->model_localisation_order_status->getOrderStatuses();
		foreach($orderStates as $status)
			$this->arrayOfStats[$status["name"]] = $status["order_status_id"];
			
		$this->stat=$this->config->get('mshpo_order_status');
		
		if($this->request->request['LOGIN'] && $this->customer->login($this->request->request['LOGIN'], $this->request->request['PASSWORD']))
		{
			
			$orderObject = $this->model_account_order->getOrders(0, 1000);
			$this->getOrderArray($orderObject,'mobile');
			
		}
		else $this->arrayOfOrders["error"]["err5"] = "Authorization error";			
				
		
		/*$ordersOfToken=CSaleOrderPropsValue::GetList(array(),array('CODE'=>'IPOLMSHP_OPEN_ID','VALUE' => trim($_POST['udid'])));
		$arrayOfTokenorders=array();
		while($order=$ordersOfToken->Fetch())
			$arrayOfTokenorders[]=$order['ORDER_ID'];

		if(count($arrayOfTokenorders)>0)
		{
			$orderObject=CSaleOrder::GetList(array(),array('ID'=>$arrayOfTokenorders));
			getOrderArray($orderObject,$arrayOfOrders,'mobile');
		}*/
		
		if((count($this->arrayOfOrders)<=0) || (count($this->arrayOfOrders)==1 && $this->arrayOfOrders['error']))
			$arrayOfOrders["error"]["err6"] = "No orders";
		
		krsort($this->arrayOfOrders);
		
		$this->log->write(json_encode($this->arrayOfOrders)); // write to log
		
		echo json_encode($this->arrayOfOrders);
		
		// $this->mshpo->pre($this->arrayOfOrders);
		
		
		
	}

	private function getOrderArray($orderObject,$from)
	{
		foreach($orderObject as $order)
		{
			$archieveStat=0;
			if($this->arrayOfStats[$order['status']]==$this->stat)
				$archieveStat=1;
			
			$this->arrayOfOrders[$order['order_id']]=array(
				"Date" => date($this->language->get('date_format_short'), strtotime($order['date_added'])),
				"Status" => $order['status'],
				"Price" => round($order['total'], 0),
				"From" => $from,
				"Archive" => $archieveStat,
			);

			$products = $this->model_account_order->getOrderProducts($order['order_id']);

			$this->arrayOfOrders[$order['order_id']]['Goods']=array();
			foreach($products as $good)
			{

				// $product_info = $this->model_catalog_product->getProduct($good['product_id']);
				
				$this->arrayOfOrders[$order['order_id']]['Goods'][$good['product_id']]=array(
					"Name" => htmlspecialchars_decode($good['name']),
					"Quan" => $good['quantity'],
					"Price" => round($good['total'], 0),
					"Available" => "Y",/**/
				);

				/*if($tmpEl=CIblockElement::GetById($good['PRODUCT_ID'])->Fetch())
					if($tmpEl['ACTIVE']=='Y')
						$this->arrayOfOrders[$order['ID']]['Goods'][$good['PRODUCT_ID']]['Available']='Y';
					else
						$this->arrayOfOrders[$order['ID']]['Goods'][$good['PRODUCT_ID']]['Available']='N';
				else
					$this->arrayOfOrders[$order['ID']]['Goods'][$good['PRODUCT_ID']]['Available']='N';*/
				
			}
			
			if(count($this->arrayOfOrders[$order['order_id']]['Goods'])<1)
				unset($this->arrayOfOrders[$order['order_id']]);
			
		}
	}	
	
}