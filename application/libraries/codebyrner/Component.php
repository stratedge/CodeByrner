<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeByrner
 *
 * An open source application development framework leveraging components and built on CodeIgniter for PHP 5.1.6 or newer
 *
 * @package     CodeByrner
 * @author      JB
 * @copyright   Copyright (c) 2012, Solvo Media, LLC
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://solvomedia.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------------------------------

/**
 * CodeByrner Component Class
 *
 * This class is one of the core files for the CodeByrner platform. The purpose of this class is to
 * provide consistent behaviors and global methods for all components. Each component should either
 * extend this class, or extend a class that extends this class at some point. Essentially, all
 * component classes should have this class as a parent class at some level.
 *
 * @package		CodeByrner
 * @subpackage	Libraries
 * @category	Libraries
 * @author		JB
 */
class Component {
	
	private $_params = array();
	

	function __construct()
	{
		
	}
	
	
	//---------------------------------------------------------------------------------------------
	

	/**
	 * Magic method for get calls
	 * 
	 * This method overrides the typical get functionality for the component by checking to see if
	 * the requested property exists within the object. If it does not exist, we then check the
	 * CodeIgniter instance to see if the property exists in there. If it does, return it, if it
	 * doesn't, return FALSE. This allows us to call $this->load->view(), for example.
	 * 
	 * @param	string	$name	The name of the property being requested
	 * @return	mixed			The value of the property in the object, in CodeIgniter, or FALSE
	 * @author	JB
	 */	
	function __get($name)
	{
		if(isset($this->$name)) return $this->$name;
		
		$CI =& get_instance();
		if(isset($CI->$name)) return $CI->$name;
		
		return FALSE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Add parameters to the component
	 * 
	 * Accepts parameters to add to the component's _params array. Arrays and objects will be
	 * iterated over and each values will be added to the _params array. Keys that are numeric will
	 * be ignored, while keys that are strings will be preserved. All other data types will just be
	 * appended to the _params array.
	 * 
	 * @param	mixed	$params	The parameter(s) to be added to the object's _params array
	 * @return	bool			Currently only returns TRUE
	 * @author	JB
	 */
	function setParams($params)
	{
		//If the variavle passed is an array or object, merge its keys or properties, maintaining only string keys
		if(is_array($params) || is_object($params))
		{
			foreach((array) $params as $key => $value)
			{
				if(is_numeric($key)) $this->_params[] = $value;
				else $this->_params[$key] = $value;
			}
		}
		else $this->_params[] = $params;
		
		return TRUE;
	}
	
}

/* End of file Component.php */
/* Location: ./application/libraries/Component.php */