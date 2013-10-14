<?php
class ServiceDataBase extends DataObject {
public $serviceid="";
public $customerid="";
public $servicename="";
public $createdate="";
public $expiration="";
public $description="";
public $status="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "service";
 $this->_idcolumnname = "serviceid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->serviceid=$row["serviceid"];
$this->customerid=$row["customerid"];
$this->servicename=$row["servicename"];
$this->createdate=$row["createdate"];
$this->expiration=$row["expiration"];
$this->description=$row["description"];
$this->status=$row["status"];
}
}

  public function Save(){
$result=parent::Save();
$this->serviceid = $this->_id;
return $result;
}
}//end of class