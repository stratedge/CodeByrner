<?php

class WelcomeComponent extends Component {
	
	function __construct()
	{
		
	}
	
	function index()
	{
		return $this->load->view('welcome_message', FALSE, TRUE);
	}
	
	private function _birds()
	{
		return 'hello';
	}
}
