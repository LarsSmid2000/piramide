<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logged_in_user extends MY_Controller {
	public function __construct(){
		parent::__construct();
		//load model
		$this->load->model('Logged_in_users', 'Model');
	}
	
}
