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
?>

<?php 
// Parse the form data and add client to the system
if (isset($_POST['company_name'])) {
	
	$cid = mysql_real_escape_string($_POST['thisID']);
    $company_name = mysql_real_escape_string($_POST['company_name']);
	$contact_first_name = mysql_real_escape_string($_POST['contact_first_name']);
	$contact_last_name = mysql_real_escape_string($_POST['contact_last_name']);
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$phone = mysql_real_escape_string($_POST['phone']);
	$cell_phone = mysql_real_escape_string($_POST['cell_phone']);
	$email = mysql_real_escape_string($_POST['email']);
	$address1 = mysql_real_escape_string($_POST['address1']);
	$address2 = mysql_real_escape_string($_POST['address2']);
	$zip = mysql_real_escape_string($_POST['zip']);
	$state = mysql_real_escape_string($_POST['state']);
	
	$sql = mysql_query("UPDATE cliente SET company_name='$company_name', contact_first_name='$contact_first_name', contact_last_name='$contact_last_name', username='$username', password='$password' , phone='$phone', cell_phone='$cell_phone', email='$email', address1='$address1', address2='$address2', zip='$zip', state='$state'  WHERE id='$cid'");
	 {
	    
	}
	header("location: client_list.php"); 
    exit();
}
?>

<?php 
// Gather this client's full information for inserting automatically into the edit form below on page
if (isset($_GET['cid'])) {
	$targetID = $_GET['cid'];
    $sql = mysql_query("SELECT * FROM cliente WHERE id='$targetID' LIMIT 1");
    $client_count = mysql_num_rows($sql); 
    if ($client_count > 0) {
	    while($row = mysql_fetch_array($sql)){ 
             
			
			 $company_name = $row["company_name"];
			 $contact_first_name = $row ["contact_first_name"];
			 $contact_last_name = $row ["contact_last_name"];
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
<title>Client Edit</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("../header.php");?>
  <div id="Page_Content">
  
  <table width="100%" height="265" border="1" cellpadding="1">
  <tr>
    <td width="9%" bgcolor="#E7F7FF">
    
    <h5><a href= "http://localhost:8888/Joel/admin_area/admin_index.php" >Back</a></h5>
    <h5><a href= "http://localhost:8888/Joel/scripts/log_out.php" >Log Out</a></h5>
    
    </td>
    <td width="91%" height="124" colspan="2" valign="top">
    

    
	<div align="left" style="margin: 25px;">
  	<h2>Edit Client</h2>
    
    <form action="client_edit.php" enctype="multipart/form-data" name="add_new_client_form" id="add_new_client_form" method="post">
	
	
  
   	Company Name:<br />
   
    <input name="company_name" type="text" id="company_name" size="70" value="<?php echo $company_name  ?>" />
    <br />
  
    Contact first name:<br />	
    
    <input name="contact_first_name" type="text" id="contact_first_name" size="70" value="<?php echo $contact_first_name  ?>" />
    <br />
  
    Contact last name:<br />
   
    <input name="contact_last_name" type="text" id="contact_last_name" size="70" value="<?php echo $contact_last_name  ?>" />
    <br />
  
    Username:<br />
    
    <input name="username" type="text" id="username" size="70" value="<?php echo $username  ?>" />
     <br />
     
    Password:<br />
   
   <input name="password" type="text" id="password" size="70" value="<?php echo $password  ?>" />
 	<br />
  
    Phone:<br />
 
   <input name="phone" type="text" id="phone" size="70" value="<?php echo $phone  ?>" />
 	<br />
  
    Cell phone:<br />
    
    <input name="cell_phone" type="text" id="cell_phone" size="70" value="<?php echo $cell_phone  ?>" />
    <br />
 
	Email:<br />
  
   <input name="email" type="text" id="email" size="70" value="<?php echo $email  ?>" />
   <br />
        
 	Address 1:<br />
    
    <input name="address1" type="text" id="address1" size="70" value="<?php echo $address1  ?>" />
    <br />
  
    Address 2:<br />
   
    <input name="address2" type="text" id="address2" size="70" value="<?php echo $address2  ?>" />
    <br />
 
    Zip:<br />
  
    <input name="zip" type="text" id="zip" size="70" value="<?php echo $zip  ?>" />
   	<br />
  
    State:<br />
  
    <input name="state" type="state" id="phone" size="70" value="<?php echo $state  ?>" />
    <br /><br />
    <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
   
	<input type="submit" name="button" id="button" value="Edit This Client" />
    </form>
    
 	 </div>

    
    
  </tr>
  </table>
  
  
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>