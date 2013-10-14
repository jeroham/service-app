<?php
class TicketData extends TicketDataBase {

private $employee;
public $details = array();

public function AddDetail($detail){
	$this->details[] = $detail;
}


//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

public function GetDetails(){
	if(!isset($details)){  //only load if null or changed
		$details = new array();
		$list = (new TicketdetailData())->Search("*","ticketid=".$this->ticketid);
		while($d = $list->fetch()){
			$newdetail = new TicketdetailData();
			$newdetail->ticketdetailid = $d["ticketdetailid"]; 
			$newdetail->ticketid = $d["ticketid"];
			$newdetail->equipmentid = $d["equipmentid"];
			$newdetail->serviceid = $d["serviceid"];
			$newdetail->employeeid = $d["employeeid"];
			$newdetail->description = $d["description"];
			$newdetail->status = $d["status"];
			
			$details[] = $newdetail; 
		}
		
	}
	
	return $details;
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



}//end of class