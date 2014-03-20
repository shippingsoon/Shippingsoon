<?php

defined('BASEPATH') OR die('404 Not Found');

class Blog extends Public_Controller
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
    //
	public function index()
	{
        $this->load->view('core/header', $this->data['layout']);
		$this->load->view('blog/index', $this->data);
		$this->load->view('blog/recent', $this->data);
		$this->load->view('core/footer', $this->data);
    }
	public function development($slug = NULL, $article_id = NULL, $page = 0)
	{
		$this->_category($article_id, $page);
    }
	public function design($slug = NULL, $article_id = NULL, $page = 0)
	{
		$this->_category($article_id, $page);
    }
	public function discovery($slug = NULL, $article_id = NULL, $page = 0)
	{
		$this->_category($article_id, $page);
    }
	private function _category($article_id = NULL, $page = 0)
	{
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('blog/category', $this->data['layout']);
		if ($article_id) {
			if ($this->data['article'] = $this->articles->get_project((int) $article_id, TRUE)) {
				$this->data['article']['pages'] = $this->articles->get_pages((int) $article_id);
				if (isset($this->data['article']['pages'][(int) $page]['content']))
					$this->data['article']['content'] = $this->data['article']['pages'][(int) $page]['content'];
				else
					redirect("blog/{$this->data['layout']['method']}");
				$this->load->view('blog/view', $this->data);
			}
			else
				redirect("blog/{$this->data['layout']['method']}");
		}
		else {
			$this->data['articles'] = $this->articles->get_articles(TRUE);
			$this->load->view('blog/list', $this->data['articles']);
			$this->load->view('blog/recent', $this->data['articles']);
			
		}
		$this->load->view('core/footer', $this->data);
    }
}