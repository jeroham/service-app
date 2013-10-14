<?php 
session_start();
//load classes automagically
 function __autoload($class_name) {
    include "../".$class_name . '.php';
}

if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information

$employee1 = new EmployeeData();
    $employee1->username = $manager;
    $employee1->password = $password;
    
    if (!$employee1->CheckLogin(true)) {
	 echo "Your login session data is not on record <a href= http://localhost:8888/Joel/ >Click Here</a>.";
     exit();
}
// Delete client Question to Admin, and Delete client if they choose
if (isset($_GET['action'])){
	if($_GET['action'] == "delete") {
		echo 'Do you really want to delete Employee with ID ' . $_GET['employeeid'] . '? <a href="employee_list.php?action=dodelete&employeeid='. $_GET['employeeid'] . '">Yes</a> | <a href="employee_list.php">No</a>';
		//exit();
	}


	if ($_GET['action'] == "dodelete") {
		// remove item from system and delete its picture
		// delete from database
		$employee1->employeeid = $_GET['employeeid'];
		$employee1->Delete();
		header("location: employee_list.php"); 
	   // exit();
	}
}
$employee_list = $employee1->Search("employeeid,first_name,last_name, phone,email", "");
$employee_table = "";
if ($employee_list->rowCount() > 0) {
	
		while($row = $employee_list->fetch()){ 
                         $id = $row["employeeid"];
                         $name = $row["first_name"]." ".$row["last_name"];
                         $phone = $row["phone"];
			 $email = $row["email"];
			 $employee_table .= " <a href='employee_edit.php?employeeid=$id'>ID: $id </a>- Name: $name - Phone#: $phone - Email: $email &nbsp; &nbsp; <a href='employee_edit.php?employeeid=$id'>Edit</a> &bull; <a href='employee_list.php?action=delete&employeeid=$id'>Delete</a> <br />";
    }
} else {
	$employee_table = "You have no employees listed yet";
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee List</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("../header.php");?>
  <div id="Page_Content">
  
  <table width="100%" height="265" border="1" cellpadding="1">
  <tr>
    <td width="9%" bgcolor="#E7F7FF">
    
    <h5><a href= "./admin_area/admin_index.php" >Back</a></h5>
    
    <h5><a href= "./scripts/log_out.php" >Log Out</a></h5></td>
    <td width="91%" height="124" colspan="2" valign="top">
    
	<div align="right" style="margin-right:25px;"><a href="employee_edit.php?action=new">Add New Employee</a></div>
    
<div align="left" style="margin-left: 25px;">
  <h2>Employee List</h2>
	
	<?php echo $employee_table; ?>
    
  </div>

    
    </td>
  </tr>
  </table>
  
  
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>