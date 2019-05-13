<?php
class Users extends CI_Model {

	public function __construct(){
		$this->load->database();
	}

	public function getUsers(){
		$query = $this->db->get('users');
    	return( $query->result_array());
	}
	
	public function addUser(){
		$data = array(
        	'name' => '',
        	'email' => '',
    	);

    	return $this->db->insert('user', $data);
	}
}