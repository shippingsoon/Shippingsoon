<?php

defined('BASEPATH') OR die('404 Not Found');

class Ip2nation
{
	// All user groups.
	private $user_groups = array(
		'admin' => 1, 
		'moderator' => 2,
		'member' => 3,
		'guest' => 4,
		'vip' => 5,
		'banned' => 6
	);

	public function is($user_group_title)
	{
		return (isset($this->user_groups[$user_group_title]))
			? ($user_group_id == $this->user_groups[$user_group_title])
			: FALSE;
	}
	
	public function is_admin($user_group_id)
	{
		return ($user_group_id == $this->user_groups['admin']);
	}
	
	public function is_staff($user_group_id)
	{
		return ($user_group_id == $this->user_groups['admin'] OR $user_group_id == $this->user_groups['moderator']);
	}
	
	public function is_member($user_group_id)
	{
		return ($user_group_id == $this->user_groups['member'] OR $user_group_id == $this->user_groups['admin']);
	}
	
	public function is_guest($user_group_id)
	{
		return ($user_group_id == $this->user_groups['guest']);
	}
	
	public function is_banned($user_group_id)
	{
		return ($user_group_id == $this->user_groups['banned']);
	}
	
}