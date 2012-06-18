<?php

class WelcomeComponent extends Component {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		return $this->build('welcome_message');
	}
}

/* End of file WelcomeComponent.php */
/* Location: ./application/libraries/components/WelcomeComponent.php */