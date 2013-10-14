<?php
class CustomerData extends CustomerDataBase {
//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

public function GetEquipmentList(){
	$equipment = new EquipmentData();
	return $equipment->Search("*","WHERE customerid=".$this->customerid );
}

public function GetServicesList(){
	$service = new ServiceData();
	return $service->Search("*","WHERE customerid=" . $this->customerid );
}

}//end of class