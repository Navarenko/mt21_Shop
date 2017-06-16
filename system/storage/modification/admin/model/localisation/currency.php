<?php
class ModelLocalisationCurrency extends Model {
	public function addCurrency($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "currency SET title = '" . $this->db->escape($data['title']) . "', code = '" . $this->db->escape($data['code']) . "', symbol_left = '" . $this->db->escape($data['symbol_left']) . "', symbol_right = '" . $this->db->escape($data['symbol_right']) . "', decimal_place = '" . $this->db->escape($data['decimal_place']) . "', value = '" . $this->db->escape($data['value']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW()");

		if ($this->config->get('config_currency_auto')) {
			$this->refresh(true);
		}

		$this->cache->delete('currency');
	}

	public function editCurrency($currency_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "currency SET title = '" . $this->db->escape($data['title']) . "', code = '" . $this->db->escape($data['code']) . "', symbol_left = '" . $this->db->escape($data['symbol_left']) . "', symbol_right = '" . $this->db->escape($data['symbol_right']) . "', decimal_place = '" . $this->db->escape($data['decimal_place']) . "', value = '" . $this->db->escape($data['value']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE currency_id = '" . (int)$currency_id . "'");

		$this->cache->delete('currency');
	}

	public function deleteCurrency($currency_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "currency WHERE currency_id = '" . (int)$currency_id . "'");

		$this->cache->delete('currency');
	}

	public function getCurrency($currency_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE currency_id = '" . (int)$currency_id . "'");

		return $query->row;
	}

	public function getCurrencyByCode($currency) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = '" . $this->db->escape($currency) . "'");

		return $query->row;
	}

	public function getCurrencies($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "currency";

			$sort_data = array(
				'title',
				'code',
				'value',
				'date_modified'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY title";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$currency_data = $this->cache->get('currency');

			if (!$currency_data) {
				$currency_data = array();

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency ORDER BY title ASC");

				foreach ($query->rows as $result) {
					$currency_data[$result['code']] = array(
						'currency_id'   => $result['currency_id'],
						'title'         => $result['title'],
						'code'          => $result['code'],
						'symbol_left'   => $result['symbol_left'],
						'symbol_right'  => $result['symbol_right'],
						'decimal_place' => $result['decimal_place'],
						'value'         => $result['value'],
						'status'        => $result['status'],
						'date_modified' => $result['date_modified']
					);
				}

				$this->cache->set('currency', $currency_data);
			}

			return $currency_data;
		}
	}

	
                public function refresh() {
                    file_get_contents(HTTP_SERVER."index.php?route=wgi/currency_plus&type=all");
                }

                public function refreshOLD(
            $force = false) {
		if (extension_loaded('curl')) {
			$data = array();

			if ($force) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "'");
			} else {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "' AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'");
			}

			foreach ($query->rows as $result) {
				$data[] = $this->config->get('config_currency') . $result['code'] . '=X';
			}

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $data) . '&f=sl1&e=.csv');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);

			$content = curl_exec($curl);

			curl_close($curl);

			$lines = explode("\n", trim($content));

			foreach ($lines as $line) {
				$currency = utf8_substr($line, 4, 3);
				$value = utf8_substr($line, 11, 6);

				if ($currency == "EUR") { // собственный скрипт получения курса с ЦБ РФ

					$scripturl = 'http://www.cbr.ru/scripts/XML_dynamic.asp';
					$date_1=date('d/m/Y');
					//$date_2=date('d.m.Y', time()+86400);


					$currency_code='R01239';

					$requrl = "{$scripturl}?date_req1={$date_1}&date_req2={$date_1}&VAL_NM_RQ={$currency_code}";

					$doc = file($requrl);
					$doc = implode($doc, '');

					$r = array();

					if(preg_match("/<ValCurs.*?>(.*?)<\/ValCurs>/is", $doc, $m))
						# а потом ищем все вхождения <Record>...</Record>
						preg_match_all("/<Record(.*?)>(.*?)<\/Record>/is", $m[1], $r, PREG_SET_ORDER);

					$m = array();	# его уже использовали, реинициализируем
					$d = array();	# этот тоже проинициализируем

					for($i=0; $i<count($r); $i++) {
						if(preg_match("/Date=\"(\d{2})\.(\d{2})\.(\d{4})\"/is", $r[$i][1],$m)) {
							$dv = "{$m[1]}/{$m[2]}/{$m[3]}"; # Приводим дату в норм. вид
							if(preg_match("/<Nominal>(.*?)<\/Nominal>.*?<Value>(.*?)<\/Value>/is", $r[$i][2], $m)) {
								$m[2] = preg_replace("/,/",".",$m[2]);
								$d[] = array($dv, $m[1], $m[2]);
								}
							}
						}

					$last = array_pop($d);				# последний известный день
					$prev = array_pop($d);				# предпосл. известный день
					$date = $last[0];					# отображаемая дата
					$rate = sprintf("%.4f",$last[2]);	# отображаемый курс

					$cours = 1 / round($rate, 6);
					$value = $cours;

					//отправляем письмо

					$curdate = date("d-m-Y H:i:s");

					$to  = "design@mt21.ru, "; 
					$to .= "nikita@mt21.ru"; 

					$subject = "Обновление курса в интернет-магазине - ".$curdate.""; 

					$err = " | <font color=red>Ошибка 0</font> — Курс не записан в файл! Обновите вручную позже! | ";

					$message = ' 
					<html> 
					    <head> 
					        <title>Обновление курса в интернет-магазине</title> 
					    </head> 
					    <body> 
						<table border="0"><tr><td><img src="http://mt21.ru/export-price/robot.jpg"></td><td valign="top">
					        <h2>Отчет робота</h2>Cгенерирован автоматически <b>'.$curdate.'</b><br><br>
							— Курс составляет 1 RUB = <b>'.(($cours == 0) ? $err : $cours).'</b> EUR
							<br><br>
							<i>Курс '.$cours.' записан в базу</i>
							</td></tr>
							</table>
					    </body> 
					</html>'; 

					$headers  = "Content-type: text/html; charset=UTF-8 \r\n"; 
					$headers .= "From: Robot MT21 <noreply@mt21.ru>\r\n"; 
					$headers .= "Bcc: design@mt21.ru\r\n"; 

					//mail($to, $subject, $message, $headers);

					// Пишем содержимое в файл
					file_put_contents('test-price.txt', $message);
				}
				

				if ((float)$value) {
					$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . (float)$value . "', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($currency) . "'");
				}
			}

			$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($this->config->get('config_currency')) . "'");

			$this->cache->delete('currency');
		}
	}

	public function getTotalCurrencies() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "currency");

		return $query->row['total'];
	}
}
?>