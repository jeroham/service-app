<?php
class TimesheetDataBase extends DataObject {
public $timesheetid="";
public $employeeid="";
public $recordtime="";
public $ticketid="";
public $operation="";
public $ticketdetailid="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "timesheet";
 $this->_idcolumnname = "timesheetid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->timesheetid=$row["timesheetid"];
$this->employeeid=$row["employeeid"];
$this->recordtime=$row["recordtime"];
$this->ticketid=$row["ticketid"];
$this->operation=$row["operation"];
$this->ticketdetailid=$row["ticketdetailid"];
}
}

  public function Save(){
$result=parent::Save();
$this->timesheetid = $this->_id;
return $result;
}
}//end of class