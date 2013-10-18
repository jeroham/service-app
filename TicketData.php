<?php
class TicketData extends TicketDataBase {

private $_employee;
private $_details;

public function AddDetail($detail){

	if(!isset($this->_details)){	
		$this->_details = array();
	}
	$this->_details[] = $detail;
}


//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

public function GetDetails(){
		if( $this->ticketid > 0 & !isset($this->_details)) {  //only load if null or changed
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
				
				$this->_details[] = $newdetail; 
		}
		
	}
	if(!isset($this->_details)){	
		$this->_details = array();
	}
	
	return $this->_details;
}


public function GetDetail($index){
		
	if(!isset($this->_details)){	
		$this->_details = array();
		return null; //or new detail
	}
	
	return $this->_details[$index];
}

public function GetEmployee(){
	if(!isset($employee)){  //only load if null or changed
		$_employee = new EmployeeData();
		$_employee->Get($this->employeeid);
	} 
	if($this->employeeid != $_employee->employeeid) { //only load if null or changed
		$_employee->Get($this->employeeid);
	}
	return $_employee;
}



}//end of class