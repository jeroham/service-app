<?php   
include "../scripts/connect_to_mysql.php";
session_start(); 
session_destroy(); 
header("location: ".$root);

exit();echo "You have successfully logged out.  <a href=".$root.">Click here to login again.</a>";
?>;


