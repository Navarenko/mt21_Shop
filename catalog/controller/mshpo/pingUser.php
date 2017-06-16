<?php
class ControllerMshpoPingUser extends Controller {

	private $error = array();

	protected $discount = "000";
	
	public function index() {

		// echo $this->mshpo->zaJsonit("òåñò"); 
	
		error_reporting(0);
		// header("Content-Type: text/xml; charset=UTF-8");
		
		if(!empty($this->request->request['login']))
			$this->request->request['login']=trim($this->request->request['login']);

		if(!empty($this->request->request['password']))
			$this->request->request['password']=trim($this->request->request['password']);

		$this->load->model('account/customer');
		$this->load->language('account/login');

		if ($this->validate()) {
			echo '1';
			echo $this->discount; //ïîñëåäíèå 3 ñèìâîëà - ñêèäêà â %
		} else {
			
			if(!defined(LANG_CHARSET))
				define("LANG_CHARSET", "UTF-8");
				 
			header("Content-Type: text; charset=" . LANG_CHARSET);
			
			echo $this->mshpo->zaDejsonit($this->error['warning']);
			echo "   "; //ïîñëåäíèå 3 ñèìâîëà - ñêèäêà â %

		}
	
	}

	protected function validate() {
	
		if(empty($this->request->request['login'])||empty($this->request->request['password'])){ 
		
			$this->error['warning'] =  $this->language->get('error_incoming_data');
			
		} else {

			$this->event->trigger('pre.customer.login');

			// Check how many login attempts have been made.
			$login_info = $this->model_account_customer->getLoginAttempts($this->request->request['login']);

			if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
				$this->error['warning'] = $this->language->get('error_attempts');
			}

			// Check if customer has been approved.
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->request['login']);

			$ñustomerGroupId = $this->model_account_customer->getCustomerGroupIdByEmail($this->request->request['login']);
			if ($ñustomerGroupId > 2) {
				include $_SERVER['DOCUMENT_ROOT'].'/shop/myscript.php';
				$this->discount = (String)getCurSale($ñustomerGroupId);
				$this->discount = str_pad($this->discount, 3, "0", STR_PAD_LEFT);
			}

			if ($customer_info && !$customer_info['approved']) {
				$this->error['warning'] = $this->language->get('error_approved');
			}
		
		}
		
		if (!$this->error) {
			if (!$this->customer->login($this->request->request['login'], $this->request->request['password'])) {
				$this->error['warning'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($this->request->request['login']); 
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->request['login']);
			}
		}

		return !$this->error;
		
	}		

}	
?>