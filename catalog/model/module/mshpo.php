<?php
class ModelModuleMshpo extends Model {
	
	
	public function Visit($data)
    {
		
        // = $Data = format:
		//TOKEN varchar(255) NOT NULL,
		//UDID varchar(255) NOT NULL,
		//DEVICE_NAME varchar(255) NOT NULL,
		//DEVICE_INFO varchar(255) NOT NULL,
		//VIS_DATE DATE,
		//VISITS tinyint UNSIGNED,
		
		$data['VIS_DATE']=date('Y.m.d');

		$rec = self::checkRecord($data['UDID'],$data['VIS_DATE']);//либо array(id,visits) либо false

		if($rec)//сегодня уже заходил
		{
			$data['VISITS']=intval($rec['VISITS'])+1;
			$put = self::PrepareUpdate($data);
			$query = "UPDATE " . DB_PREFIX . "ipol_mshpStatistics SET $put WHERE ID='".$rec['ID']."'";
			$this->db->query($query);
		}
		else//не было сегодня
		{
			$data['VISITS']=1;
			$put = self::PrepareInsert($data);
			$query = "INSERT INTO " . DB_PREFIX . "ipol_mshpStatistics SET $put";

			$this->db->query($query);
		}
		
		return true; 
    }
	
	public function checkRecord($udid,$date) // Проверяет наличие записи
	{
		
        $query =
            "SELECT ID, VISITS ".
            "FROM " . DB_PREFIX . "ipol_mshpStatistics ".
			"WHERE UDID = '" . $udid . "' and VIS_DATE = '" . $date . "'";
		
		$res = $this->db->query($query);
		
		foreach ($res->rows as $result) {
				return array('ID'=>$result['ID'],'VISITS'=>$result['VISITS']);
				break;
		}
		
		return false;
		
	}
	
	public function getStat($dayCount=false,$isUnic=false,$udid=false,$nnt=false)//дни выборки, выводить ли только уникальные, конкретный юзер, не выводить без токена
	{
		
		$where='';
		if(is_array($dayCount))
		{
			if($dayCount[0])
				$dayCount[0]=' VIS_DATE >= "'.$dayCount[0].'"';
			if($dayCount[1])
				$dayCount[1]=' VIS_DATE <= "'.$dayCount[1].'"';
			$where="WHERE".$dayCount[0];
			if($dayCount[0] && $dayCount[1])
				$where.=" and";
			$where.=$dayCount[1];
		}
		elseif($dayCount !== false)
		{
			$dayCount=date('Y.m.d',(time()-($dayCount+1)*24*60*60));
			$dayCount=$this->db->escape($dayCount);
			$where="WHERE VIS_DATE > '".$dayCount."'";
		}
		$user='';
		if($udid)
		{
			$udid=$this->db->escape($udid);
			$user="UDID = '".$udid."'";
			if($where)
				$where.=' and '.$user;
			else
				$where='WHERE '.$user;
		}
		
		if($nnt)
		{
			if($where)
				$where.=' and TOKEN != "no token"';
			else
				$where='WHERE TOKEN != "no token"';
		}
		
		$query =
            "SELECT VISITS, VIS_DATE, UDID, TOKEN, DEVICE_NAME, DEVICE_INFO ".
            "FROM " . DB_PREFIX . "ipol_mshpStatistics ".
			$where;
		
		$res = $this->db->query($query);

		$returnArray=array();
		$ttl=0;
		foreach ($res->rows as $arr) {
			
			$date=substr($arr['VIS_DATE'],8).substr($arr['VIS_DATE'],4,4).substr($arr['VIS_DATE'],0,4);
			if($isUnic)
			{
				$ttl++;
				$returnArray[$date]['TTL']=$returnArray[$date]['TTL']+1;
				$returnArray[$date]['UDIDS'][$arr['UDID']]=array('VISITS'=>$arr['VISITS'],'TOKEN'=>$arr['TOKEN'],'DEVICE_NAME'=>$arr['DEVICE_NAME'],'DEVICE_INFO'=>$arr['DEVICE_INFO']);
			}
			else
			{
				$ttl+=$arr['VISITS'];
				$returnArray[$date]['TTL']=$returnArray[$date]['TTL']+$arr['VISITS'];
				$returnArray[$date]['UDIDS'][$arr['UDID']]=array('VISITS'=>$arr['VISITS'],'TOKEN'=>$arr['TOKEN'],'DEVICE_NAME'=>$arr['DEVICE_NAME'],'DEVICE_INFO'=>$arr['DEVICE_INFO']);
			}
		}
		$returnArray['TTL']=$ttl;
		
		return $returnArray;
	}

	public function delStat($term=false)
	{
		if(!$term)
			return false;
				
		$term=$this->db->escape($term);
		$where='';
		if($term!=='all')
			$where='WHERE VIS_DATE <= "'.$term.'"';
		
		$strSql =
            "DELETE FROM " . DB_PREFIX . "ipol_mshpStatistics ".
			$where;
			
		$res = $this->db->query($query);

		return 'done';
	}
	
