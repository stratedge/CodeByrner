<?php

class UserService extends Service {

	protected $user_id;
	protected $user;
	protected $primary_key = 'UserId';
	
	function __construct($user_id = NULL)
	{
		parent::__construct();
		$this->load->model('user');
		$this->setUserId($user_id);
	}
	
	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}
	
	function getUserId()
	{
		return $this->user_id;
	}
	
	function getUser()
	{
		if(!$this->user)
		{
			if($this->getUserId())
			{
				$u = new User();
				if($u->load($this->getUserId()))
				{
					$this->user = $u;
					return $this->user;
				} else return false;
			} else return false;
		} else return $this->user;
	}
	
	function getUsersPermissions()
	{
		if(!$this->getUser()) return false;
		
		return $this->getUser()->getRoleIds();
	}
	
	function getRolePermissionScopes()
	{
		return $scopes = $this->getUser()->getPermissionScopes(1);
	}
	
	/**
	 * Retrieves the account object for the user attached to the service.
	 * @return mixed Either an integer or false.
	 * @author JB
	 */
	function getUsersAccount()
	{
		if(!$this->getUser()) return false;
		
		$acct_id = $this->getUser()->getAccountId();
		
		$a = new Account();
		$a->load($acct_id);
		
		return $a;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * Gets and returns all the users that fall under the same account as the user loaded.
	 * @return mixed Either an array of User objects, or false.
	 * @author JB
	 */
	function getUsersColleagues()
	{
		$a = $this->getUsersAccount();
		
		if(!$a) return false;
		
		$ids = $a->getUserIds();
		
		if(!$ids) return false;
		
		return $this->getUser()->loadAll($ids);
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * Gets the name of the user's department.
	 * @param User $user
	 * @return string
	 * @author JB
	 */
	function getUsersDepartmentName(User $user)
	{
		$d = new Department();
		$d->load($user->dept_id);
		return $d->department;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function getUsersAccessibleScopesByPermission($permission_id)
	{
		if(!$this->getUser()) return false;
		
		$scopes = $this->getUser()->getPermissionScopes($permission_id);
		
		if(!$scopes) return false;
		
		return getAllScopes($scopes);
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function getUsersAccessibleDepartmentsByPermission($permission_id)
	{
		$scopes = $this->getUsersAccessibleScopesByPermission($permission_id);
		
		if(!$scopes) return false;
		
		$dept_ids = array();
		foreach($scopes as $scope)
		{
			if($scope['scope_level'] == 10) $dept_ids[] = $scope['scope_id'];
		}
		
		if(!$dept_ids) return false;
		
		$this->load->model('department');
		$d = new Department();
		
		return $d->loadAll($dept_ids);
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function emailIsAvailable($email)
	{
		$this->load->model('user');
		$u = new User();
		return $u->getIdByEmail($email) ? false : true;
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function createUser($data)
	{
		if(!array_key_exists('dept_id', $data)) return false;
		if(!array_key_exists('email', $data)) return false;
		if(!array_key_exists('first_name', $data)) return false;
		if(!array_key_exists('last_name', $data)) return false;
		
		$data['confirmation_hash'] = md5(sprintf('%s|%d', $data['email'], time()));
		
		$u = new User();
		$u->addData($data);
		return $u->save();
	}
	
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function getUserByHash($hash)
	{
		$u = new User();
		$user_id = $u->getIdByHash($hash);
		
		if(!$user_id) return false;
		
		$this->setUserId($user_id);
		
		return $this->getUser();
	}
	
	
	//-------------------------------------------
	
	
	/**
	 * 
	 */
	function getUserByLogin($email, $password)
	{
		$u = new User();
		$user_id = $u->getIdByLogin($email, $password);
		
		if(!$user_id) return false;
		
		$this->setUserId($user_id);
		
		return $this->getUser();
	}
}

/* End of file UserService.php */
/* Location: ./application/libraries/UserService.php */