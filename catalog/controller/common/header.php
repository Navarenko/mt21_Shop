<?php
class ControllerCommonHeader extends Controller
{
  public function index()
  {

    ini_set('display_errors','On');
    error_reporting('E_ALL'); /* ИГНОРИРОВАНИЕ PHP ОШИБОК */
    
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

    $data['text_course'] = $this->language->get('text_course');
    $data['text_cart'] = $this->language->get('text_cart');
    $data['text_price'] = $this->language->get('text_price');
    $data['text_offers'] = $this->language->get('text_offers');
    $data['text_about_us'] = $this->language->get('text_about_us');
    $data['text_delivery'] = $this->language->get('text_delivery');
    $data['text_contacts'] = $this->language->get('text_contacts');
    $data['text_products1'] = $this->language->get('text_products1');
    $data['text_products2'] = $this->language->get('text_products2');
    $data['text_products3'] = $this->language->get('text_products3');

    $data['text_title_block_2'] = $this->language->get('text_title_block_2');
    $data['text_title_block_3'] = $this->language->get('text_title_block_3');

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
              'filter_category_id' => $child['category_id'],
              'filter_sub_category' => true
          );

          $children_data[] = array(
              'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
              'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
          );
        }

        // Level 1
        $data['categories'][] = array(
            'name' => $category['name'],
            'children' => $children_data,
            'column' => $category['column'] ? $category['column'] : 1,
            'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
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

    /* _______ ПРИВЕДЕНИЕ КУРСА В НОРМАЛЬНЫЙ ВИД ___________ */
    $full_course = file_get_contents('https://mt21.ru/export-price/sek_cours.txt');
    $round_course = round($full_course, 4);
    $arr_course = explode(".", $round_course);
    $html_сopecks = '<span>' . str_pad($arr_course[1], 4, 0) . '</span>';
    $data['normal_course'] = $arr_course[0] . '.' . $html_сopecks;
    /* _____________________________________________________ */

    /* __________________ ОПРЕДЕЛЕНИЕ РЕГИОНА __________________ */
    include("identify-region.php");
    $data['phone'] = get_region_phone_number();

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
      return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
    } else {
      return $this->load->view('default/template/common/header.tpl', $data);
    }
  }
}