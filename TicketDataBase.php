<?php
class TicketDataBase extends DataObject {
public $ticketid="";
public $customerid="";
public $employeeid="";
public $createdate="";
public $description="";
public $status="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "ticket";
 $this->_idcolumnname = "ticketid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->ticketid=$row["ticketid"];
$this->customerid=$row["customerid"];
$this->employeeid=$row["employeeid"];
$this->createdate=$row["createdate"];
$this->description=$row["description"];
$this->status=$row["status"];
}
}

  public function Save(){
$result=parent::Save();
$this->ticketid = $this->_id;
return $result;
}
}//end of class