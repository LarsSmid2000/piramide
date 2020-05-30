<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Day_time extends MY_Controller {
	public function __construct(){
		parent::__construct();
		//load model
		$this->load->model('Day_times', 'Model');
		$this->load->model('Reservations');
	}
	
	/*
	** Function to get all day times
	*/
	public function getTimesWithDate($id = null){

		$tempData = array();
		$tempData = $this->Model->get($id);
		$data['status'] = (count($tempData) > 0);
		$weekDays = array(
			1 => "monday",
			2 => "tuesday",
			3 => "wednesday",
			4 => "thursday",
			5 => "friday",
		);

		if ($data['status']) {
			for ($field = 1; $field <= 2; $field++) {
				for ($week = 1; $week <= 2; $week++) {
					foreach ($tempData as $row) {
						if($row['field'] == $field) {

							
							if ($week == 1) {
								$date = date("d-m-Y", strtotime($weekDays[$row['day_id']] .' this week'));
							} 

							if ($week == 2) {
								$date = date("d-m-Y", strtotime($weekDays[$row['day_id']] .' next week'));
							}
							

							if (!isset($data['data'][$date . $field])) {
								$data['data'][$date . $field] = array();
							}

							$dateTimeArr = array(
								'start_date_time' => $date . ' ' . $row['start_time'],
								'start_time' => date("H:i", strtotime($row['start_time'])),
								'end_date_time' => $date . ' ' . $row['end_time'],
								'end_time' => date("H:i", strtotime($row['end_time'])),
							);

							//get reservations to check
							$reservations = array();
							$this->Reservations->setReturnAsMany(false);

							$this->Reservations->setWhere(
								array(
									array(
										'field' => 'datetime',
										'data' => date("Y-m-d H:i:s", strtotime($dateTimeArr['start_date_time'])),
									),
									array(
										'field' => 'field',
										'data' => $field,
									),
								)
							);

							$reservations = $this->Reservations->get(null);

							if (isset($reservations) && is_array($reservations) && count($reservations)) {
								$dateTimeArr['reservation'] = $reservations; 
							}
							//push date with time into day array
							array_push($data['data'][$date . $field], $dateTimeArr);
						}
					}
				}
			}
		}

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}
