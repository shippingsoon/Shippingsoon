<?php

defined('BASEPATH') OR die('404 Not Found');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		//Store the URI segments.
		$controller = $this->router->class;
		$method = $this->router->method;
		//If the user doesn't have a session log them in as a guest.
		if (!$this->session->userdata('user_group_id')) {
			$this->session->set_userdata(array(
				'user_group_id' => $this->authentication->get_user_group_id('guest'),
				'user_name' => 'Guest',
				'logged_in' => FALSE
			));
		}
		//An array of data that will be sent to our views.
		$this->data['layout'] = array(
			'title' => 'Shipping Soon - ' . (($controller != 'core') ? "$controller/$method" : SLOGAN),
			'meta_description' => 'Shippingsoon is shipping soon. Come back later',
			'meta_keywords' => 'Shipping Soon, Shipping, Soon, Web Design, Savannah Georgia, PHP, SEO, Content Management System, Programming, MySQL',
			'controller' => $controller,
			'method' => $method,
			'is_mobile' => $this->agent->is_mobile(),
			'ajax_call' => (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'),
			'logged_in' => ($this->session->userdata('logged_in') === TRUE AND $this->authentication->is_member()),
			'statistic_id' => $this->statistics->track((int) $this->session->userdata('user_id'), (int) $this->session->userdata('user_group_id'))
		);
		//The user's session data.
		$this->data['user'] = array(
			'user_id' => (int) $this->session->userdata('user_id'),
			'user_group_id' => (int) $this->session->userdata('user_group_id'),
			'user_name' => $this->session->userdata('user_name'),
			'email' => $this->session->userdata('email'),
		);
	}
}