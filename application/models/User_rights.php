<?php
class User_rights extends MY_Model {

	public function __construct(){
		//load model
		$this->table = 'user_rights';
	}
}