<?php

defined('BASEPATH') OR die('404 Not Found');

class Blog extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load the required libraries.
		$this->load->library(array('parser'));
		$this->load->helper(array('pager', 'article'));
	}
	
	public function index()
	{
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/navigation', $this->data['layout']);
		$this->load->view('blog/index', $this->data);
		$this->load->view('blog/recent', $this->data['layout']);
		$this->load->view('core/footer', $this->data);
	}
	
	public function development($slug = NULL, $article_id = NULL, $page = 0)
	{
		$this->_category($slug, $article_id, $page, 1);
	}
	
	public function design($slug = NULL, $article_id = NULL, $page = 0)
	{
		$this->_category($slug, $article_id, $page, 2);
	}
	
	public function discovery($slug = NULL, $article_id = NULL, $page = 0)
	{
		$this->_category($slug, $article_id, $page, 3);
	}
	
	private function _category($slug = NULL, $article_id = NULL, $page = 0, $category_id = 1)
	{
		//Set the page's breadcrumbs.
		$this->data['breadcrumbs'] = array(
			'Blog' => base_url('blog'),
			ucfirst($this->data['layout']['method']) => ''
		);
		
		if (!$article_id) {
			$offset = (int) $slug;
			$this->data['articles'] = $this->articles->get_articles(NULL, NULL, $offset, 4, $category_id);
			foreach ($this->data['articles'] AS &$article) {
				$article['pages'] = $this->articles->get_pages($article['article_id']);
				$article['image_url'] = set_image($article);
				$article['page'] = set_page($article, $offset);
			}
			set_title($this->data, ucfirst($this->data['layout']['method']), TRUE);
		}
		else {
			$this->data['article_id'] = (int) $article_id;
			
			if (!($this->data['article'] = $this->articles->get_articles($this->data['article_id'], NULL, 0, 1, $category_id)))
				redirect('blog');
			
			//Set the page's title.
			set_title($this->data, $this->data['article']['title'], FALSE);
			
			//Get the search tags for this article.
			$this->data['article']['tags'] = $this->articles->get_tags($this->data['article_id']);
			
			//Get the recent articles.
			$this->data['article']['recent_articles'] = $this->articles->get_articles($this->data['article_id'], NULL, 0, 2, $category_id, TRUE);
			
			//Set the pages.
			$this->data['article']['pages'] = $this->articles->get_pages($this->data['article_id']);
			$this->data['article']['page'] = (isset($this->data['article']['pages'][$page]['content']))
				? $this->data['article']['pages'][$page]['content']
				: '';
			
			//Set the bread crumbs for this page.
			$this->data['breadcrumbs'][ucfirst($this->data['layout']['method'])] = base_url("blog/{$this->data['layout']['method']}");
			$this->data['breadcrumbs'][$this->data['article']['title']] = '';
			
			//Retrieve resources for this article.
			load_resources($this->data['layout'], $this->data['article_id'], 'js');
			load_resources($this->data['layout'], $this->data['article_id'], 'css');
		}
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/navigation', $this->data['layout']);
		$this->load->view('core/banner', array('title' => ucfirst($this->data['layout']['method'])));
		$this->load->view('portfolio/breadcrumb', $this->data);
		$this->load->view('blog/blog-open');
		$this->load->view('portfolio/view/article-open');
		
		if (!$article_id)
			$this->load->view('blog/list', $this->data);
		else
			$this->parser->parse('blog/page', $this->data['article']);
		$this->load->view('portfolio/view/article-close');
		$this->load->view('portfolio/view/sidebar-open', $this->data);
		
		if ($article_id) {
			$this->load->view('portfolio/view/recent', $this->data['article']);
			$this->load->view('portfolio/view/tag', $this->data['article']);
		}
		
		$this->load->view('portfolio/view/sidebar-close', $this->data);
		$this->load->view('blog/blog-close');
		
		if (!$article_id)
			$this->load->view('blog/recent', $this->data['layout']);
		$this->load->view('core/footer', $this->data['layout']);
	}

}