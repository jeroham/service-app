<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Home</title>

        <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />

    </head>

    <body>

        <div align="center" id="main div">

            <?php
            include_once("header.php");

            function __autoload($class_name) {
                include $class_name . '.php';
            }
            ?>


            <div id="Page_Content">

                <table width="100%" height="174" border="1" cellpadding="1">
                    <tr>
                        <td width="17%" height="133" bgcolor="#E7F7FF"><p>&nbsp;</p></td>
                        <td width="83%">Welcome to the service system for OWC Computer and Network Solutions.
                            <br />Please select client, employee or admin login from the menu.
                        </td>
                    </tr>
                </table>


            </div>

            //Tests for data and classes
            <?php
            $employee1 = new EmployeeData();
            $employee1->first_name = "Pepe";
            $employee1->last_name = "Rodriguez";
            $employee1->employeeid = 2;
            $employee1->last_log_date = null;



            if ($employee1->Save()) {
                echo "<br>Success";
            } else {
                echo "<br>Failure";
            }
            //$d = new DBCon();
            //$d->GenerateClass("customer");

            include_once("footer.php");
            ?>
        </div>

    </body>
</html>