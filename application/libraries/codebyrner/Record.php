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
 * @property	array		$_columns	An associative array that will hold the names and values of the loaded row from the database
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
	 * Magic method to override retrieving a property
	 * 
	 * This method allows the developer to obtain a property that exists on the record class if it
	 * exists, otherwise it will try and return the designated key from the global CodeIgniter
	 * instance. If the key still cannot be found the _columns property of the record will be
	 * searched to see if the property exists there. If the key can be found there it will be
	 * returned, otherwise FALSE will be returned. Due to the potential collision of keys between
	 * properties of the CodeIgniter instance and columns in the loaded objected, getting a column
	 * value with the $this->key_name syntax may not necessarily be safe. Use the
	 * $this->getKeyName() syntax instead.
	 * 
	 * @param	string	$name	The name of property that has been requested
	 * @return	mixed			Either the value of the property if found on the object, the CI instance, or the _columns array, or FALSE
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function __get($name)
	{
		if(property_exists($this, $name))
		{
			return $this->$name;
		}
		
		$CI = &get_instance();
		if(property_exists($CI, $name))
		{
			return $CI->$name;
		}
		
		if(isset($this->_columns[$name]))
		{
			return $this->_columns[$name];
		}
		
		return FALSE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Magic method to override setting the value of a class property
	 * 
	 * This method will intercept attempts to save a property to the class. If the property exists
	 * within the class the property value will be updated. If the property does not exist the
	 * CodeIgniter instance will be searched and if the property exists within it the value will be
	 * updated. If the property still hasn't been found the property is set in the _columns array
	 * of this record. Because there may be collisions between property names of properties in the
	 * CodeIgniter instance and the columns of this record, setting properties with the
	 * $this->key_name syntax may not necesarily be safe. Use the $this->setKeyName($value) syntax
	 * instead.
	 * 
	 * @param	string	$name	The key to set the property to
	 * @param	mixed	$value	The value to the property's value to
	 * @return	boolean			Whether or not setting the property was successful
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function __set($name, $value)
	{
		if(property_exists($this, $name))
		{
			return $this->$name = $value;
		}
		
		$CI = &get_instance();
		if(property_exists($CI, $name))
		{
			return $CI->$name = $value;
		}
		
		return $this->_columns[$name] = $value;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Magic method that responds to calls to methods that don't actually exist on the class
	 * 
	 * The purpose of this method is to allow for safer setting and getting of properties inside
	 * the object. Because there may be collisions between the keys in the CodeIgniter instance and
	 * the names of the columns in the table associated with this record, using the standard getter
	 * and setter syntaxes may produce bizarre results since they are overridden. If a model named
	 * User is loaded, for example, it creates a key of "user" in the CodeIgniter instance. If you
	 * have a column in a table named "user", using the syntax $this->user = 'JB'; would actually
	 * replace the "user" key in the CodeIgniter instance. Instead, to get or set values
	 * associated with database columns, camel-case the column name and prepend either "get" or
	 * "set". You can then call this value as a method and pass the value you wish to set if you
	 * are attempting to set a value. IE, instead of $this->column_name, use
	 * $this->setColumnName($value) or $this->getColumnName().
	 * 
	 * @param	string	$name		The name of the function that was called but not found in the object
	 * @param	array	$arguments	An array of the arguments passed to the function called
	 * @return	mixed				Returns the value of the property or FALSE when getting a property, or a boolean when setting a property
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function __call($name, $arguments)
	{
		switch(substr($name, 0, 3))
		{
			case 'get':
				$name = substr($name, 3);
				preg_match_all('/([A-Z][^A-Z]*)/', $name, $matches);
				if(!isset($matches[1]) || empty($matches[1])) return FALSE;
				$column = strtolower(implode('_', $matches[1]));
				return isset($this->_columns[$column]) && !empty($this->_columns[$column]) ? $this->_columns[$column] : FALSE;
				break;
				
			case 'set':
				$name = substr($name, 3);
				preg_match_all('/([A-Z][^A-Z]*)/', $name, $matches);
				if(!isset($matches[1]) || empty($matches[1])) return FALSE;
				$column = strtolower(implode('_', $matches[1]));
				$this->_columns[$column] = $arguments[0];
				break;
		}
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
		
		//If we got something back then add the columns to the object
		$this->_columns = $q->row_array();
		
		//Add the object to the repository
		$CI->$key = &$this;
		
		//Return the object
		return $CI->$key;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds data directly to the _columns property
	 * 
	 * This method takes an array of data, or an object with properties, and adds each key or
	 * property to the _columns property of this object using the key or property name as the key
	 * and the value for the value.
	 * 
	 * @param	mixed	$data	Either an associative array or an object
	 * @return	boolean			If the wrong input is given FALSE will be returned, otherwise true is returned
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function addData($data)
	{
		if(!is_array($data) && !is_object($data)) return FALSE;
		
		foreach((array) $data as $key => $value)
		{
			$this->_columns[$key] = $value;
		}
		
		return TRUE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Returns the columns
	 * 
	 * Returns the associative array of values in the _columns property of this object.
	 * 
	 * @return	array	The values in the _columns property as an associative array
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function getData()
	{
		return $this->_columns;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Saves the current values of the record to the corresponding row in the database
	 * 
	 * Determines whether or not a primary key is defined and will either try and save a name row
	 * or update an existing row respectively. Properties in the _columns property are evaluated to
	 * determine if they are columns in the database table, and if they are they are saved. If they
	 * are not columns in the database table they will simply be ignored.
	 * 
	 * @return	mixed	Can either be FALSE or the id of the new row, or the number of rows affected
	 * @author	JB
	 * @version 1.0
	 * @since	1.0
	 */
	function save()
	{
		//Determine if we are saving a new record, or updating an old record and perform the action
		$pk = $this->_primary_key;
		
		if(isset($this->_columns[$pk]) && !empty($this->_columns[$pk]))
		{
			return $this->_update();
		}
		else
		{
			return $this->_insert();
		}
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Tries to create a new row in the database table
	 * 
	 * This method will take any properties in the _columns array that match actual columns in the
	 * database table and try to save a new row. If it succeeds it will return the new primary key
	 * value generated by the insert, otherwise it will return FALSE.
	 * 
	 * @return	mixed	Either the numerical id of the newly created row, or FALSE on failure
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	private function _insert()
	{
		//Get only the data in the object that corresponds to the columns that really exist in the
		//table
		$data = $this->_resolveColumns();
		
		//No data? Return FALSE
		if(empty($data)) return FALSE;
		
		//Try and run the insert
		$this->db->insert($this->_table, $data);
		
		//Get the id value of the new row
		$id = $this->db->insert_id();
		
		//If we don't get an id, something went wrong, return FALSE
		if(!$id) return FALSE;
		
		//Add the newly saved object to the CodeIgniter object as a repository cache
		$pk = $this->_primary_key;
		$this->_columns[$pk] = $id;
		$key = get_class($this) . '|' . $id;
		
		$CI = &get_instance();
		$CI->$key = $this;

		//Return the id of the new row
		return $id;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Attempts to update a given row in the database table
	 * 
	 * This method will take any properties in the _columns array that match actual columns in the
	 * database table and try to update the row identified by the value of the primary key. The
	 * number of affected rows is returned. A value of zero doesn't necessarily mean the query
	 * failed, as the data provided might have been the same as the values in the database, and so
	 * no rows may have been updated.
	 * 
	 * @return	int	The number of rows affected by the update
	 * @author	JB
	 * @version 1.0
	 * @since	1.0
	 */
	private function _update()
	{
		$data = $this->_resolveColumns();
		
		if(empty($data)) return FALSE;
		
		$pk = $this->_primary_key;
		
		$where = array($this->_primary_key => $this->_columns[$pk]);
		
		$this->db->where($where)->update($this->_table, $data);
		
		return $this->db->affected_rows();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Determines which columns in the _columns property actually exist on the table
	 * 
	 * Goes through each column in the _columns property of the object and checks to see if that
	 * column actually exists as a column in the database table. If it does, that column and its
	 * value are kept. An associative array of columns with values on the object that correspond to
	 * columns in the database table are returned.
	 * 
	 * @return	array	An associative array of column names and values for values in the _columns property that correspond to columns in the database table
	 * @author	JB
	 * @version 1.0
	 * @since 1.0
	 */
	private function _resolveColumns()
	{
		$columns = $this->db->list_fields($this->_table);
		
		$data = array();
		
		foreach($this->_columns as $key => $value)
		{
			if(in_array($key, $columns)) $data[$key] = $value;
		}
		
		return $data;
	}
}

/* End of file Record.php */
/* Location: ./application/libraries/codebyrner/Record.php */