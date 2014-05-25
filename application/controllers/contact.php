<?php

defined('BASEPATH') OR die('404 Not Found');

class Contact extends Public_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		$this->load->library('form_validation');
	}
	//
	public function index()
	{
		//Load the views.
		$this->load->view('core/header', $this->data['layout']);
		$this->load->view('contact/banner-top');
		$this->load->view('contact/form');
		$this->load->view('contact/index');
		$this->load->view('core/modal');
		$this->load->view('core/footer', $this->data['layout']);
	}
	//
	public function feedback()
	{
		//An array of validation rules.
		$validation_rules = array(
			array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|max_length[60]|required'),
			array('field' => 'email', 'label' => 'Email Address', 'rules' => 'trim|max_length[100]|valid_email|required'),
			array('field' => 'message', 'label' => 'Message', 'rules' => 'trim|max_length[500]|required'),
			array('field' => 'ignore', 'label' => 'ignore', 'rules' => '')
		);
		//Set a default value for the email's status. If the status is false the message was not delivered.
		$data['status'] = FALSE;
		//Set the validation rules.
		$this->form_validation->set_rules($validation_rules);
		//If the form is submitted and valid, run this block of code.
		if ($this->form_validation->run()) {
			$to = 'info@shippingsoon.com';
			$subject = COMPANY.' - Feedback';
			$message = $this->input->post('message');
			$headers = 'From: '.$this->input->post('email')."\r\n" .
				'Reply-To: no-reply@shippingsoon.com'."\r\n";
			if (!$this->input->post('ignore'))
				$data['status'] = @mail($to, $subject, $message, $headers);
		}
		//Set the contact modal's header.
		$data['header'] = ($data['status'])
			? 'Message Received'
			: 'Error Sending Message';
		//Set the contact modal's body.
		$data['body'] = ($data['status'])
			? 'Thank you for contacting us. We will get back to you as soon as possible!'
			: '<p>Your message was not delivered</p>'.validation_errors();
		//Set the core modal's response.
		core_modal($data, $data['header'], $data['body'], 1, NULL);
		//Send a response back to the frontend.
		echo json_encode($data);
	}
}