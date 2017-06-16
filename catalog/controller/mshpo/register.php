<?php
class ControllerMshpoRegister extends Controller {

	private $error = array();
	
	public function index() {

		error_reporting(0);	
		$this->load->language('account/register');
		$this->load->language('account/success');
		$this->load->language('mshpo/register');
		$this->load->model('account/customer');
		
		
		if (empty($this->request->request["action"]) || empty($this->request->request))
		{	
			header("Content-Type: application/json");
			echo json_encode(array("TYPE" => "Error", "DESC" => "Unknown action", "FIELD" => array("request" => $this->request->request)));
			die();
		}
		
		
		/*запрос на выдачу формы*/
		if($this->request->request['action']=='fields'){

			include $_SERVER['DOCUMENT_ROOT'].'/shop/SxGeo.php';
			$SxGeo = new SxGeo(); // Режим по умолчанию, файл бд SxGeo.dat
			$currentCity = $SxGeo->get($_SERVER["REMOTE_ADDR"])['city']['name_ru'];
		
			header("Content-Type: text/xml; charset=UTF-8");
			$strXml='<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE shop><shop>
			<fields>
				<field name="'.$this->language->get('regform_field_email').'" type="TEXT" code="email" keyboardType="email" necess="true" hint="'.$this->language->get('regform_field_email_hint').'" placeholder=""></field>
				<field name="'.$this->language->get('regform_field_firstname').'" type="TEXT" code="firstname" keyboardType="text" necess="true" hint="'.$this->language->get('regform_field_firstname_hint').'"></field>
				<field name="'.$this->language->get('regform_field_lastname').'" type="TEXT" code="lastname" keyboardType="text" necess="true" hint="'.$this->language->get('regform_field_lastname_hint').'" placeholder=""></field>
				<field name="'.$this->language->get('regform_field_surname').'" type="TEXT" code="surname" keyboardType="text" necess="false" hint="'.$this->language->get('regform_field_surname_hint').'" placeholder=""></field>
				<field name="'.$this->language->get('regform_field_telephone').'" type="TEXT" code="telephone" keyboardType="text" necess="true" hint="'.$this->language->get('regform_field_telephone_hint').'" placeholder=""></field>
				<field name="'.$this->language->get('regform_field_city').'" type="TEXT" code="city" value="'.$currentCity.'" keyboardType="text" necess="true" hint="'.$this->language->get('regform_field_city_hint').'" placeholder=""></field>
				<field name="'.$this->language->get('regform_field_password').'" type="PASSWORD" code="password" keyboardType="password" necess="true" hint="'.$this->language->get('regform_field_password_hint').'" placeholder=""></field>
			</fields>
			</shop>';
	
			echo $strXml;
			die();

		}
		
		/*запрос на регистрацию*/
		if($this->request->request['action']=='reg') {
				
			// $this->request->request['param'] = '{&quot;email&quot;:&quot;2121212121@dddd.com&quot;,&quot;firstname&quot;:&quot;sssssss&quot;,&quot;lastname&quot;:&quot;ssssssssss&quot;,&quot;surname&quot;:&quot;dssddsdsds&quot;,&quot;password&quot;:&quot;1234&quot;}';
			
			$this->request->request['param'] = htmlspecialchars_decode($this->request->request['param']);
			
			//$this->log->write($this->request->request['param']); // write to log
			
			$this->request->request=json_decode($this->request->request['param'],true);

			if ($this->validate()) {
				
				// имя, фамилия и отчество почему то отдельно не пишутся, запишем их в одно поле, как в стандартной регистрации на сайте
				$this->request->request['firstname'] .= " " . $this->request->request['lastname'] . " " . $this->request->request['surname'];
				
				$customer_id = $this->model_account_customer->addCustomer($this->request->request);

				$сustomerGroupId = $this->model_account_customer->getCustomerGroupIdByEmail($this->request->request['email']);
				$discount = "0";
				if ($сustomerGroupId > 2) {
					include $_SERVER['DOCUMENT_ROOT'].'/shop/myscript.php';
					$discount = (String)getCurSale($сustomerGroupId);
				}

				// Clear any previous login attempts for unregistered accounts.
				$this->model_account_customer->deleteLoginAttempts($this->request->request['email']);

				$this->customer->login($this->request->request['email'], $this->request->request['password']);

				// Add to activity log
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $this->request->request['firstname']/*,
					'discount'	  => '3'*/
				);

				$this->model_account_activity->addActivity('register', $activity_data);
				
				header("Content-Type: application/json");
				echo json_encode(array("success"=>"Y",'message'=>$this->language->get('text_success'), 'discount'=>$discount));
				//echo json_encode(array("success"=>"Y",'message'=>$this->language->get('text_success')));
				
			} else {
				
				header("Content-Type: application/json");
				echo json_encode($this->error);
			
			}
			
		}
		
	}

	private function validate() {
	
		if ((utf8_strlen(trim($this->request->request['firstname'])) < 1) || (utf8_strlen(trim($this->request->request['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->request['lastname'])) < 1) || (utf8_strlen(trim($this->request->request['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->request['email']) > 96) || !preg_match($this->config->get('config_mail_regexp'), $this->request->request['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->request['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->request['telephone']) < 3) || (utf8_strlen($this->request->request['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		/*if ((utf8_strlen(trim($this->request->request['address_1'])) < 3) || (utf8_strlen(trim($this->request->request['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}*/

		if ((utf8_strlen(trim($this->request->request['city'])) < 2) || (utf8_strlen(trim($this->request->request['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		// Customer Group
		if (isset($this->request->request['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->request['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->request['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		// Custom field validation
		$this->load->model('account/custom_field');

		/*$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			if ($custom_field['required'] && empty($this->request->request['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
				$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
			}
		}*/

		if ((utf8_strlen($this->request->request['password']) < 4) || (utf8_strlen($this->request->request['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		/*if ($this->request->request['confirm'] != $this->request->request['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}*/

		return !$this->error;
		
	}	

}	
?>