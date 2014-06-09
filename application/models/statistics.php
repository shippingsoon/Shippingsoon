<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Statistics extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//
	public function track($user_id, $user_group_id)
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
			return NULL;
		$insert = array(
			'controller' => $this->router->class,
			'method' => $this->router->method,
			'uri' => $this->uri->uri_string(),
			'user_id' => ($user_id) ? (int) $user_id : NULL,
			'user_group_id' => (int) $user_group_id,
			'user_agent' => preg_replace('/[^a-zA-Z0-9. -]+/i', '', $this->agent->browser()),
			'user_agent_version' => preg_replace('/[^a-zA-Z0-9. -]+/i', '', $this->agent->version()),
			'ip_address' => $this->input->ip_address(),
			'referrer' => (filter_var($this->agent->referrer(), FILTER_VALIDATE_URL)) ? $this->agent->referrer() : NULL,
			'is_mobile' => ($this->agent->is_mobile()),
			'is_robot' => ($this->agent->is_robot()),
			'is_browser' => ($this->agent->is_browser())
		);
		return ($this->db->insert('statistics', $insert))
			? $this->db->insert_id()
			: NULL;
	}
	public function track_usage($statistic_id)
	{
		return $this->db
			->set('time_spent', 'NOW()', FALSE)
			->where('statistic_id', (int) $statistic_id)
			->update('statistics');
	}
}

