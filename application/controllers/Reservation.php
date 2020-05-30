<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends MY_Controller {
	public function __construct(){
		parent::__construct();
		//load model
		$this->load->model('Reservations', 'Model');
		
	}

	public function afmelden($hash = null, $personId = null) {
		$status = true;
		$data = array();

		if ($status = strlen($hash)) {
			$this->Model->setWhere(
				array(
					array(
						'field' => 'hash',
						'data' => $hash,
					)
				)
			);
			$this->Model->setReturnAsMany(false);
			$data = $this->Model->get(null);

			if ($status = isset($data) && is_array($data) && count($data)) {
				if ($status = isset($data['datetime']) && strlen($data['datetime'])) {

					//check for hour before
					if ($status = date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($data['datetime'])))) {

					
						if ($data['reservation_type_id'] == 1) {
							//reservation
							$updateData = array(
								"name" => "",
								"email" => "",
								"persons" => "",
								"reserved" => 0,					
							);

							if ($status = $this->Model->update($data['id'], $updateData)) {
								//send succes mail
$message = "
Beste " .  $data['name'] . ",

Je hebt de reservering geannuleerd voor " . date("d-m-Y H:i", strtotime($data['datetime'])) . " op veld " . $data['field'] .  ".

Mochten er nog vragen zijn kun je mailen naar beach@clubhuisvollido.nl.

Met vriendelijke groet,
De Barcommissie
";

								//send mail
								mail($data['email'], "Bevestiging van annuleren", $message);
							} else {
								$data['message'] = "update.reservation.failed";
							}
						} else {
							//training
							if ($status = isset($personId) && is_numeric($personId)) {
								if ($status = isset($data['persons']) && strlen($data['persons'])) {
									$data['persons'] = json_decode($data['persons'], true);

									$newPersons = array();
									foreach($data['persons'] as $person) {
										if (isset($person['id']) && $person['id'] != $personId) {
											$newPersons[] = $person;
										} else {
											$deletedPerson = $person;
										}
									}

									if ($status = isset($deletedPerson) && is_array($deletedPerson)) {
										$updateData = array(
											"persons" => json_encode($newPersons),
											"taken_places" => (intval(count($data['persons'])) - 1),
										);

										if ($status = $this->Model->update($data['id'], $updateData)) {
											//send succes mail
$message = "
Beste " .  $deletedPerson['name'] . ",

Je hebt de trainging geannuleerd voor " . date("d-m-Y H:i", strtotime($data['datetime'])) . " op veld " . $data['field'] .  ".

Mochten er nog vragen zijn kun je mailen naar beach@clubhuisvollido.nl.

Met vriendelijke groet,
De Barcommissie
";

											//send mail
											mail($deletedPerson['email'], "Bevestiging van annuleren", $message);
										} else {
											$data['message'] = "update.reservation.failed";
										}
									} else {
										$data['message'] = "person.dont.exists";
									}
									
								} else {
									$data['message'] = "no.persons.failed";
								}
							} else {
								$data['message'] = "no.personid.failed";
							}
						}
					} else {
						$data['message'] = "less.then.hour";
					}
				} else {
					$data['message'] = "no.datetime.found";
				}
			} else {
				$data['message'] = "no.reservation.found";
			}
		} else {
			$data['message'] = "no.hash.failed";
		}

		$data['status'] = $status;
		$this->load->view('annulering', $data);
	}


	public function reserveDateTime($id = nul) {
		$status = true;
		$data = json_decode(file_get_contents('php://input'), true);

		if ($status = is_numeric($id)) {
			if ($status = isset($data['name']) && strlen($data['name'])) {
				if ($status = isset($data['email']) && strlen($data['email'])) {
					if ($status = isset($data['persons']) && is_array($data['persons'])) {
						//check for existing 
						$reservation = array();
						$this->Model->setReturnAsMany(false);
						$reservation = $this->Model->get($id);

						if ($status = isset($reservation) && is_array($reservation) && isset($reservation['reserved']) && $reservation['reserved'] == 0) {
							//fill reservation
							$newArrPersons = array();
							foreach ($data['persons'] as $key => $person) {
								$newArrPersons[] = array(
									'id' => $key,
									'name' => $person,
								);
							}

							$updateData = array(
								"name" => $data['name'],
								"email" => $data['email'],
								"persons" => json_encode($newArrPersons),
								"reserved" => 1,							);

							if ($status = $this->Model->update($id, $updateData)) {
								//send succes mail
$message = "
Beste " .  $data['name'] . ",
Bedankt voor je reservering van het beachveld.

Hierbij de bevestiging! 
Je hebt gereserveerd voor " . date("d-m-Y H:i", strtotime($reservation['datetime'])) . " op veld " . $reservation['field'] .  ".

Als je wilt afmelden voor deze reservering kan je op de afmeldlink hieronder klikken:
https://beach.clubhuisvollido.nl/reservation/afmelden/". $reservation['hash'] . "

Mochten er nog vragen zijn kun je mailen naar beach@clubhuisvollido.nl.

Met vriendelijke groet,
De Barcommissie
";

								//send mail
								mail($data['email'], "Bevestiging van reserveren", $message);
							} else {
								$data['message'] = "update.reservation.failed";
							}
						} else {
							$data['message'] = "already.reserved.failed";
						}

					} else {
						$data['message'] = "no.persons.failed";
					}
				} else {
					$data['message'] = "no.email.failed";
				}
			} else {
				$data['message'] = "no.name.failed";
			}
		} else {
			$data['message'] = "no.id.failed";
		}

		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function signUpForTraining($id = null) {
		$status = true;
		$data = json_decode(file_get_contents('php://input'), true);
		
		if ($status = is_numeric($id)) {
			if($status = isset($data['name']) && isset($data['email'])){
				//get reservation
				$reservation = array();
				$reservation = $this->Model->get($id);

				//check for reservation
				if ($status = isset($reservation) && is_array($reservation) && count($reservation)) {
					//check for max persons
					if ($status = isset($reservation['taken_places']) && is_numeric($reservation['taken_places']) && isset($reservation['max_places']) && is_numeric($reservation['max_places']) && $reservation['max_places'] != $reservation['taken_places'] ) {
						if ($status = (isset($reservation['persons']) && is_string($reservation['persons'])) || !isset($reservation['persons'])) {
							if (!isset($reservation['persons'])) {
								$reservation['persons'] = array();
							} else {
								//decode persons
								$reservation['persons'] = json_decode($reservation['persons'], true);
							}
							$personAlreadyExists = false;
							foreach ($reservation['persons'] as $person) {
								if (isset($person['name']) && isset($person['email'])) {
									if ($person['name'] == $data['name'] && $person['email'] == $data['email']) {
										$personAlreadyExists = true;
									}
								}
							}
							if ($status = !$personAlreadyExists) {
								$pushArr = array("id" => date("YmdHis"), "name" => $data['name'], "email" => $data['email']);
								array_push($reservation['persons'], $pushArr );
						
								$updateReservation = array(
									"persons" => json_encode($reservation['persons']),
									"taken_places" => $reservation['taken_places'] + 1,
								);

								$updateReservationResult = $this->Model->update($id, $updateReservation);
								
								
								if ($status = $updateReservationResult) {
$message = "
Beste " .  $data['name'] . ",
Bedankt voor je aanmelding voor training " . $reservation['name'] . ".

Hierbij de bevestiging! 

Je bent aangemeld voor een training op " . date("d-m-Y H:i", strtotime($reservation['datetime'])) . " op veld " . $reservation['field'] .  ".

Als je wilt afmelden voor deze training kan je op de afmeldlink hieronder klikken:
https://beach.clubhuisvollido.nl/reservation/afmelden/". $reservation['hash'] . "/" . $pushArr['id'] . "

Mochten er nog vragen zijn kun je mailen naar beach@clubhuisvollido.nl.

Met vriendelijke groet,
De Barcommissie
";
									mail($data['email'], "Bevestiging van aanmelden", $message);
								} else {
									$data['message'] = "insert.person.failed";
								}
							} else {
								$data['message'] = "already.signedup.person";
							}
						} else {
							$data['message'] = "invalid.person.reservation";
						}
					} else {
						$data['message'] = "reservation.is.full";
					}
				} else {
					$data['message'] = "no.reservation.failed";
				}
			} else {
				$data['message'] = "missing.user.values";
			}	
		} else {
			$data['message'] = "missing.reservation.id";
		}
		
		$data['status'] = $status;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
}
