<?php
class ControllerMshpoSearch extends Controller {

	public function index() {
	
		$this->log->write($this->request->request); // write to log
		
		if(array_key_exists('search',$this->request->request)) {
			// $this->request->request['ELEMENTS']=mshpdriver::searchEls($_REQUEST['search']);
			
			$this->load->controller('mshpo/elements');
			
		} elseif(array_key_exists('q',$this->request->request)) {
		
			if(!$this->request->request['q'])
			{
				echo '';die();
			}
			if(!$this->request->request['nPageSize'] || $REQUEST['nPageSize']<=0)
				$this->request->request['nPageSize']=10;
				
				$this->load->controller('mshpo/elements');
				
		}

	}
	
}