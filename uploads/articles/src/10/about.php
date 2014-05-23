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
		$this->data['layout']['title'] = 'What does shipping soon mean?';
		// Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/banner', array('title' => $this->data['layout']['title']));
		$this->load->view('about/index');
		$this->load->view('core/footer');
	}
	public function resume()
	{
		// Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/banner', array('title' => 'Resume'));
		$this->load->view('about/resume');
		$this->load->view('core/footer');
	}
}