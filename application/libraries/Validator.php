<?php

class Validator {
	
	private $rules = array();
	
	function __construct()
	{
		$this->data = new stdClass();
		$get = $this->input->get(null, true);
		$post = $this->input->post(null, true);
		if(is_array($get)) foreach($get as $key => $value) $this->data->$key = $value;
		if(is_array($post)) foreach($post as $key => $value) $this->data->$key = $value;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function __get($key)
	{
		if(property_exists($this, $key)) return $this->$key;
		
		$CI =& get_instance();
		if(property_exists($CI, $key)) return $CI->$key;
		
		return false;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds the specified rule to the Validator's list of rules to process.
	 * 
	 * @param	string		$type	The type of rule
	 * @param	array		$params	An array of information that the rule will use to process
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addRule($type, $params)
	{
		return $this->rules[] = array(
			'type' => $type,
			'params' => $params
		);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a rule that will ensure that an input is not empty.
	 * 
	 * @param	string		$element	The key of the request that should contain a value
	 * @param	array		$params		An array containing validator failure information
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addEmptyCheck($element, $params)
	{
		$params['element'] = $element;
		return $this->addRule('empty', $params);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a rule that will ensure that an input is a valid email address.
	 * 
	 * @param	string		$element	The key of the request that should contain a value
	 * @param	array		$params		An array containing validator failure information
	 * @return	bool
	 * @author	JB
	 * @version	2011-10-26
	 */
	function addEmailCheck($element, $params)
	{
		$params['element'] = $element;
		return $this->addRule('email', $params);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a rule that will ensure that two inputs are identical.
	 * 
	 * @param	string		$element1	The key of the request containing the first value
	 * @param	string		$element2	The key of the request containing the second value
	 * @param	array		$params		An array containing validator failure information
	 * @return	bool
	 * @author	JB
	 * @version	2011-10-26
	 */
	function addMatchCheck($element1, $element2, $params)
	{
		$params['element1'] = $element1;
		$params['element2'] = $element2;
		return $this->addRule('match', $params);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a rule that will ensure that an input is a valid password.
	 * 
	 * @param	string		$element	The key of the request that should contain a value
	 * @param	array		$params		An array containing validator failure information
	 * @return	bool
	 * @author	JB
	 * @version	2011-10-30
	 */
	function addPasswordCheck($element, $params)
	{
		$params['element'] = $element;
		return $this->addRule('password', $params);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a rule that will ensure that at least one of the listed inputs isn't empty.
	 * 
	 * @param	array		$elements	The keys of the request where at least one should contain a value
	 * @param	array		$params		An array containing validator failure information
	 * @return	bool
	 * @author	JB
	 * @version	2011-11-08
	 */
	function addAnyCheck($elements, $params)
	{
		$params['elements'] = $elements;
		return $this->addRule('any', $params);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Iterates through all the rules, determines if the tests pass or fail, and will
	 * return failure info if the tests fail.
	 * 
	 * @param	bool		$debug	Whether or not to dump the results to the page
	 * @return	array
	 * @author	JB
	 * @version	2011-11-08
	 */
	function process($debug = false)
	{
		$pass = true;
		$codes = array();
		$classes = array();
		
		foreach($this->rules as $rule)
		{
			$check = true;
			
			switch($rule['type'])
			{
				case 'empty':
					if(!$this->emptyCheck($rule['params'])) $check = false;
					break;
					
				case 'email':
					if(!$this->emailCheck($rule['params'])) $check = false;
					break;
					
				case 'match':
					if(!$this->matchCheck($rule['params'])) $check = false;
					break;
					
				case 'password':
					if(!$this->passwordCheck($rule['params'])) $check = false;
					break;
					
				case 'any':
					if(!$this->anyCheck($rule['params'])) $check = false;
					break;
			}
			
			if(!$check)
			{
				$pass = false;
				if($rule['params']['code']) $codes[] = $rule['params']['code'];
				if($rule['params']['classes'])
				{
					if(isset($rule['params']['classes']['element'])) $classes[] = $rule['params']['classes'];
					else foreach($rule['params']['classes'] as $classRule) $classes[] = $classRule;
				}
			}
		}
		
		$results = array(
			'pass' => $pass,
			'codes' => array_values(array_unique($codes)),
			'classes' => $classes
		);
		
		if($debug) dump($results);
		
		return (object) $results;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Checks to see whether a specified key in the request object exists and isn't empty.
	 * 
	 * @param	array		$params	The parameters of the rule, including the key to check
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function emptyCheck($params)
	{
		$pass = true;
		
		if($params['element'])
		{

			$el = $params['element'];
			if(!isset($this->data->$el) || !trim($this->data->$el)) $pass = false;

		} else $pass = false;
		
		return $pass;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Checks to see whether a specified key in the request object contains a valid email address.
	 * 
	 * @param	array		$params	The parameters of the rule, including the key to check
	 * @return	bool
	 * @author	JB
	 * @version	2011-10-26
	 */
	function emailCheck($params)
	{
		if(!$this->emptyCheck($params)) return false;
		
		$el = $params['element'];
		$this->load->helper('email');
		return valid_email($this->data->$el);
		//return filter_var($this->data->$el, FILTER_VALIDATE_EMAIL);
		
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Checks to see whether two specified keys in the request object contain identical values.
	 * 
	 * @param	array		$params	The parameters of the rule, including the key to check
	 * @return	bool
	 * @author	JB
	 * @version	2011-10-26
	 */
	function matchCheck($params)
	{
		if($params['element1'] && $params['element2'])
		{

			$el1 = $params['element1'];
			$el2 = $params['element2'];
			
			if(isset($this->data->$el1) && isset($this->data->$el2))
				return $this->data->$el1 === $this->data->$el2;
			
			return isset($this->data->$el1) == isset($this->data->$el2);
			
		} else return false;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Checks to see whether a specified key in the request object contains a valid password.
	 * 
	 * @param	array		$params	The parameters of the rule, including the key to check
	 * @return	bool
	 * @author	JB
	 * @version	2011-10-30
	 */
	function passwordCheck($params)
	{
		if(!$this->emptyCheck($params)) return false;
		
		$el = $params['element'];
		$this->load->helper('email');
		$pattern = '/^(?!.*(.)\1{2})((?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\!\@\#\$\%\?])(?!.*[^A-Za-z0-9\!\@\#\$\%\?])).{8,20}$/';
		return preg_match($pattern, $this->data->$el) ? true : false;
		
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Checks to see whether at least one of the specified keys in the request object isn't empty.
	 * 
	 * @param	array		$params	The parameters of the rule, including the keys to check
	 * @return	bool
	 * @author	JB
	 * @version	2011-11-08
	 */
	function anyCheck($params)
	{
		$pass = false;
		
		foreach($params['elements'] as $element)
		{
			if($this->emptyCheck(array('element' => $element)))
			{
				$pass = true;
				break;
			}
		}
		
		return $pass;
		
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Builds a failure object in order to send codes that are don't necessarily get
	 * generated through the form validation.
	 * 
	 * @param	integer		$code	The error code to return in the failure object
	 * @return	array
	 * @author	JB
	 * @version	2011-09-10
	 */
	function buildFailure($code, $classes = false)
	{
		if($classes) $classes = array($classes);

		$results = array(
			'pass' => false,
			'codes' => array($code),
			'classes' => $classes
		);
		
		return $results;
	}
}