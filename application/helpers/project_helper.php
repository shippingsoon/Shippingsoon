<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function project_image($article)
{
    if (file_exists("uploads/article/img/{$article['article_id']}/article_image.jpg"))
		return base_url("uploads/article/img/{$article['article_id']}/article_image.jpg");
	else if (file_exists("uploads/article/img/{$article['article_id']}/article_image.png"))
		return base_url("uploads/article/img/{$article['article_id']}/article_image.png");
	else
		return base_url('assets/img/layout/placeholder.gif');
}