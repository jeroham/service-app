<?php
            include_once("header.php");

            function __autoload($class_name) {
                include $class_name . '.php';
            }
            
            //Tests for data and classes
            
			$detail = new TicketdetailData();
			$list = $detail->Search();
			if(isset($detail)){
				echo "ok detail";
			}
			if(isset($list)){
				echo "ok list";
			}
			
			$w =  $list->fetch();
			echo  "Row: $w";
			exit();
			
            $employee1 = new EmployeeData();
            $employee1->first_name = "Keila";
            $employee1->last_name = "Mafufa";
            //$employee1->employeeid = 11;
            $employee1->last_log_date = null;
            $employee1->username = "mafufa2";


            $employee1->Save();
            echo "<br>Success: ".$employee1->employeeid;
            
            
            $employee1 = new EmployeeData();
			
		echo '<select name="customerid" id="customerid"  > ';
		echo '<option value="0">-select a customer-</option>'; 
		$customer1 = new CustomerData();
		$list = $customer1->Search();
		
		while($c = $list->fetch()){ 
			echo '<option value="'. $c["customerid"].'">'. $c["company_name"].'-'. $c["contact_first_name"] . ' ' .  $c["contact_last_name"].'</option>'; 
		}
	
	echo '</select><input type="button" onclick="window.open(\'../admin_area/client_edit.php?action=new\',\'\')" value="Add Customer" />';

$query = "SELECT * FROM employee";// WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1"; // query the person

$results = $employee1->Query($query);
echo "<br />Results: ".$results->rowCount();



          //  } else {
          //     echo "<br>Failure";
          //  }
            //auto generate classes , will overwrite existing files!
            
/*
            $d = new DBCon();
            $d->GenerateClasses("customer");
            $d->GenerateClasses("employee");//has other data
            $d->GenerateClasses("equipment");
            $d->GenerateClasses("equipmenttype");
            $d->GenerateClasses("invoice");
            $d->GenerateClasses("invoicedetail");
            $d->GenerateClasses("schedule");
            $d->GenerateClasses("service");
            $d->GenerateClasses("ticket");
            $d->GenerateClasses("ticketdetail");
            $d->GenerateClasses("timesheet");
             */  
            include_once("footer.php");
            ?>