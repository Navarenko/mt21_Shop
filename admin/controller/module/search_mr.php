<?php

class ControllerModuleSearchMr extends Controller {

	private $error = array();

	public function index() {

		$data = $this->load->language('module/search_mr');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('catalog/search_mr');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('search_mr', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/search_mr', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/search_mr', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['search_mr_status'])) {
            $data['search_mr_status'] = $this->request->post['search_mr_status'];
        } else {
            $data['search_mr_status'] = $this->config->get('search_mr_status');
        }
		
		if (isset($this->request->post['search_mr_options'])) {
			$data['options'] = $this->request->post['search_mr_options'];
		} elseif ($this->config->get('search_mr_options')) {
			$data['options'] = $this->config->get('search_mr_options');
		}

		$data['fields'] = $this->model_catalog_search_mr->getFields();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/search_mr.tpl', $data));
	}

	public function install() {

		$this->load->model('setting/setting');
		$this->load->model('catalog/search_mr');

		$this->model_catalog_search_mr->install();

		$this->model_setting_setting->deleteSetting('search_mr');
		$setting['search_mr_options'] = $this->model_catalog_search_mr->getDefaultOptions();
		$this->model_setting_setting->editSetting('search_mr', $setting);
	}

	public function uninstall() {

		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('search_mr');
	}

	private function validate() {

		if (!$this->user->hasPermission('modify', 'module/search_mr')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error ? TRUE : FALSE;
	}
}
//author sv2109 (sv2109@gmail.com) license for 1 product copy granted for Lixor (nikita@mt21.ru mt21.ru)
