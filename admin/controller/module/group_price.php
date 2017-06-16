<?php
 class ControllerModuleGroupPrice extends Controller{private $ab1f5835b8c87cb7afdc6fbbe815c3ab4=array();public function index(){$aac3e74256380d96ed96cc3f636a5d1b9=$this->load->language('module/group_price');$this->document->setTitle($this->language->get('heading_title'));$this->load->model('catalog/group_price');$this->load->model('setting/setting');if(($this->request->server['REQUEST_METHOD']=='POST')&&$this->validate()){$this->model_setting_setting->editSetting('group_price',$this->request->post);$this->model_catalog_group_price->saveCategoryPrices($this->request->post);$this->model_catalog_group_price->saveManufacturePrices($this->request->post);if(isset($this->error)&&is_array($this->error)){$this->error=array_merge($this->error,$this->model_catalog_group_price->getError());}else{$this->error=$this->model_catalog_group_price->getError();}$this->session->data['success']=$this->language->get('text_success');}$aac3e74256380d96ed96cc3f636a5d1b9['token']=$this->session->data['token'];if(isset($this->error)&&$this->error){$aac3e74256380d96ed96cc3f636a5d1b9['error_warning']=implode('<br />',$this->error);}else{$aac3e74256380d96ed96cc3f636a5d1b9['error_warning']='';}$aac3e74256380d96ed96cc3f636a5d1b9['breadcrumbs']=array();$aac3e74256380d96ed96cc3f636a5d1b9['breadcrumbs'][]=array('text'=>$this->language->get('text_home'),'href'=>$this->url->link('common/home','token='.$this->session->data['token'],'SSL'),'separator'=>false);$aac3e74256380d96ed96cc3f636a5d1b9['breadcrumbs'][]=array('text'=>$this->language->get('text_module'),'href'=>$this->url->link('extension/module','token='.$this->session->data['token'],'SSL'),'separator'=>' :: ');$aac3e74256380d96ed96cc3f636a5d1b9['breadcrumbs'][]=array('text'=>$this->language->get('heading_title'),'href'=>$this->url->link('module/group_price','token='.$this->session->data['token'],'SSL'),'separator'=>' :: ');$aac3e74256380d96ed96cc3f636a5d1b9['action']=$this->url->link('module/group_price','token='.$this->session->data['token'],'SSL');$aac3e74256380d96ed96cc3f636a5d1b9['cancel']=$this->url->link('extension/module','token='.$this->session->data['token'],'SSL');$this->load->model('customer/customer_group');$aac3e74256380d96ed96cc3f636a5d1b9['customer_groups']=$this->model_customer_customer_group->getCustomerGroups();$a4434a9251934f278be860d08e9241c7a=$this->model_catalog_group_price->getAllDbCategories();$aac3e74256380d96ed96cc3f636a5d1b9['categories']=array('0'=>array('category_id'=>0,'name'=>$this->language->get('group_base_price')));$aac3e74256380d96ed96cc3f636a5d1b9['categories']+=$this->model_catalog_group_price->getAllCategoriesWithParents($a4434a9251934f278be860d08e9241c7a);$aac3e74256380d96ed96cc3f636a5d1b9['categories_price']=$this->model_catalog_group_price->getAllCategoriesPrice();$this->load->model('catalog/manufacturer');$aac3e74256380d96ed96cc3f636a5d1b9['manufacturers']=$this->model_catalog_manufacturer->getManufacturers();$aac3e74256380d96ed96cc3f636a5d1b9['manufacturers_price']=$this->model_catalog_group_price->getAllManufacturersPrice();$aac3e74256380d96ed96cc3f636a5d1b9['currency']=$this->config->get('config_currency');if(isset($this->request->post['group_price_options'])){$aac3e74256380d96ed96cc3f636a5d1b9['options']=$this->request->post['group_price_options'];}elseif($this->config->get('group_price_options')){$aac3e74256380d96ed96cc3f636a5d1b9['options']=$this->config->get('group_price_options');}$aac3e74256380d96ed96cc3f636a5d1b9['header']=$this->load->controller('common/header');$aac3e74256380d96ed96cc3f636a5d1b9['column_left']=$this->load->controller('common/column_left');$aac3e74256380d96ed96cc3f636a5d1b9['footer']=$this->load->controller('common/footer');$this->response->setOutput($this->load->view('module/group_price.tpl',$aac3e74256380d96ed96cc3f636a5d1b9));}public function install(){$this->load->model('catalog/group_price');$this->model_catalog_group_price->install();$this->load->model('setting/setting');$this->model_setting_setting->deleteSetting('group_price');$a252aa4f7dcf3f5d6be61fc3d7b12bec1=array('key'=>'3d0e5d9d46405890f2316382acef9573',);$ab9873bd9963628adde01c0f6afcfbc20['group_price_options']=$a252aa4f7dcf3f5d6be61fc3d7b12bec1;$this->model_setting_setting->editSetting('group_price',$ab9873bd9963628adde01c0f6afcfbc20);}public function uninstall(){$this->load->model('catalog/group_price');$this->model_catalog_group_price->uninstall();$this->load->model('setting/setting');$this->model_setting_setting->deleteSetting('group_price');}private function validate(){if(!$this->user->hasPermission('modify','module/group_price')){$this->error['warning']=$this->language->get('error_permission');}return!$this->error?TRUE:FALSE;}public function updateDbPrice(){$af88e29d5a014a14d68ddb1c6f742da7c=array();$this->load->language('module/group_price');$this->load->model('catalog/group_price');if(!$this->validate()){$af88e29d5a014a14d68ddb1c6f742da7c['error']=$this->language->get('error_permission');}else{$a0859eb2360b08c4710820677e06d0818=$this->model_catalog_group_price->updateDbPrice($this->request->get);if($a0859eb2360b08c4710820677e06d0818===FALSE){$af88e29d5a014a14d68ddb1c6f742da7c['error']=$this->language->get('refresh_link_error');}else{$af88e29d5a014a14d68ddb1c6f742da7c['success']=$this->language->get('refresh_link_success').$a0859eb2360b08c4710820677e06d0818;}}$this->response->setOutput(json_encode($af88e29d5a014a14d68ddb1c6f742da7c));}}