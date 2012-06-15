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
 * CodeByrner Record Parent Class
 *
 * This class defines common functionality and utilities for all record classes.
 *
 * @package     CodeByrner
 * @subpackage  Libraries
 * @category    Libraries
 * @author      JB
 * @version		1.0
 * @since		1.0
 */
class Record extends MY_Model {
	
	/**
	 * Constructor Method
	 * 
	 * This construction method will call the constructor from MY_Model so that all Records will
	 * instantiate with the same behaviors of all other models.
	 * 
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function load($id)
	{
		dump(get_class($this));
	}
}

/* End of file Record.php */
/* Location: ./application/libraries/codebyrner/Record.php */