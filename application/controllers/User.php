<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//load model
		$this->load->model('Users');
	}

	public function getUsers(){
		 $data['users'] = $this->Users->getUsers();

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}
