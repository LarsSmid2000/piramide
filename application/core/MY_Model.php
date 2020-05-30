<?php
class MY_Model extends CI_Model {
	var $returnAsMany = true;
	//execute construct
	public function __construct(){
      	parent::__construct();
    	// Your own constructor code
    	
    }
    /*
     ** Function to get 1 array or array in a array
    */
    public function setReturnAsMany($bool){
    	$this->returnAsMany = $bool;
    }
    
	/*
     ** Function to get 1 array or array in a array
    */
    public function setSelectedFields($fields){
    	if(isset($fields) && is_array($fields)){
    		$this->selectedFields = implode(', ', $fields);
    	}
     }

    /*
     ** Function to filter array
    */
    public function setWhere($filter){
    	/*
    	Format:
    	array(
			array(
				'field' => 'sha',
				'data' => $sha,
			),
		);
		*/
		$this->where = $filter;
    }
    /*
     ** Function to set order
    */
    public function setOrderBy($order){
    	/*
    	Format:
    	array(
			'field' => 'name',
			'order' => 'DESC or ASC',
		),
		*/
		$this->orderBy = $order;
    }
    /*
     ** Function to get count
    */
    public function getCount(){
    	//set where if isset
    	if(isset($this->where) && (count($this->where) > 0)){
    		foreach($this->where as $filter){
				$this->db->where($filter['field'], $filter['data']);
	    	}
    	}
    	
		$data = $this->db->count_all_results($this->table);
		
    	return $data;
	}

	/*
     ** Function to get all items
    */
    public function get($id){
    	//set where if isset
    	if(isset($this->where) && (count($this->where) > 0)){
    		foreach($this->where as $filter){
				$this->db->where($filter['field'], $filter['data']);
	    	}
    	}
    	//set selected fields if isset
    	if(isset($this->selectedFields) && strlen($this->selectedFields)){
    		$this->db->select($this->selectedFields);
    	}
    	//set order by if isset
    	if(isset($this->orderBy) && is_array($this->orderBy)){
    		$this->db->order_by($this->orderBy['field'] . ' ' . $this->orderBy['order']);
    	}

    	if($id != null){
			$this->db->where('id', $id);
			$this->returnAsMany = false;
    	}
    	//$this->db->select('username');
		$query = $this->db->get($this->table);
		if(isset($this->returnAsMany) && $this->returnAsMany){
			//return array in a array
			$data = $query->result_array();
		}else{
			//return single array
			$data = $query->row_array();
		}
		
    	return $data;
	}

	/*
     ** Function to get all items
    */
    public function getWith(){
    	//set where if isset
    	if(isset($this->where) && (count($this->where) > 0)){
    		foreach($this->where as $filter){
				$this->db->where($filter['field'], $filter['data']);
	    	}
    	}
    	//set selected fields if isset
    	if(isset($this->selectedFields) && strlen($this->selectedFields)){
    		$this->db->select($this->selectedFields);
    	}
    	//set order by if isset
    	if(isset($this->orderBy) && is_array($this->orderBy)){
    		$this->db->order_by($this->orderBy['field'] . ' ' . $this->orderBy['order']);
    	}

		$query = $this->db->get($this->table);
		if(isset($this->returnAsMany) && $this->returnAsMany){
			//return array in a array
			$data = $query->result_array();
			foreach ($data as &$arr) {
				foreach($arr as $key => $value){
					
					if(strpos($key, '_id') !== false){

						$this->setWhere(
							array(
								array(
									'field' => 'id',
									'data' => $value,
								)
							)
						);
						//set where if isset
				    	if(isset($this->where) && (count($this->where) > 0)){
				    		foreach($this->where as $filter){
								$this->db->where($filter['field'], $filter['data']);
					    	}
				    	}
						$query = $this->db->get(str_replace("_id","s",$key));
						
						$withData = $query->row_array();
						
						if(isset($withData) && is_array($withData)){
							$arr[str_replace("_id","",$key)] = $withData;
						}
					}
				}
				
			}
		}else{
			//return single array
			$data = $query->row_array();
			foreach($data as $key => $value){
				if(strpos($key, '_id') !== false){
					$this->setWhere(
						array(
							array(
								'field' => 'id',
								'data' => $value,
							)
						)
					);
					$query = $this->db->get(str_replace("_id","s",$key));
					$withData = $query->row_array();
					
					if(isset($withData) && is_array($withData)){
						$data[str_replace("_id","",$key)] = $withData;
					}
				}
			}
		}
		
    	return $data;
	}

	/*
     ** Function to insert item
    */
	public function insert(&$data){
		if(isset($data) && is_array($data) && (count($data) > 0)){
			$status = $this->db->insert($this->table, $data);
		}

    	return $status;
	}

	/*
	** Function to update item
	*/
	public function update($id, &$data){
		$this->db->where('id', $id);
		$status = $this->db->update($this->table, $data);

		return $status;
	}

	/*
     ** Function to delete item
    */
	public function delete($id){
		$this->db->where('id', $id);
		//get item
		$query = $this->db->get($this->table);
		$data['data'] = $query->row_array();
		//delete item
		$this->db->where('id', $id);
		$data['status'] = $this->db->delete($this->table);

    	return $data;
	}
}