<?php

class Account extends MY_Model {
	
	protected $table = 'accounts';
	protected $primary_key = 'acct_id';
	
	function getAccounts($name = false, $order = 'ASC')
	{
		$sql = sprintf('SELECT acct_id FROM accounts ORDER BY account %s', $order);
		$q = $this->db->query($sql);
		
		if($q->num_rows())
		{
			return flatten($q->result_array(), 'acct_id');
		} else return false;
	}
	
	function getDepartments()
	{
		$q = $this->db->select('dept_id')->where('acct_id', $this->acct_id)->get('accounts_departments');
		
		if($q->num_rows())
		{
			return flatten($q->result_array(), 'dept_id');
		} else return false;
	}
	
	function getUserIds()
	{
		$sql = 'SELECT user_id
				FROM accounts_departments
				JOIN users USING (dept_id)
				WHERE acct_id = %d';
		$sql = sprintf($sql, $this->acct_id);
		
		$q = $this->db->query($sql);
		
		if($q->num_rows())
		{
			return flatten($q->result_array(), 'user_id');
		}
		else return false;
	}
	
}

/* End of file account.php */
/* Location: ./application/models/account.php */