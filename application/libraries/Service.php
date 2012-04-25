<?php

class Service {
	
	function __construct()
	{
		//Nothing required here yet...
	}
	
	function __get($key)
	{
		if(property_exists($this, $key)) return $this->$key;
		
		$CI =& get_instance();
		if(property_exists($CI, $key)) return $CI->$key;
		
		return FALSE;
	}
	
	/**
	 * Returns the service specified by the service parameter, and will automatically set the
	 * primary id to the specified id value if given.
	 * @param string $service The service to load.
	 * @param integer $id The primary id to set in the service if provided.
	 * @return object
	 * @author JB
	 */
	static function load($service, $id = FALSE)
	{
		$CI =& get_instance();
		
		$CI->load->library($service);
		
		$service = new $service();
		
		if($id && $service->primary_key)
		{
			$func = sprintf('set%s', $service->primary_key);
			$service->$func($id);
		}
		
		return $service;
	}
	
}

/* End of file Service.php */
/* Location: ./application/libraries/Service.php */