<?php
class ModelWgiCurrencyPlus extends Model {

    public function updateCurrencies($force = true, $type = 'all', $data = array() ) {
        $this->create_fields();

        $arr_new_res = array();

        if ($type == 'product' and isset($data['product_id']) and (int)$data['product_id'] > 0) {
            $sql_where = " AND product_id = ".(int)$data['product_id'];
        }
        else {
            $sql_where = "";
        }

        $sql = "SELECT * FROM " . DB_PREFIX . "currency";
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $arr_new_res[$result['code']] = array('value' => str_replace(",", ".", $result['value']), 'value_official' => $result['value_official'],
                'nominal' => $result['nominal'],
            );
        }

        if ($type == 'currency' or $type == 'all') {
            if ($this->config->get('currency_plus_charcode')) {
                $source = $this->config->get('currency_plus_charcode');
            }
            else {
                $source = 'RUB';
            }
            $arr_new_res = $this->getCourse($source);
        }

        //print_r($arr_new_res);

        foreach ($arr_new_res as $key => $val) {
            if ($val['value'] > 0) {
                $sql_1 = "UPDATE " . DB_PREFIX . "currency SET `value` = " . $val['value'] . ", value_official='" . $val['value_official'] . "', `nominal` = " . $val['nominal'] . ", date_modified=now() WHERE code='".$key."' ";
                //echo $sql_1."\n";

                if ($val['value'] and $val['value'] > 0) {
                    $val['value'] =  str_replace(",", ".", 1/$val['value']);
                }
                else {
                    $val['value'] = 0;
                }

                if (!$force) {
                    $sql_1 .= " AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "' ";
                    $sql_1 .= " AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "' ";
                }

                if ($type == 'all' or $type == 'currency') {
                    $this->db->query($sql_1);
                }

                if ($type == 'product' or $type == 'all') {
                    $sql = "SELECT value FROM " . DB_PREFIX . "currency WHERE code='".$key."' LIMIT 1";
                    $query = $this->db->query($sql);
                    if ($query->num_rows) {
                        $value = $query->row['value'];

                        if ($value and $value > 0) {
                            $value =  str_replace(",", ".", 1/$value);
                        }
                        else {
                            $value = 0;
                        }

                        if ($value > 0) {
                            $sql = "SELECT * FROM `" . DB_PREFIX . "product` LIMIT 1";
                            $query = $this->db->query($sql);
                            $result = $query->row;

                            $update_val = $this->updatePriceValue($result, $value);

                            $sql_3 = "UPDATE " . DB_PREFIX . "product SET date_modified=now(), ".$update_val."
                                        WHERE base_price > 0 AND base_currency_code='".$key."' ".$sql_where;

                            if (!$force and $type == 'all') {
                                $sql_3 .= " AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "' ";
                            }

                            //echo $sql_3."\n\n";
                            $this->db->query($sql_3);
                        }

                        $sql_4 = "UPDATE " . DB_PREFIX . "product SET price = 0 WHERE price < 0 ";
                        $this->db->query($sql_4);
                    }
                }


                if ($type == 'all' or $type == 'product') {
                    $round_val = $this->roundPriceValue('base_price', $val['value'], $this->config->get('currency_plus_round'));

                    $update_val = $this->updatePriceValue($result, $val['value']);

                    $sql = "SELECT product_id,extra_charge FROM " . DB_PREFIX . "product WHERE base_currency_code='".$key."' ".$sql_where;
                    if (!$force) {
                        $sql .= " AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "' ";
                    }
                    $query = $this->db->query($sql);


                    foreach ($query->rows as $result) {
                        $update = str_replace('extra_charge', $result['extra_charge'], $update_val);

                        $sql_4 = "UPDATE " . DB_PREFIX . "product_option_value SET ".$update."
                                    WHERE base_price > 0 AND product_id = '".$result['product_id']."' ";

                        $this->db->query($sql_4);

                        $sql_5 = "UPDATE " . DB_PREFIX . "product_discount SET price = ".$round_val."
                                    WHERE base_price > 0 AND product_id = '".$result['product_id']."'
                                    AND ( date_end = '0000-00-00' OR date_end > NOW() ) ";
                        $this->db->query($sql_5);

                        $sql_6 = "UPDATE " . DB_PREFIX . "product_special SET price = ".$round_val."
                                    WHERE base_price > 0 AND product_id = '".$result['product_id']."'
                                    AND ( date_end = '0000-00-00' OR date_end > NOW() ) ";
                        $this->db->query($sql_6);
                    }

                    $sql_1 = "UPDATE " . DB_PREFIX . "product_option_value SET price = 0 WHERE price < 0 ";
                    $this->db->query($sql_1);

                    $sql_1 = "UPDATE " . DB_PREFIX . "product_discount SET price = 0 WHERE price < 0 ";
                    $this->db->query($sql_1);

                    $sql_1 = "UPDATE " . DB_PREFIX . "product_special SET price = 0 WHERE price < 0 ";
                    $this->db->query($sql_1);
                }
            }
        }

