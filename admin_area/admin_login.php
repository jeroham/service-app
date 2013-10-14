<?php 
session_start();
if (isset($_SESSION["manager"])) {
    header("location: admin_index.php"); 
    exit();
}
//load classes automagically
 function __autoload($class_name) {
    include "../" . $class_name . '.php';
}

?>
<?php 
// Parse the log in form if the user has filled it out and pressed "Log In"
if (isset($_POST["username"]) && isset($_POST["password"])) {
    
    $manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); // filter everything but numbers and letters
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]); // filter everything but numbers and letters 
    // Connect to the MySQL database  
    //include "../scripts/connect_to_mysql.php"; 
    //$sql = mysql_query("SELECT id FROM employee WHERE username='$manager' AND password='$password' AND roles like '%manager%' LIMIT 1"); // query the person
    // ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
    //$existCount = mysql_num_rows($sql); // count the row nums
    $employee1 = new EmployeeData();
    $employee1->username = $manager;
    $employee1->password = $password;
    
    if ($employee1->CheckLogin(true)) { // evaluate the count
	     
		 $_SESSION["id"] =$employee1->employeeid;
		 $_SESSION["manager"] = $manager;
		 $_SESSION["password"] = $password;
		 header("location: admin_index.php");
         exit();
    } else {
		echo 'That information is incorrect, try again <a href="#">Click Here</a>';
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Log In </title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="main div">

  <?php include_once("../header.php");?>
  
  <div id="Page_Content">
  
  <table width="100%" height="174" border="1" cellpadding="1">
  <tr>
    <td width="17%" height="133" bgcolor="#E7F7FF">&nbsp;</td>
    <td width="83%"><h2>Welcome Boss Please Log In </h2>
      <form id="form1" name="form1" method="post" action="admin_login.php">
        User Name:<br />
          <input name="username" type="text" id="username" size="40" />
        <br /><br />
        Password:<br />
       <input name="password" type="password" id="password" size="40" />
       <br />
       <br />
       <br />
       
         <input type="submit" name="button" id="button" value="Log In" />
       
      </form>&nbsp;</td>
  </tr>
</table>
  
  
  </div>
  
   <?php include_once("../footer.php");?>
</div>
</body>
</html>