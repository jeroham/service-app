<?php

include "DBCon.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This class provides persistance to database, mysql in this case 
 *
 * @author jeroham
 */
class DataObject extends stdClass {

    // public $id = 51;
    public $_tablename = "";
    public $_idcolumnname = "";
    public $_id = 0;
    private $_db_con;
    
    
    function __construct($json=false) {
        $this->_db_con = new DBCon();
			 if ($json) $this->set(json_decode($json, true));
			 
		
    }
     public function set($data) {
        foreach ($data AS $key => $value) {
            if (is_array($value)) {
                $sub = new JSONObject;
                $sub->set($value);
                $value = $sub;
            }
            $this->{$key} = $value;
        }
    }
    /*/*save event registering
    protected $_savedCallbacks = array();

    function registerSavedCallback($callback) {
        $this->_savedCallbacks[] = $callback;
    }
    
    //save event fire
    function fireSaved() {
        foreach ($this->_savedCallbacks as $callback) {
            call_user_func($callback);
        }
    }
    */

    function Save() {
        //save to db
        $sql = "";
        $columns = "";
        $values = array();
        $placeholders = "";
        $props = get_object_vars($this);
        $id = $props[$this->_idcolumnname];
        //insert
        if ($id == 0) {
            $sql = "INSERT INTO `" . $this->_tablename . "` ";
            foreach ($this as $property => $value) {
                //exclude meta properties
                if (
				substr ($property,0,1) != "_" &
					//$property != "_db_con" &
                    //    $property != "_tablename" &
                     //   $property != "_idcolumnname" &
                     //    $property != "_id" &
                        $property != $this->_idcolumnname) {
                    $columns .= "`" . $property . '`,';
				
                    //validate types
                  //  print "Type: " . gettype($value);
                    switch (gettype($value)) {
                        case "integer":
                            break;
                        case "double":

                            $placeholders .= $value . ",";
                            break;
                        case "string":
                            $placeholders .= "'" . $value . "',";
                            break;
                        case "NULL":
                            $placeholders .= "null,";
                            break;
						case "array":  //TODO: check
                            $placeholders .= "null,";
                            break;
							
                        default:
                            $placeholders .= "'" . $value . "',";
                            break;
                    }
                }
            }

            //eliminate last commas
            $columns = substr($columns, 0, strlen($columns) - 1);
            $placeholders = substr($placeholders, 0, strlen($placeholders) - 1);
            $sql .= "($columns) values ($placeholders);";
        //    echo "<br>$sql<br>";
			// Performing SQL query
             $this->_id  = $this->_db_con->Execute($sql,true);
            //return new id
            return  $this->_id;
        }
        //update
        else {
            $sql = "UPDATE " . $this->_tablename . " SET ";

            foreach ($this as $property => $value) {
                //exclude meta properties
                if (	substr ($property,0,1) != "_"  &
						/*$property != "_db_con" &
                        $property != "_tablename" &
                        $property != "_idcolumnname" &
                        $property != "_id" &*/
                        $property != $this->_idcolumnname) {
                    if ($this->_idcolumnname === $property) {
                        $id = $value;
                    } else {
                        //use single quote for strings, none for numbers    

                        switch (gettype($value)) {
                            case "integer":
                            case "double":
                                $sql .= $property . "=" . $value . ",";
                                break;
                            case "string":
                                $sql .= $property . " = '" . $value . "',";
                                break;
                            case "NULL":
                                $sql .= $property . " = null,";
                                break;
                            default:
                                $sql .= $property . " = '" . $value . "',";
                                break;
                        }
                    }
                }
            }

            //eliminate last comma
            $sql = substr($sql, 0, strlen($sql) - 1);
            $sql .= " WHERE " . $this->_idcolumnname . "=" . $id;
            
            $result = $this->_db_con->Execute($sql);
            $this->_id = $id;
            
            return $result;
        }
    }

    function Delete() {
        //delete to db
        $sql = "DELETE FROM `" . $this->_tablename."`";

        foreach ($this as $property => $value) {
            //exclude meta properties

            if ($this->_idcolumnname === $property) {
                $id = $value;
            }
        }

        $sql .= " WHERE " . $this->_idcolumnname . "=" . $id;
        //print($sql);
        $result = $this->_db_con->Execute($sql);
        return $result;
    }

    function Get($id) {
        // get from db
        $sql = "SELECT * FROM " . $this->_tablename;
        $sql .= " WHERE " . $this->_idcolumnname . "=" . $id;
        return $this->_db_con->Query($sql);
    }

    function Search($columns="*",$filters="1=1") {
        // search on db
        $sql = "SELECT " . $columns . " FROM " . $this->_tablename;
        $sql .= " WHERE ".$filters;
		//echo "<br/>$sql<br/>";
		return $this->_db_con->Query($sql);
    }

    //pass thru query
    function Query($query) {
        return $this->_db_con->Query($query);
    }

    function Log($info){
        
    }
	
	public function __sleep()
{
    $this->_db_con = null;
	return array(
	"_tablename",
    "_idcolumnname",
    "_id",
    "_db_con" );
	
}

public function __wakeup()
{
    $this->_db_con = new DBCon();
}


}
?>