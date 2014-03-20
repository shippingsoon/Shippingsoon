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
		$this->load->model('projects');
	}
    //
	public function index()
	{
        $this->load->view('core/header', $this->data['layout']);
		$this->load->view('portfolio/index', $this->data);
		$this->load->view('portfolio/featured', array('ignore' => ''));
		$this->load->view('core/footer', $this->data);
    }
	//Find projects
	public function find($offset = 0, $limit = 12, $tags = '')
	{
		//Set the page offset and display limit.
		$this->data['offset'] = (int) $offset;
        $this->data['limit'] = (int) $limit;
        //Set the autocomplete tags for the search.
        $this->data['auto_complete'] = $this->projects->get_tags(NULL, TRUE);
        $this->validation_rules = array(
			array(
				'field' => 'tags',
				'label' => 'Tags',
				'rules' => 'trim|max_length[100]|required'
			)
		);
		//Set the validation rules.
		$this->form_validation->set_rules($this->validation_rules);
		//If the form is submitted.
        if ($this->form_validation->run()) {
			//Make sure all the search tags are unique.
			$this->data['tags'] = array_unique(explode(',', $this->input->post('tags')));
			//Use the tags to get the results we want.
			if ($this->data['projects'] = $this->projects->get_by_tags($this->data['tags'], $this->data['offset'], $this->data['limit'])) {

            }
		}
		//If the form is not submitted or invalid.
		else {
			//Set the search tags and make sure they are unique.
            $this->data['tags'] = array_unique(explode('-', urldecode($tags)));
            //Retrieve the projects by the date they were ordered or by the search tags we received.
            $this->data['projects'] = (empty($this->data['tags'][0]))
                ? $this->projects->get_by_date($this->data['offset'], $this->data['limit'])
                : $this->projects->get_by_tags($this->data['tags'], $this->data['offset'], $this->data['limit']);
        }
		$this->data['total_results'] = $this->projects->get_total_results();
        if ($this->data['projects'])
        {
            //Store the current page offset and search tags in a sesssion.
            $this->session->set_userdata(array(
                'tags' => implode('-', $this->data['tags']),
                'offset' => $offset,
                'limit' => $limit
            ));
			foreach ($this->data['projects'] AS &$project) {
				//Set a link to this project's details page.
				$project['details_link'] = base_url("project/view/{$project['slug']}/{$project['project_id']}");
				$project['edit_link'] = base_url("admin/edit_project/{$project['project_id']}/");
				//Truncate the project's description if it's too large.
				$project['short_description'] = (strlen($project['description']) > 140)
					? substr($project['description'], 0, 140) . "...<a href=\"{$project['details_link']}\" title=\"{$project['title']}\">Read More</a>"
					: $project['description'];
				//Check to see if this project has an image. Otherwise set a placeholder image.
				$project['image_path'] = project_image($project);
            }
			//The following variables will be used for pagination.
            
            $this->data['total_pages'] = ($this->data['limit'])
                ? ceil($this->data['total_results'] / $this->data['limit'])
                : 0;
            $this->data['pager_links'] = pagination($this->data['offset'], $this->data['limit'], $this->data['total_pages'], $this->data['total_results'], implode('-', $this->data['tags']));
        }
        //Log the search results.
		if (!empty($this->data['tags'][0]))
			$this->projects->search_log(implode('-', $this->data['tags']), $this->data['offset'], $this->data['limit'], $this->data['total_results']);
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('portfolio/find', $this->data);
		$this->load->view('core/footer', $this->data);
	}
    //Find projects
	public function view($slug = NULL, $project_id = NULL)
	{
        //If the slug or project ID isn't set, redirect the user to the projects page.
        if (!$slug OR !$project_id)
            redirect('portfolio');    
		//Set the project ID and slug.
		$this->data['project_id'] = (int) $project_id;
        $this->data['slug'] = $slug;
		//Grab the recent projects.
		$this->data['recent_projects'] = $this->projects->recent_projects($this->data['project_id']);
		//Attempt to retrieve the project.
        if ($this->data['project'] = $this->projects->get_project($this->data['project_id'])) {
			//Set the meta description.
			$this->data['meta_description'] = (!empty($this->data['project']['description']))
				? htmlspecialchars("{$this->data['project']['description']} - {$this->data['project']['title']}")
				: htmlspecialchars($this->data['project']['title']);
			$this->data['project']['details_link'] = base_url("portfolio/view/{$this->data['project']['slug']}/{$this->data['project_id']}/");
			$this->data['project']['edit_link'] = base_url("admin/edit/{$this->data['project_id']}/");
			$this->data['project']['date_created'] = date('F d, Y', strtotime($this->data['project']['date_created']));
            $this->data['project']['date_modified'] = date('F d, Y', strtotime($this->data['project']['date_modified']));
			$this->data['project']['tags'] = $this->projects->get_tags($this->data['project_id']);
            $this->data['directory_path'] = "uploads/project/src/{$this->data['project_id']}";
            if ($this->data['project']['has_file'] = file_exists($this->data['directory_path'])) {
                $files = array_diff(scandir($this->data['directory_path']), array('.', '..'));
				arsort($files);
				foreach ($files AS $filename) {
					$this->data['project']['files'][$filename]['path'] = $this->data['directory_path']."/$filename";
					$this->data['project']['files'][$filename]['info'] = pathinfo($this->data['project']['files'][$filename]['path']);
					$extensions['supported'] = array('php', 'c', 'py', 'html');
					$extensions['not_supported'] = array('zip', 'gz', '7z', 'tar', 'exe', '');
					$extension = (isset($this->data['project']['files'][$filename]['info']['extension']))
						? $this->data['project']['files'][$filename]['info']['extension']
						: '';
					if ($this->data['project']['files'][$filename]['supported'] = (!in_array($extension, $extensions['not_supported']))) {
						$this->data['project']['files'][$filename]['content'] = htmlspecialchars(file_get_contents($this->data['project']['files'][$filename]['path']));
						
						if (in_array($extension, $extensions['supported'])) {
							if ($extension == 'c' OR $extension == 'h')
								$this->data['project']['files'][$filename]['info']['extension'] = 'cpp';
							if ($extension == 'html')
								$this->data['project']['files'][$filename]['info']['extension'] = 'xml';
						}
						else 
							$this->data['project']['files'][$filename]['info']['extension'] = 'js';
					}
					//print_r($this->data['project']['files'][$filename]['info']);
					//echo "<br/>";
				}
            }
			
			//die_r($this->data);
            $this->data['project']['image_path'] = project_image($this->data['project']);
			$this->data['project']['has_image'] = ($this->data['project']['image_path'] != base_url('assets/img/layout/placeholder.gif'));
            foreach ($this->data['recent_projects'] AS &$recent_project) {
				$recent_project['image_path'] = project_image($recent_project);
				$recent_project['details_link'] = base_url("project/view/{$recent_project['slug']}/{$recent_project['project_id']}/");
			}
			//die("<pre>".print_r($this->data, TRUE));
			//Load the views.
            $this->load->view('core/header', $this->data['layout']);
            $this->load->view('portfolio/view', $this->data['project']);
            $this->load->view('core/footer', $this->data);
        }
        else
            redirect('project');
	}
	//This function returns a JSON object which is used to populate the search results area.
	public function get_projects()
	{
        //Set the offset and limit.
		$this->data['offset'] = (int) $this->input->post('offset');
        $this->data['limit'] = (int) $this->input->post('limit');
	    //Convert the search query string to an array and make sure it's unique.
        $this->data['tags'] = array_unique(explode('-', $this->input->post('tags')));
		//Retrieve the projects by the date they were modified or by tags.
		$this->data['projects'] = (!empty($this->data['tags'][0]))
			? $this->projects->get_by_tags($this->data['tags'], $this->data['offset'], $this->data['limit'])
			: $this->projects->get_by_date($this->data['offset'], $this->data['limit']);
		$this->data['total_results'] = $this->projects->get_total_results();
		//If we have results.
		if (!empty($this->data['projects']))
		{
            //Store the current page offset and search tags in a sesssion.
            $this->session->set_userdata(array(
                'tags' => implode('-', $this->data['tags']),
                'offset' => $this->data['offset'],
                'limit' => $this->data['limit']
                )
            );
            //These variables will be used for pagination.
			$this->data['total_pages'] = ($this->data['limit'])
                ? ceil($this->data['total_results'] / $this->data['limit'])
                : 0;
            $this->data['pager_links'] = pagination($this->data['offset'], $this->data['limit'], $this->data['total_pages'], $this->data['total_results'], implode('-', $this->data['tags']));
            //In this loop we set the paths to the project's images and details page.
            foreach ($this->data['projects'] AS $key => &$project) {
                //Set a link to this project's details page.
				$project['details_link'] = base_url("project/view/{$project['slug']}/{$project['project_id']}");
				$project['edit_link'] = base_url("admin/edit_project/{$project['project_id']}/");
				$project['maintenance'] = ($this->data['layout']['logged_in'])
					? "<a href=\"{$project['details_link']}\" class=\"btn btn-small\" title=\"View {$project['title']}\">View</a> <a href=\"{$project['edit_link']}\" class=\"btn btn-inverse btn-small\" title=\"Edit {$project['title']}\">Edit</a>"
					: '';
				//Truncate the project's description if it's too large.
				$project['short_description'] = (strlen($project['description']) > 140)
					? substr($project['description'], 0, 140) . "...<a href=\"{$project['details_link']}\" title=\"{$project['title']}\">Read More</a>"
					: $project['description'];
				//Check to see if this project has an image. Otherwise set a placeholder image.
				$project['image_path'] = project_image($project);
            }
			//Log the search results.
			if (!empty($this->data['tags'][0]))
				$this->projects->search_log(implode('-', $this->data['tags']), $this->data['offset'], $this->data['limit'], $this->data['total_results']);
			//Output our data as a JSON object.
			echo json_encode($this->data);
		}
	}
	
}