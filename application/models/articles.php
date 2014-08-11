<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Articles extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Insert or update an article.
	public function save($article_id, $article, $pages, $tags)
	{
		if ($article_id)
			$this->db->where('article_id', $article_id)->update('articles', $article);
		else
			$this->db->insert('articles', $article);
		//Attempt to update the article.
		if ($this->db->affected_rows() > 0 OR $article_id) {
			if (!$article_id)
				$article_id = $this->db->insert_id();
			//Remove existing pages and tags.
			$this->db->delete('article_tags', array('article_id' => $article_id));
			$this->db->delete('article_pages', array('article_id' => $article_id));
			//Insert the search tags.
			foreach ($tags AS $tag)
				if (!empty($tag))
					$this->db->insert('article_tags', array('article_id' => $article_id, 'tag' => $tag));
			//Insert the new pages.
			foreach ($pages AS $page)
				if (!empty($page))
					$this->db->insert('article_pages', array('article_id' => $article_id, 'content' => $page));
			return $article_id;
		}
		return NULL;
	}
	//Get all results by tag name or article ID.
	public function get_articles($article_id = NULL, $tags = array(), $offset = 0, $limit = NULL, $category = NULL, $random = FALSE, $visible = TRUE, $listed = TRUE)
	{
		$this->db
			->select("
				SQL_CALC_FOUND_ROWS a.*,
				ac.title AS category,
				count(*) AS tally,
				DATE_FORMAT(a.date_created, '%M %d, %Y') AS date_created_formatted,
				DATE_FORMAT(a.date_modified, '%M/%d/%Y') AS date_modified_formatted".
				((!empty($tags)) ? ', group_concat(at.tag) AS tags' : '')
				, FALSE)
			->from('articles AS a')
			->join('article_categories AS ac', 'a.category_id = ac.category_id', 'left')
			->group_by('a.article_id');
		if (!empty($tags)) {
			$this->db->join('article_tags AS at', 'at.article_id = a.article_id', 'left');
			foreach ($tags AS $tag)
				if ($tag)
					$this->db->or_like('at.tag', $tag, (strlen($tag) > 3) ? 'after' : 'none');
		}
		else if ($article_id)
			$this->db->where(array((($random) ? 'a.article_id !=' : 'a.article_id') => (int) $article_id));
		if ($visible)
			$this->db->where(array('a.visible' => 1));
		if ($listed)
			$this->db->where(array('a.listed' => 1));
		if (!is_null($category)) {
			if (is_array($category)) {
				$where = '(';
				for ($i = 0; $i < count($category); $i++) {
					$column = (is_numeric($category[$i])) ? 'a.category_id' : 'ac.title';
					if (!is_numeric($category[$i]))
						$category[$i] = "'{$category[$i]}'";
					$where .= "$column = {$category[$i]}".(($i+1 < count($category)) ? ' OR ' : ')');
				}
				$this->db->where($where);
			}
			else
				$this->db->where(array((is_numeric($category) ? 'a.category_id' :'ac.title') => $category));
		}
		if ($random)
			$this->db->order_by('rand()');
		else {
			$this->db
				->order_by('tally', 'desc')
				->order_by('a.date_modified', 'desc');
		}
			
		if (!is_null($limit))
			$this->db->limit($limit, $offset * $limit);
		$query = $this->db->get();
		return ($article_id AND !$random) ? $query->row_array() : $query->result_array();

	}
	//Get the total amount of results from the previous query. This will be used for pagination.	
	public function get_total_results()
	{
		return $this->db
			->select('FOUND_ROWS() AS total_rows', FALSE)
			->get()
			->row()
			->total_rows;
	}
	//Get search tags from the database.
	public function get_tags($article_id = NULL, $is_visible = TRUE)
	{
		$this->db
			->select('GROUP_CONCAT(DISTINCT pt.tag) AS tags')
			->distinct()
			->from('article_tags AS pt')
			->join('articles AS p', 'p.article_id = pt.article_id', 'left');
		if ($article_id)
			$this->db->where(array('pt.article_id' => (int) $article_id));
		if ($is_visible)
			$this->db->where(array('p.visible' => 1));
		$query = $this->db->get();
		return ($query->num_rows() > 0) 
			? $query->row()->tags
			: NULL;
	}
	//Retrieves all project categories.
	public function get_categories()
	{
		return $this->db
			->get_where('article_categories')
			->result_array();
	}
	//Retrieves all pages for a given article.
	public function get_pages($article_id)
	{
		return $this->db
			->get_where('article_pages', array('article_id' => (int) $article_id))
			->result_array();
	}
	//Used for debugging.
	public function last_query()
	{
		return $this->db->last_query();
	}
}

