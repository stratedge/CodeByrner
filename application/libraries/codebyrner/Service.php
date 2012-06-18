<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeByrner
 *
 * An open source application development framework leveraging components and built on CodeIgniter for PHP 5.2 or newer
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
 * CodeByrner Service Parent Class
 *
 * This class defines common functionality and utilities for all service classes.
 *
 * @package     CodeByrner
 * @subpackage  Libraries
 * @category    Libraries
 * @property	string|FALSE	$_path	FALSE before construction, this property gets filled in with the default path to services so this class can load them if a value is set in the CodeByrner config
 * @author      JB
 * @version		1.0
 * @since		1.0
 */
class Service {
	
	private $_path = FALSE;
	
	/**
	 * Constructor Method
	 * 
	 * This construction method will define the path to services in the application/libraries
	 * directory as set in the CodeByrner configuration file.
	 * 
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function __construct()
	{
		if($this->config->item('cb_services_folder')) $this->_path = $this->config->item('cb_services_folder') . '/';
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Magic __get Method
	 * 
	 * This usage of the _get magic method allows the Service class to return properties within
	 * itself, which is the standard behavior, but in the event that the property is not set on the
	 * object the method will then check the global CodeIgniter object, allowing access to all
	 * loaded libraries and models. If the property doesn't exist with the CodeIgniter object FALSE
	 * will be returned.
	 * 
	 * @param	string	$name	The name of the property to check for
	 * @return	mixed			Either the value of the property in this object or the CI object, or FALSE
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
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
	 * Load Service Method
	 * 
	 * This method will try and load the service name passed to it to the global CodeIgniter object
	 * making it accessable across the entire CI object. Also handles building the correct path
	 * to where the service should be located within the application/libraries directory so that
	 * configuration options can be updated as necessary without requiring the updating of all the
	 * places where services are loaded.
	 * 
	 * @param	string	$service_name	The name of the service to try and load (camelcase)
	 * @return	object					If the class can be loaded, it will be returned
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function load($service_name)
	{
		$this->load->library($this->_path . $service_name);
		$service_name = strtolower($service_name);
		return $this->$service_name;
	}
	
}

/* End of file Service.php */
/* Location: ./application/libraries/codebyrner/Service.php */