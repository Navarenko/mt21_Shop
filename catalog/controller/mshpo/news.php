<?php
class ControllerMshpoNews extends Controller {
	public function index() {
		
		error_reporting(0);
		$this->load->model('tool/image');
		$this->load->model('catalog/news');

		global $params;
		$this->request->request['param'] = htmlspecialchars_decode($this->request->request['param']);
		$params=json_decode($this->request->request['param'],true);
		
		$this->log->write($this->request->request['param']); // write to log
		
		if(!$params['ID']){
			echo "No new's id!";
			die;
		}

		$news_info = $this->model_catalog_news->getNewsStory($params['ID']);		
		
		if (!$news_info) {
			
			echo "No news with id {$params['ID']}!";
			die;			
			
		}
		
		if ($this->config->get('news_setting')) {
			$news_setting = $this->config->get('news_setting');
		}else{
			$news_setting['news_thumb_width']  = '220';
			$news_setting['news_thumb_height'] = '220';
			$news_setting['news_popup_width']  = '560';
			$news_setting['news_popup_height'] = '560';
		}		
		
		if($news_info['image'])
			// $data['image'] = $this->model_tool_image->resize($news_info['image'], $news_setting['news_popup_width'],
			$data['image'] = DIR_IMAGE_OTN . $news_info['image'];
		
		$data['date_added'] = date($this->language->get('date_format_short'), strtotime($news_info['date_added']));
		
		$data['description'] = html_entity_decode($news_info['description']);
			
		if(preg_match_all('/src=(\'|")([^\'"]+)(\'|")/',$data['description'],$matches)){
			foreach($matches[2] as $link){
				if(strpos($link,'mt21.ru')===false && strpos($link,'/')===0)
					$data['description'] = str_replace($link,"https://mt21.ru".$link,$data['description']);
			}
		}
		
		// количество просмотров +1
		$this->model_catalog_news->updateViewed($params['ID']);
	
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mshpo/news.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/mshpo/news.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/mshpo/news.tpl', $data));
		}
	}
}