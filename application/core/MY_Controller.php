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
 * CodeByrner Custom Controller Class
 *
 * This class servers primarily as a holding file. Since CodeIgniter allows the user to extend
 * CI_Controller with this file, and users may wish to do so, then our Page class extends this
 * class to maintain the developer's flexibility and standard CodeIgniter functionality without
 * requiring that the developer then need to go change any inheritance in CodeByrner files.
 *
 * @package		CodeByrner
 * @subpackage	Core
 * @category	Core
 * @author		JB
 * @version		1.0
 * @since		1.0
 */
 class MY_Controller extends CI_Controller {
    
	
	/**
	 * Constructor Method
	 * 
	 * This construction method will call the class' parent's constructor to ensure that any
	 * required initializations are completed.
	 * 
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
    function __construct()
    {
        parent::__construct();
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
