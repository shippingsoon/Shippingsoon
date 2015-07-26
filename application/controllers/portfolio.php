<?php

defined('BASEPATH') OR die('404 Not Found');

class Portfolio extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load the required libraries.
		$this->load->library(array('parser'));
		$this->load->helper(array('form', 'url', 'pager'));
	}
	
	//Displays featured articles.
	public function index($slug = NULL, $article_id = NULL)
	{
		//Set the article ID.
		if (!($this->data['article_id'] = (int) $article_id)) {
			//Retrieve the articles by their tags.
			$tags = array('application', 'website', 'software', 'freelance', 'professional', 'design');
			$this->data['articles'] = $this->articles->get_articles(NULL, $tags, 0, 30, 4);
		}
		else if ($this->data['article'] = $this->articles->get_articles($this->data['article_id'], NULL, 0, 1, 4)) {
			//Set the page's title.
			set_title($this->data, $this->data['article']['title'], FALSE);
			
			//Set the page's meta description.
			set_description($this->data, "{$this->data['article']['description']} | {$this->data['article']['title']}");
			
			//Get the search tags for this article.
			$this->data['article']['tags'] = $this->articles->get_tags($this->data['article_id']);
			
			//Get the recent articles.
			$this->data['article']['recent_articles'] = $this->articles->get_articles($this->data['article_id'], NULL, 0, 2, 4, TRUE);
			
			//Set the pages.
			$this->data['article']['pages'] = $this->articles->get_pages($this->data['article_id']);
			$this->data['article']['page'] = (isset($this->data['article']['pages'][0]['content']))
				? $this->data['article']['pages'][0]['content']
				: '';
			
			//Set the page's breadcrumbs.
			$this->data['breadcrumbs'] = array(
				'Portfolio' => base_url('portfolio'),
				$this->data['article']['title'] => ''
			);
			
			//Retrieve images and source code for this article.
			$src_path = "uploads/articles/src/{$this->data['article_id']}";
			$img_path = "uploads/articles/img/{$this->data['article_id']}";
			$this->data['article']['images'] = file_exists($img_path) ? array_diff(scandir($img_path), array('.', '..', '0.jpg', '.DS_Store')) : array();
			$this->data['article']['files'] = file_exists($src_path) ? array_diff(scandir($src_path), array('.', '..', '.DS_Store')) : array();
			//die(print_r($this->data['article']['images'], TRUE));
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
		}
		else
			redirect('portfolio');
		
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('core/navigation', $this->data['layout']);
		$this->load->view('core/banner', array('title' => ($article_id) ? $this->data['article']['title'] : 'Portfolio'));
		if (!$article_id) {
			$this->load->view('portfolio/featured-open');
			$this->load->view('portfolio/filter/list');
			$this->load->view('portfolio/featured-close', $this->data);
		}
		else {
			$this->load->view('portfolio/breadcrumb', $this->data);
			$this->load->view('blog/blog-open', $this->data['article']);
			$this->load->view('portfolio/view/article-open', $this->data['article']);
			$this->load->view('portfolio/view/carousel', $this->data['article']);
			if (!$this->data['article']['pages']) {
				$this->load->view('portfolio/view/profile', $this->data['article']);
			}
			$this->parser->parse('blog/page', $this->data['article']);
			$this->load->view('portfolio/view/source', $this->data['article']);
			$this->load->view('portfolio/view/article-close', $this->data['article']);
			$this->load->view('portfolio/view/sidebar-open', $this->data['article']);
			$this->load->view('portfolio/view/recent', $this->data['article']);
			$this->load->view('portfolio/view/tag', $this->data['article']);
			$this->load->view('portfolio/view/sidebar-close', $this->data['article']);
			$this->load->view('blog/blog-close', $this->data['article']);
			
		}
		$this->load->view('core/footer', $this->data['layout']);
	}
	
	//Search for articles.
	public function search($offset = 0, $limit = 12, $tags = '')
	{
		//Set the page offset and display limit.
		$this->data['offset'] = (int) $offset;
		$this->data['limit'] = (int) $limit;
		
		//Set the autocomplete tags for the search.
		$this->data['auto_complete'] = $this->articles->get_tags(NULL, TRUE);
		
		//Set the page's breadcrumbs.
		$this->data['breadcrumbs'] = array(
			'Portfolio' => base_url('portfolio'),
			'Search' => ''
		);
		
		//Set the search tags and make sure they are unique.
		$this->data['tags'] = array_unique(explode('-', preg_replace('/[^\w+-]+/', '', urldecode($tags))));
		$this->data['articles'] = $this->articles->get_articles(NULL, $this->data['tags'], $this->data['offset'], $this->data['limit']);
		
		//The following variables will be used for pagination.
		$this->data['total_results'] = $this->articles->get_total_results();
		$this->data['total_pages'] = ($this->data['limit']) ? ceil($this->data['total_results'] / $this->data['limit']) : 0;
		$this->data['pager'] = pagination($this->data['offset'], $this->data['limit'], $this->data['total_pages'], $this->data['total_results'], $this->data['tags']);
		$this->data['search_tags'] = trim(implode(', ', $this->data['tags']));
		set_title($this->data, ($this->data['search_tags']) ? "{$this->data['search_tags']} - Search results" : 'Search - Shipping Soon');
		set_description($this->data, $this->data['search_tags']);
		$this->data['title'] = ($this->data['search_tags']) ? "Search results for: <b>{$this->data['search_tags']}</b>" : 'Search';
		
		if (!$this->data['layout']['ajax_call']) {
			//Load the views.
			$this->load->view('core/header', $this->data['layout']);
			$this->load->view('core/navigation', $this->data['layout']);
			$this->load->view('core/banner', $this->data);
			$this->load->view('portfolio/breadcrumb', $this->data);
			$this->load->view('portfolio/search');
			$this->load->view('portfolio/featured-open');
			$this->load->view('portfolio/featured-close', $this->data);
			$this->load->view('portfolio/pager', $this->data);
			$this->load->view('core/footer', $this->data['layout']);
		}
		else {
			//Output our data as a JSON object.
			echo json_encode($this->data);
		}
	}
}
