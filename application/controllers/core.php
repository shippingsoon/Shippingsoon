<?php

defined('BASEPATH') OR die('404 Not Found');

class Core extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	//Home page.
	public function index()
	{
		//Use tags to retrieve projects.
		$tags = array('application', 'website', 'software', 'freelance', 'professional', 'design');
		$this->data['articles'] = $this->articles->get_articles(NULL, $tags, 0, 8);
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/carousel-top');
		$this->load->view('contact/form');
		$this->load->view('core/carousel-bottom');
		$this->load->view('core/index');
		$this->load->view('blog/recent', $this->data['layout']);
		$this->load->view('portfolio/featured-open');
		$this->load->view('portfolio/filter/buttons');
		$this->load->view('portfolio/featured-close', $this->data);
		$this->load->view('core/modal');
		$this->load->view('core/footer', $this->data['layout']);
	}
	//Nefarious data mining.
	public function statistics($statistic_id)
	{
		if ($statistic_id)
			$this->statistics->track_usage((int) $statistic_id);
	}
}