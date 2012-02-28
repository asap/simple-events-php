<?php

require_once dirname(dirname(__FILE__)) . '/includes/constants.php';

class EventList {
	
	function __construct() {
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or 
					  die('There was a problem connecting to the database.');
	}
	
	function get_events($start_date = null, $end_date = null){
		$mysql = New Mysql();
		$temp_events = null;

		if(is_null($start_date) && is_null($end_date))
			$query = "SELECT * FROM `events`";
		else
			$query = "SELECT * FROM `events` WHERE DATE BETWEEN '$start_date' AND '$end_date'";
				
		if( $result = $this->conn->query($query) ) {
			while( $row = $result->fetch_object() ){
				$temp_events[] = $row;
			}
			return $temp_events;
		}
		
	}
	
	function get_event($event_id){
		$mysql = New Mysql();
		
		$query = "SELECT * from `events`.`events` WHERE `events`.id = $event_id;";
		
		if( $result = $this->conn->query($query) )
			$obj = $result->fetch_object() or die(mysql_error());
			return $obj;
	}

	function create_event($event){
		$mysql = New Mysql();

		$query = "INSERT INTO `events`.`events` (`id`, `venue`, `address`, `summary`, `date`, `link`, `phone`) VALUES (NULL, '" . $event->venue . "', '" . $event->address . "', '" . $event->summary . "',  '" . $event->date . "', '" . $event->link . "', '" . $event->phone . "');";
		
		if( $result = $this->conn->query($query) )
			return $result or die(mysql_error());
	}

	function update_event($event){
		$mysql = New Mysql();
		
		$query = "UPDATE `events`.`events` SET `venue` = '" . $event->venue . "', `address` = '" . $event->address . "', `summary` = '" . $event->summary . "', `date` = '" . $event->date . "', `link` = '" . $event->link . "', `phone` = '" . $event->phone . "' WHERE `events`.`id` ='" . $event->id . "';";
		
		if( $result = $this->conn->query($query) )
			return $result or die(mysql_error());
	}	
	
	function destroy_event($event){
		$mysql = New Mysql();
		
		$query = "DELETE FROM `events`.`events` WHERE `events`.`id` = ". $event->id .";";
				
		if( $result = $this->conn->query($query) )
			return $result or die(mysql_error());
	}
}

class Event{
	function __construct($id, $date, $venue, $address, $phone, $summary, $link){
		$this->id = $id;
		$this->date = $date;
		$this->venue = $venue;
		$this->address = $address;
		$this->phone = $phone;
		$this->summary = $summary;
		$this->link = $link;	
	}
}