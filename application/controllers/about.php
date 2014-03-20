<?php

defined('BASEPATH') OR die('404 Not Found');

class About extends Public_Controller
{
	public function __construct()
	{
		// Load the parent constructor.
		parent::__construct();
	}
	
	public function index()
	{
		// Load the views.
		$this->load->view('core/header', $this->data['layout']);
        $this->load->view('about/index');
		$this->load->view('core/footer');
	}
}