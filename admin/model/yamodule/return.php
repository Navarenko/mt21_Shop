<?php
class ModelYamoduleReturn extends Model {
	public $sum;
	public function addReturn($data){
		$this->db->query("INSERT INTO `" . DB_PREFIX . "mws_return` (`".implode("`,`",array_keys($data))."`)
			VALUES ('".implode("','",array_values($data))."')");
	}
	public function getSuccessReturns($inv){
		$data=array();
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mws_return` o WHERE o.invoice_id = '" . $inv."' ORDER BY `date` DESC");
		$sum = 0;
		if ($order_query->num_rows) {
			$returns = array_filter($order_query->rows, function($row) { return ($row['status'] == '0');});
			if ($returns) foreach ($returns as $k => $item) $sum += $item['amount'];
			$this->sum = $sum;
			return $returns;
		}
		return false;
	}
}
?>