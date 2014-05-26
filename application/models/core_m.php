<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Core extends CI_Model 
{
	public function __construct()
	{
		//Load the parent constructor.
		parent::__construct();
		$this->load->database();
	}
	
	
}

