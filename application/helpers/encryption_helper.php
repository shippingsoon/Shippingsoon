<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function generateBlowfishSalt()
{
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ./';
	$count = strlen($chars);
	$salt = '';
	for ($i = 0; $i < 22; ++$i)
		$salt .= $chars[mt_rand(0, $count - 1)];
	return str_shuffle($salt);
}

function blowfishCrypt($password, $salt, $cost = 11)
{
	return crypt($password, '$2a$'.$cost.'$'.$salt);
}