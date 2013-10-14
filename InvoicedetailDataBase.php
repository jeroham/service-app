<?php
class InvoicedetailDataBase extends DataObject {
public $invoicedetailid="";
public $invoiceid="";
public $linenumber="";
public $quantity="";
public $price="";
public $description="";
public $taxes="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "invoicedetail";
 $this->_idcolumnname = "invoicedetailid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->invoicedetailid=$row["invoicedetailid"];
$this->invoiceid=$row["invoiceid"];
$this->linenumber=$row["linenumber"];
$this->quantity=$row["quantity"];
$this->price=$row["price"];
$this->description=$row["description"];
$this->taxes=$row["taxes"];
}
}

  public function Save(){
$result=parent::Save();
$this->invoicedetailid = $this->_id;
return $result;
}
}//end of class