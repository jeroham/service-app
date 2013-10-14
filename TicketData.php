<?php
class TicketData extends TicketDataBase {

private $employee;
public $details;

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
		if( $this->ticketid > 0 & !isset($this->details))) {  //only load if null or changed
		$detail = new TicketdetailData();
		
		
		$list = $detail->Search("*","ticketid=".$this->ticketid);
		while($d = $list->fetch()){
			$newdetail = new TicketdetailData();
			$newdetail->ticketdetailid = $d["ticketdetailid"]; 
			$newdetail->ticketid = $d["ticketid"];
			$newdetail->equipmentid = $d["equipmentid"];
			$newdetail->serviceid = $d["serviceid"];
			$newdetail->employeeid = $d["employeeid"];
			$newdetail->description = $d["description"];
			$newdetail->status = $d["status"];
			
			$this->details[] = $newdetail; 
		}
		
	}
	if(!isset($this->details)){	
		$this->details = array();
	}
	
	
	return $this->details;
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