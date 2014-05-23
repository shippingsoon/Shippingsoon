<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//Retrieves an article's image or sets a fallback image.
function set_image($article, $filename = 0, $size = '800x600', $ext = 'jpg')
{
	$image_url = "uploads/articles/img/{$article['article_id']}/$filename.$ext";
	if (file_exists($image_url))
		return base_url($image_url);
	else if ($size)
		return base_url("assets/img/article/$size.$ext");
	else
		return NULL;
}
//Use a DOM parser to return the first N sections of an article's page.
function set_page($article, $offset = 0, $n = 2)
{
	//The truncated content that will be returned. 
	$page = '';
	$html = isset($article['pages'][$offset]) ? $article['pages'][$offset]['content'] : '';
	//Create a new DOMDocument.
	$dom = new DOMDocument;
	//Load the html and use @ to suppress HTML5 warnings.
	@$dom->loadHTML($html);
	//Retrieve the section elements.
	$sections = $dom->getElementsByTagName('section');
	//If we've found any section tags.
	if ($length = $sections->length)
		for ($i = 0; ($i < $n AND $i < $length); $i++)
			$page .= $dom->saveHTML($sections->item($i));
	//Otherwise just return the original content.
	else
		return $html;
	return $page;
}
//Retrieve resources for this article.
function load_resources(&$data, $article_id, $type = 'js', $folder = 'uploads/articles')
{
	$path = "$folder/$type/$article_id";
	if (file_exists($path)) {
		$data[$type.'_files'] = array_diff(scandir($path), array('.', '..'));
		foreach ($data[$type.'_files'] AS &$file)
			$file = base_url("$path/$file");
	}
}