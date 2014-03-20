<?php

defined('BASEPATH') OR die('404 Not Found');

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		//If the user isn't logged in, redirect them to the login page.
		if (!$this->data['layout']['logged_in'] OR !$this->authentication->is_admin()) {
			redirect('user/login');
			die();
		}
	}
}