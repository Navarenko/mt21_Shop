<?php
class ControllerMshpoAjax extends Controller {
	
	public function statistics() {
		
		error_reporting(0);
		$this->load->language('mshpo/ajax');
		
		if($this->request->request['ACTION']=='getstat')
		{
			switch($this->request->request['DAY'])
			{
				case 'day': $day=0;break;
				case 'week':$day=date('N')-1;break;
				case 'month':$day=date('d')-1;break;
				case 'year':$day=intval(date('z'));break;
				default:
					$day=false;
					if($this->request->request['DAY'] && $this->request->request['DAY']!=='false')
					{
						if(strpos($this->request->request['DAY'],'spec')!==false || strpos($this->request->request['DAY'],'regi')!==false || strpos($this->request->request['DAY'],'last')!==false)
						{
							$dayFrom=substr($this->request->request['DAY'],4,strpos($this->request->request['DAY'],'|')-4);
							if(preg_match('/([\d]{2})\.([\d]{2})\.([\d]{4})/',$dayFrom,$matches))
								$dayFrom=$matches[3].".".$matches[2].".".$matches[1];
							else $dayFrom=false;
							$dayTo=substr($this->request->request['DAY'],strpos($this->request->request['DAY'],'|')-1);
							if(preg_match('/([\d]{2})\.([\d]{2})\.([\d]{4})/',$dayTo,$matches))
								$dayTo=$matches[3].".".$matches[2].".".$matches[1];
							else $dayTo=false;
							if(strpos($this->request->request['DAY'],'spec')!==false)
							{
								$day=array(false,false);
								if(strlen($dayFrom)==10)
									$day[0]=$dayFrom;
								if(strlen($dayTo)==10)
									$day[1]=$dayTo;
								if(!$day[0] && !$day[1])
									$day=false;
							}
						}
						else
							$day=$this->request->request['DAY'];
					}
					break;
			}
			
			$result=self::getStatSql($day);
			
			$strReturn='';
			$total=intval($result['TTL']);
			unset($result['TTL']);

			if(strpos($this->request->request['DAY'],'last')!==false)
				krsort($result,SORT_STRING);
			if(strpos($this->request->request['DAY'],'regi')!==false||strpos($this->request->request['DAY'],'last')!==false)
			{
				$strFostrReturn='';
				$workedTokens=array();
				$visits=0;
				$hints = '';
				foreach($result as $date => $dayInfo)
				{
					$strDay=false;
					foreach($dayInfo['UDIDS'] as $udid =>$udidInfo)
					{	
						$chekDate=false;
						if(!in_array($udid,$workedTokens))
						{
							$workedTokens[]=$udid;
							preg_match('/([\d]{2})\.([\d]{2})\.([\d]{4})/',$date,$matches);
							$chekDate=$matches[3].".".$matches[2].".".$matches[1];
							if(($chekDate>=$dayFrom || !$dayFrom) && ($chekDate<=$dayTo || !$dayTo))
							{
								$labelH = $udid.str_replace(".","",$date);
								$visits++;
								$detailInfo="token : ".$udidInfo['TOKEN']."<br>udid : ".$udid."<br>deviceName : ".$udidInfo['DEVICE_NAME']."<br>".$udidInfo['DEVICE_INFO'];
								$detailInfo='<div id="hlpr_'.$labelH.'" class="b-popup" style="display:none"><div class="pop-text">'.$detailInfo.'</div><div class="close" onclick="$(this).closest(\'.b-popup\').hide();">x</div></div>';
								$strUdid='no udid';
								if($udid)
									$strUdid=substr($udid,0,5)." ... ".substr($udid,-5)." ".$udidInfo['DEVICE_NAME'];
								$strDay.="<tr><td id='tbl_".$labelH."' onclick='IPOLMSHP_clickTable(this)'>".$strUdid."</td><td>";
								if($udidInfo['TOKEN'] && $udidInfo['TOKEN']!=='no token')
									$strDay.="<input type='checkbox' onchange='IPOLMSHP_onCheckBoxClick($(this))' value='".$udidInfo['TOKEN']."'>";
								$strDay.="</td></tr>";
								$hints.=$detailInfo;
							}
						}
					}
					if($strDay)
						$strFostrReturn.='<tr><td>'.$date."</td><td><table class='table table-hover'>".$strDay.'</table></td></tr>';
				}
				if($strFostrReturn)
					$strReturn.='<table class="table"><tr><th>'.$this->language->get("IPOLMSHP_STAT_REGIDATE").'</th><th>'.$this->language->get("IPOLMSHP_STAT_VISITERS").'</th></tr>'.$strFostrReturn.'</table>'.$hints.'<input type="button" class="btn btn-default pull-right" value="'.$this->language->get('IPOLMSHP_STAT_WNDTITLE').'" onclick="IPOLMSHP_windowShow()">';
				else
					$strReturn='<p>'.$this->language->get("IPOLMSHP_STAT_TOTAL").": 0</p><br>";
				echo '<p>'.$this->language->get("IPOLMSHP_STAT_TOTAL").': '.$visits."</p>".$strReturn;
				die();
			}
			if($this->request->request['DETAIL'])
			{
				if($this->request->request['UDID'])
				{
					if($total>0)
					{
						$strReturn.='<table class="table"><tr><th>'.$this->language->get("IPOLMSHP_STAT_VISITDATE").'</th>';
						if(!$this->request->request['IS_UNIC'])
							$strReturn.='<th>'.$this->language->get("IPOLMSHP_STAT_VISITCNT").'</th>';
						$strReturn.='</tr>';
						$lstToken='';
						foreach($result as $date => $visitors)
						{
							foreach($visitors['UDIDS'] as $udid => $param)
								$detailInfo="token : ".$param['TOKEN']."<br>udid : ".$udid."<br>deviceName : ".$param['DEVICE_NAME']."<br>".$param[	'DEVICE_INFO'];
							$labelH = $this->request->request['UDID'].str_replace(".","",$date);
							$detailInfo='<div id="hlpr_'.$labelH.'" class="b-popup" style="display:none"><div class="pop-text">'.$detailInfo.'</div><div class="close" onclick="$(this).closest(\'.b-popup\').hide();">x</div></div>';
							$strReturn.="<tr><td id='tbl_".$labelH."' onclick='IPOLMSHP_clickTable(this)'>".$date."</td>";
							if(!$this->request->request['IS_UNIC'])
								$strReturn.="<td id='tbl_".$labelH."' onclick='IPOLMSHP_clickTable(this)'>".$visitors['TTL']."</td>";
							$strReturn.="</tr>";
							$hints.=$detailInfo;
							$lstToken=$param['TOKEN'];
						}
						$strReturn.='</table>'.$hints.'<input type="button" class="btn btn-default pull-right" value="'.$this->language->get('IPOLMSHP_STAT_WNDTITLE').'" onclick="IPOLMSHP_windowShow()">';
						$strReturn.='<input type="hidden" id="IPOLMSHP_tokenPlace" value="'.$lstToken.'">';
					}
				}
				elseif($total>0)
				{
					$strReturn.='<table class="table"><tr><th>'.$this->language->get("IPOLMSHP_STAT_VISITDATE").'</th><th>'.$this->language->get("IPOLMSHP_STAT_VISITCNT").'</th><th><a href="javascript:void(0)" title="'.$this->language->get("IPOLMSHP_STAT_MARKALL").'" onclick="IPOLMSHP_selectAll()">'.$this->language->get("IPOLMSHP_STAT_VISITERS").'</a></th></tr>';
					foreach($result as $date => $visitors)
					{
						$strReturn.="<tr><td>".$date."</td><td>".$visitors['TTL']."</td><td><table class='table table-hover'>";
						
						foreach($visitors['UDIDS'] as $udid => $params)
						{
							$labelH = $udid.str_replace(".","",$date);
							$detailInfo="token : ".$params['TOKEN']."<br>udid : ".$udid."<br>deviceName : ".$params['DEVICE_NAME']."<br>".$params['DEVICE_INFO'];
							$detailInfo='<div id="hlpr_'.$labelH.'" class="b-popup" style="display:none"><div class="pop-text">'.$detailInfo.'</div><div class="close" onclick="$(this).closest(\'.b-popup\').css(\'display\',\'none\');return false;">x</div></div>';
							$strUdid='no udid';
							if($udid)
								$strUdid=substr($udid,0,5)." ... ".substr($udid,-5)." ".$params['DEVICE_NAME'];
							$strReturn.="<tr><td id='tbl_".$labelH."' onclick='IPOLMSHP_clickTable(this)'>".$strUdid."</td><td>";
							if(!$this->request->request['IS_UNIC'])
								$strReturn.=$params['VISITS']."</td><td>";
							if($params['TOKEN'] && $params['TOKEN']!=='no token')
								$strReturn.="<input type='checkbox' onchange='IPOLMSHP_onCheckBoxClick($(this))' value='".$params['TOKEN']."'>";
							$strReturn.="</td></tr>";
							$hints.=$detailInfo;
							
						}
							
						$strReturn.="</table></tr>";
					}
					
					$strReturn.='</table>'.$hints.'<input type="button" class="btn btn-default pull-right" value="'.$this->language->get('IPOLMSHP_STAT_WNDTITLE').'" onclick="IPOLMSHP_windowShow()">';
				
				}
			}

			echo '<p>'.$this->language->get("IPOLMSHP_STAT_TOTAL").': '.$total."</p><br>".$strReturn;
			
			// $this->mshpo->pre();
			
		}

		if($this->request->request['ACTION']=='delstat')
		{
			if(preg_match('/([\d]{2})\.([\d]{2})\.([\d]{4})/',$this->request->request['TERM'],$matches))
				$term=$matches[3].".".$matches[2].".".$matches[1];
			if($this->request->request['TERM']=='all')
				$term='all';
			if($term)
				$result=self::delStatSql($term);

			if($result!=='done')
				echo $this->language->get("IPOLMSHP_STAT_DELERROR");
			else
				echo $this->language->get("IPOLMSHP_STAT_DELETED");
		}
	
	}
	
