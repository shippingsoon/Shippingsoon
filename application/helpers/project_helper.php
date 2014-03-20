<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function project_image($project)
{
    if (file_exists("uploads/project/img/{$project['project_id']}/project_image.jpg"))
		return base_url("uploads/project/img/{$project['project_id']}/project_image.jpg");
	else if (file_exists("uploads/project/img/{$project['project_id']}/project_image.png"))
		return base_url("uploads/project/img/{$project['project_id']}/project_image.png");
	else
		return base_url('assets/img/layout/placeholder.gif');
}