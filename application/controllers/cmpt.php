<?php

class Cmpt extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	public function _remap($class, array $params = array())
	{
		//Make sure we have been given a controller class to load
		if($class == 'index' || !$class)
		{
			if($this->config->item('cb_redirect_cmpt_to_404') === TRUE) show_404('page');
		}
	}
}

/* End of file cmpt.php */
/* Location: ./application/controllers/cmpt.php */
