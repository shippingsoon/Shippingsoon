<?php

defined('BASEPATH') OR die('404 Not Found');

class Admin extends Admin_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		$this->load->library(array('form_validation', 'upload'));
		//Common form validation rules.
		$this->common_rules = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'trim|min_length[1]|max_length[200]|required'
			),
            array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim|min_length[4]'
			),
            array(
				'field' => 'tags[]',
				'label' => 'Tags',
				'rules' => 'trim|min_length[1]|required'
			),
			array(
				'field' => 'license',
				'label' => 'License',
				'rules' => 'trim|max_length[500]'
			),
            array(
				'field' => 'visible',
				'label' => 'Visible',
				'rules' => 'trim|min_length[1]|max_length[1]|numeric|required'
			),
			array(
				'field' => 'listed',
				'label' => 'Listed',
				'rules' => 'trim|min_length[1]|max_length[1]|numeric|required'
			),
            array(
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'trim|min_length[1]|max_length[20]|alpha|required'
			),
			array(
				'field' => 'date_created',
				'label' => 'Date Created',
				'rules' => 'trim|max_length[20]'
			),
            array(
				'field' => 'date_modified',
				'label' => 'Date Modified',
				'rules' => 'trim|max_length[20]'
			)
		);
	}
	//Admin control panel.
	public function index()
	{
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('admin/index', $this->data);
		$this->load->view('core/footer');
	}
	//Add or edit projects.
	public function project($project_id = NULL)
	{
		//File validation.
		$this->data['config'][0]['allowed_types'] = '*';
		$this->data['config'][0]['upload_path'] = './uploads/project/src/';
		$this->data['config'][1]['allowed_types'] = 'gif|jpg|png';
		$this->data['config'][1]['upload_path'] = './uploads/project/img/';
		$this->data['files'] = array(
			'user_file',
			'user_image'
		);
		//Validation rules.
		$this->project_rules = array_merge($this->common_rules, array(
			array(
				'field' => 'owner',
				'label' => 'Owner',
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'line_count',
				'label' => 'Line Count',
				'rules' => 'trim|max_length[10]|numeric'
			),
			array(
				'field' => 'word_count',
				'label' => 'Word Count',
				'rules' => 'trim|max_length[10]|numeric'
			),
			array(
				'field' => 'version',
				'label' => 'Version',
				'rules' => 'trim|max_length[20]'
			),
			array(
				'field' => 'reference',
				'label' => 'Reference',
				'rules' => 'trim|min_length[2]|max_length[500]'
			),
			array(
				'field' => 'link',
				'label' => 'Link',
				'rules' => 'trim|min_length[5]|max_length[250]'
			),
			array(
				'field' => 'indention_style',
				'label' => 'Indention Style',
				'rules' => 'trim|min_length[2]|max_length[100]'
			)
		));
		//Call our DRY (Don't Repeat Yourself) function.
		$this->_handle_form_submission('project', $this->project_rules, $project_id);
	}

	public function article($article_id = NULL)
	{
        //File validation.
		$this->data['config'][0]['allowed_types'] = 'css';
		$this->data['config'][0]['upload_path'] = './uploads/article/css/';
		$this->data['config'][1]['allowed_types'] = '*';
		$this->data['config'][1]['upload_path'] = './uploads/article/js/';
		$this->data['config'][2]['allowed_types'] = 'gif|jpg|png';
		$this->data['config'][2]['upload_path'] = './uploads/article/img/';
		$this->data['files'] = array(
			'user_css',
			'user_js',
			'user_image'
		);
		//Validation rules.
		$this->article_rules = array_merge($this->common_rules, array(
			array(
				'field' => 'category_id',
				'label' => 'Category',
				'rules' => 'trim|min_length[1]|max_length[1]|numeric|required'
			),
			array(
				'field' => 'pages[]',
				'label' => 'Page',
				'rules' => 'trim'
			)
		));
		//Handle the form submission.
		$this->_handle_form_submission('article', $this->article_rules, $article_id);
	}
	//Handles form validation.
	private function _handle_form_submission($type, $validation_rules, $id)
	{
		$this->load->model($type.'s', 'model');
		$this->data['project_id'] = $id;
		foreach ($validation_rules AS $rule)
			$this->data['project'][$rule['field']] = NULL;
        //Form validation messages.
		$this->data['status'] = $this->session->flashdata('status');
		//Set the autocomplete tags.
        $this->data['auto_complete'] = $this->model->get_tags(NULL, FALSE);
		if ($type == 'article') {
			$this->data['categories'] = $this->model->get_categories();
			if ($this->data['project_id'])
				$this->data['pages'] = $this->model->get_pages((int) $this->data['project_id']);
		}
		//Set the validation rules.
		$this->form_validation->set_rules($validation_rules);
		//If the form is submitted and valid, run this block of code.
		if ($this->form_validation->run()) {
			$input = $this->input->post(NULL, TRUE);
			error_log(print_r($input, TRUE));
			$this->data['project_id'] = (!$this->data['project_id'])
				? $this->model->save($input)
				: $this->model->edit((int) $this->data['project_id'], $input);
            if ($this->data['project_id']) {
                for ($i = 0; $i < count($this->data['config']); $i++) {
                    $this->data['config'][$i]['max_size']	= '100000000';
                    $this->data['config'][$i]['overwrite'] = TRUE;
                    $this->data['config'][$i]['remove_spaces'] = TRUE;
					$this->data['config'][$i]['upload_path'] .= "{$this->data['project_id']}/";
                    $this->upload->initialize($this->data['config'][$i]);
					$path = $this->data['config'][$i]['upload_path'];
                    if (!empty($_FILES[$this->data['files'][$i]]['name']) AND (mkdir($path) OR is_dir($path))) {
						chmod($this->data['config'][$i]['upload_path'], 766);
                        $this->data['upload']['errors'] = (!$this->upload->do_upload($this->data['files'][$i]))
                            ? $this->upload->display_errors()
                            : NULL;
                        $this->data['upload']['data'] = (!$this->data['upload']['errors'])
                            ? $this->upload->data()
                            : NULL;
                    }
                }
				$this->model->has_file($this->data['project_id'], is_dir($this->data['config'][0]['upload_path']));
                //Redirect to the edit page.
                redirect("admin/$type/{$this->data['project_id']}");
            }
		}
        //Load the views.
		$this->load->view('core/header', $this->data['layout']);
        if ($this->data['project_id']) {
			if ($this->data['project'] = $this->model->get_project((int) $this->data['project_id'], FALSE)) {
				foreach ($this->data['categories'] AS $category)
					if ($category['category_id'] == $this->data['project']['category_id'])
						$this->data['project']['category_title'] = strtolower($category['title']);
			}
			else
				redirect("admin/$type");
			$this->data['project']['tags'] = explode(',', $this->model->get_tags($this->data['project_id'], FALSE));
        }
		//Load the views.
		$this->load->view("admin/$type", $this->data);
		$this->load->view('core/footer');
	}
}