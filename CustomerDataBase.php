<?php
class CustomerDataBase extends DataObject {
public $customerid="";
public $company_name="";
public $contact_first_name="";
public $contact_last_name="";
public $username="";
public $password="";
public $phone="";
public $cell_phone="";
public $email="";
public $address1="";
public $address2="";
public $zip="";
public $state="";
public $last_log_date="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "customer";
 $this->_idcolumnname = "customerid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->customerid=$row["customerid"];
$this->company_name=$row["company_name"];
$this->contact_first_name=$row["contact_first_name"];
$this->contact_last_name=$row["contact_last_name"];
$this->username=$row["username"];
$this->password=$row["password"];
$this->phone=$row["phone"];
$this->cell_phone=$row["cell_phone"];
$this->email=$row["email"];
$this->address1=$row["address1"];
$this->address2=$row["address2"];
$this->zip=$row["zip"];
$this->state=$row["state"];
$this->last_log_date=$row["last_log_date"];
}
}

  public function Save(){
$result=parent::Save();
$this->customerid = $this->_id;
return $result;
}
}//end of class