<?php

class User extends MY_Model {
	
	protected $table = 'users';
	protected $primary_key = 'user_id';
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function getIdByLogin($email, $password)
	{
		$where = array(
			'email' => $email,
			'password' => md5($password),
			'is_active' => 1
		);
		
		$q  = $this->db->select('user_id')->get_where($this->table, $where, 1);
		
		if($q->num_rows())
		{
			return $q->row()->user_id;
		} else return false;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	function getIdByEmail($email)
	{
		$where = array(
			'email' => $email,
			'is_active' => 1
		);
		
		$q = $this->db->select('user_id')->get_where($this->table, $where, 1);
		
		if($q->num_rows())
		{
			return $q->row()->user_id;
		} else return false;
	}
	
	
	//-------------------------------------------
	
	/**
	 * 
	 * Enter description here ...
	 */
	function getRoleIds()
	{
		$sql = sprintf('SELECT role_id FROM users_roles WHERE user_id = %d GROUP BY role_id', $this->user_id);
		$q = $this->db->query($sql);
		
		if($q->num_rows())
		{
			return flatten($q->result_array(), 'role_id');
		} else return false;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $permission_id
	 */
	function getPermissionScopes($permission_id)
	{
		$sql = 'SELECT scope_level, scope_id FROM users_roles ur
				JOIN roles_permissions rp USING (role_id)
				WHERE
					ur.user_id = 1
					AND rp.permission_id = 1
					AND ur.is_active = 1
					AND rp.is_active = 1';
		$sql = sprintf($sql, $this->user_id, $permission_id);
		
		$q = $this->db->query($sql);
		
		if($q->num_rows())
		{
			return $q->result();
		}
		else return false;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	function getAccountId()
	{
		$sql = 'SELECT acct_id
				FROM users
				JOIN accounts_departments USING (dept_id)
				WHERE user_id = %d';
		$sql = sprintf($sql, $this->user_id);
		
		$q = $this->db->query($sql);
		
		if($q->num_rows())
		{
			return $q->row()->acct_id;
		}
		else return false;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	function getPermissionIds()
	{
		$sql = 'SELECT permission_id
				FROM users_roles ur
				JOIN roles_permissions rp USING (role_id)
				WHERE
					user_id = %d
					AND ur.is_active = 1
					AND rp.is_active = 1
				GROUP BY permission_id
				ORDER BY permission_id ASC';
		$sql = sprintf($sql, $this->user_id);
		
		$q = $this->db->query($sql);
		
		if($q->num_rows())
		{
			return flatten($q->result_array(), 'permission_id');
		}
		else return array();
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $format
	 */
	function getName($format = false)
	{
		switch($format)
		{
			default:
				return sprintf('%s %s', $this->first_name, $this->last_name);
				break;
				
			case 'first':
				return $this->first_name;
				break;
				
			case 'last':
				return $this->last_name;
				break;
		}
		
		return false;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function getIdByHash($hash)
	{
		$where = array(
			'confirmation_hash' => $hash,
			'confirmed' => 0,
			'is_active' => 1
		);
		
		$q = $this->db->select('user_id')->get_where($this->table, $where, 1);
		
		if($q->num_rows())
		{
			return $q->row()->user_id;
		} else return false;
	}
	
}

/* End of file User.php */
/* Location: ./application/models/User.php */