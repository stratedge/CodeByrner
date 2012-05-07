<?php

class WelcomeComponent extends Component {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		return $this->load->view('welcome_message', FALSE, TRUE);
	}
}

/* End of file WelcomeComponent.php */
/* Location: ./application/libraries/components/WelcomeComponent.php */