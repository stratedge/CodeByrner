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
 * CodeByrner Application Initialization Class
 *
 * This class works as a hook within CodeIgniter and pre-loads the required Controller extension
 * files.
 *
 * @package     CodeByrner
 * @subpackage  Hooks
 * @category    Hooks
 * @author      JB
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
     * @return	bool				No need to return anything, but a good habit - returns TRUE
     * @author	JB
     */
    function loadCodeByrner(Array $classes)
    {
        foreach($classes as $class)
        {
            $this->load->library($class);
        }
        
        return TRUE;
    }
    
}

/* End of file Codebyrner.php */
/* Location: ./application/hooks/Codebyrner.php */