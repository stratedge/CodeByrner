<?php

class Template {
	
	private $data = array();
	private $view;
	private $template = FALSE;
	private $component;
	private $layout = FALSE;
	private $blocks = array();
	
	
	function __construct()
	{
		$this->layout = get_instance()->config->item('default_layout');
		return TRUE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds data to the template's data array under the key specified.
	 * 
	 * @param	string		$key	The key to place the data into inside the template's data array
	 * @param	mixed		$value	The data to be added
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addData(/* $key, $value OR (array) $value */)
	{
		switch(func_num_args())
		{
			case 1:
				$var = func_get_arg(0);
				if(is_array($var) || is_object($var))
				{
					$this->formatArrayData($var);
					foreach($var as $key => $value) $this->data[$key] = $value;
					
				} else return FALSE;
				break;
				
			case 2:
				$key = func_get_arg(0);
				$value = func_get_arg(1);
				
				if(is_array($value) || is_object($value))
				{
					$this->formatArrayData($value);
					$this->data[$key] = $value;
				}
				else
				{
					return $this->data[$key] = htmlspecialchars($value, ENT_QUOTES);
				}
				
				break;
			
			default:
				return FALSE;
				break;
		}
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Sets the view to parse.
	 * 
	 * @param	string		$view	The view file to set to the template's view property
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function setView($view)
	{
		return $this->view = $view;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Parses a component's template and returns the final HTML markup.
	 * 
	 * @return	string
	 * @author	JB
	 * @version	2011-09-10
	 */
	function parse($template = FALSE)
	{
		if($template) $this->setTemplate($template);
		
		$CI =& get_instance();
		$view = $this->template;
		
		
		/*
		 * Since XSS blocking is enabled by default, let's make sure we provide the CSRF tokens to
		 * the view by default as well
		 */
		$this->addData(array(
			'token_name' => $CI->security->get_csrf_token_name(),
			'token_hash' => $CI->security->get_csrf_hash()
		));
		
		return $CI->load->view($view, $this->data, TRUE);
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Sets the component folder name that the template files for this component will
	 * be located within.
	 * 
	 * @param	string		$component	The component that this template will be parsing
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function setComponent($component)
	{
		$component = preg_match_all('/[A-Z][^A-Z]*/', $component, $parts);
		$component = strtolower(implode('_', $parts[0]));
		return $this->component = $component;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Sets the template that the parser will need to load and parse.
	 * 
	 * @param	string		$template	Optional template name, otherwise defaults to index
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function setTemplate($template = 'index')
	{
		return $this->template = $template;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Sets the view to parse.
	 * 
	 * @param	string		$view	The view file to set to the template's view property
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function setLayout($layout = 'one_column')
	{
		$this->layout = $layout;
		return TRUE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a block of HTML onto the end of the specified section of the template's
	 * layout.
	 * 
	 * @param	string		$position	The section of the page to load the file into
	 * @param	string		$block		The HTML/text to add into the specified section of the layout
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addBlock($position, $block)
	{
		if($position && $block)
		{
			$this->blocks[$position][] = $block;
			return TRUE;
		} else return FALSE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Builds the page's HTML markup by adding the blocks into the correct sections of
	 * the layout and parsing the layout file.
	 * 
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function build()
	{
		$CI =& get_instance();
		$layout = sprintf('layouts/%s', $this->layout);
		$CI->load->view($layout, $this->blocks);
		return TRUE;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	function formatArrayData(&$arr)
	{
		foreach($arr as &$value)
		{
			if(is_array($value) || is_object($value))
			{
				$this->formatArrayData($value);
			}
			else $value = htmlspecialchars($value, ENT_QUOTES);
		}
	}
	
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */