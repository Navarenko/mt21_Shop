<?php
class ControllerMshpoElements extends Controller {

	public function index() {
		/*
			errorCods:
			2 - no entering data
			3 - no element found
		*/
		// $this->log->write($this->request->request); // write to log
		error_reporting(0);
		
		$this->load->language('mshpo/elements');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');	
		$this->load->model('tool/image');		
		
		if(!is_array($flagError))//can be declared in search.php
			$flagError=array();		
		
		/*
		if(isset($_REQUEST['BLOCK']))
			foreach($optBlocks as $code => $descr)
				if($code==$_REQUEST['BLOCK']){
					if(!$preFilter)
						$preFilter=array();
					$preFilter['IBLOCK_ID'] = $descr[3];
					if($descr[2]){
						try{
							eval('$BlockFilter = '.$optBlocks[$code][2].';');
							$preFilter = array_merge($preFilter,$BlockFilter);
						}
						catch(Exception $e){
							$flagError['9'] = "Unable to use filter in block ".$code." error is: ".$e->getMessage();
						}
					}
				}
		*/	

		$strHeader='<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE shop><shop>'."\n";
		
		if(!empty($this->request->request['q']))
			$filter_name = $this->request->request['q'];
		elseif(!empty($this->request->request['search'])) {
			$filter_name = $this->request->request['search'];
			$filter_tag = $this->request->request['search'];
		}
	
		
		
		if(!$this->request->request['SECTION_ID'] && !$this->request->request['ELEMENTS'] && !$filter_name)
			$flagError['2']=$this->language->get('err_no_sectoion') . ": " . $this->request->request['SECTION_ID']." is false and" . $this->request->request['ELEMENTS'] . ".";
		else{
										
			if (isset($this->request->request['SECTION_ID'])) {
				$filter_category_id = $this->request->request['SECTION_ID'];
			} else {
				$filter_category_id = 0;
			}				
				
			if (isset($this->request->request['SORT_CODE'])) {
				$sort = $this->request->request['SORT_CODE'];
			} else {
				$sort = 'p.product_id';
			}

			if (isset($this->request->request['SORT_ASC'])) {
				$order = $this->request->request['SORT_ASC'];
			} else {
				$order = 'ASC';
			}

			if (isset($this->request->request['PAGE'])) {
				$page = $this->request->request['PAGE'];
			} else {
				$page = 1;
			}

			if (isset($this->request->request['nPageSize'])) {
				$limit = (int)$this->request->request['nPageSize'];
			} else {
				$limit = 20;
			}

			$filter_data = array(
				'filter_category_id' => $filter_category_id,
				'filter_name'        => $filter_name,
				'filter_tag'         => $filter_tag,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			
			/*если в фильтр переданы id элементов*/
			$elementsIds = array();
			if($this->request->request['ELEMENTS'])
				$elementsIds = explode(",", $this->request->request['ELEMENTS']);

			if($product_total = count($elementsIds) > 0) {

				foreach($elementsIds as $id) {
					
					$prod = $this->model_catalog_product->getProduct($id);
					
					if($prod)
						$results[$id] = $prod;
				
				}	
			/*либо выбираем по категории*/
			} else {
			
				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
				$results = $this->model_catalog_product->getProducts($filter_data);
			
			}
			
			if(count($results)>0){
				$strContent="<ofrs>\n";
				foreach($results as $element){
					if(!$this->request->request['devType']&&strpos($element['NAME'],'Android')!==false) // убираем то, что описывает Андроид, если девайс - не андроид
						continue;
					// if(1)
						$mode = 'good'; // пока что только каталог
					// else
						// $mode = 'text';

						$strContent.='<ofr id="'.$element['product_id'].'" mode="'.$mode.'">'."\n";
						// $quickSearch.=$this->mshpo->cutText($element['name'])."\n";
						$quickSearch.=$element['name']."\n";
						
						// $strContent.='<name>'.$this->mshpo->cutText($this->mshpo->delStyle($element['name']))."</name>\n";
						$strContent.='<name>'.$this->mshpo->delStyle($element['name'])."</name>\n";

						if(!empty($element['sku'])){
							$strContent.='<sku>'.$this->mshpo->delStyle($element['sku'])."</sku>\n";

						}
						
						$strContent.="<pId>".$filter_category_id."</pId>\n";
						if(!empty($element['image']))
							$strContent.='<pic>'.$this->mshpo->cutHost($this->model_tool_image->resize($element['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')))."</pic>\n";
						if($this->request->request['ELEMENTS']){
							
							// $propTable="<tr>";
							$propTable="";

							if(!empty($element['sku'])){
								// $propTable.='<td>'.$this->language->get('sku').'&nbsp;&nbsp;&nbsp;'.$element['sku'].'</td>';
								$propTable.='<div class = "sku">'.$this->language->get('sku').'&nbsp;&nbsp;&nbsp;'.$this->mshpo->delStyle($element['sku']).'</div>';
								
							}
							
							// $price = $this->currency->format($element['price'], 0, 0, 1, 0); //for round price in my place
							// $price = str_replace("руб.", "", $price); 
							
							if($mode == 'good')
								// $propTable.='<td class="price"><div>'.number_format(round($element['price'], 0), 0, '', ' '). ' ' . $this->language->get('pub') . '</div></td>';
								$propTable.='<div class="price">'.number_format(round($element['price'], 0), 0, '', ' '). ' ' . $this->language->get('pub') . '</div>'; //Цена в описании товара на Android и iOS(Закрыто белым прямоугольником)  
							
							// $propTable.="</tr>";

							$descr = false;
							if($propTable)
								// $descr=$this->mshpo->cutText("<style>body{margin:0; padding:10px;}#harTable{width: 100%;border-collapse: collapse;margin: 5px 0 10px 0;} #harTable td {vertical-align: bottom;border:1px solid black;} #harTable td.price{text-align: right; color: #000; font-size: 30px; font-weight: bold; white-space: nowrap;}#harTable</style>".$this->mshpo->delStyle('<table id="harTable">'.$propTable.'</table>'));
								$descr=$this->mshpo->cutText("<style>body{margin:0; padding:10px;} div.sku {color: #6c6c6c;float: left;padding-top: 15px;} div.sku a{text-decoration: none;color: #6c6c6c;} div.price{text-align: right; color: #000; font-size: 30px; font-weight: bold; white-space: nowrap;float: right;} div.price a {color: #000;text-decoration: none;}</style>".$this->mshpo->delStyle($propTable.'<div style = "clear: both;"></div>'));
							if(strlen($element['description'])>0)
								$descr.=$this->mshpo->cutText($this->mshpo->delStyle(htmlspecialchars_decode($element['description'])));
							if($descr)
								$strContent.='<dscr>'.$descr."</dscr>\n"; 
						}

						if(strlen($element['description'])>0)
							$strContent.='<anons>'.$this->mshpo->cutText(substr(strip_tags($anons),0,100))."</anons>\n";
											
						if($mode == 'good'){
							$strContent.='<prc>'.round($element['price'], 0)."</prc>\n";
						}

					$strContent.="</ofr>\n";
				}
				$strContent.="</ofrs>\n";
									
				if($this->request->request['SECTION_ID']/* || isset($this->request->request['BLOCK'])*/)
					$strContent.='<nav ttl="'.ceil($product_total/$limit).'" cur="'.($this->request->request['PAGE']?$this->request->request['PAGE']:1).'"></nav>'."\n";
		
			}
			else
				$flagError['3']="No elements found.";			

		}
		
		//error check
		if(count($flagError)>0)
		{
			$strError="<err>\n";
			foreach($flagError as $errCode => $errName)
			{
				$strError.='<err'.$errCode.'>'.$errName.'</err'.$errCode.'>'."\n";
			}
			$strError.="</err>\n";
		}

		$strFooter='</shop>';	
// ob_start();
		if(array_key_exists('q',$this->request->request))
			echo $quickSearch;
		else {
			header("Content-Type: text/xml; charset=UTF-8");
			echo $strHeader.$strContent.$strError.$strFooter;		
		}
// отладка
// $content = ob_get_contents();
// ob_end_clean();

// echo $content;

// $fname = "appLog";
// $file=fopen($_SERVER["DOCUMENT_ROOT"]."/".$fname.".txt","a+");
// fwrite($file,"\n\n".date("H:i:s d-m-Y")."\n");
// fwrite($file,print_r($content,true));
// fclose($file);
		
	}

}