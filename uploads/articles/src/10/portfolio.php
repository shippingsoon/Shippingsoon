<?php

defined('BASEPATH') OR die('404 Not Found');

class Portfolio extends Public_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		//Load the required libraries.
		$this->load->library(array('form_validation', 'authentication'));
		$this->load->helper(array('form', 'url', 'pager'));
		$this->load->model('articles');
	}
	//Displays featured projects.
	public function index()
	{
		//Retrieve the projects by their tags.
		$this->data['articles'] = $this->articles->get_by_tags(explode(' ', 'application website software freelance professional design'), 30, NULL);
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/banner', array('title' => 'Portfolio'));
		$this->load->view('portfolio/featured', $this->data);
		$this->load->view('core/footer', $this->data);
	}
	//View articles
	public function view($slug = NULL, $article_id = NULL)
	{
		//If the slug or article ID is not set, redirect the user to the portfolio page.
		if (!$slug OR !$article_id)
			redirect('portfolio');	
		//Set the article ID.
		$this->data['article_id'] = (int) $article_id;
		//Attempt to retrieve the article.
		if ($this->data['article'] = $this->articles->get_article($this->data['article_id'])) {
			//Set the page title.
			$this->data['layout']['title'] = $this->data['article']['title'];
			//Set the meta description.
			$this->data['layout']['meta_description'] = "{$this->data['article']['description']} | {$this->data['article']['title']}";
			//Get the search tags for this artilces.
			$this->data['article']['tags'] = $this->articles->get_tags($this->data['article_id']);
			//Get the recent articles.
			$this->data['article']['recent_articles'] = $this->articles->recent_articles($this->data['article_id'], 2, 4);
			//Set the page's breadcrumbs.
			$this->data['breadcrumbs'] = array(
				'Portfolio' => base_url('portfolio'),
				$this->data['article']['title'] => ''
			);
			//Retrieve images and source code for this project.
			$src_path = "uploads/articles/src/{$this->data['article_id']}";
			$img_path = "uploads/articles/img/{$this->data['article_id']}";
			$this->data['article']['images'] = file_exists($img_path) ? array_diff(scandir($img_path), array('.', '..', '0.jpg')) : array();
			$this->data['article']['files'] = file_exists($src_path) ? array_diff(scandir($src_path), array('.', '..')) : array();
			//Filter out .PNGs.
			$this->data['article']['images'] = array_filter($this->data['article']['images'], function($file) {
				return (pathinfo($file)['extension'] == 'jpg');
			});
			//Filter out unsupported file extensions.
			$this->data['article']['files'] = array_filter($this->data['article']['files'], function($file) {
				$supported = array('c', 'cpp', 'h', 'hpp', 'css', 'js', 'sh', 'py', 'php', 'html', 'txt', 'xml', 'sql');
				return (in_array((count(pathinfo($file)) > 3) ? pathinfo($file)['extension'] : '', $supported));
			});
			//Get the contents of the source code files.
			foreach ($this->data['article']['files'] AS $key => $filename) {
				$this->data['article']['files'][$key] = array(
					'filename' => $filename,
					'content' => htmlspecialchars(file_get_contents("$src_path/$filename"))
				);
			}
			//Load the views.
			$this->load->view('core/header', $this->data['layout']);
			$this->load->view('core/banner', array('title' => $this->data['article']['title']));
			$this->load->view('portfolio/breadcrumb', $this->data);
			$this->load->view('portfolio/view', $this->data['article']);
			$this->load->view('portfolio/sidebar', $this->data['article']);
			$this->load->view('core/footer', $this->data);
		}
		else
			redirect('article');
	}
}