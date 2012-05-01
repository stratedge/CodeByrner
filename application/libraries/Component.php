<?php

class Component {

	function __construct()
	{
		
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __get($name)
	{
		if(isset($this->$name)) return $this->$name;
		
		$CI =& get_instance();
		if(isset($CI->$name)) return $CI->$name;
		
		return FALSE;
	}
	
}

/* End of file Component.php */
/* Location: ./application/libraries/Component.php */