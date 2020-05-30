<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Day extends MY_Controller {
	public function __construct(){
		parent::__construct();
		//load model
		$this->load->model('Days', 'Model');
	}

	public function get($id = null){
		$data = array();
		$days = $this->Model->get($id);
		if ($data['status'] = (count($days) > 0)) {
			$weekDays = array(
				1 => "monday",
				2 => "tuesday",
				3 => "wednesday",
				4 => "thursday",
				5 => "friday",
			);
			//loop this and next week
			for ($week = 1; $week <= 2; $week++) {
				foreach($days as $row) {
					if ($week == 1) {
						$row['date'] = date("d-m-Y", strtotime($weekDays[$row['id']] . 'this week'));
						$row['week'] = 1;
					}
					if ($week == 2) {
						$row['date'] = date("d-m-Y", strtotime($weekDays[$row['id']] . 'next week'));
						$row['week'] = 2;
					}

					$data['data'][] = $row;
				}
			}
			
		}
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
}
