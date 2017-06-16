<?php
class ControllerMshpoCreateOrder extends Controller {

	public function index() {
		
		// self::success();
		// return;
		
		error_reporting(0);
		$this->load->model('account/customer');
		$this->load->model('catalog/product');
		$this->load->language('mshpo/createOrder');
		
		/*нужно очистить корзину, заполнить ее пришедшими продуктами и авторизовать юзера*/

		// разлогиниваем, если есть стара€ авторизаци€
		if ($this->customer->isLogged()) {
		
			$this->event->trigger('pre.customer.logout');

			$this->customer->logout();
			
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$this->event->trigger('post.customer.logout');

		}
		
			
		// валидаци€ на пришедшие данные
		global $params;
		$this->request->request['param'] = htmlspecialchars_decode($this->request->request['param']);
		 
		// if($this->request->request['test'])
			// $this->request->request['param'] = '{"PASSWORD":"test5555","IPOLMSHP_TOKEN":"APA91bFes0x5KlSzx240nTf-9NPoL4U6mWQSzPajqOcfhTUxyYKWt8ycWZ4UXl07RgMIgQcOOlyXdqsHvR6UPemd8O2Tz5r7kd9My79ZzYNABZat3Y5tqoQ","IPOLMSHP_UDID":"a233229dd37a2145","LOGIN":"test5@test.com","new_auth_system":"1","Offers":{"0":{"count":1,"id":299,"price":66142.1757}}}';
		 
		$params=json_decode($this->request->request['param'],true);
		
		$this->log->write($this->request->request); // write to log
		
		/*test data*/
		if($this->request->request['test']) {
		
			$params['LOGIN'] = "sahalin9@mail.ru";
			$params['PASSWORD'] = "dbc796ff87";
			
			$params['Offers'] = array(
			
				array("id"=>299, "price"=>68272.93923, "count"=>1), // ќртопедический набор, полный
			
			);
		
		}
		
		if(count($params['Offers'])==0 /* && !$this->request->request['ORDER_ID']*/ ){
			$data['error_die'] = $this->language->get('err_empty_data');
		}			
		if(!$this->customer->login(trim($params['LOGIN']), $params['PASSWORD'])){			
			$data['error_die'] = $this->language->get('err_wrong_login_or_password');
		}
		
		
		// заполн€ем корзину продуктами

		//проверка на количество (пока не нужно)
		// if(COPtion::GetOptionString($module_id,"TIAQUANTITY",'N')=='Y')
			// $TIAQUANTITY=true;		
		
		// очистим корзину, если в ней есть товары
		if($this->cart->hasProducts())
			$this->cart->clear();		
		
		foreach($params['Offers'] as $value){
			
			$prod = $this->model_catalog_product->getProduct($value['id']);
			
			if(!$prod){
				$data["arMSHPErrors"][]=$this->language->get('err_no_found_product')." \"".$value['id']."\"";
				continue;
			}
			
			if(empty($prod['price'])){
				$data["arMSHPErrors"][]=$this->language->get('err_no_found_price')." \"".$prod['name']."\"";
				continue;
			}
			elseif(floatval(round($prod['price'], 0))!=floatval(round($value['price'], 0)))
				$data["arMSHPErrors"][]=$this->language->get('err_change_price_1')." ".$prod['name']." ".$this->language->get('err_change_price_2')." ".$this->currency->format(round($value['price'], 0))." ".$this->language->get('err_change_price_3')." ".$this->currency->format(round($prod['price'], 0));
			
			if (isset($value['count'])) {
				$quantity = $value['count'];
			} else {
				$quantity = 1;
			}			
			
			$commonPrice+=floatval($prod['price'])*floatval($quantity);
			
			//проверка на количество (пока не нужно)
			// if($TIAQUANTITY && $goods['CATALOG_QUANTITY']<$value['count']){
				// $data["arMSHPErrors"][]="Ќет товара на складе \"".mshpdriver::zajsonit($goods['NAME'])."\"";
				// continue;
			// }
			// else
			// {
			
				if (isset($prod['option'])) {
					$option = $prod['option'];
				} else {
					$option = array();
				}
				
				// $this->mshpo->pre($prod);
				
				$res = $this->cart->add($prod['product_id'], $quantity, $option);
				
				// $this->mshpo->pre($res);
				
			// }
			
			$minPrice = $this->config->get('mshpo_min_price');
			$minPrice = !empty($minPrice) ? $minPrice : 0;
			if(floatval($minPrice) > $commonPrice /*&& !$this->request->request['ORDER_ID']*/ ){
			
				$data['error_die'] = $this->language->get('err_min_price') . ": " . $this->currency->format($minPrice); 
				
			}		
			
		}
		
		/**/
		
		if(!$data['error_die']) {
			
			// Validate minimum quantity requirements.
			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$this->response->redirect($this->url->link('checkout/cart'));
				}
			}

			$this->load->language('checkout/checkout');

			$this->document->setTitle($this->language->get('heading_title'));

			/*перенесено в header статикой*/ 
			// $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
			// $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/locale/'.$this->session->data['language'].'.js');
			// $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			// $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
			// $this->document->addStyle('catalog/view/theme/basecart/css/main.css');
			
			// Required by klarna
			// if ($this->config->get('klarna_account') || $this->config->get('klarna_invoice')) {
				// $this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
			// }

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_checkout_option'] = $this->language->get('text_checkout_option');
			$data['text_checkout_account'] = $this->language->get('text_checkout_account');
			$data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
			$data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
			$data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');
			$data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');
			$data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];
				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			$data['logged'] = $this->customer->isLogged();

			if (isset($this->session->data['account'])) {
				$data['account'] = $this->session->data['account'];
			} else {
				$data['account'] = '';
			}

			$data['shipping_required'] = $this->cart->hasShipping();

			$data['header'] = $this->load->controller('mshpo/header');
		
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mshpo/checkout.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/mshpo/checkout.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/mshpo/checkout.tpl', $data));
		}
		
	}

	public function success() {

		// $this->load->language('checkout/success');
		$this->load->language('mshpo/createOrder');

		 if (isset($this->session->data['order_id'])) {
		 
			$this->load->model('yamodel/pokupki');
			$data['script_order'] = $this->model_yamodel_pokupki->getscript($this->session->data['order_id']);
			
			$this->cart->clear();

			// Add to activity log
			$this->load->model('account/activity');

			if ($this->customer->isLogged()) {
				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
					'order_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_account', $activity_data);
			} else {
				$activity_data = array(
					/*'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],*/
					'order_id' => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_guest', $activity_data);
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
			
		}

		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		$data['contact_message'] = $this->language->get('contact_message');
		$data['button_main'] = $this->language->get('button_main');
		
		$data['header'] = $this->load->controller('mshpo/header');
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mshpo/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/mshpo/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/mshpo/success.tpl', $data));
		}	

	}
	
	public function failure() {
	
		$this->load->language('checkout/failure');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['header'] = $this->load->controller('mshpo/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mshpo/failure.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/mshpo/failure.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/mshpo/failure.tpl', $data));
		}
		
	}

}	
?>