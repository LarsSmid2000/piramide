<?php
class MY_Controller extends CI_Controller {
	//execute construct
	public function __construct(){
      	parent::__construct();
    	// Your own constructor code
    	$this->checkAuth();
    }
    /*
	** Function to check authentication
	*/
    public function checkAuth(){
    	//print_r($_SESSION);
    	$message = "";
    	$status = false;
    	$this->load->model("User_rights");
    	$this->load->model("Open_rights");
    	$this->load->model("Allowed_ips");

    	//check if ip is allowed
    	if($status = isset($_SERVER['REMOTE_ADDR'])){
    		$this->Allowed_ips->setReturnAsMany(false);
			$this->Allowed_ips->setWhere(
				array(
					array(
						'field' => 'ip',
						'data' => $_SERVER['REMOTE_ADDR'],
					),
				)
			);
			$ipData = $this->Allowed_ips->get(null);

			//check for allow all
			if($status = (!isset($ipData))){
				$this->Allowed_ips->setReturnAsMany(false);
				$this->Allowed_ips->setWhere(
					array(
						array(
							'field' => 'ip',
							'data' => '*',
						),
					)
				);
				$ipData = $this->Allowed_ips->get(null);
			}

			//check for data from ip
			if($status = (isset($ipData) && is_array($ipData))){
				//check for params
		    	if($status = isset($_SERVER['PATH_INFO'])){
		    		/*
						explode params
						[1] = controller
						[2] = function
		    		*/
		    		$params = explode('/', $_SERVER['PATH_INFO']);
		    		if($status = (isset($params) && is_array($params) && isset($params[1]) && isset($params[1]))){
						//check for open rights
		    			$openRightData = array();
		    			$this->Open_rights->setReturnAsMany(false);
		    			$this->Open_rights->setWhere(
		    				array(
								array(
		    						'field' => 'controller',
									'data' => $params[1],
								),
								array(
		    						'field' => 'function',
									'data' => $params[2],
								),
		    				)
		    			);
		    			$openRightData = $this->Open_rights->get(null);
		    			if(isset($openRightData) && is_array($openRightData)){
		    				//function is in open rights
		    			}else{
		    				//check for session
				    		if($status = (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['user_role_id']))){
				    			//check for user role
				    			$this->User_rights->setReturnAsMany(false);
				    			$this->User_rights->setWhere(
				    				array(
				    					array(
				    						'field' => 'user_role_id',
											'data' => $_SESSION['user']['user_role_id'],
										),
										array(
				    						'field' => 'controller',
											'data' => $params[1],
										),
										array(
				    						'field' => 'function',
											'data' => $params[2],
										),
				    				)
				    			);
				    			$data = $this->User_rights->get(null);
				    			if(isset($data) && is_array($data)){
				    				//user rights are ok
				    			}else{
				    				$status = false;
				    				$message = "auth.failed";
				    			}
				    		}else{
				    			$message = "no.user.session";
				    		}
		    			}
		    		}else{
		    			$message = "no.controller.or.funciton";
		    		}
		    	}else{
		    		$message = "no.path.info";
		    	}
		    }else{
		    	$message = "not.allowed.ip";
			}
    	}
    	

    	if(!$status){
    		$data = array(
    			"status" => false,
    			"data" => array(),
    			"message" => $message,
    		);
    		header('Content-type: application/json');
			echo json_encode($data);
    		exit;
    	}
    }

    /*
	** Function to get all items
	*/
	public function get($id = null){

		$data = array();
		$data['data'] = $this->Model->get($id);
		$data['status'] = (count($data['data']) > 0);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to get count from all items
	*/
	public function getCount(){
		$data = array();
		$data['data'] = $this->Model->getCount();
		$data['status'] = (strlen($data['data']) > 0);
		
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to get all items
	*/
	public function getWith(){
		$data = array();
		$this->Model->setReturnAsMany(true);
		$data['data'] = $this->Model->getWith();
		$data['status'] = (count($data['data']) > 0);
		
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function insert new item
	*/
	public function insert(){
		$insertData = json_decode(file_get_contents('php://input'), true);
		
		$data['status'] = $this->Model->insert($insertData);
		$data['data'] = $insertData;

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function update item
	*/
	public function update($id){
		$updateData = json_decode(file_get_contents('php://input'), true);
		
		$data['status'] = $this->Model->update($id, $updateData);
		$data['data'] = $updateData;

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to delete item
	*/
	public function delete($id){
		$data = array();
		
		$data = $this->Model->delete($id);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}