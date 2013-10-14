<?php
class EquipmenttypeDataBase extends DataObject {
public $equipmenttypeid="";
public $equipmenttypename="";
public $parentid="";


 public function __construct() {
 parent::__construct();
 $this->_tablename = "equipmenttype";
 $this->_idcolumnname = "equipmenttypeid";
}

//validate data, moved to traits
 //check existing conflicting data, moved to traits
public function Get($id){
$result = parent::Get($id);
while($row=$result->fetch()){
$this->equipmenttypeid=$row["equipmenttypeid"];
$this->equipmenttypename=$row["equipmenttypename"];
$this->parentid=$row["parentid"];
}
}

  public function Save(){
$result=parent::Save();
$this->equipmenttypeid = $this->_id;
return $result;
}
}//end of class