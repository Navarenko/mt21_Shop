<?php
class ControllerModuleMshpo extends Controller {
	private $error = array();

	public function index() {

		// $this->load->model('module/mshpo');
		// $this->model_module_mshpo->show("ipol_mshpPush");
		
		$this->load->language('module/mshpo');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		// $this->document->deleteScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		// $this->document->deleteStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('mshpo', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			// $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		 
		/*lang data*/
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_min_price'] = $this->language->get('entry_min_price');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_banner_time'] = $this->language->get('entry_banner_time');
		$data['entry_url_uppstore'] = $this->language->get('entry_url_uppstore');
		$data['entry_url_googleplay'] = $this->language->get('entry_url_googleplay');
		$data['entry_url_appid'] = $this->language->get('entry_url_appid');
		$data['entry_url_appargument'] = $this->language->get('entry_url_appargument');
		$data['entry_url_uppstore_help'] = $this->language->get('entry_url_uppstore_help');
		$data['entry_url_googleplay_help'] = $this->language->get('entry_url_googleplay_help');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_banner_iphone'] = $this->language->get('entry_banner_iphone');
		$data['entry_banner_ipad'] = $this->language->get('entry_banner_ipad');
		$data['entry_push_status'] = $this->language->get('entry_push_status');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['empty_option'] = $this->language->get('empty_option');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['entry_order_status'] = $this->language->get('entry_order_status_noactive');
		$data['tab_settings'] = $this->language->get('tab_settings');
		$data['tab_statistic'] = $this->language->get('tab_statistic');
		$data['tab_push'] = $this->language->get('IPOLMSHP_TAB_PUSH');
		//statistic 
		$data['IPOLMSHP_STAT_TERMS_SPECIAL'] = $this->language->get('IPOLMSHP_STAT_TERMS_SPECIAL');
		$data['IPOLMSHP_TAB_STAT'] = $this->language->get('IPOLMSHP_TAB_STAT');
		$data['IPOLMSHP_TAB_STAT_TITLE'] = $this->language->get('IPOLMSHP_TAB_STAT_TITLE');
		$data['IPOLMSHP_POPUP_FIRSTVISIT'] = $this->language->get('IPOLMSHP_POPUP_FIRSTVISIT');
		$data['IPOLMSHP_POPUP_LASTVISIT'] = $this->language->get('IPOLMSHP_POPUP_LASTVISIT');
		$data['IPOLMSHP_POPUP_UNIC'] = $this->language->get('IPOLMSHP_POPUP_UNIC');
		$data['IPOLMSHP_STAT_WEEKDAYS'] = $this->language->get('IPOLMSHP_STAT_WEEKDAYS');
		$data['IPOLMSHP_STAT_MONTHDAYS'] = $this->language->get('IPOLMSHP_STAT_MONTHDAYS');
		$data['IPOLMSHP_STAT_TERMS'] = $this->language->get('IPOLMSHP_STAT_TERMS');
		$data['IPOLMSHP_STAT_TERMS_APPEAR'] = $this->language->get('IPOLMSHP_STAT_TERMS_APPEAR');
		$data['IPOLMSHP_STAT_TERMS_TODAY'] = $this->language->get('IPOLMSHP_STAT_TERMS_TODAY');
		$data['IPOLMSHP_STAT_TERMS_WEEK'] = $this->language->get('IPOLMSHP_STAT_TERMS_WEEK');
		$data['IPOLMSHP_STAT_TERMS_MONTH'] = $this->language->get('IPOLMSHP_STAT_TERMS_MONTH');
		$data['IPOLMSHP_STAT_TERMS_YEAR'] = $this->language->get('IPOLMSHP_STAT_TERMS_YEAR');
		$data['IPOLMSHP_STAT_TERMS_WHOLE'] = $this->language->get('IPOLMSHP_STAT_TERMS_WHOLE');
		$data['IPOLMSHP_STAT_SPECIAL'] = $this->language->get('IPOLMSHP_STAT_SPECIAL');
		$data['IPOLMSHP_STAT_TERMS_PERIOD'] = $this->language->get('IPOLMSHP_STAT_TERMS_PERIOD');
		$data['IPOLMSHP_STAT_TERMS_REGISTER'] = $this->language->get('IPOLMSHP_STAT_TERMS_REGISTER');
		$data['IPOLMSHP_STAT_TERMS_LAST'] = $this->language->get('IPOLMSHP_STAT_TERMS_LAST');
		$data['IPOLMSHP_STAT_FROM'] = $this->language->get('IPOLMSHP_STAT_FROM');
		$data['IPOLMSHP_STAT_TO'] = $this->language->get('IPOLMSHP_STAT_TO');
		$data['IPOLMSHP_STAT_SETUPS'] = $this->language->get('IPOLMSHP_STAT_SETUPS');
		$data['IPOLMSHP_STAT_SETUPS_UNIC'] = $this->language->get('IPOLMSHP_STAT_SETUPS_UNIC');
		$data['IPOLMSHP_STAT_SETUPS_UDID'] = $this->language->get('IPOLMSHP_STAT_SETUPS_UDID');
		$data['IPOLMSHP_STAT_SETUPS_DETAIL'] = $this->language->get('IPOLMSHP_STAT_SETUPS_DETAIL');
		$data['IPOLMSHP_STAT_SETUPS_NONOTOKEN'] = $this->language->get('IPOLMSHP_STAT_SETUPS_NONOTOKEN');
		$data['IPOLMSHP_STAT_SHOW'] = $this->language->get('IPOLMSHP_STAT_SHOW');
		$data['IPOLMSHP_STAT_CLEAR_STAT'] = $this->language->get('IPOLMSHP_STAT_CLEAR_STAT');
		$data['IPOLMSHP_STAT_CLEAR_DATE'] = $this->language->get('IPOLMSHP_STAT_CLEAR_DATE');
		$data['IPOLMSHP_STAT_CLEAR'] = $this->language->get('IPOLMSHP_STAT_CLEAR');
		$data['IPOLMSHP_STAT_WNDSND'] = $this->language->get('IPOLMSHP_STAT_WNDSND');
		$data['IPOLMSHP_STAT_WDBESNDD_1'] = $this->language->get('IPOLMSHP_STAT_WDBESNDD_1');
		$data['IPOLMSHP_STAT_WDBESNDD_2'] = $this->language->get('IPOLMSHP_STAT_WDBESNDD_2');
		$data['IPOLMSHP_STAT_ERRCHSTOK'] = $this->language->get('IPOLMSHP_STAT_ERRCHSTOK');
		$data['IPOLMSHP_STAT_LEFT'] = $this->language->get('IPOLMSHP_STAT_LEFT');
		$data['IPOLMSHP_STAT_TOMCH'] = $this->language->get('IPOLMSHP_STAT_TOMCH');
		$data['IPOLMSHP_STAT_SIGNS'] = $this->language->get('IPOLMSHP_STAT_SIGNS');
		$data['IPOLMSHP_STAT_ERRMCHPUSH'] = $this->language->get('IPOLMSHP_STAT_ERRMCHPUSH');
		$data['IPOLMSHP_STAT_ERRNOPUSH'] = $this->language->get('IPOLMSHP_STAT_ERRNOPUSH');
		$data['IPOLMSHP_STAT_PUSHDONE'] = $this->language->get('IPOLMSHP_STAT_PUSHDONE');
		$data['IPOLMSHP_STAT_PUSHSQLERR'] = $this->language->get('IPOLMSHP_STAT_PUSHSQLERR');
		$data['IPOLMSHP_STAT_PUSHSNDERR'] = $this->language->get('IPOLMSHP_STAT_PUSHSNDERR');
		$data['IPOLMSHP_STAT_PUSHFAILURE'] = $this->language->get('IPOLMSHP_STAT_PUSHFAILURE'); 
		//push-history
		$data['IPOLMSHP_TAB_PUSH'] = $this->language->get('IPOLMSHP_TAB_PUSH');
		$data['IPOLMSHP_TAB_PUSH_TITLE'] = $this->language->get('IPOLMSHP_TAB_PUSH_TITLE');
		$data['IPOLMSHP_PUSH_HIDE'] = $this->language->get('IPOLMSHP_PUSH_HIDE');
		$data['IPOLMSHP_PUSH_FILTER'] = $this->language->get('IPOLMSHP_PUSH_FILTER');
		$data['IPOLMSHP_PUSH_TABLE'] = $this->language->get('IPOLMSHP_PUSH_TABLE');
		$data['IPOLMSHP_PUSH_TERMS'] = $this->language->get('IPOLMSHP_PUSH_TERMS');
		$data['IPOLMSHP_PUSH_TOKENS'] = $this->language->get('IPOLMSHP_PUSH_TOKENS');
		$data['IPOLMSHP_PUSH_DOFILT'] = $this->language->get('IPOLMSHP_PUSH_DOFILT');
		$data['IPOLMSHP_STAT_ERRPUSHCK'] = $this->language->get('IPOLMSHP_STAT_ERRPUSHCK');
		$data['IPOLMSHP_STAT_CONFIRM_DEL_PERIOD_1'] = $this->language->get('IPOLMSHP_STAT_CONFIRM_DEL_PERIOD_1');
		$data['IPOLMSHP_STAT_CONFIRM_DEL_PERIOD_2'] = $this->language->get('IPOLMSHP_STAT_CONFIRM_DEL_PERIOD_2');
		$data['IPOLMSHP_STAT_CONFIRM_DEL_ALL'] = $this->language->get('IPOLMSHP_STAT_CONFIRM_DEL_ALL');
		$data['IPOLMSHP_STAT_WNDTITLE'] = $this->language->get('IPOLMSHP_STAT_WNDTITLE');
		$data['IPOLMSHP_PUSH_DATE'] = $this->language->get('IPOLMSHP_PUSH_DATE');
		$data['IPOLMSHP_PUSH_TEXT'] = $this->language->get('IPOLMSHP_PUSH_TEXT');
		$data['IPOLMSHP_PUSH_GOT'] = $this->language->get('IPOLMSHP_PUSH_GOT');
		$data['IPOLMSHP_PUSH_SHOW'] = $this->language->get('IPOLMSHP_PUSH_SHOW');
		$data['IPOLMSHP_PUSH_NOSTAT'] = $this->language->get('IPOLMSHP_PUSH_NOSTAT');
		$data['IPOLMSHP_PUSH_SELALL'] = $this->language->get('IPOLMSHP_PUSH_SELALL');
		$data['IPOLMSHP_PUSH_DELPUSH'] = $this->language->get('IPOLMSHP_PUSH_DELPUSH');
		$data['IPOLMSHP_STAT_DELDONE'] = $this->language->get('IPOLMSHP_STAT_DELDONE');
		//Blocks
		$data['IPOLMSHP_RUSPREG'] = $this->language->get('IPOLMSHP_RUSPREG');
		$data['IPOLMSHP_ADDNEW'] = $this->language->get('IPOLMSHP_ADDNEW');
		$data['IPOLMSHP_BLOCKS_TYPE'] = $this->language->get('IPOLMSHP_BLOCKS_TYPE');
		$data['IPOLMSHP_BLOCKS_TEXT'] = $this->language->get('IPOLMSHP_BLOCKS_TEXT');
		$data['IPOLMSHP_BLOCKS_PROD'] = $this->language->get('IPOLMSHP_BLOCKS_PROD');
		$data['IPOLMSHP_BLOCKS_CAT'] = $this->language->get('IPOLMSHP_BLOCKS_CAT');
		$data['IPOLMSHP_BLOCKS_TITLE'] = $this->language->get('IPOLMSHP_BLOCKS_TITLE');
		$data['IPOLMSHP_BLOCKS_IBLOCK'] = $this->language->get('IPOLMSHP_BLOCKS_IBLOCK');
		$data['IPOLMSHP_FILTER'] = $this->language->get('IPOLMSHP_FILTER');
		

