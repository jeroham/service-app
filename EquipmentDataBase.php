<?php
class EquipmentDataBase extends DataObject {
public $equipmentid="";
public $customerid="";
public $brand="";
public $model="";
public $serial="";
public $buydate="";
public $warrantydays="";
public $status="";
public $equipmenttypeid="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "equipment";
 $this->_idcolumnname = "equipmentid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->equipmentid=$row["equipmentid"];
$this->customerid=$row["customerid"];
$this->brand=$row["brand"];
$this->model=$row["model"];
$this->serial=$row["serial"];
$this->buydate=$row["buydate"];
$this->warrantydays=$row["warrantydays"];
$this->status=$row["status"];
$this->equipmenttypeid=$row["equipmenttypeid"];
}
}

  public function Save(){
$result=parent::Save();
$this->equipmentid = $this->_id;
return $result;
}
}//end of class