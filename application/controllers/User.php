<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct(){
		parent::__construct();
		//load model
		$this->load->model('Users', 'Model');
		$this->load->model("Reservations");
	}
	
	public function getReservations () {
		$data = array();
		
		$this->Reservations->setOrderBy(
			array(
				'field' => 'id',
				'order' => 'DESC',
			),
		);
		$data['data'] = $this->Reservations->get(null);
		if (isset($data['data']) && is_array($data['data']) && count($data['data'])) {
			$status = true;

			foreach($data['data'] as &$row) {
				if (isset($row['persons']) && is_string($row['persons'])) {
					$row['persons'] = json_decode($row['persons'], true);
				}
				$row['date'] = date("Y-m-d", strtotime($row['datetime']));
				$row['time'] = date("H:i:s", strtotime($row['datetime']));
			}
		} else {
			$data['message'] = "fetch.reservations.failed";
		}

		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function insertReservation(){
		$status = true;
		$data['data'] = json_decode(file_get_contents('php://input'), true);
		
		if ($status = isset($data['data']) && is_array($data['data']) && count($data['data'])) {
			if (isset($data['data']['date']) && strlen($data['data']['date']) && isset($data['data']['time']) && strlen($data['data']['time'])) {

				$date = date("Y-m-d", strtotime($data['data']['date']));
				$time = date("H:i:s", strtotime($data['data']['time']));
				$data['data']['datetime'] = date("Y-m-d H:i:s", strtotime($date . $time));
				unset($data['data']['date']);
				unset($data['data']['time']);

				$data['data']['hash'] = sha1(date("Y-m-d H:i:s"));
			
				//insert data
				if (!$status = $this->Reservations->insert($data['data'])) {
					$data['message'] = "insert.data.failed";
				} 
			} 
		} else {
			$data['message'] = "fetch.data.failed";
		}
		
		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function updateReservation($id = null){
		$status = true;
		$data['data'] = json_decode(file_get_contents('php://input'), true);
		
		if ($status = is_numeric($id)) {
			if ($status = isset($data['data']) && is_array($data['data']) && count($data['data'])) {
				if (isset($data['data']['date']) && strlen($data['data']['date']) && isset($data['data']['time']) && strlen($data['data']['time'])) {

					$date = date("Y-m-d", strtotime($data['data']['date']));
					$time = date("H:i:s", strtotime($data['data']['time']));
					$data['data']['datetime'] = date("Y-m-d H:i:s", strtotime($date . $time));
					unset($data['data']['date']);
					unset($data['data']['time']);
					if (isset($data['data']['persons'])) {
						unset($data['data']['persons']);
					}

					//update data
					if (!$status = $this->Reservations->update($id, $data['data'])) {
						$data['message'] = "update.data.failed";
					}
				} 
			} else {
				$data['message'] = "fetch.data.failed";
			}
		} else {
			$data['message'] = "id.invalid.reservation";
		}
		
		
		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function deleteReservation ($id = null) {
		$data = array();
		
		if ($status = is_numeric($id)) {
			$data['data'] = $this->Reservations->delete($id);
		} else {
			$data['message'] = 'id.invalid.reservation';
		}

		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function getReservationTypes () {
		$data = array();
		$reservationTypes = array();

		$this->load->model('Reservation_types');
		$reservationTypes = $this->Reservation_types->get(null);

		if ($data['status'] = isset($reservationTypes) && is_array($reservationTypes) && count($reservationTypes)) {
			foreach ($reservationTypes as $type) {
				$data['data'][$type['id']] = $type;
			}
		}

		//load json view
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function deleteReservationPerson($reservationId = null) {
		$status = true;
		$data['data'] = json_decode(file_get_contents('php://input'), true);
		
		if ($status = is_numeric($reservationId)) {
			if ($status = isset($data['data']) && is_array($data['data']) && count($data['data'])) {
				if (isset($data['data']['person'])) {
					$this->Reservations->setReturnAsMany(false);
					$reservation = $this->Reservations->get($reservationId);
					if (isset($reservation) && is_array($reservation) && isset($reservation['persons']) && is_string($reservation['persons'])) {
						$reservation['persons'] = json_decode($reservation['persons'], true);

						foreach ($reservation['persons'] as $key => $person) {
							if ($person == $data['data']['person']) {
								unset($reservation['persons'][$key]);
							}
						}
						$reservation['taken_places'] = count($reservation['persons']);
						$reservation['persons'] = json_encode($reservation['persons']);
						if (!$status = $this->Reservations->update($reservationId, $reservation)) {
							$data['message'] = "update.data.failed";
						}
					}
				} 
			} else {
				$data['message'] = "fetch.data.failed";
			}
		} else {
			$data['message'] = "id.invalid.reservation";
		}
		
		
		$data['status'] = $status;
		$data['data'] = $reservation;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to ladd price to user and save in database
	*/
	public function addAmount($id){
		$data = json_decode(file_get_contents('php://input'), true);
		
		if($status = isset($data['total'])){
			$userData = array();
			$userData = $this->Model->get($id);
			if($status = (count($userData) > 0)){
				//get current total amount and update
				if(isset($userData['total_amount'])){
					$updateUserData = array(
						'total_amount' => $userData['total_amount'] + $data['total'],
						'amount_update' => date("Y-m-d H:i:s"),
					);
					if($status = $this->Model->update($id, $updateUserData)){
						//insert log
						$this->load->model('Logs');
						$insertLogData = array(
							'user_id' => $id,
							'products' => (isset($data['products']) && is_array($data['products']) ? json_encode($data['products']) : NULL),
							'amount' => $data['total'],
						);
						$status = $this->Logs->insert($insertLogData);
					}
				}
			}
		}
		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to login and get session
	*/
	public function login(){

		$data = json_decode(file_get_contents('php://input'), true);
		//check for username and password
		if(isset($data['username']) && strlen($data['username']) > 0 && isset($data['password']) && strlen($data['password']) > 0){
			$status = $this->Model->checkAuth($data);
		}else{
			$status = false;
			$data['message'] = "Vul een gebruikersnaam en wachtwoord in!";
		}
		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to refresh and get session
	*/
	public function getSession(){
		$status = false;
		$message = "";
		$data = array();
		if($status = (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['id']))){
			$data['data'] = $this->Model->get($_SESSION['user']['id']);
			if(isset($data['data']) && is_array($data['data'])){
				$_SESSION['user'] = $data['data'];
			}else{
				$status = false;
				$message = "no.user";
			}
		}else{
			$message = "no.user.session";
		}

		$data['status'] = $status;
		$data['message'] = $message;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to get users for homepage
	*/
	public function getForHome($id = null){
		$status = false;
		$data = array();
		$this->Model->setReturnAsMany(true);
		$this->Model->setSelectedFields(array("id", "firstname", "lastname", "mail","total_amount"));
		$data['data'] = $this->Model->get($id);
		if (isset($data['data']) && is_array($data['data'])) {
			$status = true;
		}else{
			$status = true;
			$data['data'] = array();
		}

		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to logout
	*/
	public function logout(){
		if(!$status = session_destroy()){
			$data['message'] = "no.session";
		}
		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	/*
	** Function to update user for rights
	*/
	public function updateUser($id){
		$updateData = json_decode(file_get_contents('php://input'), true);
		if(isset($updateData['password'])){
			unset($updateData['password']);
		}
		if($data['status'] = isset($updateData['total_amount'])){
			$data['status'] = $this->Model->update($id, $updateData);
		}
		$data['data'] = $updateData;

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}