        $this->cache->delete('product');
        $this->cache->delete('yml');
    }

    public function create_fields() {

        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product WHERE field = 'base_price'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD COLUMN `base_price` decimal(15,4) NOT NULL;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "currency WHERE field = 'value_official'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "currency` ADD COLUMN `value_official` float(15,8) NULL;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "currency WHERE field = 'nominal'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "currency` ADD COLUMN `nominal` smallint NULL;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product WHERE field = 'base_currency_code'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD COLUMN `base_currency_code` varchar(3) NOT NULL DEFAULT '".$this->config->get('config_currency')."' AFTER `base_price`;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_option_value WHERE field = 'base_price'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD COLUMN `base_price` decimal(15,4) NOT NULL AFTER `price`;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_discount WHERE field = 'base_price'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_discount` ADD COLUMN `base_price` decimal(15,4) NOT NULL AFTER `price`;");
        }

        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_special WHERE field = 'base_price'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_special` ADD COLUMN `base_price` decimal(15,4) NOT NULL AFTER `price`;");
        }

        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product WHERE field = 'extra_charge'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD COLUMN `extra_charge` decimal(15,4) NOT NULL DEFAULT 0 AFTER `price`;");
        }
        else {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` MODIFY COLUMN `extra_charge` decimal(15,4) NOT NULL DEFAULT 0 AFTER `price`;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product WHERE field = 'cost'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_option_value WHERE field = 'cost'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "order_product WHERE field = 'cost'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
        }


        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "order_option WHERE field = 'cost'");
        if (count($query->rows) == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "order_option` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000';");
        }
    }


    private function updatePriceValue($result, $value) {
        $round_val = $this->roundPriceValue('base_price', $value, $this->config->get('currency_plus_round'));
        $round_val_for_cost = $this->roundPriceValue('base_price', $value, 'NO');

        if (count($result) == 0 or (count($result) > 0 and !isset($result['cost']) and !isset($result['extra_charge']))) {
            $update_val = " price = ".$round_val;
        }
        elseif (count($result) > 0) {
            if ( isset($result['cost']) and !isset($result['extra_charge'])) {
                $update_val = " price = ".$round_val.", cost = ".$round_val_for_cost;
            }
            elseif ( !isset($result['cost']) and isset($result['extra_charge'])) {
                $update_val = " price = ".$round_val;
            }
            elseif ( isset($result['cost']) and isset($result['extra_charge'])) {
                $round_val_2 = $this->roundPriceValue('base_price', $value, $this->config->get('currency_plus_round'), 'extra_charge');

                $update_val = " price = ".$round_val_2.", cost = ".$round_val_for_cost;
            }
        }

        return $update_val;
    }


    private function roundPriceValue($name, $value, $round, $extra_charge = '') {
        if ($extra_charge != '') {
            $name = "(".$name."+(".$name."/100*".$extra_charge."))";
        }

        if ($round == 'digit10' or $round == 'digit5' or $round == 'digit50' or $round == 'digit100' or $round == 'digit1000' or
            $round == 'digit10000' or $round == 'digit100000') {

            $digits = (int)str_replace('digit', '' ,$round);
            $round_val = "ROUND(".$name."*".$value."/".$digits.", 0)*".$digits;
        }
        elseif ($round == 'digit9') {
            $round_val = "ROUND(".$name."*".$value."/10, 0)*10 - 1";
        }
        elseif ($round == 'digitx9') {
            $round_val = "ROUND(".$name."*".$value."/0.1, 0)*0.1 - 0.01";
        }
        elseif ($round == 'digit01') {
            $round_val = "ROUND(".$name."*".$value."/0.1, 0)*0.1";
        }
        elseif ($round == 'digit001') {
            $round_val = "ROUND(".$name."*".$value."/0.01, 0)*0.01";
        }
        elseif ($round == 'digit99') {
            $round_val = "ROUND(".$name."*".$value.", 0) - 0.01";
        }
        elseif ($round == 'digit1') {
            $round_val = "ROUND(".$name."*".$value.", 0)";
        }
        elseif ($round == 'digit1_plus') {
            $round_val = "CEIL(".$name."*".$value.", 0)";
        }
        else {
            $round_val = "ROUND(".$name."*".$value.", 4)";
        }

        return $round_val;
    }


    private function getCourse($source = 'RUB') {
        //echo $source;

        if ($source == 'RUB' or $source == 'RUR') {
            $Request = "http://www.cbr.ru/scripts/XML_daily.asp";

            $arr = array('title' => 'CharCode', 'nominal' => 'Nominal', 'value' => 'Value');
        }
        elseif ($source == 'KZT') {
            $Request = "http://www.nationalbank.kz/rss/rates_all.xml";

            $arr = array('title' => 'title', 'nominal' => 'quant', 'value' => 'description');
        }
        elseif ($source == 'UAH') {
            $Request = "http://bank-ua.com/export/currrate.xml";
            $arr = array('title' => 'char3', 'nominal' => 'size', 'value' => 'rate');

            //$Request = "http://pfsoft.com.ua/service/currency/";
            //$arr = array('title' => 'CharCode', 'nominal' => 'Nominal', 'value' => 'Value');
        }
        elseif ($source == 'BYR') {
            $Request = "http://www.nbrb.by/Services/XmlExRates.aspx";

            $arr = array('title' => 'CharCode', 'nominal' => 'Scale', 'value' => 'Rate');
        }


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $Request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $Response = curl_exec($curl);
        //print_r($Response);

        curl_close($curl);

        $reader = new XMLReader();
        //$reader->open($Request);

        $arr_base_res = array();

        if ($Response) {
            $reader->xml($Response);
            while ($reader->read()) {
                switch ($reader->nodeType) {
                    case (XMLREADER::ELEMENT):
                        if ( $reader->localName == $arr['title']) {
                            $reader->read();
                            $local_name = $reader->value;
                        }
                        elseif ( $reader->localName == $arr['nominal']) {
                            $reader->read();
                            $local_nominal = $reader->value;

                            $arr_nominal[$local_name] = $local_nominal;
                        }
                        elseif ( $reader->localName == $arr['value']) {
                            $reader->read();
                            $value = $reader->value;

                            //echo $value;

                            if ($source == 'RUB' or $source == 'RUR') {
                                $pos = strpos($value,',');
                                //echo $pos."\n";
                                if ($pos > 0) {
                                    $value = (substr($value,0,$pos).'.'.substr($value,$pos+1));
                                }
                            }

                            $arr_base_res[$local_name] = $value;
                        }
                }
            }
        }

        //print_r($arr_base_res);
        //print_r($arr_nominal);
        //echo $this->config->get('config_currency')."\n\n";

        foreach ($arr_base_res as $k => $v) {
            if ($k == $this->config->get('config_currency')) {
                $summa = $v/$arr_nominal[$k];
                //echo " - summa=".$summa."\n\n";

                break;
            }
        }

        foreach ($arr_base_res as $key => $value) {
            if ($key == $this->config->get('config_currency')) {
                $arr_new_res[$key] = 1;
            }
            elseif ($key != $this->config->get('config_currency') and $this->config->get('config_currency') == $source) {
                $arr_new_res[$key] = str_replace(",", ".", (1/$value*$arr_nominal[$key]));
            }
            elseif ($key != $this->config->get('config_currency') and $this->config->get('config_currency') != $source
                and isset($arr_nominal[$key]) and $arr_nominal[$key] != 0) {
                $res1 = $value/$arr_nominal[$key];

                //echo "key=".$key." value=".$value." nominal=".$arr_nominal[$key]." res1=".$res1."\n";

                if (isset($summa) and $summa > 0) {
                    $res = $res1/$summa;
                }
                else {
                    $res = '0';
                }

                if (strlen($key) == 3) {
                    $arr_new_res[$key] = str_replace(",", ".", 1/$res);
                }
            }
        }


        if ($this->config->get('config_currency') == $source) {
            $arr_new_res[$source] = 1;
        }
        elseif (isset($arr_base_res[$this->config->get('config_currency')])) {
            $arr_new_res[$source] = str_replace(",", ".", $arr_base_res[$this->config->get('config_currency')]/$arr_nominal[$this->config->get('config_currency')]);
        }
        else {
            $arr_new_res[$source] = 0;
        }

        //print_r($arr_new_res);

        $arr_res = array();

        foreach($arr_new_res as $key => $val) {
            if (!isset($arr_base_res[$key])) {
                $arr_base_res[$key] = 1;
            }

            if (!isset($arr_nominal[$key])) {
                $arr_nominal[$key] = 1;
            }

            $arr_res[$key] = array('value' => $val, 'value_official' => $arr_base_res[$key], 'nominal' => $arr_nominal[$key]);
        }

        // print_r($arr_res);
        return $arr_res;
    }

}
?>