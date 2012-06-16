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
	
	private $_columns = array();
	
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
	
	
	/**
	 * Load a single record from the database
	 * 
	 * This method is used to load a single record and return it as an object. It employs a psuedo-
	 * repository system by saving the object to the global CodeIgniter instance keyed by the
	 * class name and the id of the row to load. If the object is not in the global CodeIgniter
	 * object, then the method will try to load the row using the protected _table and
	 * _primary_key properties that must be set on the class that is extending this one. The values
	 * of the row are added to the columns property of the object as an associative array.
	 * 
	 * @param	mixed	$id	The id of the row in the table, the value for the primary_key that identifies the row in the table
	 * @return	mixed		Returns either an object of the type extending this class, or FALSE if nothing can be loaded
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function load($id)
	{
		$class = get_class($this);
		
		$key = $class . '|' . $id;
		
		$CI = &get_instance();
		
		//Have we already loaded this record? If so, and it's the right class, return it
		if(property_exists($CI, $key) && get_class($this->$key) === $class) return $this->$key;
		
		//Can't get the object from the repository, so try and get it from the database
		$where = array($this->_primary_key => $id);
		
		$q = $this->db->where($where)->get($this->_table);
		
		//If we didn't get anything back from the database, return FALSE
		if(!$q->num_rows()) return FALSE;
		
		//If we got something back then add it to the repository and return the repository copy
		$obj = new $class();
		$obj->_columns = $q->row_array();
		
		$CI->$key = $obj;
		
		return $CI->$key;
	}
}

/* End of file Record.php */
/* Location: ./application/libraries/codebyrner/Record.php */