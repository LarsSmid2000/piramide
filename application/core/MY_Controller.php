<?php
class MY_Controller extends CI_Controller {
	//execute construct
	public function __construct(){
      	parent::__construct();
    	// Your own constructor code
    }

    /*
	** Function to get all items
	*/
	public function get(){
		$data = array();
		$data['data'] = $this->Model->get();
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