		/*stat urls*/
		$data['pathToAjaxStat'] = "/shop/index.php?route=mshpo/ajax/statistics";
		$data['pathToAjaxPush'] = "/shop/index.php?route=mshpo/ajax/push";
		
		
		/*saves show errors*/
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['min_price'])) {
			$data['error_min_price'] = $this->error['min_price'];
		} else {
			$data['error_min_price'] = '';
		}
		
		if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = '';
		}		
		
		if (isset($this->error['banner_time'])) {
			$data['error_banner_time'] = $this->error['banner_time'];
		} else {
			$data['error_banner_time'] = '';
		}
		
		if (isset($this->error['url_uppstore'])) {
			$data['error_url_uppstore'] = $this->error['url_uppstore'];
		} else {
			$data['error_url_uppstore'] = '';
		}

		if (isset($this->error['url_googleplay'])) {
			$data['error_url_googleplay'] = $this->error['url_googleplay'];
		} else {
			$data['error_url_googleplay'] = '';
		}

		if (isset($this->error['url_appid'])) {
			$data['error_url_appid'] = $this->error['url_appid'];
		} else {
			$data['error_url_appid'] = '';
		}			

		if (isset($this->error['url_appargument'])) {
			$data['error_url_appargument'] = $this->error['url_appargument'];
		} else {
			$data['error_url_appargument'] = '';
		}	
		
		/*breadcrumbs*/
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/mshpo', 'token=' . $this->session->data['token'], 'SSL')
		);

		/*links*/
		$data['action'] = $this->url->link('module/mshpo', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		/*config data*/
		if (isset($this->request->post['mshpo_order_status'])) {
			$data['mshpo_order_status'] = $this->request->post['mshpo_order_status'];
		} else {
			$data['mshpo_order_status'] = $this->config->get('mshpo_order_status');
		}		
		
		if (isset($this->request->post['mshpo_status'])) {
			$data['mshpo_status'] = $this->request->post['mshpo_status'];
		} else {
			$data['mshpo_status'] = $this->config->get('mshpo_status');
		}

		if (isset($this->request->post['mshpo_min_price'])) {
			$data['min_price'] = $this->request->post['mshpo_min_price'];
		}
		else {
			$data['min_price'] = $this->config->get('mshpo_min_price');
		}
		
		if (isset($this->request->post['mshpo_phone'])) {
			$data['phone'] = $this->request->post['mshpo_phone'];
		}
		else {
			$data['phone'] = $this->config->get('mshpo_phone');
		}		
		
		if (isset($this->request->post['mshpo_banner_time'])) {
			$data['banner_time'] = $this->request->post['mshpo_banner_time'];
		}
		else {
			$data['banner_time'] = $this->config->get('mshpo_banner_time');
		}
		
		if (isset($this->request->post['mshpo_url_uppstore'])) {
			$data['url_uppstore'] = $this->request->post['mshpo_url_uppstore'];
		}
		else {
			$data['url_uppstore'] = $this->config->get('mshpo_url_uppstore');
		}

		if (isset($this->request->post['mshpo_url_googleplay'])) {
			$data['url_googleplay'] = $this->request->post['mshpo_url_googleplay'];
		}
		else {
			$data['url_googleplay'] = $this->config->get('mshpo_url_googleplay');
		}
		
		if (isset($this->request->post['mshpo_url_appid'])) {
			$data['url_appid'] = $this->request->post['mshpo_url_appid'];
		}
		else {
			$data['url_appid'] = $this->config->get('mshpo_url_appid');
		}

		if (isset($this->request->post['mshpo_url_appargument'])) {
			$data['url_appargument'] = $this->request->post['mshpo_url_appargument'];
		}
		else {
			$data['url_appargument'] = $this->config->get('mshpo_url_appargument');
		}

		if (isset($this->request->post['mshpo_banner_id_iphone'])) {
			$data['banner_id_iphone'] = $this->request->post['mshpo_banner_id_iphone'];
		} else {
			$data['banner_id_iphone'] = $this->config->get('mshpo_banner_id_iphone');
		}

		if (isset($this->request->post['mshpo_banner_id_ipad'])) {
			$data['banner_id_ipad'] = $this->request->post['mshpo_banner_id_ipad'];
		} else {
			$data['banner_id_ipad'] = $this->config->get('mshpo_banner_id_ipad');
		}

		if (isset($this->request->post['mshpo_push_status'])) {
			$data['push_status'] = $this->request->post['mshpo_push_status'];
		} else {
			$data['push_status'] = $this->config->get('mshpo_push_status');
		}		 
		
		/*get order statuses*/
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		/*get banners from banner model*/
		$this->load->model('design/banner');
		$data['banners'] = $this->model_design_banner->getBanners();	
		
		/*loading chanks*/
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		/*output to view*/
		$this->response->setOutput($this->load->view('module/mshpo.tpl', $data));
		
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'module/mshpo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->request->post['mshpo_min_price'] = str_replace(",", ".", $this->request->post['mshpo_min_price']);
		if ($this->request->post['mshpo_min_price'] && !is_numeric($this->request->post['mshpo_min_price'])) {
			$this->error['min_price'] = $this->language->get('error_min_price');
		}
		
		if (!$this->request->post['mshpo_banner_time'] || !is_numeric($this->request->post['mshpo_banner_time'])) {
			$this->error['banner_time'] = $this->language->get('error_banner_time');
		}

		return !$this->error;
		
	}
	
	public function install() {
		
		$this->load->model('module/mshpo');
		$this->model_module_mshpo->addTables();
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('mshpo', array('mshpo_status'=>1));
		
		
	}

	public function uninstall() {
		
		$this->load->model('module/mshpo');
		$this->model_module_mshpo->deleteTables();
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('mshpo', array('mshpo_status'=>0));		
		
	}
	
}