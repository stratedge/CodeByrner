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
 * CodeByrner Custom Model Class
 *
 * This class servers primarily as a holding file. Since CodeIgniter allows the user to extend
 * CI_Model with this file, and users may wish to do so, then our Record class extends this
 * class to maintain the developer's flexibility and standard CodeIgniter functionality without
 * requiring that the developer then need to go change any inheritance in CodeByrner files.
 *
 * @package		CodeByrner
 * @subpackage	Core
 * @category	Core
 * @property	CI_DB_mysql_driver	$db	A CodeIgniter database driver object that can be used to switch databases as needed
 * @author		JB
 * @version		1.0
 * @since		1.0
 */
 class MY_Model extends CI_Model {
    
	public $db;
	
	/**
	 * Constructor Method
	 * 
	 * This construction method will call the class' parent's constructor to ensure that any
	 * required initializations are completed. It will also set the local $db property to the
	 * global CodeIgniter object's $db property so that connections changed within this model
	 * impact this model only.
	 * 
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
    function __construct()
    {
        parent::__construct();
		
		//Create a local copy of the CodeIgniter instance's $db property
		$this->connect();
    }
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Database Connection Method
	 * 
	 * This method is a helper for developers who are building a site that requires writing to a
	 * master database and reading from a slave(s). By passing the name of the database to connect
	 * to as defined in the database configuration file, the developer can set the database
	 * connection to the specified database. Any subsequent calls to $this->db within the model
	 * will act upon the given database. It is suggested to set the slave database to the default
	 * and connect to the master only when you wish to write new data or update old data.
	 * 
	 * @param	string	$db	The name of the database to connect to as defined in the database config file (default is 'default')
	 * @return	bool		Whether loading the database information and setting it to the $db property succeeds
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function connect($db = 'default')
	{
		return $this->db = $this->load->database($db, TRUE);
	}
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
