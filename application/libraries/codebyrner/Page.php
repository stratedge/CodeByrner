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
 * CodeByrner Page Class
 *
 * This class is one of the core files for the CodeByrner platform. The purpose of this class is to
 * provide methods that allow the developer to componentize their project by keeping track of
 * components and their locations within a layout and constructing the page. Controllers should
 * extend this class, or any other class that extends this class.
 *
 * @package		CodeByrner
 * @subpackage	Libraries
 * @category	Libraries
 * @property	array		$_components		An array of the components added to the page and their properties
 * @property	array		$_data				Deprecated property, no longer in use and should go away in the next version
 * @property	string		$_default_location	The name of the section in a layout that content should be assigned to if not given when a component is added. Uses the value from the CodeByrner config
 * @property	string		$_layout			The name of the layout file that should be used to build the page
 * @property	string		$_layout_folder		The name of folder in which layout files are kept by default. Uses the value from the CodeByrner config unless otherwise specified
 * @property	string		$_tpl				Deprecated property, no longer in use and should go away in the next version
 * @author		JB
 * @version		1.0
 * @since		1.0
 */
class Page extends MY_Controller {
		
    private $_components = array();
	private $_data = array();
	private $_default_location;
	private $_layout;
	private $_layout_folder;
	private $_tpl;
	
	/**
	 * Constructor Method
	 * 
	 * This construction method will call the class' parent's constructor to ensure that any
	 * required initializations are completed and then define some default properties according to
	 * values set in the CodeByrner configuration file.
	 * 
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
    function __construct()
    {
        parent::__construct();
		
		//Define default settings
		$this->_default_location = $this->config->item('cb_default_location');
		$this->_layout = $this->config->item('cb_default_layout');
		$this->_layout_folder = $this->config->item('cb_default_layout_folder');
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Adds a component to the page
	 * 
	 * This method takes a component class and an optional location on the page and saves it to the
	 * page for building the page later. Essentially, this method adds a component to the page in
	 * the designated spot.
	 * 
	 * @param	string			$class		The name of the library class to add to the page
	 * @param	string|FALSE	$location	The identifier of the location on the page to add the specified component
	 * @param	array			$params		An array of name-value pairs that serve as parameters that will be passed to the component
	 * @param	string			$method		The name of the method to call in the component class. Defaults to just index.
	 * @return	bool
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function addComponent($class, $location = FALSE, array $params = array(), $method = 'index')
	{
		if(!$location) $location = $this->_default_location;
		
		$data = array(
			'class' => $class,
			'location' => $location,
			'params' => $params,
			'method' => $method
		);
		
		return $this->_components[] = $data;
	}
	
	
	//---------------------------------------------------------------------------------------------
	
	
	/**
	 * Builds the page
	 * 
	 * Calling this method is the final step in constructing a completed page from components. It
	 * runs through the list of components and executes the given method for each. What gets
	 * returned is added to the content for the section of the layout the component was specified
	 * for. That data is then added to the layout view and sent to the browser.
	 * 
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	 function build()
	{
		//Get the path to where the component classes are being stored from the config
		$path = FALSE;
		$components_folder = $this->config->item('cb_components_folder');
		if(!empty($components_folder)) $path = $components_folder . '/';

		foreach($this->_components as $component)
		{
			//Extract the array of component information
			extract($component, EXTR_OVERWRITE);
			
			//Load the class so we can use it
			$this->load->library($path . $class);
			
			//Adjust the name so we can call it appropriately
			$class = strtolower($class);
			
			//Add the data to the data container to be set to the layout later
			if(!isset($this->_data[$location])) $this->_data[$location] = $this->$class->$method($params);
			else $this->_data[$location] .= $this->$class->$method($params);
		}
		
		//If a layouts folder is defined add a backslash to it so we can build a path to the view correctly
		if(!empty($this->_layout_folder)) $this->_layout_folder = $this->_layout_folder . '/';
		
		//Build the page
		$this->load->view($this->_layout_folder . $this->_layout, $this->_data);
	}


	/**
	 * Set the Layout
	 * 
	 * This method allows the developer to define the layout view file to use when building the
	 * page.
	 * 
	 * @param	string	$layout	The name of the viewfile to use as the layout
	 * @author	JB
	 * @version	1.0
	 * @since	1.0
	 */
	function setLayout($layout)
	{
		$this->_layout = $layout;
	}
	
}

/* End of file Page.php */
/* Location: ./application/libraries/codebyrner/Page.php */