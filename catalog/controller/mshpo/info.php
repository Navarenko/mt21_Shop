<?php
class ControllerMshpoInfo extends Controller {
	
	public function index() {
	
		error_reporting(0);
		header("Content-Type: text/xml; charset=UTF-8");
		$strHeader='<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE shop><shop>'."\n";
		$strFooter='</shop>';
		
		$this->load->model('catalog/information');
		$information_list = $this->model_catalog_information->getInformations();
		
		$strContent='<pages>';
		foreach($information_list as $item) {
		
			if($item["sort_order"] >= 0) continue;
			
			$pageType='text';
			// if($file=='news.php' || $file=='stocks.php' || $file=='articles.php')
				// $pageType='xml';
			$strContent.="<page type='".$pageType."'>";
			if(!empty($item["meta_title"]))
				$strContent.="<title>".$item["meta_title"]."</title>";
			elseif(!empty($item["meta_h1"]))
				$strContent.="<title>".$item["meta_h1"]."</title>";
			else	
				$strContent.="<title>No title</title>";
				
			$strContent.="<url>/shop/index.php?route=mshpo/info/getInfo&amp;information_id=".$item["information_id"]."</url>";
			$strContent.="</page>";
			
		}
		
		$strContent.='</pages>';

		$strContent.='<appstoreUrl>'.$this->config->get('mshpo_url_uppstore').'</appstoreUrl>';
		$strContent.='<GooglePlayUrl>'.$this->config->get('mshpo_url_googleplay').'</GooglePlayUrl>';		
		
		// $this->mshpo->pre($information_list);
		
		echo $strHeader.$strContent.$strFooter;
	
	}
	
	public function getInfo() {
	
		$this->load->language('information/information');
		$this->load->model('catalog/information');
		
		$data['appid'] = $this->config->get('mshpo_url_appid');
		$data['appargument'] = $this->config->get('mshpo_url_appargument');
	
		if (isset($this->request->request['information_id'])) {
			$information_id = (int)$this->request->request['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {

			if ($information_info['meta_title']) {
				$data['heading_title'] = $information_info['meta_title'];
			} else {
				$data['heading_title'] = $information_info['title'];
			}

			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			if ($information_info['meta_h1']) {
				$data['heading_title'] = $information_info['meta_h1'];
			} else {
				$data['heading_title'] = $information_info['title'];
			}
				
			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mshpo/information.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/mshpo/information.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/mshpo/information.tpl', $data));
			}
			
		} else {
			
			header("Content-Type: application/json");
			echo json_encode(array("TYPE" => "Error", "DESC" => "Element not found", "FIELD" => array("request" => $this->request->request)));
			die();
			
		}
		
	}
	
	

}