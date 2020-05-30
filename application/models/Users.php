<?php
class Users extends MY_Model {

	public function __construct(){
		$this->table = 'users';
	}

	public function checkAuth(&$data){
		//sha password and get user
		if($status = isset($data)){
			//sha password
			$data['password'] = sha1($data['password']);
			//get
			$query = $this->db->get_where($this->table, array('username' => $data['username'], 'password' => $data['password']));
			$data = $query->row_array();
			if(isset($data) && count($data) > 0){
				$status = true;
				if(isset($data['password'])){
					unset($data['password']);
				}
				
				$_SESSION['user'] = $data;
			}else{
				$status = false;
				$data['message'] = "Gegevens komen niet overeen";
			}
		}else{
			$data['message'] = "Vul geldige gegevens in";
		}
		//return status
		return $status;
	}
}