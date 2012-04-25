<?php

class JSON {
	
	public $success = true;
	public $data = array();
	public  $redirect = false;
	
	/**
	 * Adds data to the JSON object's data property with the passed key as the key in the
	 * array, and the data as the value.
	 * 
	 * @param	string		$key	The key to save the data to in the data array
	 * @param	mixed		$data	The data to be added to the key in the data array
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addData($key, $data)
	{
		return $this->data[$key] = $data;
	}
	
	
	//-----------------------------------------------------------------------------------
	
	
	/**
	 * Stops processing the page, encodes the object's properties, sets the right JSON
	 * header, and sends it to the browser.
	 * 
	 * @author	JB
	 * @version	2011-09-10
	 */
	function send()
	{
		$CI =& get_instance();
		$CI->load->library('user_agent');
		if(!$CI->agent->is_mobile()) header('Content-type: application/json');
		exit(json_encode($this));
	}
	
	
	//-----------------------------------------------------------------------------------
	
	
	/**
	 * Sends a redirect command to the browser.
	 * 
	 * @param	string		$url	The URL that the browser should redirect to
	 * @author	JB
	 * @version	2011-09-10
	 */
	function redirect($url)
	{
		$CI =& get_instance();
		$CI->load->library('user_agent');
		if(!$CI->agent->is_mobile()) header('Content-type: application/json');
		$this->redirect = $url;
		$this->send();
	}
}