<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function core_modal(&$data, $header, $body = NULL, $show_modal = TRUE, $redirect_url = NULL)
{
	//Set the modal's header.
	$data['header'] = $header;
	//Set the modal's body.
	$data['body'] = ($body) ? $body : validation_errors();
	//If we will show the modal.
	$data['show_modal'] = $show_modal;
	//The place we will redirect the user to.
	$data['redirect_url'] = $redirect_url;
}