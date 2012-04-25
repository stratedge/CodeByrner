<?php

class MY_Model extends CI_Model {
	
	protected $schema = array();
	private $properties = array();
	private $fields = array();
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __get($key)
	{
		if(property_exists($this, $key)) return $this->$key;
		
		if(isset($this->properties[$key])) return $this->properties[$key];
		
		$CI =& get_instance();
		if(property_exists($CI, $key)) return $CI->$key;
		
		return FALSE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __set($key, $value = FALSE)
	{
		if(property_exists($this, $key))
		{
			$this->$key = $value;
		}
		else
		{
			$this->properties[$key] = $value;
		}
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __isset($key)
	{
		if(property_exists($this, $key)) return TRUE;
		
		$CI =& get_instance();
		if(property_exists($CI, $key)) return TRUE;
		
		if(isset($this->properties[$key])) return TRUE;
		
		return FALSE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __call($name, $args)
	{
		if(method_exists($this, $name)) return $this->$name($args);
		
		$method = substr($name, 0, 3);
		$property = substr($name, 3);
		$peices = preg_split('/(?=[A-Z])/', $property, -1, PREG_SPLIT_NO_EMPTY);
		$property = strtolower(implode('_', $peices));
		
		switch($method)
		{
			case 'set':
				if(empty($args)) return FALSE;
				return $this->$property = $args[0];
				break;
				
			case 'get':
				return $this->$property;
				break;
		}
		
		return FALSE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function connect($db = 'slave')
	{
		if(!in_array($db, array('master', 'slave'))) return false;
		
		return $this->db = $this->load->database($db, TRUE);
	}
	
	//---------------------------------------------------------------------------------------------
	
	
//	function __isset($key)
//	{
//		if(property_exists($this, $key)) return true;
//		if(isset($this->properties[$key])) return true;
//		return false;
//	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Takes the primary key provided and attempts to load the record from the database.
	 * By default will ingore inactive rows, but can be set to include them.
	 * 
	 * @param	integer		$key		The primary key value to load
	 * @param	bool 		$is_active	Whether or not to load an inactive record
	 * @return	bool					Whether or not the loading was successful
	 * @author	JB
	 * @version	2011-09-10
	 */
	function load($key, $is_active = true)
	{
		if($key)
		{
			$where = array();
			$where[$this->primary_key] = $key;
			if($is_active) $where['is_active'] = 1;
			
			$q = $this->db->get_where($this->table, $where, 1);
			
			if($q->num_rows())
			{
				
				foreach($q->row_array() as $key => $value)
				{
					$this->$key = $value;
				}
				
				return true;
				
			} else return false;
			
		} else return false;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Takes an array of ids and returns an array of objects for each id that could be
	 * loaded. Will ignore inactive records unless specified otherwise.
	 * 
	 * @param	array		$keys		An array of ids
	 * @param	bool		$is_active	Whether or not to include inactive rows
	 * @return	mixed					Either an array of objects, or false
	 * @author	JB
	 * @version	2011-09-10
	 */
	function loadAll($keys, $is_active = true)
	{
		$objs = array();
		$class= get_class($this);
		
		if(is_array($keys))
		{
			
			foreach($keys as $key)
			{
				$obj = new $class();
				if($obj->load($key, $is_active)) $objs[] = $obj;
			}
			
			return $objs;
			
		} return false;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Takes an associative array of data and adds it to the object using the keys as
	 * variable names.
	 * 
	 * @param	array		$data	An associative array containing keys and values
	 * @param	bool		$check	Whether or not to check if any value actually got changed
	 * @return	bool				Whether or not adding data succeeded
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addData($data, $check = false)
	{
		$pass = false;
		
		if(is_array($data) || is_object($data))
		{
			
			foreach($data as $key => $value)
			{
				if(isset($this->$key) && $this->$key != $value) $pass = true;
				
				if($key !== $this->primary_key) $this->$key = $value;
			}
			
			if($check == true && $pass != true) return false;
			
			return true;
			
		} else return false;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Determines if this is a new object, or an existing one, and then either saves a new row in
	 * the database or updates the existing one as necessary. Saving returns the new row id,
	 * updating returns a boolean.
	 * 
	 * @return	mixed		Either an integer for the row's id, or a boolean value
	 * @author	JB
	 * @version	2011-11-08
	 */
	function save()
	{
		$pk = $this->primary_key;
		
		$data = $this->trimData();
		
		$pk = $this->$pk;
		
		if(!empty($pk))
		{
			return $this->update($data);
		}
		else
		{
			return $this->insert($data);
		}
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Creates a new row in the database with the data provided and returns the new row's id.
	 * 
	 * @param	Array		$data	The data that will populate the row
	 * @return	mixed				Either the new row id or false
	 * @author	JB
	 * @version	2011-11-08
	 */
	private function insert($data)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$this->connect('master');
		$this->db->insert($this->table, $data);
		return $this->master->insert_id();
		
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Updates the data in the row defined by the value of the object's primary key's property with
	 * the data provided.
	 * 
	 * @param	Array		$data	The data that the row will be updated with
	 * @return	boolean
	 * @author	JB
	 * @version	2011-11-08
	 */
	private function update($data)
	{
		$pk = $this->primary_key;
		$this->connect('master');
		$this->db->where($pk, $this->$pk)->update($this->table, $data);
		return $this->db->affected_rows();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * This is a utility method that will go through all the properties in the object's properties
	 * array and return a new array containing only properties that correspond to columns in the
	 * object's database table.
	 * 
	 * @return	Array		An associative array of only the properties that are database columns
	 * @author	JB
	 * @version	2011-11-08
	 */
	function trimData()
	{
		$fields = $this->getPropertyKeys();
		
		$data = array();
		
		$exclude = array($this->primary_key, 'created', 'modified');
		
		foreach($fields as $field)
		{
			if(isset($this->properties[$field]) && !in_array($field, $exclude))
				$data[$field] = $this->properties[$field];
		}
		
		return $data;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Simply returns the array of properties currently assigned to the object.
	 * 
	 * @return	Array		An array of the properties assigned to the object
	 * @author	JB
	 * @version	2011-11-08
	 */
	function getData()
	{
		return $this->properties;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function deactivate()
	{
		$this->is_active = 0;
		return $this->save();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function getPropertyKeys()
	{
		$fields = $this->fields;
		
		if(!$fields)
		{
			return $this->db->list_fields($this->table);
		}
		
		return $fields;
	}
	
}

/* End of file MY_Model.php */
/* LocationL ./application/core/MY_Model.php */