	public function push() {
	
		error_reporting(0);	
		$this->load->language('mshpo/ajax');
		
		// error_reporting(E_ERROR | E_WARNING | E_PARSE);
		// ini_set("error_reporting", true);

		// if ($this->request->request["DEBUG"] == "Y")
		// {
			// $this->request->request['ACTION'] = 'addPush';
			// $this->request->request['tokens'] = "APA91bGPS3BbvkmsjRoX2U06cChMa4ucFABWzvTwqPu4lIWAGYBk0ghYOSCxMZPVDkBtYcOr1Jpj6VZrNcWxeOYcf2oV2vdQBUO-6CN2zlWAgLyTCtVwG8nkG3HXRgHLlbmGUYXNgEIR,";
			// $this->request->request['push'] = "123";
		// }

		//startDiffModules
		$pathToApns='/shop/system/library/ApnsPHP/';
		// $sertName='mt21';
		//endDiffModules

		$this->log->write($this->request->request); // write to log
		
		if($this->request->request['ACTION']=='addPush'){
			$arRecievers = explode(',',$this->request->request['tokens']);
			$arTokens = array();
			$arRegIds = array();
			$errors = false;
			$eWID   = false;
			$good   = false;
			foreach($arRecievers as $handle){
				if($handle != 'no token' && $handle){
					if(strlen($handle) < 75)
						$arTokens[] = $handle;
					else
						$arRegIds[] = $handle;
				}
			}
			
			// Apple
			if(count($arTokens)/* && !$this->request->request['BLOCK_APPLE']*/){

				date_default_timezone_set('Europe/Rome');
				error_reporting(-1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);				
				require_once $_SERVER["DOCUMENT_ROOT"].$pathToApns.'Autoload.php';
				 
				if($this->config->get('mshpo_push_status') == 1)
					$push = new ApnsPHP_Push(
						ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION, 
						$_SERVER["DOCUMENT_ROOT"].$pathToApns.'mt21Dis.pem'
					); 
				else
					$push = new ApnsPHP_Push(
						ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
						$_SERVER["DOCUMENT_ROOT"].$pathToApns.'mt21Dev.pem'
					);
					
				$this->log->write($this->request->request); // write to log	
				$this->log->write($this->config->get('mshpo_push_status')); // write to log		
				$this->log->write($push); // write to log	 
				 
				 
				$push->setProviderCertificatePassphrase('123456');// надо
				$push->connect();
				foreach($arTokens as $token){
					if($token && strlen(str_replace(' ','',$token)) == 64)
					{
						$message = new ApnsPHP_Message(str_replace(' ','',$token));// Instantiate a new Message with a single recipient
						$message->setCustomIdentifier(date('dmYH').substr($token,0,5).'-'.substr($token,0,-5));// Set a custom identifier. To get back this identifier use the getCustomIdentifier() method over a ApnsPHP_Message object retrieved with the getErrors() message.
						// $message->setBadge(0);// Set badge icon to "3"
						$message->setText($this->request->request['push']);// Set a text
						if(array_key_exists('news',$this->request->request) && $this->request->request['news']) {
							$message->setCustomProperty('item_type',0); // инфо страница
							$message->setCustomProperty('id',$this->request->request['news']);
							$message->setCustomProperty('title',$this->request->request['push']);
						}
						elseif(array_key_exists('offers',$this->request->request) && $this->request->request['offers']) {
							$message->setCustomProperty('item_type',1); // продукт/предложение
							$message->setCustomProperty('id',$this->request->request['offers']);
							$message->setCustomProperty('title',$this->request->request['push']);
						}						
						$message->setSound();// Play the default sound
						$message->setExpiry(30);// Set the expiry value to 30 seconds
						$push->add($message);// Add the message to the message queue
					}
				}
				$push->send();// Send all messages in the message queue
				$push->disconnect();// Disconnect from the Apple Push Notification Service
				// Examine the error message container
				
				$aErrorQueue = $push->getErrors();
				
				$this->log->write($aErrorQueue); // write to log
				
				if (!empty($aErrorQueue)){
					
					foreach($aErrorQueue as $arMess){
						$badToken=array_pop($arMess['MESSAGE']->getRecipients());
						$errors.="\nTOKEN ".$badToken." ";
						foreach($arMess['ERRORS'] as $arError)
							$errors.=$arError['statusMessage'];
						foreach($arTokens as $key => $token)
						{
							$tmpToken=str_replace(' ','',$token);
							if($tmpToken==$badToken){
								unset($arTokens[$key]);}
						}
					}
					$this->request->request['tokens']=implode(',',$arTokens);
				}
				if((array_key_exists('offers',$this->request->request) && $this->request->request['offers']) || (array_key_exists('news',$this->request->request) && $this->request->request['news']) || self::ifAddedPush())
					$good = true;
				else{
					$eWID = '%error while inputting data%';
					if(strlen($this->request->request['tokens'])>=75)
						$good = true;
				}
			}
			// ANDROID
			if(count($arRegIds)/* && !$this->request->request['BLOCK_ANDROID']*/) {
				
				//$this->log->write("send android"); // write to log
				
				$fields = array(
					'registration_ids'  => $arRegIds,
					'data'              => array(
						"message" => $this->request->request['push'],
					),
				);
				
				if(array_key_exists('news',$this->request->request) && $this->request->request['news']) {
					$fields['data']['item_type'] = 0; // новость
					$fields['data']['id'] = $this->request->request['news'];
					$fields['data']['title'] = $this->request->request['push'];
				}
				elseif(array_key_exists('offers',$this->request->request) && $this->request->request['offers']) {
					$fields['data']['item_type'] = 1; // продукт/предложение
					$fields['data']['id'] = $this->request->request['offers'];
					$fields['data']['title'] = $this->request->request['push'];
				}				
				
				$headers = array(
					'Authorization: key=AIzaSyDuFxjM9pc4MENdhRmEtSzEwIUxLoiUPAY',
					'Content-Type: application/json'
				);
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
				
				if ($result === FALSE)
				{
					$errors .= curl_error($ch);
				}			
				
				$this->request->request['tokens']=implode(",",$arRegIds);
				
				if((array_key_exists('offers',$this->request->request) && $this->request->request['offers']) || (array_key_exists('news',$this->request->request) && $this->request->request['news']) || self::ifAddedPush())
					$good = true;
				else{
					$eWID = '%error while inputting data%';
					if(strlen($this->request->request['tokens'])>=75)
						$good = true;
				}
			}
			if($errors){
				echo "srt{".$errors."}";
			}
			elseif($eWID){
				echo ($good)? $eWID."%done%" : $eWID;
			}
			else{
				echo "%done%";
			}
		}
		elseif($this->request->request['ACTION']=='getpush')
		{
			$strHtml="<table class='table'><tr><th>".$this->language->get('IPOLMSHP_PUSH_DATE')."</th><th>".$this->language->get('IPOLMSHP_PUSH_TEXT')."</th><th>".$this->language->get('IPOLMSHP_PUSH_GOT')."</th><th><a href='javascript:void(0)' onclick='$(\".IPOLMSHP_checkPush\").prop(\"checked\",true);'>".$this->language->get('IPOLMSHP_PUSH_SELALL')."</a></th></tr>";
			unset($this->request->request['ACTION']);
			
			if(preg_match('/([\d]{2})\.([\d]{2})\.([\d]{4})/',$this->request->request['DAYFROM'],$matches))
				$this->request->request['DAYFROM']=$matches[3].".".$matches[2].".".$matches[1];
			else
				unset($this->request->request['DAYFROM']);
			if(preg_match('/([\d]{2})\.([\d]{2})\.([\d]{4})/',$this->request->request['DAYTO'],$matches))
				$this->request->request['DAYTO']=$matches[3].".".$matches[2].".".$matches[1];
			else
				unset($this->request->request['DAYTO']);
			
			if(!$this->request->request['TOKEN'])
				unset($this->request->request['TOKEN']);
			
			$arPushes=self::getPushesList();

			if(count($arPushes)){
				$strForHtml = "";
				foreach($arPushes as $push){
					if($push['TOKENS']{strlen($push['TOKENS'])-1}==',')
						$push['TOKENS']=substr($push['TOKENS'],0,strlen($push['TOKENS'])-1);
					preg_match('/([\d]{4})\.([\d]{2})\.([\d]{2})/',$push['INP_DATE'],$matches);
					$date=$matches[3].".".$matches[2].".".$matches[1];
					$tokens='<a href="javascript:void(0)" onclick="IPOLMSHP_showDetals(this,\''.$push['INP_DATE'].'\');return false;">'.str_replace(',','</a><br><a href="javasctipt:void(0)" onclick="IPOLMSHP_showDetals(this,\''.$push['INP_DATE'].'\');return false;">',$push['TOKENS'])."</a>";
					$strForHtml.="<tr><td>".$date."</td><td>".$push['PUSH']."</td><td><a href='javascript:void(0)' onclick='IPOLMSHP_toggleTokens($(this))'>".$this->language->get('IPOLMSHP_PUSH_SHOW')."</a><div style='display:none'>".$tokens."</div></td><td><input type='checkbox' class='IPOLMSHP_checkPush' value='".$push['ID']."'></td></tr>";
				}
				
				if($strForHtml)
					$strHtml.=$strForHtml."</table><br>
						<input type='button' class='btn btn-default pull-right' value='".$this->language->get('IPOLMSHP_PUSH_DELPUSH')."' onclick='IPOLMSHP_clearPush()'/>";
			}
			else
				$strHtml="<p>".$this->language->get('IPOLMSHP_PUSH_NOSTAT')."</p>";

			echo $strHtml;
		}
		elseif($this->request->request['ACTION']=='delPush')
		{
			if(!$this->request->request['IDS']){echo 'noIds'; die();}

			$result=self::delPushes();

			if($result!=='done')
				echo $this->language->get("IPOLMSHP_STAT_DELERROR");
			else
				echo $this->language->get("IPOLMSHP_STAT_DELDONE");
		}
		elseif($this->request->request['ACTION']=='getParams')
		{
			if($this->request->request['TOKEN']&&$this->request->request['DATE'])
			{
				$arParams=self::getByTokens();
				echo 'token : '.$this->request->request['TOKEN']."<br>udid : ".$arParams['UDID']."<br>deviceName : ".$arParams['DEVICE_NAME']."<br>".$arParams['DEVICE_INFO'];
			}
		}	
	}

	public function delStatSql($term){
		$this->load->model('module/mshpo');
		return $this->model_module_mshpo->delStat($term);
	}	
	
	public function getStatSql($day){
		$this->load->model('module/mshpo');
		return $this->model_module_mshpo->getStat($day,$this->request->request['IS_UNIC'],$this->request->request['UDID'],$this->request->request['NNT']);
	}

	public function ifAddedPush(){
		$this->load->model('module/mshpo');
		return $this->model_module_mshpo->inputPush(array('PUSH'=>$this->request->request['push'],'TOKENS'=>$this->request->request['tokens']));
	}
	
	public function getPushesList(){
		$this->load->model('module/mshpo');
		return $this->model_module_mshpo->getList($this->request->request);
	}	

	public function delPushes(){
		$this->load->model('module/mshpo');
		return $this->model_module_mshpo->delPush($this->request->request['IDS']);
	}		

	public function getByTokens(){
		$this->load->model('module/mshpo');
		return $this->model_module_mshpo->getByToken($this->request->request['TOKEN'],$this->request->request['DATE']);
	}		
	
}