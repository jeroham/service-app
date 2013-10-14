<?php

// Connect to the MySQL database  
require "connect_to_mysql.php";  

$sqlCommand = "CREATE TABLE admin (
		 		 admin_id  int(11) NOT NULL auto_increment,
		 		 first_name varchar(30) NOT NULL,
		 		 last_name varchar(30) NOT NULL,
				 username varchar(25) NOT NULL,
		 		 password varchar(15) NOT NULL,
		 		 phone int(10) NOT NULL,
				 cell_phone int(10) NULL,
				 email varchar(50) NOT NULL,
				 address1 varchar(50) NOT NULL,
				 address2 varchar(50)  NULL,
				 zip int(5) NOT NULL,
				 state varchar(2) NOT NULL,
		 		 last_log_date date NOT NULL,
		 		 PRIMARY KEY (admin_id),
		 		 UNIQUE KEY username (username)
		 		 ) ";
if (mysql_query($sqlCommand)){ 
    echo "Your admin table has been created successfully!"; 
} else { 
    echo "CRITICAL ERROR: admin table has not been created.";
}
?>