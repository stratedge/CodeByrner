<?php

class Component {
	
	protected $tpl;
	protected $params;
	
	function __construct($params = FALSE)
	{
		
		$this->params = new Params($params);
		
		//Get scrubbed $_POST and $_GET values from CI
		$this->data = new Data();
		$get = $this->input->get(NULL, TRUE);
		$post = $this->input->post(NULL, TRUE);
		$this->data->setData($get, $post);
		
		if(!isset($this->data->op) || empty($this->data->op)) $this->data->do = $this->uri->segment(2);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function initialize()
	{
		return TRUE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __get($key)
	{
		if(property_exists($this, $key)) return $this->$key;
		
		$CI =& get_instance();
		if(property_exists($CI, $key)) return $CI->$key;
		
		return false;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Automatically calls the correct processing function based on the request type, and
	 * sets the Template class to the template property.
	 * 
	 * @author	JB
	 * @version	2011-09-10
	 */
	function run()
	{
		$this->tpl = new Template();
		$this->tpl->setComponent(get_class($this));
		
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET':
				return $this->get();
				break;
				
			case 'POST':
				return $this->post();
				break;
		}
	}
	
}


/**
 * Params class merely is a stdClass with a constructor and get magic method. Its used to store and
 * retrieve information from the controller about the environment a component should render for.
 * 
 * @author	JB
 * @version	2012-04-24
 */
class Params {
	
	function __construct($params)
	{
		if(is_array($params))
		{
			foreach($params as $key => $value)
			{
				$this->$key = $value;
			}
		}
	}
	
	function __get($key)
	{
		if(!isset($this->$key)) return FALSE;
		return $this->$key;
	}
}


/**
 * Data class that just defines an object with simple methods to help make sure that getting and
 * setting data is consistent each time. Used in the construction of each component to hold
 * $_POST and $_GET data and to return FALSE if a desired property was never sent from the page.
 * 
 * @author	JB
 * @version	2012-04-24
 */
class Data {
	
	function __construct($data = FALSE)
	{
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				$this->$key = $value;
			}
		}
	}
	
	function __get($key)
	{
		if(!isset($this->$key)) return FALSE;
		return $this->$key;
	}
	
	function setData($get = FALSE, $post = FALSE)
	{
		if(is_array($get))
		{
			foreach($get as $key => $value)
			{
				$this->$key = $value;
			}
		}
		
		if(is_array($post))
		{
			foreach($post as $key => $value)
			{
				$this->$key = $value;
			}
		}
	}
}

/* End of file Component.php */
/* Location: ./application/libraries/Component.php */