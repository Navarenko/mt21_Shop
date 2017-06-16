<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		












// Analytics
    $this->load->model('extension/extension');

    $data['analytics'] = array();

    $analytics = $this->model_extension_extension->getExtensions('analytics');

    foreach ($analytics as $analytic) {
      if ($this->config->get($analytic['code'] . '_status')) {
        $data['analytics'][] = $this->load->controller('analytics/' . $analytic['code']);
      }
    }

    if ($this->request->server['HTTPS']) {
      $server = $this->config->get('config_ssl');
    } else {
      $server = $this->config->get('config_url');
    }

    if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
      $this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
    }

    $data['title'] = $this->document->getTitle();

    $data['base'] = $server;
    $data['description'] = $this->document->getDescription();
    $data['keywords'] = $this->document->getKeywords();
    $data['links'] = $this->document->getLinks();
    $data['styles'] = $this->document->getStyles();
    $data['scripts'] = $this->document->getScripts();
    $data['lang'] = $this->language->get('code');
    $data['direction'] = $this->language->get('direction');

	$data['text_special_offers'] = $this->language->get('text_special_offers');

    $data['name'] = $this->config->get('config_name');

    if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
      $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
    } else {
      $data['logo'] = '';
    }

    $this->load->language('common/header');

    $data['text_home'] = $this->language->get('text_home');

    // Wishlist
    if ($this->customer->isLogged()) {
      $this->load->model('account/wishlist');

      $data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
    } else {
      $data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
    }

    $data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
    $data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

    $data['text_account'] = $this->language->get('text_account');
    $data['text_register'] = $this->language->get('text_register');
    $data['text_login'] = $this->language->get('text_login');
    $data['text_order'] = $this->language->get('text_order');
    $data['text_transaction'] = $this->language->get('text_transaction');
    $data['text_download'] = $this->language->get('text_download');
    $data['text_logout'] = $this->language->get('text_logout');
    $data['text_checkout'] = $this->language->get('text_checkout');
    $data['text_category'] = $this->language->get('text_category');
    $data['text_all'] = $this->language->get('text_all');

    $data['home'] = $this->url->link('common/home');
    $data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
    $data['logged'] = $this->customer->isLogged();
    $data['account'] = $this->url->link('account/account', '', 'SSL');
    $data['register'] = $this->url->link('account/register', '', 'SSL');
    $data['login'] = $this->url->link('account/login', '', 'SSL');
    $data['order'] = $this->url->link('account/order', '', 'SSL');
    $data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
    $data['download'] = $this->url->link('account/download', '', 'SSL');
    $data['logout'] = $this->url->link('account/logout', '', 'SSL');
    $data['shopping_cart'] = $this->url->link('checkout/cart');
    $data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
    $data['contact'] = $this->url->link('information/contact');
    $data['telephone'] = $this->config->get('config_telephone');
    $data['theme'] = $this->config->get('basecart_module_theme');
    $data['nav'] = $this->config->get('basecart_module_nav');

	$data['text_special_offers'] = $this->language->get('text_special_offers');
	$data['text_more'] = $this->language->get('text_more');
	$data['text_create_account'] = $this->language->get('text_create_account');
	$data['text_title_h1'] = $this->language->get('text_title_h1');
	$data['text_main'] = $this->language->get('text_main');
	$data['text_title_block_1'] = $this->language->get('text_title_block_1');
	$data['text_ad_block_1'] = $this->language->get('text_ad_block_1');
	$data['text_title_block_2'] = $this->language->get('text_title_block_2');
	$data['text_ad_block_2'] = $this->language->get('text_ad_block_2');
	$data['text_title_block_3'] = $this->language->get('text_title_block_3');
	$data['text_ad_block_3'] = $this->language->get('text_ad_block_3');
	$data['text_title_slide_1'] = $this->language->get('text_title_slide_1');
	$data['text_ad_slide_1'] = $this->language->get('text_ad_slide_1');
	$data['text_title_slide_2'] = $this->language->get('text_title_slide_2');
	$data['text_ad_slide_2'] = $this->language->get('text_ad_slide_2');
	$data['text_title_slide_3'] = $this->language->get('text_title_slide_3');
	$data['text_ad_slide_3'] = $this->language->get('text_ad_slide_3');
    $data['text_cat_1'] = $this->language->get('text_cat_1');
    $data['text_cat_2'] = $this->language->get('text_cat_2');
    $data['text_cat_3'] = $this->language->get('text_cat_3');

    $status = true;

    if (isset($this->request->server['HTTP_USER_AGENT'])) {
      $robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

      foreach ($robots as $robot) {
        if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
          $status = false;

          break;
        }
      }
    }
 // Menu
    $this->load->model('catalog/category');

    $this->load->model('catalog/product');

    $data['categories'] = array();

    $categories = $this->model_catalog_category->getCategories(0);

    foreach ($categories as $category) {
      if ($category['top']) {
        // Level 2
        $children_data = array();

        $children = $this->model_catalog_category->getCategories($category['category_id']);

        foreach ($children as $child) {
          $filter_data = array(
            'filter_category_id'  => $child['category_id'],
            'filter_sub_category' => true
          );

          $children_data[] = array(
            'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
            'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
          );
        }

        // Level 1
        $data['categories'][] = array(
          'name'     => $category['name'],
          'children' => $children_data,
          'column'   => $category['column'] ? $category['column'] : 1,
          'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
        );
      }
    }

    $data['language'] = $this->load->controller('common/language');
    $data['currency'] = $this->load->controller('common/currency');
    $data['search'] = $this->load->controller('common/search');
    $data['cart'] = $this->load->controller('common/cart');

    // For page specific css
    if (isset($this->request->get['route'])) {
      if (isset($this->request->get['product_id'])) {
        $class = '-' . $this->request->get['product_id'];
      } elseif (isset($this->request->get['path'])) {
        $class = '-' . $this->request->get['path'];
      } elseif (isset($this->request->get['manufacturer_id'])) {
        $class = '-' . $this->request->get['manufacturer_id'];
      } else {
        $class = '';
      }

      $data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
    } else {
      $data['class'] = 'common-home';
    }









		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}