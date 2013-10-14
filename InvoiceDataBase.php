<?php
class InvoiceDataBase extends DataObject {
public $invoiceid="";
public $customerid="";
public $employeeid="";
public $status="";
public $createdate="";
public $invoicenumber="";
public $ticketid="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "invoice";
 $this->_idcolumnname = "invoiceid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->invoiceid=$row["invoiceid"];
$this->customerid=$row["customerid"];
$this->employeeid=$row["employeeid"];
$this->status=$row["status"];
$this->createdate=$row["createdate"];
$this->invoicenumber=$row["invoicenumber"];
$this->ticketid=$row["ticketid"];
}
}

  public function Save(){
$result=parent::Save();
$this->invoiceid = $this->_id;
return $result;
}
}//end of class