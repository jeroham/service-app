<?php
class ScheduleDataBase extends DataObject {
public $scheduleid="";
public $customerid="";
public $employeeid="";
public $day="";
public $starttime="";
public $endtime="";
public $fromdate="";
public $todate="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "schedule";
 $this->_idcolumnname = "scheduleid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->scheduleid=$row["scheduleid"];
$this->customerid=$row["customerid"];
$this->employeeid=$row["employeeid"];
$this->day=$row["day"];
$this->starttime=$row["starttime"];
$this->endtime=$row["endtime"];
$this->fromdate=$row["fromdate"];
$this->todate=$row["todate"];
}
}

  public function Save(){
$result=parent::Save();
$this->scheduleid = $this->_id;
return $result;
}
}//end of class