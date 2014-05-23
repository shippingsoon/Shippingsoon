<?php

defined('BASEPATH') OR die('404 Not Found');

class Admin extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'upload'));
		$this->load->model('articles');
	}
	//Admin control panel.
	public function index()
	{
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('admin/index', $this->data);
		$this->load->view('core/footer', $this->data['layout']);
	}
	//Add or edit articles.
	public function article($article_id = NULL, $slug = NULL)
	{
		//Form validation rules.
		$this->validation_rules = array(
			array('field' => 'category_id', 'label' => 'Category', 'rules' => 'trim|min_length[1]|max_length[1]|numeric|required'),
			array('field' => 'title', 'label' => 'Title', 'rules' => 'trim|min_length[1]|max_length[200]|required'),
			array('field' => 'slug', 'label' => 'Slug', 'rules' => 'trim|min_length[1]|max_length[200]|alpha_dash|required'),
			array('field' => 'description', 'label' => 'Description', 'rules' => 'trim|min_length[4]'),
			array('field' => 'version', 'label' => 'Version', 'rules' => 'trim|max_length[20]'),
			array('field' => 'owner', 'label' => 'Owner', 'rules' => 'trim|max_length[100]'),
			array('field' => 'license', 'label' => 'License', 'rules' => 'trim|max_length[500]'),
			array('field' => 'reference', 'label' => 'Reference', 'rules' => 'trim|max_length[500]'),
			array('field' => 'live_link', 'label' => 'Live Link', 'rules' => 'trim|max_length[250]'),
			array('field' => 'source_link', 'label' => 'Source Link', 'rules' => 'trim|max_length[250]'),
			array('field' => 'status', 'label' => 'Status', 'rules' => 'trim|min_length[1]|max_length[20]|alpha|required'),
			array('field' => 'visible', 'label' => 'Visible', 'rules' => 'trim|min_length[1]|max_length[1]|numeric|required'),
			array('field' => 'listed', 'label' => 'Listed', 'rules' => 'trim|min_length[1]|max_length[1]|numeric|required'),
			array('field' => 'date_created', 'label' => 'Date Created', 'rules' => 'trim|max_length[20]'),
			array('field' => 'date_modified', 'label' => 'Date Modified', 'rules' => 'trim|max_length[20]'),
			array('field' => 'tags[]', 'label' => 'Tags', 'rules' => 'trim|min_length[1]|required'),
			array('field' => 'pages[]', 'label' => 'Page', 'rules' => 'trim'),
		);
		$this->data['article_id'] = (int) $article_id;
		foreach ($this->validation_rules AS $rule)
			$this->data['article'][$rule['field']] = NULL;
		//Form validation messages.
		$this->data['status'] = $this->session->flashdata('status');
		//Set the autocomplete tags.
		$this->data['auto_complete'] = $this->articles->get_tags(NULL, FALSE);
		$this->data['categories'] = $this->articles->get_categories();
		if ($this->data['article_id'])
			$this->data['pages'] = $this->articles->get_pages((int) $this->data['article_id']);
		//Set the validation rules.
		$this->form_validation->set_rules($this->validation_rules);
		//If the form is submitted and valid, run this block of code.
		if ($this->form_validation->run()) {
			$input = $this->input->post(NULL, TRUE);
			//Codeigniter's XSS filter does not play well with source code input.
			$input['pages'] = $this->input->post('pages', FALSE);
			$article = array(
				'category_id' => $input['category_id'],
				'user_id' => $this->data['user']['user_id'],
				'title' => $input['title'],
				'slug' => $input['slug'],
				'description' => $input['description'],
				'version' => $input['version'],
				'owner' => $input['owner'],
				'license' => $input['license'],
				'reference' => $input['reference'],
				'live_link' => $input['live_link'],
				'source_link' => $input['source_link'],
				'status' => $input['status'],
				'visible' => $input['visible'],
				'listed' => $input['listed'],
				'date_created' => $input['date_created'] ? $input['date_created'] : date('Y-m-d H:i:s'),
				'date_modified' => $input['date_modified'] ? $input['date_modified'] : date('Y-m-d H:i:s')
			);
			//Save the project.
			if ($this->data['article_id'] = $this->articles->save($this->data['article_id'], $article, $input['pages'], $input['tags'])) {
				//Set some rules for the upload process.
				$this->data['config'][0]['allowed_types'] = 'css';
				$this->data['config'][0]['upload_path'] = './uploads/articles/css/';
				$this->data['config'][1]['allowed_types'] = '*';
				$this->data['config'][1]['upload_path'] = './uploads/articles/js/';
				$this->data['config'][2]['allowed_types'] = 'gif|jpg|png';
				$this->data['config'][2]['upload_path'] = './uploads/articles/img/';
				$this->data['config'][3]['allowed_types'] = '*';
				$this->data['config'][3]['upload_path'] = './uploads/articles/src/';
				$this->data['files'] = array('article_css', 'article_js', 'article_img', 'article_src');
				for ($i = 0; $i < count($this->data['config']); $i++) {
					//Set some additional rules for the upload process.
					$this->data['config'][$i]['max_size']	= '100000000';
					$this->data['config'][$i]['overwrite'] = TRUE;
					$this->data['config'][$i]['remove_spaces'] = TRUE;
					$this->data['config'][$i]['upload_path'] .= "{$this->data['article_id']}/";
					$this->upload->initialize($this->data['config'][$i]);
					//The file upload path.
					$path = $this->data['config'][$i]['upload_path'];
					//If there's no directory try to create one.
					if (!empty($_FILES[$this->data['files'][$i]]['name']) AND (mkdir($path) OR is_dir($path))) {
						//Change the directory's permissions.
						chmod($this->data['config'][$i]['upload_path'], 766);
						//Upload the files.
						$this->data['upload']['errors'] = (!$this->upload->do_upload($this->data['files'][$i]))
							? $this->upload->display_errors()
							: NULL;
					}
				}
				//Redirect to the edit page.
				redirect("admin/article/{$this->data['article_id']}");
			}
		}
		
		if ($this->data['article_id']) {
			if ($this->data['article'] = $this->articles->get_articles((int) $this->data['article_id'], NULL, 0, NULL, NULL, FALSE, FALSE, FALSE)) {
				//Set the page's title.
				set_title($this->data, "Edit {$this->data['article']['title']}", FALSE);
				foreach ($this->data['categories'] AS $category)
					if ($category['category_id'] == $this->data['article']['category_id'])
						$this->data['article']['category_title'] = strtolower($category['title']);
			}
			else
				redirect('admin/article');
			$this->data['article']['tags'] = explode(',', $this->articles->get_tags($this->data['article_id'], FALSE));
		}
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('admin/article', $this->data);
		$this->load->view('core/footer', $this->data['layout']);
	}
}