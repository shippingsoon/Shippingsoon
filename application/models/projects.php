<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Projects extends CI_Model 
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		$this->load->database();
	}
    //Get all results by tag name.
	public function get_by_tags($tags, $offset = 0, $limit = 12, $is_visible = TRUE)
	{
		$this->db
			->select('SQL_CALC_FOUND_ROWS p.*, count(*) AS score', FALSE)
			->from('projects AS p')
			->join('project_tags AS pt', 'pt.project_id = p.project_id', 'left');
		if ($is_visible)
			$this->db->where(array('visible' => 1));
        foreach ($tags AS $tag)
            $this->db->or_like('pt.tag', $tag, (strlen($tag) > 3) ? 'after' : 'none');
        return $this->db
            ->group_by('p.project_id')
			->order_by('score', 'desc')
            ->limit($limit, $offset * $limit)
            ->get()
            ->result_array();
	}
    //Get all results by date added.
	public function get_by_date($offset = 0, $limit = 12, $is_visible = TRUE)
	{
		$this->db
			->select('SQL_CALC_FOUND_ROWS p.*', FALSE)
			->from('projects AS p');
		if ($is_visible)
			$this->db->where(array('visible' => 1));
		return $this->db
			->group_by('p.project_id')
			->order_by('date_modified', 'desc')
            ->limit($limit, $offset * $limit)
            ->get()
            ->result_array();
	}
    //Adds a project.
	public function save($input)
	{
		//Build the insert array.
		$insert = array(
            'title' => $input['title'],
			'description' => $input['description'],
			'version' => $input['version'],
			'reference' => $input['reference'],
            'link' => $input['link'],
			'indention_style' => $input['indention_style'],
            'license' => $input['license'],
			'visible' => $input['visible'],
			'listed' => $input['listed'],
            'status' => $input['status'],
            'owner' => $input['owner'],
            'slug' => preg_replace('/\s+/', '-', strtolower($input['title'])),
            'line_count' => $input['line_count'],
            'word_count' => $input['word_count'],
            'date_created' => !empty($input['date_created']) ? strtotime($input['date_created']) : time(),
            'date_modified' => !empty($input['date_modified']) ? strtotime($input['date_modified']) : time()
		);
		//Attempt to create a new project.
		if ($this->db->insert('projects', $insert)) {
            $project_id = $this->db->insert_id();
            //Insert the search tags.
            foreach ($input['tags'] AS $tag)
                $this->db->insert('project_tags', array('project_id' => $project_id, 'tag' => $tag));
            return $project_id;
        }
        return NULL;
	}
	//Edit a project.
	public function edit($project_id, $input)
	{
		//Build the update array.
		$update = array(
            'title' => $input['title'],
			'description' => $input['description'],
			'version' => $input['version'],
			'reference' => $input['reference'],
            'link' => $input['link'],
			'indention_style' => $input['indention_style'],
            'license' => $input['license'],
			'visible' => $input['visible'],
			'listed' => $input['listed'],
            'status' => $input['status'],
            'owner' => $input['owner'],
            'slug' => preg_replace('/\s+/', '-', strtolower($input['title'])),
            'line_count' => $input['line_count'],
            'word_count' => $input['word_count'],
            'date_created' => !empty($input['date_created']) ? strtotime($input['date_created']) : time(),
            'date_modified' => !empty($input['date_modified']) ? strtotime($input['date_modified']) : time()
		);
		//Attempt to update the project.
		if ($result = $this->db->where('project_id', $project_id)->update('projects', $update)) {
			//Remove existing tags.
            $this->db->delete('project_tags', array('project_id' => $project_id));
            //Insert the search tags.
            foreach ($input['tags'] AS $tag)
                $this->db->insert('project_tags', array('project_id' => $project_id, 'tag' => $tag));
			return $project_id;
		}
		return NULL;
	}
	public function has_file($project_id, $has_file)
	{
		return $this->db
			->set('has_file', ($has_file) ? 1 : 0)
			->where('project_id', (int) $project_id)
			->update('projects');
	}
	//Get a project by ID.
	public function get_project($project_id, $is_visible = TRUE)
	{
        $this->db
            ->select('*, FROM_UNIXTIME(`date_created`, \'%m/%d/%Y\') AS date_created, FROM_UNIXTIME(`date_modified`, \'%m/%d/%Y\') AS date_modified', FALSE)
            ->from('projects')
            ->where(array('project_id' => (int) $project_id));
        if ($is_visible)
            $this->db->where(array('visible' => 1));
        return $this->db
            ->get()
            ->row_array();
	}
    //Get a projects.
	public function get_projects($is_visible = TRUE)
	{
        $this->db
            ->select('*, FROM_UNIXTIME(`date_created`, \'%m/%d/%Y\') AS date_created', FALSE)
            ->from('projects');
        if ($is_visible)
			$this->db->where(array('visible' => 1));
		return $this->db
			->get()
            ->result_array();
	}
	//Get recent projects.
	public function recent_projects($project_id, $limit = 2, $is_visible = TRUE)
	{
        $this->db
            ->select('*, FROM_UNIXTIME(`date_created`, \'%m/%d/%Y\') AS date_created', FALSE)
            ->from('projects')
			->where(array('project_id !=' => (int) $project_id))
			->limit($limit)
			->order_by('rand()'); 
			
        if ($is_visible)
			$this->db->where(array('visible' => 1));
		return $this->db
			->get()
            ->result_array();
	}
	//Get the total amount of results from the prepous query. This will be used for pagination.	
	public function get_total_results()
	{
        $this->db
			->select('FOUND_ROWS() AS total_rows', FALSE);
		return $this->db
			->get()
			->row()
            ->total_rows;
	}
    //Get search tags from the database.
	public function get_tags($project_id = NULL, $is_visible = TRUE)
	{
        $this->db
            ->select('GROUP_CONCAT(DISTINCT pt.tag) AS tags')
            ->distinct()
            ->from('project_tags AS pt')
			->join('projects AS p', 'p.project_id = pt.project_id', 'left');
        if ($project_id)
            $this->db->where(array('pt.project_id' => (int) $project_id));
		if ($is_visible)
			$this->db->where(array('p.visible' => 1));
        $query = $this->db->get();
        return ($query->num_rows() > 0) 
            ? $query->row()->tags
            : NULL;
	}
    //Used for debugging.
    public function last_query()
    {
        return $this->db->last_query();
    }
	//Log the search results.
	public function search_log($tags, $offset, $limit, $total_results)
	{
		//Build our insert array.
		$insert = array(
		    'search_log' => "$offset/$limit/$tags",
			'total_results' => $total_results,
			'ip_address' => $this->input->ip_address()
		);
	   //Insert the data into our table.
	   return $this->db->insert('project_search_logs', $insert);
	}
}

