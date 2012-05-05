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
 * CodeByrner Component Controller Class
 *
 * This class is one of the core files for the CodeByrner platform. The purpose of this class is to
 * allow the developer to call a specific method within a specific component and have only that
 * component's output returned to the browser. Especially useful when the developer must call a
 * component's method via ajax to either save some data or update a specific section of a page.
 *
 * @package		CodeByrner
 * @subpackage	Controllers
 * @category	Controllers
 * @author		JB
 */
class Cmpt extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Component routing method
	 * 
	 * This method will use the URI segments and CodeIgniter's built in controller remapping to
	 * load the class being requested and call the appropriate method (or index if none is
	 * provided). Subsequent URI segments are provided as an array to the params object of the
	 * class being requested. If the class cannot be loaded or the method cannot be found, the
	 * request will render a 404 error or nothing, depending on options set in the config.
	 */
	public function _remap($class, array $params = array())
	{
		//Make sure we have been given a controller class to load
		if($class == 'index' || !$class)
		{
			if($this->config->item('cb_redirect_cmpt_to_404') === TRUE)
			{
				show_404('page');
			}
			else return FALSE;
		}
		
		//Get the path to the component classes from the config
		$path = FALSE;
		$components_folder = $this->config->item('cb_components_folder');
		if(!empty($components_folder)) $path = $components_folder . '/';
		
		//Try and load the library
		$this->load->library($path . $class);
		
		//Set the class name to all lowercase, since that is how CodeIgniter references it once loaded
		$class = strtolower($class);
		
		//If we have no specific function to call, assume the index function is being requested
		$method = isset($params[0]) && !empty($params[0]) ? $params[0] : 'index';
		
		//Instantiate a reflection of the method being called so we can test it's availability
		$reflection = new ReflectionMethod($this->$class, $method);
		
		//Check and see if there is a method in the class by this name, and that it's public, otherwise return nothing
		if(method_exists($this->$class, $method) === FALSE || $reflection->isPublic() === FALSE || substr($method, 0, 1) != '_')
		{
			if($this->config->item('cb_redirect_cmpt_to_404') === TRUE)
			{
				show_404('page');
			}
			else return FALSE;
		}
		
		//Remove the first item from the parameters since it's the method name and not technically user data to pass along
		array_shift($params);
		
		//Set the parameters to the component
		$this->$class->setParams($params);
		
		//Render the HTML and send it to the browser
		$this->output->set_output($this->$class->$method($params));
	}
}

/* End of file cmpt.php */
/* Location: ./application/controllers/cmpt.php */