<?php

defined('BASEPATH') OR die('404 Not Found');

class Core extends Public_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
	}
	//
	public function index()
	{
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/carousel-top');
		$this->load->view('contact/form');
		$this->load->view('core/carousel-bottom');
        $this->load->view('core/index');
		$this->load->view('blog/recent');
		$this->load->view('portfolio/featured', array('ignore' => 'web'));
		$this->load->view('core/modal');
		$this->load->view('core/footer');
	}
	//
	public function statistics($statistic_id)
	{
		if ($statistic_id)
			$this->statistics->track_usage((int) $statistic_id);
	}
}