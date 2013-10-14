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
// Gather this product's full information for inserting automatically into the edit form below on page
if (isset($_GET['cid'])) {
	$targetID = $_GET['cid'];
    $sql = mysql_query("SELECT * FROM cliente WHERE id='$targetID' LIMIT 1");
    $client_count = mysql_num_rows($sql); // c0-=ount the output amount
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
<title>Client Info</title>
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
  	<h2>Client Info:</h2>
    
    <form>
	
	Company ID        : <?php echo $targetID; ?>
    <br />
  
   	Company Name      : <?php echo $company_name  ?>
    <br />
  
    Contact first name:	<?php echo $contact_first_name  ?>
    <br />
  
    Contact last name : <?php echo $contact_last_name  ?>
    <br />
  
    Username          :  <?php echo $username  ?>
     <br />
     
    Password          : <?php echo $password  ?>
 	<br />
  
    Phone             : <?php echo $phone  ?>
 	<br />
  
    Cell phone        : <?php echo $cell_phone  ?>
    <br />
 
	Email             : <?php echo $email  ?>
   <br />
        
 	Address 1         : <?php echo $address1  ?>
    <br />
  
    Address 2         : <?php echo $address2  ?>
    <br />
 
    Zip               : <?php echo $zip  ?>
   	<br />
  
    State             : <?php echo $state  ?>
    <br />
   
	
    </form>
    
 	 </div>

    
    
  </tr>
  </table>
  
  
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>