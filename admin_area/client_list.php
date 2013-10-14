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
// Delete client Question to Admin, and Delete client if they choose
if (isset($_GET['delete_id'])) {
	echo 'Do you really want to delete Client with ID of ' . $_GET['delete_id'] . '? <a href="client_list.php?yes_delete='. $_GET['delete_id'] . '">Yes</a> | <a href="client_list.php">No</a>';
	exit();
}
if (isset($_GET['yes_delete'])) {
	// remove item from system and delete its picture
	// delete from database
	$id_to_delete = $_GET['yes_delete'];
	$sql = mysql_query("DELETE FROM cliente WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error());
	
	header("location: client_list.php"); 
    exit();
}
?>


<?php 
$client_list = "";
$sql= mysql_query("SELECT * FROM cliente");
$client_count = mysql_num_rows($sql); // count the output amount
if ($client_count > 0) {
	
		while($row = mysql_fetch_array($sql)){ 
             $id = $row["id"];
			 $company_name = $row["company_name"];
			 $phone = $row["phone"];
			 $email = $row["email"];
			 $client_list .= " <a href='client_info.php?cid=$id'>ID:</a> $id - Company Name: $company_name - Phone#: $phone - Email: $email &nbsp; &nbsp; <a href='client_edit.php?cid=$id'>Edit</a> &bull; <a href='client_list.php?delete_id=$id'>Delete</a> <br />";
    }
} else {
	$client_list = "You have no products listed in your store yet";
}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Client List</title>
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
    
	<div align="right" style="margin-right:25px;"><a href="add_new_client.php">Add New Client</a></div>
    
<div align="left" style="margin-left: 25px;">
  <h2>Client List</h2>
	
	<?php echo $client_list; ?>
    
  </div>

    
    </td>
  </tr>
  </table>
  
  
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>