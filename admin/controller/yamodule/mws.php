<?php
class ControllerYamoduleMws extends Controller {
	private $error = array();
	const PREFIX_DEBUG = "";
   const ORDERNUMBER = "orderNumber";
	
	public function generate(){
		$this->load->model('yamodule/mws');
		$this->load->model('setting/setting');
		$sid = $this->model_setting_setting->getSetting("ya_kassa_sid");
		$pkey="";
		$csr="";
		$sign = $this->model_yamodule_mws->gen_CSR_PKey(
		array(
			"countryName" => "RU",
			"stateOrProvinceName" => "Russia",
			"localityName" => "Moscow",
			"commonName" => "/business/oc2/yacms-".$sid['ya_kassa_sid'],
		),	$pkey, $csr);
		$this->model_setting_setting->editSetting("yamodule_mws", array("yamodule_mws_pkey" => $pkey, "yamodule_mws_csr" =>$csr, "yamodule_mws_csr_sign" => $sign));
		//$this->response->addHeader('Content-Type: application/json');
		//$this->response->setOutput(json_encode(array('ok')));
	}
	public function upload(){
		$this->load->language('yamodule/mws');
		$json=array();
		if (!empty($this->request->files['file']['name'])) {
			if (substr($this->request->files['file']['name'], -4) != '.cer') {
				$json['error'] = $this->language->get('err_upload_type');
			}
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->request->files['file']['error'];
			}
			if (filesize($this->request->files['file']['tmp_name'])>2048) {
				$json['error'] = $this->language->get('err_upload_size');
			}
		} else {
			$json['error'] = $this->language->get('err_upload_main');
		}
		if (!isset($json['error'])){
			$this->load->model('setting/setting');
			$cert = file_get_contents($this->request->files['file']['tmp_name']);
			$conf = $this->model_setting_setting->getSetting("yamodule_mws");		
			$this->model_setting_setting->editSetting("yamodule_mws", array('yamodule_mws_cert'=>$cert, 'yamodule_mws_pkey'=>$conf['yamodule_mws_pkey']));
		}
		$this->response->addHeader('Content-Type: application/json; charset=utf-8');
		$this->response->setOutput(json_encode($json));
	}
	public function csr(){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=csr_for_yamoney.csr');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');		
		$this->load->model('setting/setting');
		$conf = $this->model_setting_setting->getSetting("yamodule_mws");
		echo $conf['yamodule_mws_csr'];
	}
	
	public function index() {
		$this->load->model('sale/order');
		$this->load->model('setting/setting');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		$is_act_return = (isset($this->request->get['act']) && $this->request->get['act']=='return');
		$order_info = $this->model_sale_order->getOrder($order_id);
		
		if ($order_info) {
			$this->load->language('yamodule/mws');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['btn_return'] = $this->language->get('btn_return');
			$data['text_history_empty'] = $this->language->get('text_history_empty');
			$data['text_invoice_empty'] = $this->language->get('text_invoice_empty');
			//
			$data['text_history'] = $this->language->get('text_history');
			$data['text_return_success'] = $this->language->get('text_return_success');
			
			$data['tbl_head_date'] = $this->language->get('tbl_head_date');
			$data['tbl_head_amount'] = $this->language->get('tbl_head_amount');
			$data['tbl_head_cause'] = $this->language->get('tbl_head_cause');
			
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_cancel'] = $this->language->get('button_cancel');

			$data['tab_return'] = $this->language->get('tab_return');
			$data['text_amount'] = $this->language->get('text_amount');
			$data['text_cause'] = $this->language->get('text_cause');
			
			$data['tab_history'] = $this->language->get('tab_history');

			$data['token'] = $this->session->data['token'];
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$data['text_total'] = $this->language->get('text_total');
			$data['text_return_total'] = $this->language->get('text_return_total');
			$data['lbl_mws_inv'] = $this->language->get('lbl_mws_inv'); 
			
			$errors=array();
			$return_error = array();
			
			$this->load->model('yamodule/mws');
			$this->load->model('yamodule/return');
						
			$conf = $this->model_setting_setting->getSetting("yamodule_mws");
			$sid = $this->model_setting_setting->getSetting("ya_kassa_sid");
			$kassa_active = $this->model_setting_setting->getSetting("ya_kassa_active");
			$test = $this->model_setting_setting->getSetting("ya_kassa_test");
			
			if (!isset($sid['ya_kassa_sid']) || $sid['ya_kassa_sid']<=0) $errors[]=$this->language->get('err_mws_shopid');
			if ($kassa_active['ya_kassa_active'] != true) $errors[]=$this->language->get('err_mws_kassa');
			
			$this->model_yamodule_mws->demo = ($test["ya_kassa_test"]==true);
			$this->model_yamodule_mws->shopId = $sid['ya_kassa_sid'];
			$this->model_yamodule_mws->PkeyPem = (isset($conf['yamodule_mws_pkey']))?$conf['yamodule_mws_pkey']:'';
			$this->model_yamodule_mws->CertPem = (isset($conf['yamodule_mws_cert']))?$conf['yamodule_mws_cert']:'';
			
			$payment = $this->model_yamodule_mws->request('listOrders', array("orderNumber" => self::PREFIX_DEBUG.$order_id), false, false);
			if (!isset($payment['invoiceId'])) $errors[]=$this->language->get('err_mws_listorder');
			
			if (!$errors && $this->request->server['REQUEST_METHOD'] == 'POST' && $is_act_return && isset($this->request->post['return_sum'])){
				$amount = str_replace(',','.',$this->request->post['return_sum']);
				$cause  = $this->request->post['return_cause'];
				if (strlen($cause)>100 || strlen($cause)<3) $return_error[] = $this->language->get('err_mws_cause');
				if ($amount>$payment['orderSumAmount']) $return_error[] = $this->language->get('err_mws_amount');
				if (!$return_error){
					$respPayment = $this->model_yamodule_mws->request('returnPayment', array('invoiceId'=> $payment['invoiceId'], 'amount'=>	$amount, 'cause'=>$cause));
					if (isset($respPayment['status'])){
						$this->model_yamodule_return->addReturn(array(
							'amount'=>$amount,
							'cause'=>$cause,
							'request'=>$this->model_yamodule_mws->txt_request || 'NULL',
							'response'=>$this->model_yamodule_mws->txt_respond || 'NULL',
							'status'=>$respPayment['status'],
							'error' => $respPayment['error'],
							'invoice_id'=>$payment['invoiceId']
						));
						if($respPayment['status']==0) {
							$data['return_success'] = true;
						} else{
							$data['return_error'] = array($this->model_yamodule_mws->getErr($respPayment['error']));
						}
					}
				}else{
					$data['return_error'] = $return_error;
				}
			}

			$inv = (isset($payment['invoiceId']))?$payment['invoiceId']:0;
			$inv_sum = (isset($payment['orderSumAmount']))?$payment['orderSumAmount']:0;
			$inv_type = (isset($payment['paymentType']))?$payment['paymentType']:"none";
			$data['return_items'] = $this->model_yamodule_return->getSuccessReturns($inv);
			$sum_returned = $this->model_yamodule_return->sum;
			$data['invoiceId'] = $inv;
			
			$data['return_sum_symbol']	= $this->currency->getSymbolRight();
			$data['return_sum'] = number_format(floatval ($inv_sum - $sum_returned),2, '.', '');
			$data['order_total'] = $this->currency->format($inv_sum, $order_info['currency_code'], $order_info['currency_value']);
			$data['payment_method'] = $this->language->get('text_method_'.$inv_type)." (".$inv_type.")";
			
			$url = '';
			$data['return_total'] = $this->currency->format($sum_returned, $order_info['currency_code'], $order_info['currency_value']);
			$data['form_return_url'] = $this->url->link('yamodule/mws', 'order_id='.$order_id.'&act=return&token=' . $this->session->data['token'], 'SSL');
			$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$data['order_id'] = $this->request->get['order_id'];
			$data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
			
			$this->load->model('localisation/order_status');
			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);
			if ($order_status_info) {
				$data['order_status'] = $order_status_info['name'];
			} else {
				$data['order_status'] = '';
			}
			if (isset($this->request->get['order'])) $url .= 'order=' . $this->request->get['order'];
			
			$data['mws_order_error'] = $errors; 
			$data['breadcrumbs'] = array();
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('yamodule/mws', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
			
			$this->response->setOutput($this->load->view('yamodule/mws_info.tpl', $data));
		
		}else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found.tpl', $data));
		}
	}
}
?>