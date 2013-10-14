<?php 
session_start();
if (false){//!isset($_SESSION["client"])) {
    header("location: client_login.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$clientID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$client = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["client"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database  
include "../scripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM cliente WHERE id='$clientID' AND username='$client' AND password='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
//$existCount = mysql_num_rows($sql); // count the row nums
if (false){//   $existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record <a href=".$root." >Click Here</a>.";
     exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>client Area</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("../header.php");?>
  <div id="Page_Content">
  
  <table width="100%" height="174" border="1" cellpadding="1">
  <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF"><p>&nbsp;</p></td>
    <td width="83%">
        <h2>Hello client, what would you like to do today?</h2>
     
<!--        <p><a href="#">Request</a><br />
      <a href="#">Algo2  </a></p>&nbsp;</td>-->
  </tr>
      <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>Open tickets:</h3></td>
    <td width="83%">
       <ul>
          <li><a href="#" >Router problems</a></li>
      </ul>
  </tr>
      
       </tr>
      <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>Actions:</h3></td>
    <td width="83%">
        <ul>
          <li><a href="#" >Create new ticket</a></li>
          <li><a href="#" >View and pay invoices</a></li>
          <li><a href="#" >Troubleshoot an equipment</a></li>
      </ul>
          
  </tr>
        <tr>
                        <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>System:</h3></td>
                        <td width="83%">
                            <ul>
                                 <li><a href="<?echo $root;?>/scripts/log_out.php">Logout</a></li>

                            </ul>

                    </tr>
</table>
      
    
  </div>
  <?php include_once("../footer.php");?>
</div>
</body>
</html>