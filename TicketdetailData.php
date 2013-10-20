<?php
class TicketdetailData extends TicketdetailDataBase {

	private $_equipment;
	private $_service;
	private $_employee;
	
	
public function GetEquipment(){
	if(!isset($this->equipment)){  //only load if null or changed
		$this->equipment = new EquipmentData();
		$this->equipment->Get($this->equipmentid);
	} 
	if($this->equipmentid != $this->_equipment->equipmentid) { //only load if null or changed
		$this->_equipment->Get($this->equipmentid);
	}
	return $this->_equipment;
}

	
public function GetService(){
	if(!isset($this->_service)){  //only load if null or changed
		$this->_service = new ServiceData();
		$this->_service->Get($this->serviceid);
	} 
	if($this->serviceid != $this->_service->serviceid) { //only load if null or changed
		$this->_service->Get($this->serviceid);
	}
	return $this->_service;
}


public function GetEmployee(){
	if(!isset($this->_employee)){  //only load if null or changed
		$this->_employee = new EmployeeData();
		$this->_employee->Get($this->employeeid);
	} 
	if($this->employeeid != $this->_employee->employeeid) { //only load if null or changed
		$this->_employee->Get($this->employeeid);
	}
	return $this->_employee;
}

//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

}//end of class