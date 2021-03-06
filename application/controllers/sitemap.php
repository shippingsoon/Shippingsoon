<?php

defined('BASEPATH') OR die('404 Not Found');

class Sitemap extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load the required libraries.
		$this->load->library(array('parser'));
		$this->load->helper(array('form', 'url', 'pager'));
	}

	//Outputs a sitemap index file. This is basically a sitemap that indexes other sitemaps.
	public function index()
	{
		//Create a new XML element.
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
		
		$xml_files = array(
			'page-sitemap.xml',
			'blog-sitemap.xml',
			'portfolio-sitemap.xml',
			'search-sitemap.xml'
		);
		
		foreach ($xml_files AS $xml_file) {
			$sitemap = $xml->addChild('sitemap');
			$link = base_url($xml_file);
			$sitemap->addChild('loc', $link);
		}
		
		//Output the XML data.
		$this->output
			->set_content_type('application/xml')
			->set_output($xml->asXML());
	}
	
	//Outputs a sitemap for the portfolio controller.
	public function portfolio()
	{
		//Create a new XML element.
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
		
		//Retrieve the articles.
		$articles = $this->articles->get_articles(NULL, NULL, NULL, NULL, 'portfolio');

		foreach ($articles AS $article) {
			//Get a link to this article's details page.
			$details_link = base_url("portfolio/{$article['slug']}/{$article['article_id']}");
			
			//Build the XML file.
			$this->_build_xml($xml->addChild('url'), $details_link, date(DATE_W3C, strtotime($article['date_modified'])), 'weekly', '0.7');
		}
		
		//Output the XML data.
		$this->output
			->set_content_type('application/xml')
			->set_output($xml->asXML());
	}
	
	//Outputs a sitemap for the blog controller.
	public function blog()
	{
		//Create a new XML element.
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
		
		//Retrieve the articles.
		$articles = $this->articles->get_articles(NULL, NULL, NULL, NULL, array('Development', 'design'));

		foreach ($articles AS $article) {
			//Get a link to this article's details page.
			$details_link = base_url(strtolower("blog/{$article['category']}/{$article['slug']}/{$article['article_id']}"));
			
			//Build the XML file.
			$this->_build_xml($xml->addChild('url'), $details_link, date(DATE_W3C, strtotime($article['date_modified'])), 'weekly', '0.6');
		}
		
		//Output the XML data.
		$this->output
			->set_content_type('application/xml')
			->set_output($xml->asXML());
	}
	
	//Outputs a sitemap for the search controller.
	public function search()
	{
		//Create a new XML element.
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
		
		//Retrieve the articles.
		$tags = $this->articles->get_tags();
		$tags = explode(',', $tags);
		
		foreach ($tags AS $tag) {
			//Get a link to this article's details page.
			$link = base_url(strtolower("portfolio/search/0/12/$tag"));
			
			//Build the XML file.
			$this->_build_xml($xml->addChild('url'), $link, NULL, 'daily', '0.1');
		}
		
		//Output the XML data.
		$this->output
			->set_content_type('application/xml')
			->set_output($xml->asXML());
	}
	
	//Outputs a sitemap for various pages.
	public function page()
	{
		//Create a new XML element.
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');

		//An array of pages.
		$pages = array(
			'',
			'user/login',
			'what-does-shipping-soon-mean',
			'what-does-shipping-soon-mean/resume',
			'credits',
			'blog/development',
			'blog/design',
			'contact'
		);
		
		//Build the XML file for each page.
		foreach ($pages AS $page) {
			//Get a link to this page.
			$link = base_url($page);
			
			//Build the XML file.
			$this->_build_xml($xml->addChild('url'), $link);
		}
		
		//Output the XML data.
		$this->output
			->set_content_type('application/xml')
			->set_output($xml->asXML());
	}
	
	//Builds an XML file.
	private function _build_xml($url, $loc, $lastmod = NULL, $changefreq = 'weekly', $priority = '0.5')
	{
		$url->addChild('loc', $loc);
		if ($lastmod)
			$url->addChild('lastmod', $lastmod);
		$url->addChild('changefreq', $changefreq);
		$url->addChild('priority', $priority);
	}
}