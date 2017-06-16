<?php

/*
 * CURRENCY UPDATER - v 1.0.0 (22.04.2014)
*/

define('OPENCART_ROOT_DIR', '/shop/admin/');

require_once(OPENCART_ROOT_DIR . "config.php");
require_once(DIR_SYSTEM . 'startup.php');
require_once(DIR_DATABASE . 'mysql.php');

// Registry
$registry = new Registry();

// Loader
$obj = new Loader($registry);
$registry->set('load', $obj);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting");

foreach ($query->rows as $setting) {
        $config->set($setting['key'], $setting['value']);
}

// Cache
$registry->set('cache', new Cache());

//Request
$request = new Request();
$registry->set('request', $request);

// Language Detection
$query = $db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $config->get('config_language') .  "'");
$language_id = $query->row['language_id'];
$config->set('config_language_id', $language_id);

// Default Store
$config->set('config_store_id', 0);

//define('HTTP_SERVER', $config->get('config_url'));

//Currency update
$obj->load->model('localisation/currency');
$request->post['manual_update'] = true;
$obj->model_localisation_currency->updateCurrencies();

echo "Done!\n";
?>