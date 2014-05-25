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
		set_title($this->data, 'What does shipping soon mean?');
		// Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/banner', array('title' => $this->data['layout']['title']));
		$this->load->view('about/index');
		$this->load->view('core/footer', $this->data['layout']);
	}
	public function resume()
	{
		//Set the page's title.
		set_title($this->data, 'Resume', TRUE);
		// Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/banner', array('title' => 'Resume'));
		$this->load->view('about/resume');
		$this->load->view('core/footer', $this->data['layout']);
	}
	function credits()
	{
		set_title($this->data, 'Credits');
		// Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/banner', array('title' => $this->data['layout']['title']));
		$this->load->view('about/credits');
		$this->load->view('core/footer', $this->data['layout']);
	}
}