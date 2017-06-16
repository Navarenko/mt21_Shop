<?php
class ControllerModuleCategory extends Controller {
	public function index() {
		$this->load->language('module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}
		if (isset($parts[2])) {
			$data['sisters_id'] = $parts[2];
		} else {
			$data['sisters_id'] = 0; 
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		





		foreach ($categories as $category) {
			$children_data = array();

			//if ($category['category_id'] == $data['category_id'] || TRUE) {
			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach($children as $child) {
				$sister_data = array();
				$sisters = $this->model_catalog_category->getCategories($child['category_id']);

				if(count($sisters) > 1) {
					foreach ($sisters as $sisterMember) {
						$sister_data[] = array(
						'category_id' =>$sisterMember['category_id'],
						'name'	=> $sisterMember['name'],
						'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $sisterMember['category_id']) 
						);	
					}
					$children_data[] = array(
					'category_id' => $child['category_id'],
					'sister_id' => $sister_data,
					'name'	=> $child['name'],
					'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']) 
					); 
				}else{	
					$children_data[] = array(
					'category_id' => $child['category_id'],
					'sister_id' =>'',
					'name'	=> $child['name'],
					'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']) 
					); 
				}

				//$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

				/*$children_data[] = array(
					'category_id' => $child['category_id'],
					'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
				);*/
			}
			//}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

/*foreach ($categories as $category) {
	$children_data = array();

	$children = $this->model_catalog_category->getCategories($category['category_id']);

	foreach ($children as $child) {	
		$sister_data = array();
		$sisters = $this->model_catalog_category->getCategories($child['category_id']);
		if(count($sisters) > 1) {
			foreach ($sisters as $sisterMember) {
				$sister_data[] = array(
				'category_id' =>$sisterMember['category_id'],
				'name'	=> $sisterMember['name'],
				'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $sisterMember['category_id']) 
				);	
			}
			$children_data[] = array(
			'category_id' => $child['category_id'],
			'sister_id' => $sister_data,
			'name'	=> $child['name'],
			'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']) 
			); 
		}else{	
			$children_data[] = array(
			'category_id' => $child['category_id'],
			'sister_id' =>'',
			'name'	=> $child['name'],
			'href'	=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']) 
			); 
		}
	} 
}*/













		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/category.tpl', $data);
		} else {
			return $this->load->view('default/template/module/category.tpl', $data);
		}
	}
}