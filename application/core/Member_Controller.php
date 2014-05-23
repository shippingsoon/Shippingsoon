<?php

defined('BASEPATH') OR die('404 Not Found');

class Member_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		//If the user isn't a member redirect them to the main page.
		if (($this->data['layout']['logged_in'] !== TRUE) OR !$this->authentication->is_member()) {
			redirect('core');
			die();
		}
    }
}