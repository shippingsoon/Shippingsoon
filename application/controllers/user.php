<?php

defined('BASEPATH') OR die('404 Not Found');

class User extends Public_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper('encryption');
	}
	//Logs the user in.
	public function login()
	{
		//An array of validation rules.
		$validation_rules = array(
			array(
				'field' => 'email',
				'label' => 'Email Address',
				'rules' => 'trim|max_length[100]|valid_email|required'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|max_length[100]|required'
			)
		);
		$form_validation_callback = function(&$data) {
			$email = $this->input->post('email', TRUE);
			$password = $this->input->post('password', TRUE);
			//If the user has too much failed login attempts.
			if ($this->users->get_login_attempts($email) > 3)
				$data['validation_errors'] = 'Too much failed login attempts.';
			//Check to see if the email address exists.
			else if (!$this->users->exists($email, 'email'))
				$data['validation_errors'] = "The email entered <b>$email</b> was not found in our records.";
			//If the user is valid use their information to start a session.
			else if ($user = $this->_authenticate($email, $password)) {
				error_log('made it');
				//Make sure this user isn't banned.
				if ($this->authentication->is_member($user['user_group_id'])) {
					$data['success'] = 1;
					if (!$this->data['layout']['ajax_call'])
						redirect($data['redirect_url']);
				}
				else
					$this->session->sess_destroy();
			}
			//If the user's password is incorrect.
			else
				$data['validation_errors'] = 'Incorrect password.';
		};
		$this->_handle_form_validation('Login', $validation_rules, $form_validation_callback, implode('/', func_get_args()));
	}
	//Logs out the user.
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('user/login');
	}
	//Registers a new user.
	public function register()
	{
		//Only allow developers to register.
		if (ENVIRONMENT != 'development') {
			redirect();
			die();
		}
		//An array of validation rules.
		$validation_rules = array(
			array(
				'field' => 'user_name',
				'label' => 'User Name',
				'rules' => 'trim|min_length[4]|max_length[20]|alpha|required'
			),
			array(
				'field' => 'email',
				'label' => 'Email Address',
				'rules' => 'trim|max_length[150]|valid_email|required'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|min_length[6]|required'
			),
			array(
				'field' => 'ignore',
				'label' => '',
				'rules' => 'trim|max_length[1]|alpha|required'
			)
		);
		$form_validation_callback = function(&$data) {
			$user_name = $this->input->post('user_name', TRUE);
			$email = $this->input->post('email', TRUE);
			$password = $this->input->post('password', TRUE);
			//Check to see if the user name is already taken.
			if ($this->users->exists($user_name, 'user_name'))
				$data['validation_errors'] = "The user name entered <b>$user_name</b> is already in use.";
			//Check to see if the email address is already taken.
			else if ($this->users->exists($email, 'email'))
				$data['validation_errors'] = "The email entered <b>$email</b> is already in use.";
			//Register the user and log them in.
			if ($this->users->add_user($this->input->post())) {
				$this->_authenticate($email, $password);
				$data['success'] = 1;
			}
		};
		$this->_handle_form_validation('Registration', $validation_rules, $form_validation_callback);
	}
	private function _handle_form_validation($type, $validation_rules, $callback, $redirect_url = '')
	{
		//Determines if we will display a terminal on the login page.
		$data['no_terminal'] = $this->input->get('no_terminal');
		//The URL the user will be redirected to on a successful login attempt.
		$data['redirect_url'] = $redirect_url;
		//If the user is already logged in, redirect them.
		if ($this->data['layout']['logged_in'])
			redirect($data['redirect_url']);
		//Set the validation rules.
		$this->form_validation->set_rules($validation_rules);
		//Validation errors.
		$data['validation_errors'] = '';
		$data['success'] = 0;
		//If the form is submitted and valid, run this block of code.
		if ($this->form_validation->run())
			$callback($data);
		if (!$this->data['layout']['ajax_call']) {
			//Load the views.
			$this->load->view('core/header', $this->data['layout']);
			if ($type == 'Login') {
				$this->load->view('user/login', $data);
				if ($data['no_terminal'] != 1)
					$this->load->view('user/terminal', $data);
			}
			else
				$this->load->view('user/register');
			$this->load->view('core/modal');
			$this->load->view('core/footer');
		}
		else {
			//Set the core modal's response.
			core_modal($data, "$type error", $data['validation_errors'], !$data['success'], $data['redirect_url']);
			//Send a response back to the frontend.
			echo json_encode($data);
		}
	}
	private function _authenticate($email, $password)
	{
		if ($user = $this->users->get_authentic_user($email, $password)) {
			//Start a session.
			$this->session->set_userdata(array(
				'user_id' => $user['user_id'],
				'user_group_id' => $user['user_group_id'],
				'user_name' => $user['user_name'],
				'email' => $user['email'],
				'logged_in' => TRUE
			));
		}
		return $user;
	}
}