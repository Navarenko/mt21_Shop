<?php
class ModelModuleMshpo extends Model {
	
	public function addTables() {
		
		$query = "create table if not exists " . DB_PREFIX . "ipol_mshpStatistics (
					ID int(11) NOT NULL auto_increment,
					TOKEN varchar(255) NOT NULL,
					UDID varchar(255) NOT NULL,
					DEVICE_NAME varchar(255) NOT NULL,
					DEVICE_INFO varchar(255) NOT NULL,
					VIS_DATE varchar(10),
					VISITS tinyint UNSIGNED,
					PRIMARY KEY(ID),
					INDEX ix_ipol_kmudid(UDID)
				)";
		
		$this->db->query($query);
		
		$query = "create table if not exists " . DB_PREFIX . "ipol_mshpPush (
					ID int(11) NOT NULL auto_increment,
					PUSH TEXT,
					INP_DATE varchar(10),
					TOKENS MEDIUMTEXT,
					PRIMARY KEY(ID),
					INDEX ix_ipol_kmudid(INP_DATE)
				)";	
		
		$this->db->query($query);

	}

	public function deleteTables() {
		
		$query = "drop table if exists " . DB_PREFIX . "ipol_mshpStatistics";
		$this->db->query($query);
		
		$query = "drop table if exists " . DB_PREFIX . "ipol_mshpPush";
		$this->db->query($query);		

	}
	
	public function show($tableName) {
		
		self::showStr($tableName);
				
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "$tableName WHERE 1");
		foreach ($res->rows as $result) {
			echo "<pre>"; print_r($result); echo "</pre>";
		}		

	}

	public function showStr($tableName) {
				
		$res = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "$tableName");
		foreach ($res->rows as $result) {
			echo "<pre>"; print_r($result); echo "</pre>";
		}		

	}	
	

}