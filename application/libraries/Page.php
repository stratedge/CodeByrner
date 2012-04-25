<?php

class Page extends CI_Controller {
	
	public $tpl;
	public $components = array();
	public $logged_in = false;
	
	function __construct()
	{
		parent::__construct();
		
		$user_id = $this->session->userdata('user_id');
		
		if($user_id)
		{
			$service = Service::UserService($user_id);
			$u = $service->getUser();
			if($u)
			{
				$this->user = $u;
				$this->logged_in = true;
			}
			unset($u);
		}
		
		$this->tpl = new Template();
	}
	
	
	//-----------------------------------------------------------------------------------
	
	
	/**
	 * Takes care of adding a component to the page in the specified position with any
	 * optional parameters.
	 * 
	 * @param	string		$component	The component's class name
	 * @param	string		$position	The section of the layout to add the component to
	 * @param	array		$params		Optional params/environmental variables
	 * @return	bool
	 * @author	JB
	 * @version	2011-09-10
	 */
	function addComponent($component, $position, $params = false)
	{
		return $this->components[] = array(
			'component' => $component,
			'position' => $position,
			'params' => $params
		);
	}
	
	
	//-----------------------------------------------------------------------------------
	
	
	/**
	 * Builds the page by compiling components, adding them to the layout, and parsing
	 * the layout's template.
	 * 
	 * @param	string	$layout	Optional layout to use, otherwise the one_column layout will be used
	 * @author	JB
	 * @version	2011-09-10
	 */
	function build($layout = false)
	{
		foreach($this->components as $component)
		{
			$cmpt = $component['component'];
			$this->load->library($cmpt, $component['params']);
			$cmpt = strtolower($cmpt);
			$content = $this->$cmpt->run();
			$this->tpl->addBlock($component['position'], $content);
		}
		
		if($layout) $this->tpl->setLayout($layout);
		
		$this->tpl->build();
	}
	
}

/* End of file Page.php */
/* Location: ./application/libraries/Page.php */