<?php
class TicketdetailData extends TicketdetailDataBase {

	private $equipment;
	private $service;
	private $employee;
	
	
public function GetEquipment(){
	if(!isset($equipment)){  //only load if null or changed
		$equipment = new EquipmenteData();
		$equipment->Get($this->equipmentid);
	} 
	if($this->equipmentid != $equipment->equipmentid) { //only load if null or changed
		$equipment->Get($this->equipmentid);
	}
	return $equipment;
}

	
public function GetEquipment(){
	if(!isset($equipment)){  //only load if null or changed
		$equipment = new EquipmenteData();
		$equipment->Get($this->equipmentid);
	} 
	if($this->equipmentid != $equipment->equipmentid) { //only load if null or changed
		$equipment->Get($this->equipmentid);
	}
	return $equipment;
}


public function GetEmployee(){
	if(!isset($employee)){  //only load if null or changed
		$employee = new EmployeeData();
		$employee->Get($this->employeeid);
	} 
	if($this->employeeid != $employee->employeeid) { //only load if null or changed
		$employee->Get($this->employeeid);
	}
	return $employee;
}

//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

}//end of class