<?php
class EmployeeDataBase extends DataObject {
public $employeeid="";
public $first_name="";
public $last_name="";
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
public $roles="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "employee";
 $this->_idcolumnname = "employeeid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->employeeid=$row["employeeid"];
$this->first_name=$row["first_name"];
$this->last_name=$row["last_name"];
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
$this->roles=$row["roles"];
}
}

  public function Save(){
$result=parent::Save();
$this->employeeid = $this->_id;
return $result;
}
}//end of class