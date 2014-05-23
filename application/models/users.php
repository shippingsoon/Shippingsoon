<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Adds a user.
	public function add_user($input, $permissions = array('read_projects'))
	{
		//Encrypt the user's password.
		$salt = generateBlowfishSalt();
		$password = blowfishCrypt($input['password'], $salt);
		//Make sure the user name or email address is available.
		if ($this->exists($input['user_name'], 'user_name') OR $this->exists($input['email'], 'email'))
			return NULL;
		//Build the insert array.
		$insert = array(
			'user_name' => $input['user_name'],
			'user_group_id' => $this->authentication->get_user_group_id('member'),
			'email' => $input['email'],
			'password' => $password,
			'salt' => $salt,
			'first_ip_address' => $this->input->ip_address(),
			'last_ip_address' => $this->input->ip_address(),
			'last_login' => time()
		);
		//Attempt to create a new user.
		if ($this->db->insert('users', $insert)) {
			$user_id = $this->db->insert_id();
			$this->db->delete('user_permissions', array('user_id' => $user_id));
			foreach ($permissions AS $permission)
				$this->db->insert('user_permissions', array('user_id' => $user_id, 'title' => $permission));
			return $user_id;
		}
		return NULL;
	}
	//Edit a user.
	public function edit_user($user_id, $input, $permissions = array('read_projects'))
	{
		//Encrypt the user's password.
		$salt = generateBlowfishSalt();
        $password = blowfishCrypt($input['password'], $salt);
		//Build the update array.
		$update = array(
			'user_name' => $input['user_name'],
			'user_group_id' => $input['user_group_id'],
			'email' => $input['email'],
			'password' => $password,
			'salt' => $salt,
			'last_ip_address' => $this->input->ip_address(),
			'last_login' => time()
		);
		if ($result = $this->db->where('user_id', $user_id)->update('users', $update)) {
			$this->db->delete('user_permissions', array('user_id' => $user_id));
			foreach ($permissions AS $permission)
				$this->db->insert('user_permissions', array('user_id' => $user_id, 'title' => $permission));
		}
		return $result;
	}
	//Retrieves a user's information.
	public function get_authentic_user($email, $password)
	{
		$user = $this->get_by($email, 'email');
		$password = blowfishCrypt($password, $user['salt']);
		//Build the where array.
		$where = array(
			'email' => $email,
			'password' => $password
		);
		$query = $this->db
			->get_where('users', $where, 1);
		//Log the status of this login attempt.
		$this->add_login_attempt($email, ($query->num_rows() > 0) ? 1 : 0);
		//If this login was successful, clear the user's failed login attempts.
		if ($query->num_rows() > 0)
			$this->clear_login_attempts($email);
		return $query->row_array();
	}
	//Retrieves a user's profile by type.
	public function get_by($input, $type = 'user_id')
	{
		return $this->db
			->get_where('users', array($type => $input))
			->row_array();
	}
	//Checks to see if an entry exist in the 'users' table.
	public function exists($value, $type = 'user_name')
	{
		$query = $this->db->get_where('users', array($type => $value), 1);
		return ($query->num_rows() > 0);
	}
	//Retrieves all user groups and organizes them into an associative array.
	public function get_user_groups()
	{
		//An associative array of user groups.
		$user_groups = array();
		$results = $this->db
			->get_where('user_groups')
			->result_array();
		foreach ($results AS $result)
			$user_groups[$result['title']] = $result['user_group_id'];
		return $user_groups;
	}
	//Retrieves a given user's permissions.
	public function get_user_permissions($user_id)
	{
		//An array of permissions.
		$permissions = array();
		$results = $this->db
			->select('title')
			->from('user_permissions')
			->where('user_id', (int) $user_id)
			->get()
			->result_array();
		foreach ($results AS $result)
			$permissions[] = $result['title'];
		return $permissions;
	}
	//Gets a user's login attempts.
	public function get_login_attempts($email, $successful = 0)
	{
		$ip_address = $this->input->ip_address();
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		$where = "(`ip_address` =  '$ip_address' OR `email` =  '$email') AND `successful` =  $successful";
		return $this->db
			->select('count(*) AS attempts')
			->from('login_attempts')
			->where($where)
			->get()
			->row()
			->attempts;
	}
	//Logs a login attempt.
	public function add_login_attempt($email, $successful = 0)
	{
		//Build the insert array.
		$insert = array(
			'email' => $email,
			'ip_address' => $this->input->ip_address(),
			'successful' => $successful
		);
		return $this->db->insert('login_attempts', $insert);
	}
	//Clear failed login attempts.
	public function clear_login_attempts($email)
	{
		$ip_address = $this->input->ip_address();
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		$where = "(`ip_address` =  '$ip_address' OR `email` =  '$email') AND `successful` =  0";
		return $this->db->delete('login_attempts', $where);
	}
}

