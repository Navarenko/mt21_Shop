<?php
class ControllerMshpoMain extends Controller {

	public function index() {
	
		error_reporting(0);
		header("Content-Type: text/xml; charset=UTF-8");

		// header("Content-Type: text/html; charset=UTF-8");
		
		$flagError=array();
		
		/* - это вроде не используется
		$optBlocks = unserialize(COption::getOptionString($module_id,"MBlocks",'a:0:{}'));
		$arIblocks=array();
		foreach($optBlocks as $code => $descr)
			if($descr[0]=='cat')
				$arIblocks[$code]=$descr[3];
		*/
		
		if($this->request->request) {
		
			$this->request->request['param'] = htmlspecialchars_decode($this->request->request['param']);
			$params=json_decode($this->request->request['param'],true);
				if($this->request->request['DEBUG']=='Y')
					$params = array('LOGIN' => 'bpush');
		}
		
		/*статистика*/
		$otherInfo='';
		$userEmail = "";
		foreach($params as $fieldName => $field){
			switch($fieldName){
				case 'token':break;case 'udid':break;case 'deviceName':break;
				case 'LOGIN':
					$userEmail = $field;
					$otherInfo.=$fieldName." : ".$field."<br>";
				default: $otherInfo.=$fieldName." : ".$field."<br>";
			}
		}
		if($params['udid']) { 
			$this->load->model('module/mshpo');
			$this->model_module_mshpo->Visit(array('TOKEN'=>$params['token'],'UDID'=>$params['udid'],'DEVICE_NAME'=>$params['deviceName'],'DEVICE_INFO'=>$otherInfo));
		}

		$this->log->write("PARAMS"); // write to log
		$this->log->write($params); // write to log
		
		$strHeader='<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE shop><shop>'."\n";
		
		$arSections=array();
		$arBlockedSectsId=array();
		
		
		$this->load->language('mshpo/main');
		// $this->load->language('information/news');
		
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('design/banner');
		$this->load->model('catalog/news');
		
		/*структура каталога*/
		$data['categories'] = array();
		$categories = $this->model_catalog_category->getCategories(0);
		
		if(count($categories)==0)
			$noSections=true;
			
		if(!$noSections)
		{		
			foreach ($categories as $category) {
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);
				
				foreach($children as $child) {
					$sister_data = array();
					$sisters = $this->model_catalog_category->getCategories($child['category_id']);

					// $child['image'] = $this->model_tool_image->resize($child['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
					
					if(count($sisters) > 1) {
						foreach ($sisters as $sisterMember) {
						
							// $sisterMember['image'] = $this->model_tool_image->resize($sisterMember['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
						
							$sister_data[] = array(
							'category_id' =>$sisterMember['category_id'],
							'name'	=> $sisterMember['name'],
							'image'	=> $sisterMember['image'] ? DIR_IMAGE_OTN . $sisterMember['image'] : '',
							'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $sisterMember['category_id']) 
							);	
						}
						$children_data[] = array(
						'category_id' => $child['category_id'],
						'sister_id' => $sister_data,
						'name'	=> $child['name'],
						'image'	=> $child['image'] ? DIR_IMAGE_OTN . $child['image'] : '',
						'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']) 
						); 
					}else{	
						$children_data[] = array(
						'category_id' => $child['category_id'],
						'sister_id' =>'',
						'name'	=> $child['name'],
						'image'	=> $child['image'] ? DIR_IMAGE_OTN . $child['image'] : '',
						'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']) 
						); 
					}

				}

				$filter_data = array(
					'filter_category_id'  => $category['category_id'],
					'filter_sub_category' => true
				);
				
				// $category['image'] = $this->model_tool_image->resize($category['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				
				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'],
					'image'	=> $category['image'] ? DIR_IMAGE_OTN . $category['image'] : '',
					'children'    => $children_data,
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
			
			// строим структуру xml
			$strContent="<ctgs>\n";
			// usort($arSections,sortSotr);
			foreach($data['categories'] as $cat){
			
				$strContent.='<ctg id="'.$cat['category_id'].'"';
				if(!empty($cat['image']))
					$strContent.=' pic="'.$cat['image'].'"';
				$strContent.='>'.$cat['name']."</ctg>\n";
				
				foreach($cat["children"] as $ch){
				
					$strContent.='<ctg id="'.$ch['category_id'].'"';
					$strContent.=' pId="'.$cat['category_id'].'"';
					if(!empty($ch['image']))
						$strContent.=' pic="'.$ch['image'].'"';
					$strContent.='>'.$ch['name']."</ctg>\n";					
				
						foreach($ch["sister_id"] as $st){
						
							$strContent.='<ctg id="'.$st['category_id'].'"';
							$strContent.=' pId="'.$ch['category_id'].'"';
							if(!empty($st['image']))
								$strContent.=' pic="'.$st['image'].'"';
							$strContent.='>'.$st['name']."</ctg>\n";					

						}		

				}

			}
			$strContent.="</ctgs>\n";

		} else
			$flagError['1']='No sections found.';	
		
			/* - это тоже вроде отключено
			$strContent.="<blocks>\n";
			foreach($optBlocks as $code => $descr)
				$strContent.="<block code='".$code."' type='".$descr[0]."'>".mshpdriver::zajsonit($descr[1])."</block>\n";
			$strContent.="</blocks>\n";			
			*/

			// баннеры
			$idBannersIphone = $this->config->get('mshpo_banner_id_iphone');	
			$idBannersIpad = $this->config->get('mshpo_banner_id_ipad');
	
			if(!empty($idBannersIphone)) {
				$arBannersIphone = $this->model_design_banner->getBanner($idBannersIphone);
				
				foreach ($arBannersIphone as $banner) {
					if (is_file(DIR_IMAGE . $banner['image'])) {
						$data['banners'][$banner['title']] = array(
							'link'  => $banner['link'],
							'iphone_image'  => $banner['image'],
							// 'iphone_url' => $this->model_tool_image->resize($banner['image'], $setting['width'], $setting['height'])
							'iphone_url'	=> DIR_IMAGE_OTN . $banner['image'],
						);
					}
				} 
			}
			
			if(!empty($idBannersIpad)) {
				$arBannersIpad = $this->model_design_banner->getBanner($idBannersIpad);
				
				foreach ($arBannersIpad as $banner) {
					if (is_file(DIR_IMAGE . $banner['image']) && in_array($banner['title'], array_keys($data['banners']))) {
						
						$data['banners'][$banner['title']]['ipad_url'] = DIR_IMAGE_OTN . $banner['image'];
						// $data['banners']['ipad_url'] = $this->model_tool_image->resize($banner['image'], $setting['width'], $setting['height']);
						$data['banners'][$banner['title']]['ipad_image']  = $banner['image'];
						 
					}
				}
			}
			
			$strContent.="<banners>\n";
			foreach($data['banners'] as $banner){
				if(!$banner['iphone_url'] && !$banner['ipad_url']) continue;

				$strContent.="<banner";
				if(!empty($banner['link'])){
				
					$categories = array("text", "new", "offer"); //тип - статья, новость, продукт
					$link_info = explode(",", $banner['link']);
					
					if($link_info[1] && in_array($link_info[1], $categories))
						$type = $link_info[1];
						
					if(is_numeric($link_info[0]))
						$strContent.=" id='".$link_info[0]."' ";
					if($type)
						$strContent.=" type='".$type."' ";
					
				}
								
				if($banner['iphone_url']){
					list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $banner['iphone_image']);
					$strContent.=" iphone_url='".$banner['iphone_url']."' ";
					$strContent.=" iphone_width='".$width_orig."' iphone_height='".$height_orig."' ";
				}	
				if($banner['ipad_url']) {
					list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $banner['ipad_image']);
					$strContent.=" ipad_url='".$banner['ipad_url']."' ";
					$strContent.=" ipad_width='".$width_orig."' ipad_height='".$height_orig."' ";
				}	 
				$strContent.="></banner>\n";
			}
			$strContent.="</banners>\n";
			
			//$strContent.="<phoneCompany>".$this->config->get('mshpo_phone')."</phoneCompany>";

			include $_SERVER['DOCUMENT_ROOT'].'/shop/identify-region.php';
			$regionPhoneNumber = get_region_clear_phone_number();
		//$region = new identifyRegion();
		//$strContent.="<currentCity>".$region->id_city."</currentCity>";
			$strContent.="<phoneCompany>".$regionPhoneNumber."</phoneCompany>";

			//include $_SERVER['DOCUMENT_ROOT'].'/shop/SxGeo.php';
			$mySxGeo = new SxGeo(); // Режим по умолчанию, файл бд SxGeo.dat
			$currentCity = $mySxGeo->get($_SERVER["REMOTE_ADDR"])['city']['name_ru'];
			$strContent.="<currentCity>$currentCity</currentCity>";

			$this->load->model('account/customer');
			$сustomerGroupId = $this->model_account_customer->getCustomerGroupIdByEmail($userEmail);
			$discount = "0";
			if ($сustomerGroupId > 2) {
				include $_SERVER['DOCUMENT_ROOT'].'/shop/myscript.php';
				$discount = (String)getCurSale($сustomerGroupId);
			}
			$strContent.="<discount>".$discount."</discount>";
		
			$strContent.="<bannerSwitch>".$this->config->get('mshpo_banner_time')."</bannerSwitch>";

			// новости
			$filter_data = array(
				'sort' => 'n.date_added',
				'order' => 'DESC',
				'start' => 0,
				'limit' => 20
			);

			// $news_total = $this->model_catalog_news->getTotalNews();
			$news_list = $this->model_catalog_news->getNews($filter_data);				
			
			
			if ($news_list) {
			
				$strContent .= '<newsGroups>';
				$strContent .= '</newsGroups>';			
			
				$news_setting = array();

				if ($this->config->get('news_setting')) {
					$news_setting = $this->config->get('news_setting');
				}else{
					$news_setting['description_limit'] = '300';
					$news_setting['news_thumb_width'] = '220';
					$news_setting['news_thumb_height'] = '220';
				}

				$strContent .= '<news>';
				foreach ($news_list as $result) {

					if($result['image']){
						// $image = $this->model_tool_image->resize($result['image'], $news_setting['news_thumb_width'], $news_setting['news_thumb_height']);
						$image = DIR_IMAGE_OTN . $result['image'];
					}else{
						$image = false;
					}
					
					$strContent .= "<new id='".$result['news_id']."' title='".$result['title']."' pic='".$image."'  date='".date($this->language->get('date_format_short'), strtotime($result['date_added']))."'>".utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES,'UTF-8')), 0, $news_setting['description_limit'])."</new>";

				}				
				$strContent .= '</news>';

			}

			$strContent .= '<syncTime>'.mktime().'</syncTime>';
			
			$strContent .= '<sorts>';	
			$strContent .= '<sort code="pd.name" default="Y">'.$this->language->get('sort_for_name').'</sort>';
			// $strContent .= '<sort code="p.weight">'.$this->language->get('sort_for_weight').'</sort>';
			$strContent .= '<sort code="p.price">'.$this->language->get('sort_for_price').'</sort>';
			$strContent .= '<sort code="p.model">'.$this->language->get('sort_for_model').'</sort>';
			// $strContent .= '<sort code="p.sort_order" default="Y">'.$this->language->get('sort_for_sort').'</sort>';
			$strContent .= '</sorts>';

			$strContent .= '<opts>';	
			$strContent .= '</opts>';

			$strContent .= '<minVersionIOS></minVersionIOS>';
			$strContent .= '<minVersionAndroid></minVersionAndroid>';

			$strContent.='<appstoreUrl>'.$this->config->get('mshpo_url_uppstore').'</appstoreUrl>';
			$strContent.='<GooglePlayUrl>'.$this->config->get('mshpo_url_googleplay').'</GooglePlayUrl>';
			
			//error check
			if(count($flagError)>0){
				$strError="<err>\n";
				foreach($flagError as $errCode => $errName)
					$strError.='<err'.$errCode.'>'.$errName.'</err'.$errCode.'>'."\n";
				$strError.="</err>\n";
			}			
			
			$strFooter='</shop>';
			
			// $this->mshpo->pre(1);
			
			echo $strHeader.$strContent.$strError.$strFooter;

	}

}