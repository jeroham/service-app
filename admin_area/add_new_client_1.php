<?php
session_start();

//this function loads all classes automatically *** jos
function __autoload($class_name) {
    include $class_name . '.php';
}

if (false) {//!isset($_SESSION["manager"])) {
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
//$existCount = mysql_num_rows($sql); // count the row nums
if (false) {//$existCount == 0) { // evaluate the count
    echo "Your login session data is not on record <a href= http://localhost:8888/Joel/ >Click Here</a>.";
    exit();
}
//Customer main object  *** jos
$customer1 = new CustomerData();
?>



<?php
// Parse the form data and add client system
if (isset($_POST['company_name'])) {

    //update the object properties
    $customer1->company_name = mysql_real_escape_string($_POST['company_name']);
    $customer1->contact_first_name = mysql_real_escape_string($_POST['contact_first_name']);
    $customer1->contact_last_name = mysql_real_escape_string($_POST['contact_last_name']);
    $customer1->username = mysql_real_escape_string($_POST['username']);
    $customer1->password = mysql_real_escape_string($_POST['password']);
    $customer1->phone = mysql_real_escape_string($_POST['phone']);
    $customer1->cell_phone = mysql_real_escape_string($_POST['cell_phone']);
    $customer1->email = mysql_real_escape_string($_POST['email']);
    $customer1->address1 = mysql_real_escape_string($_POST['address1']);
    $customer1->address2 = mysql_real_escape_string($_POST['address2']);
    $customer1->zip = mysql_real_escape_string($_POST['zip']);
    $customer1->state = mysql_real_escape_string($_POST['state']);

    // See if that product name is an identical match to another product in the system
    $clientMatch = $customer1->CheckExisting(); //mysql_num_rows($sql); // count the output amount
    if ($clientMatch > 0) {
        echo 'Sorry you tried to place a duplicate client into the system, <a href="add_new_client.php">click here</a>';
        exit();
    }
    // Add this product into the database now
    //Save the object
    $customer1 . Save();

    header("location: client_list.php");
    exit();
}
?>




<?php
$client_list = "";
$sql = mysql_query("SELECT * FROM cliente");
$client_count = mysql_num_rows($sql); // count the output amount
if ($client_count > 0) {

    while ($row = mysql_fetch_array($sql)) {
        $id = $row["id"];
        $client_list .= "$id <br />";
    }
} else {
    $product_list = "You have no products listed in your store yet";
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
<?php include_once("../header.php"); ?>
            <div id="Page_Content">

                <table width="100%" height="265" border="1" cellpadding="1">
                    <tr>
                        <td width="9%" bgcolor="#E7F7FF">

                            <h5><a href= "http://localhost:8888/Joel/admin_area/admin_index.php" >Back</a></h5>

                            <h5><a href= "http://localhost:8888/Joel/scripts/log_out.php" >Log Out</a></h5></td>
                        <td width="91%" height="124" colspan="2" valign="top">



                            <div align="left" style="margin: 25px;">
                                <h2>Add New Client</h2>

                                <form action="add_new_client.php" enctype="multipart/form-data" name="add_new_client_form" id="add_new_client_form" method="post">



                                    Company Name:<br />

                                    <input name="company_name" type="text" id="company_name" size="70" />
                                    <br />

                                    Contact first name:<br />	

                                    <input name="contact_first_name" type="text" id="contact_first_name" size="70" />
                                    <br />

                                    Contact last name:<br />

                                    <input name="contact_last_name" type="text" id="contact_last_name" size="70" />
                                    <br />

                                    Username:<br />

                                    <input name="username" type="text" id="username" size="70" />
                                    <br />

                                    Password:<br />

                                    <input name="password" type="text" id="password" size="70" />
                                    <br />

                                    Phone:<br />

                                    <input name="phone" type="text" id="phone" size="70" />
                                    <br />

                                    Cell phone:<br />

                                    <input name="cell_phone" type="text" id="cell_phone" size="70" />
                                    <br />

                                    Email:<br />

                                    <input name="email" type="text" id="email" size="70" />
                                    <br />

                                    Address 1:<br />

                                    <input name="address1" type="text" id="address1" size="70" />
                                    <br />

                                    Address 2:<br />

                                    <input name="address2" type="text" id="address2" size="70" />
                                    <br />

                                    Zip:<br />

                                    <input name="zip" type="text" id="zip" size="70" />
                                    <br />

                                    State:<br />

                                    <input name="state" type="state" id="phone" size="70" />
                                    <br /><br />

                                    <input type="submit" name="button" id="button" value="Add This Client" />
                                </form>

                            </div>



                    </tr>
                </table>


            </div>
<?php include_once("../footer.php"); ?>
        </div>
    </body>
</html>