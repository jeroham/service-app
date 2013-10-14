<?php 
session_start();

//load classes automagically
 function __autoload($class_name) {
    include "../".$class_name . '.php';
}

//logged in?
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
// Gather this customer's full information for inserting automatically into the edit form below on page
if (isset($_GET['employeeid'])) {
	$targetID = $_GET['employeeid'];
        
        $employee1->Get($targetID);
   
} else{
    $employee1 = new EmployeeData();
}
// Parse the form data and add employee to the system
if (isset($_POST['employeeid']) &
	$_GET['action'] == "save") {
	
	$employeeid = ($_POST['employeeid']);
	if($employeeid != 0){
            $employee1->Get($employeeid);//load
        }
        $employee1->first_name = ($_POST['employee_first_name']);
	$employee1->last_name = ($_POST['employee_last_name']);
	$employee1->username = ($_POST['username']);
	$employee1->password = ($_POST['password']);
	$employee1->phone = ($_POST['phone']);
	$employee1->cell_phone = ($_POST['cell_phone']);
	$employee1->email = ($_POST['email']);
	$employee1->address1 = ($_POST['address1']);
	$employee1->address2 = ($_POST['address2']);
	$employee1->zip = ($_POST['zip']);
	$employee1->state = ($_POST['state']);
	
        $result = $employee1->Save();
	if($result>0){
            //$sql = mysql_query("UPDATE customere SET company_name='$company_name', employee_first_name='$employee_first_name', employee_last_name='$employee_last_name', username='$username', password='$password' , phone='$phone', cell_phone='$cell_phone', email='$email', address1='$address1', address2='$address2', zip='$zip', state='$state'  WHERE id='$cid'");
            header("location: employee_list.php"); 
           // exit();
        }else{
            echo "Error: ".$result;
        }
            
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Edit</title>
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
  	<h2>Edit Employee</h2>
    
    <form action="employee_edit.php?action=save" enctype="multipart/form-data" name="add_new_employee_form" id="add_new_employee_form" method="post">
	  
    First name:<br />	
    
    <input name="employee_first_name" type="text" id="employee_first_name" size="70" value="<?php echo $employee1->first_name  ?>" />
    <br />
  
    Last name:<br />
   
    <input name="employee_last_name" type="text" id="employee_last_name" size="70" value="<?php echo $employee1->last_name  ?>" />
    <br />
  
    Username:<br />
    
    <input name="username" type="text" id="username" size="70" value="<?php echo $employee1->username  ?>" />
     <br />
     
    Password:<br />
   
   <input name="password" type="text" id="password" size="70" value="<?php echo $employee1->password  ?>" />
 	<br />
  
    Phone:<br />
 
   <input name="phone" type="text" id="phone" size="70" value="<?php echo $employee1->phone  ?>" />
 	<br />
  
    Cell phone:<br />
    
    <input name="cell_phone" type="text" id="cell_phone" size="70" value="<?php echo $employee1->cell_phone  ?>" />
    <br />
 
	Email:<br />
  
   <input name="email" type="text" id="email" size="70" value="<?php echo $employee1->email  ?>" />
   <br />
        
 	Address 1:<br />
    
    <input name="address1" type="text" id="address1" size="70" value="<?php echo $employee1->address1  ?>" />
    <br />
  
    Address 2:<br />
   
    <input name="address2" type="text" id="address2" size="70" value="<?php echo $employee1->address2  ?>" />
    <br />
 
    Zip:<br />
  
    <input name="zip" type="text" id="zip" size="70" value="<?php echo $employee1->zip  ?>" />
   	<br />
  
    State:<br />
  
    <input name="state" type="state" id="phone" size="70" value="<?php echo $employee1->state  ?>" />
    <br /><br />
    <input name="employeeid" type="hidden" value="<?php echo $employee1->employeeid; ?>" />
   
	<input type="submit" name="button" id="button" value="Save" />
        <input type="button" onclick="confirm('Delete this employee?')" name="btnDelete" id="button" class="delete_button" value="Delete" />
        
    </form>
    
 	 </div>

    
    
  </tr>
  </table>
  
  
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>