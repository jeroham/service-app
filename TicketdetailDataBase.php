<?php
class TicketdetailDataBase extends DataObject {
public $ticketdetailid="";
public $ticketid="";
public $equipmentid="";
public $serviceid="";
public $description="";
public $status="";
public $employeeid="";



 public function __construct() {
 parent::__construct();
 $this->_tablename = "ticketdetail";
 $this->_idcolumnname = "ticketdetailid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->ticketdetailid=$row["ticketdetailid"];
$this->ticketid=$row["ticketid"];
$this->equipmentid=$row["equipmentid"];
$this->serviceid=$row["serviceid"];
$this->description=$row["description"];
$this->status=$row["status"];
$this->employeeid=$row["employeeid"];

}
}

  public function Save(){
$result=parent::Save();
$this->ticketdetailid = $this->_id;
return $result;
}
}//end of class