<?php
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php");
    exit();
}
//load classes automagically
 function __autoload($class_name) {
                include "../".$class_name . '.php';
}

// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
$employee1 = new EmployeeData();
    $employee1->username = $manager;
    $employee1->password = $password;
    
    if (!$employee1->CheckLogin(true)) { // evaluate the count
        echo "Your login session data is not on record <a href=" . $root . " >Click Here</a>.";
        exit();
}
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
            <?php include_once("../header.php"); ?>
            <div id="Page_Content">


                <table width="100%" height="174" border="1" cellpadding="1">
                    <tr>
                        <td width="17%" height="133" bgcolor="#E7F7FF"><p>&nbsp;</p></td>
                        <td width="83%">
                            <h2>Hello manager, what would you like to do today?</h2>

                    </tr>
                    <tr>
                        <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>Employee Management</h3></td>
                        <td width="83%">
                            <ul>
                                <li><a href="employee_list.php" >Employee list</a></li>
                                <li><a href="employee_edit.php?action=new" >Create new employee </a></li>
                                <li><a href="#" >Create timesheet report</a></li>

                            </ul>
                    </tr>

                    </tr>
                    <tr>
                        <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>Client:</h3></td>
                        <td width="83%">
                            <ul>
                                <li><a href="client_list.php" >Client List</a></li>
                                <li><a href="add_new_client.php">Add New Client</a></li>
                                <li><a href="#" >Open Invoices</a></li>
                                <li><a href="#" >Generate Invoices</a></li>

                            </ul>

                    </tr>
                    <tr>
                        <td width="17%" height="133" bgcolor="#E7F7FF" style="text-align:right"><h3>System:</h3></td>
                        <td width="83%">
                            <ul>
                                <li><a href="#" >System settings</a></li>
                                <li><a href="#">Schedules</a></li>
                                <li><a href="<?echo $root;?>/scripts/log_out.php">Logout</a></li>

                            </ul>

                    </tr>
                </table>


            </div>
            <?php include_once("../footer.php"); ?>
        </div>
    </body>
</html>