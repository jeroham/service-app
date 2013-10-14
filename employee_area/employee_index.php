<?php 
session_start();
//load classes automagically
 function __autoload($class_name) {
    include "../".$class_name . '.php';
}

if (false){//!isset($_SESSION["employee"])) {
    header("location: employee_login.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$employeeID = preg_replace('#[^0-9]#i', '', $_SESSION["employeeid"]); // filter everything but numbers and letters
$employee = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["employee"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
$employee1 = new EmployeeData();
$employee1->username = $manager;
$employee1->password = $password;

if (!$employee1->CheckLogin(true)) {
 echo "Your login session data is not on record <a href= http://localhost:8888/Joel/ >Click Here</a>.";
 exit();
}
$employee1->Get($employeeID);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Admin Area</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("../header.php");?>
 <div id="Page_Content">
  
  <table width="100%" height="174" border="1" cellpadding="1">
  <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF"><p>&nbsp;</p></td>
    <td width="83%"><h2>Hello employee, what would you like to do today?</h2>
     
  </tr>
       </tr>
      <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>Open tickets:</h3></td>
    <td width="83%">
       <ul>
          <!--<li><a href="#" >Sample: Router problems - Laboratorio Clínico Borínquen</a></li>  --> 
		  <?
				$services = $employee1->GetTickets();
				foreach($services as $s){
					echo '<li><a href="#?ticketid='. $s["ticketid"] .'" >'. $s["description"].' - '. $s["client_company"].'</a></li>';
				}
				if($services->length == 0){
					echo '<li>No tickets open.</li>';
				}
		  ?>
      </ul>
  </tr>
      
       </tr>
      <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>Actions:</h3></td>
    <td width="83%">
        <ul>
          <li><a href="new_employee_ticket.php" >Create new ticket</a></li>
          <li><a href="#" >Create new troubleshooting guide</a></li>
          <li><a href="../admin/employee_edit.php?employeeid=<? echo $employeeID; ?>$action=myinfo" >Update my information</a></li>
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