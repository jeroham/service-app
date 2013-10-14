<?php 
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database  
include "../scripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record <a href= http://localhost:8888/Joel/ >Click Here</a>.";
     exit();
}
// Parse the form data and add customer to the system
if (isset($_POST['customerid']) &
	$_POST['action'] == "save") {
	
	$employeeid = mysql_real_escape_string($_POST['employeeid']);
	$employee = new employeeData();
	$employee->GetById($employeeid);//load
	
    $employee->employee_first_name = mysql_real_escape_string($_POST['employee_first_name']);
	$employee->employee_last_name = mysql_real_escape_string($_POST['employee_last_name']);
	$employee->username = mysql_real_escape_string($_POST['username']);
	$employee->password = mysql_real_escape_string($_POST['password']);
	$employee->phone = mysql_real_escape_string($_POST['phone']);
	$employee->cell_phone = mysql_real_escape_string($_POST['cell_phone']);
	$employee->email = mysql_real_escape_string($_POST['email']);
	$employee->address1 = mysql_real_escape_string($_POST['address1']);
	$employee->address2 = mysql_real_escape_string($_POST['address2']);
	$employee->zip = mysql_real_escape_string($_POST['zip']);
	$employee->state = mysql_real_escape_string($_POST['state']);
	
	$customer->Save();
	//$sql = mysql_query("UPDATE customere SET company_name='$company_name', employee_first_name='$employee_first_name', employee_last_name='$employee_last_name', username='$username', password='$password' , phone='$phone', cell_phone='$cell_phone', email='$email', address1='$address1', address2='$address2', zip='$zip', state='$state'  WHERE id='$cid'");
	header("location: customer_list.php"); 
  // exit();
}
// Gather this customer's full information for inserting automatically into the edit form below on page
if (isset($_GET['cid'])) {
	$targetID = $_GET['cid'];
    $sql = mysql_query("SELECT * FROM customere WHERE id='$targetID' LIMIT 1");
    $employee_count = mysql_num_rows($sql); 
    if ($employee_count > 0) {
	    while($row = mysql_fetch_array($sql)){ 
             
			
			 $employee_first_name = $row ["employee_first_name"];
			 $employee_last_name = $row ["employee_last_name"];
			 $username = $row["username"];
		   	 $password = $row["password"];
			 $phone = $row["phone"];
			 $cell_phone = $row["cell_phone"];
			 $email = $row['email'];
			 $address1 = $row["address1"];
			 $address2 = $row["address2"];
			 $zip = $row["zip"];
			 $state = $row["state"];
        }
    } else {
	    echo "Sorry mate that dont exist.";
		exit();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Schedule Edit</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("../header.php");?>
  <div id="Page_Content">
  
  <table width="100%" height="265" border="1" cellpadding="1">
  <tr>
    <td width="9%" bgcolor="#E7F7FF">
    
    <h5><a href= "admin_index.php" >Back</a></h5>
    <h5><a href= "log_out.php" >Log Out</a></h5>
    
    </td>
    <td width="91%" height="124" colspan="2" valign="top">
    

    
	<div align="left" style="margin: 25px;">
  	<h2>Edit Operating or Working Schedule</h2>
    
    <form action="customer_edit.php" enctype="multipart/form-data" name="add_new_customer_form" id="add_new_customer_form" method="post">
	  
    Name:<br />	
    
    <input name="employee_first_name" type="text" id="employee_first_name" size="70" value="<?php echo $employee_first_name  ?>" />
    <br />
  
    Type:<br />
   
    <input name="employee_last_name" type="text" id="employee_last_name" size="70" value="<?php echo $employee_last_name  ?>" />
    <br />
  
  <!--  
  La idea es poder inscribir los horarios de trabajo de un empleado
  y las horas de operacion de los clientes. 
  Además:
  - inscribir dias feriados para uno o mas clientes y/o la compañía.
  - inscribir vacaciones de empleados y/o ausencias pre-determinadas

  El sistema con esta información puede programa servicios automáticamente.
  
  -->
   
	<div id="entry">
	</div>
	<div id="list">
	<table id="schedulelist">
	</table>
	</div>
	
   
    <br /><br />
    <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
   
	<input type="submit" name="button" id="button" value="Edit This customer" />
    </form>
    
 	 </div>

    
    
  </tr>
  </table>
  
  
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>