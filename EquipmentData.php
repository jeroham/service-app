<?php
class EquipmentData extends EquipmentDataBase {
    
public function GetDescription(){
    return $this->brand+" "+$this->model;
}    
//validate data,
public function Validate($id){
}

 //check existing conflicting data, moved to traits
public function CheckExisting($id){
}

}//end of class