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
 * CodeByrner Application Initialization Class
 *
 * This class works as a hook within CodeIgniter and pre-loads the required Controller extension
 * files.
 *
 * @package     CodeByrner
 * @subpackage  Hooks
 * @category    Hooks
 * @author      JB
 * @version		1.0
 * @since		1.0
 */
class CodeByrner extends CI_Controller {
    
	
    /**
     * CodeByrner load method
     * 
     * This method will load any classes defined in the params array in the config/hook.php file
     * after CI_Controller and MY_Controller are loaded, but before the requested controller is
     * loaded.
     * 
     * @param	$array	$classes	An array of classes to load in the pre_controller_load hook
     * @author	JB
	 * @version	1.0
	 * @since	1.0
     */
    function loadCodeByrner(Array $classes)
    {
    	//Lets load the CodeByrner config file so we can get default settings from it
		$this->config->load('codebyrner');
		
		//Get the path to the core CodeByrner files as set in the config
		$path = FALSE;
		$core_folder = $this->config->item('cb_core_folder');
		if(!empty($core_folder)) $path = $core_folder . '/';
		
        foreach($classes as $class)
        {
            $this->load->library($path . $class);
        }
    }
    
}

/* End of file Codebyrner.php */
/* Location: ./application/hooks/Codebyrner.php */