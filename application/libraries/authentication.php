<?php

defined('BASEPATH') OR die('404 Not Found');

class Authentication
{
	public function __construct()
	{
		$CI =& get_instance();
		$CI->load->model('users');
		//Grab the user's group and ID from a session.
		$this->user = array(
			'user_id' => (int) $CI->session->userdata('user_id'),
			'user_group_id' => (int) $CI->session->userdata('user_group_id'),
		);
		//An associative array of user groups.
		$this->user_groups = $CI->users->get_user_groups();
		//An array of permissions.
		$this->permissions = $CI->users->get_user_permissions((int) $this->user['user_id']);
	}
	//Checks to see if a user belongs to a given user group.
	public function is($user_group, $user_group_id = NULL)
	{
		//If the user group is not passed to this function then we will get it from the user's session.
		$user_group_id = ($user_group_id)
			? $user_group_id
			: $this->user['user_group_id'];
		return (isset($this->user_groups[$user_group]))
			? ($user_group_id == $this->user_groups[$user_group])
			: FALSE;
	}
	//Checks to see if a user can perform a given task.
	public function can($permission)
	{
		return (in_array($permission, $this->permissions));
	}
	//Returns a given user group's ID.
	public function get_user_group_id($user_group)
	{
		return (isset($this->user_groups[$user_group]))
			? $this->user_groups[$user_group]
			: 0;
	}
	//Checks to see if a user belongs to the admin user group.
	public function is_admin($user_group_id = NULL)
	{
		return ($this->is('founder', $user_group_id) OR $this->is('administrator', $user_group_id));
	}
	//Checks to see if a user belongs to the admin or moderator user groups.
	public function is_staff($user_group_id = NULL)
	{
		return ($this->is_admin($user_group_id) OR $this->is('moderator', $user_group_id));
	}
	//Checks to see if a user belongs to the admin, moderator or member user groups.
	public function is_member($user_group_id = NULL)
	{
		return ($this->is_staff($user_group_id) OR $this->is('member', $user_group_id));
	}
	//Checks to see if a user belongs to the guest user group.
	public function is_guest($user_group_id = NULL)
	{
		return $this->is('guest', $user_group_id);
	}
	//Checks to see if the user is banned ;_;
	public function is_banned($user_group_id = NULL)
	{
		return $this->is('banned', $user_group_id);
	}
}