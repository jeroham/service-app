<?php
class CustomerData extends CustomerDataBase {
    
    private $_equipment;
    private $_services;
    
//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

public function AddEquipment($e){
    if(!isset($this->_equipment)){	
		$this->_equipment = array();
	} 
    $this->_equipment[] = $e;
}
public function AddService($s){
    if(!isset($this->_services)){	
		$this->_services = array();
	} 
    $this->_services[] = $s;
}

public function GetEquipmentList(){
	$equipment = new EquipmentData();
        $list = $equipment->Search("*","WHERE customerid=".$this->customerid );
        while($d = $list->fetch()){
            $e = new EquipmentData();
            $e->brand = $d["brand"];
            $e->buydate = $d["brand"];
            $e->customerid = $this->customerid;
            $e->equipmenttypeid = $d["equipmenttypeid"];
            $e->model = $d["model"];
            $e->serial = $d["serial"];
            $e->status = $d["status"];
            $e->equipmentid = $d["equipmentid"];
            $e->warrantydays = $d["warrantydays"];
            
            $this->_equipment[] = $e;
        }
        if(!isset($this->_equipment)){	
		$this->_equipment = array();
	}
	
	return $this->_equipment;
}

public function GetServicesList(){
	$service = new ServiceData();
         $list = $service->Search("*","WHERE customerid=" . $this->customerid );
         while($d = $list->fetch()){
            $e = new ServiceData();
            $e->description = $d["description"];
            $e->expiration = $d["expiration"];
            $e->customerid = $this->customerid;
            $e->createdate = $d["createdate"];
            $e->serviceid = $d["serviceid"];
            $e->status = $d["status"];
            
            $this->_service[] = $e;
        }
        if(!isset($this->_service)){	
		$this->_service = array();
	}
	
	return $this->_service;
}

}//end of class