	public function getByToken($token,$day)
	{
		if(!$token||!$day)
			return false;
				
		$token=$this->db->escape($token);
		$day=$this->db->escape($day);
		
		$query =
            "SELECT VISITS, VIS_DATE, UDID, TOKEN, DEVICE_NAME, DEVICE_INFO ".
            "FROM " . DB_PREFIX . "ipol_mshpStatistics ".
			'WHERE TOKEN = "'.$token.'" and VIS_DATE <= "'.$day.'"';
			
		$res = $this->db->query($query);
		
		foreach ($res->rows as $result) {
				return $result;
				break;
		}
		
		return false;
	}
	
	public function PrepareUpdate($data) {
		
		$ret_arr = array();
		foreach ($data as $key => $value) {
			$ret_arr[] = "$key = '" . $this->db->escape($value) . "'";
		}
		
		return implode(", ", $ret_arr);

	}	
	
	public function PrepareInsert($data) {
		
		$ret_arr = array();
		foreach ($data as $key => $value) {
			$ret_arr[] = "$key = '" . $this->db->escape($value) . "'";
		}
		
		return implode(", ", $ret_arr);

	}
	
	
	public function inputPush($Data)
	{
		// = $Data = format:
		//PUSH TEXT,
		//INP_DATE varchar(10),
		//TOKENS MEDIUMTEXT,

		$Data['INP_DATE']=date('Y.m.d');
		
		$rec = self::checkPush($Data['PUSH'],$Data['INP_DATE']);//либо array(id,visits) либо false
		if($rec)//если такой пуш уже отсылался
		{
			$sended=explode(',',$Data['TOKENS']);
			$resieved=explode(',',$rec['TOKENS']);
			$rezArray=array();
			foreach(array_merge($sended,$resieved) as $token)
				if(!in_array($token,$rezArray) && $token)
					$rezArray[]=$token;
			$Data['TOKENS']=implode(',',$rezArray);
			$put = self::PrepareUpdate($Data);
			$query = "UPDATE " . DB_PREFIX . "ipol_mshpPush SET $put WHERE ID='".$rec['ID']."'";
			$this->db->query($query);
		}
		else//не отсылался
		{
		
			$put = self::PrepareInsert($Data);
			$query = "INSERT INTO " . DB_PREFIX . "ipol_mshpPush SET $put";
			$this->db->query($query);		
		
		}
		
		return true; 
	}	
	
	public function checkPush($push,$date) // Проверяет наличие записи
	{
		$push = $this->db->escape($push);
		$date = $this->db->escape($date);
       
		$query =
            "SELECT ID, TOKENS ".
            "FROM " . DB_PREFIX . "ipol_mshpPush ".
			"WHERE PUSH = '".$push."' and INP_DATE = '".$date."'";
		
		$res = $this->db->query($query);
		
		if($res) {
		
			foreach ($res->rows as $result) {
					return array('ID'=>$result['ID'],'TOKENS'=>$result['TOKENS']);
					break;
			}
			
		}
		
		return false;	
	}

	public function getList($arFilter=false)
	{
		$where='';
		if($arFilter)
		{
			$dayFilter='';
			$dayCount=array(false,false);
			if($arFilter['DAYFROM'])
				$dayCount[0]=' INP_DATE >= "'.$arFilter['DAYFROM'].'"';
			if($arFilter['DAYTO'])
				$dayCount[1]=' INP_DATE <= "'.$arFilter['DAYTO'].'"';
			$dayFilter=$dayCount[0];
			if($dayCount[0] && $dayCount[1])
				$dayFilter.=" and";
			$dayFilter.=$dayCount[1];
			
			$tokenFilter='';
			if($arFilter['TOKEN'])
				$tokenFilter=' TOKENS LIKE "%'.$arFilter['TOKEN'].'%" ';
			if($dayFilter && $tokenFilter)
				$tokenFilter=' and '.$tokenFilter;
			
			if($dayFilter || $tokenFilter)
				$where='WHERE '.$dayFilter.$tokenFilter;
		}
		
		$query =
            "SELECT PUSH, INP_DATE, TOKENS, ID ".
            "FROM " . DB_PREFIX . "ipol_mshpPush ".
			$where;
		$res = $this->db->query($query);
		
		$arReturn=false;
		foreach ($res->rows as $element)
		{
			$arReturn[]=$element;
		}
		return $arReturn;
	}
	
	public function delPush($wat)
	{
		if(!$wat)
			return false;
		
		$wat_arr = explode(",", $wat);
		foreach($wat_arr as $id)
			if((int) $id <= 0 || !is_numeric($id))
				return false;
				
		$query =
            "DELETE FROM " . DB_PREFIX . "ipol_mshpPush WHERE ID IN ($wat)";
			
		$res = $this->db->query($query);

		return 'done';
	}

}