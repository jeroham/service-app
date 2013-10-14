<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This class provides connection to database, mysql in this case 
 *
 * @author jeroham
 */
class DBCon extends PDO {

    private $dbh;
    //   private $user = "hangover_user";
    //  private $pass = "WakeUpWith1";
    private $user = "root";
    private $pass = "";

    function __construct() {
        try {
            /* $user = "hangoveruser";
              $pass = "hangoveruser1234";
              $user = "root";
              $pass = "";
             */
            $this->dbh = new PDO('mysql:host=127.0.0.1;dbname=owc', $this->user, $this->pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            // die();
        }
    }

    function __destruct() {
        $dbh = null;
        // die();
    }

    function Execute($query,$returnid=false) {
        //$this->dbh->query($query);
        try{
            if($returnid){
                 $this->dbh->exec($query);
                 return $this->dbh->lastInsertId();
            }
            else{
                return $this->dbh->exec($query);
            }
        }
        catch (PDOException $e) {
            echo "Error executing query: ".$e->getMessage()."<br/>Query: ".$query;
        }
    }

    function Query($query) {
        try{
        return $this->dbh->query($query);
         }
        catch (PDOException $e) {
            echo "Error executing query: ".$e->getMessage()."<br/>Query: ".$query;
        }
    }

    function Kill() {
        $dbh->null;
    }

    //automatically generates base and data class files for a given tablename
    function GenerateClasses($tablename,$data=true) {
        $tablename = strtolower($tablename);
        $filename = ucfirst($tablename) . "DataBase.php";
        $class = "<?php\n";
        echo $class;
        $class .= "class " . ucfirst($tablename) . "DataBase extends DataObject {\n";
        echo $class;
        $query = "SELECT * FROM " . $tablename;
        $result = $this->dbh->query($query);
        echo $class;
        for ($i = 0; $i < $result->columnCount(); $i++) {
            $meta = $result->getColumnMeta($i);
            $class.= 'public $' . $meta["name"] . '="";' . "\n";
        }
        $class .= "\n\n public function __construct() {\n";
        $class .= " parent::__construct();\n";
        $class .= ' $this->_tablename = "' . $tablename . '";' . "\n";
        $class .= ' $this->_idcolumnname = "' . $tablename . 'id";' . "\n";
        $class .= "}\n\n";
        
        $class .= "//validate data, moved to traits\n";
        
        $class .= " //check existing conflicting data, moved to traits\n";
        
        $class .= 'public function Get($id){'."\n";
        $class .= '$result = parent::Get($id);'."\n";
        $class .= 'while($row=$result->fetch()){' . "\n";
        
        for ($i = 0; $i < $result->columnCount(); $i++) {
            $meta = $result->getColumnMeta($i);
            $class.= '$this->' . $meta["name"] . '=$row["'. $meta["name"] .'"];' . "\n";
        }
        $class .= "}\n";
        $class .= "}\n\n";
        
        $class .= "  public function Save(){\n";
        $class .= '$result=parent::Save();'."\n";
        $class .= '$this->' . $tablename . 'id = $this->_id;' . "\n";
        $class .= 'return $result;'."\n";
        $class .= "}\n\n\n";
		
        $class .= "}//end of class";
        file_put_contents($filename, $class);
        
        if($data){
            //_1 to prevent overwrites, user decides to keep them
            $filename = ucfirst($tablename) . "Data_1.php";
            $class = "<?php\n";
            $class .= "class " . ucfirst($tablename) . "Data extends " . ucfirst($tablename) . "DataBase {\n";
            
            $class .= "//validate data,\n";
            $class .= 'public function Validate($id){'."\n";
            $class .= "}\n\n";
            
            $class .= " //check existing conflicting data, moved to traits\n";
            $class .= 'public function CheckExisting($id){'."\n";
            $class .= "}\n\n";
           
            $class .= "}//end of class";
            file_put_contents($filename, $class);
            }
    }

}

// Helper functions to build SELECT conditions

function isEqual($field, $value) {
    return ($value) ?
            $field . " = '" . $value . "'" : "true";
}

function isIn($field, $value) {
    return ($value) ? $field . " IN (" . $value . ")" : "true";
    //.replace(/,/g, "','") 
}

function isLike($field, $value) {
    return ($value) ? $field . " LIKE " . "'%" . $value . "%'" : "true";
}

?>
