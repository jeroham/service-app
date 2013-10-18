<?php 
session_start();

//load classes automagically
 function __autoload($class_name) {
    include "../".$class_name . '.php';
}

//logged in?
if (false){
        !isset($_SESSION["manager"]);
    header("location: admin_login.php"); 
    exit();

	// Be sure to check that this manager SESSION value is in fact in the database

	$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
	$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
	$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
	// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
	$employee1 = new EmployeeData();
    $employee1->username = $manager;
    $employee1->password = $password;
    
    if (false){//!$employee1->CheckLogin(true)) {
		echo "Your login session data is not on record <a href= http://localhost:8888/Joel/ >Click Here</a>.";
		 exit();	 
	}
}
//get action if any
if(isset($_POST['action'])){
        $action = $_POST['action'];	
} else{
        $action = 'view';
}


/*
if (!isset($ticket1) )
{	echo "Ticket is not set";
	$ticket1 = new TicketData();
}
else 
	echo "Ticket is set";
	
if (sizeof($_POST)==0)
{	echo "Post is not set";
	
}
else 
	echo "Post is set";	
	*/
//testing object persistence
$ticket1 = new TicketData();
if(isset($_SESSION['ticket'])){
	$ticket1 = new TicketData(json_decode($_SESSION['ticket']));
	$list = $ticket1->GetDetails();
	echo "restored, details: ". $_SESSION['ticket'];	
	echo "";
}
$detailindex = 0;
$detail = new TicketdetailData();

if(isset($_GET['detailindex'])){
	$detailindex = $_GET['detailindex'];
	if($detailindex > 0 ){
		$detail = $ticket1->GetDetail($detailindex);
	} else{  //new detail
		$ticket1->AddDetail($detail);
	}
	
}else{
		//index should be mandatory even if it is 0
		echo "<div style='color:red;border: thin;'>Error, detail index must be given.</div>";
		exit();
}

if($action == "save"){
	
	 $detail->ticketid = $ticket1->ticketid;
	$detail->equipmentid = ($_POST['detail_equipmentid']);
	$detail->employeeid = ($_POST['detail_employeeid']);
	$detail->serviceid = ($_POST['detail_serviceid']);
	$detail->description = ($_POST['detail_description']);
	
	//$ticket1->Adddetail($detail);
	$list = $ticket1->GetDetails();
	echo "saved, details: ". sizeof($list);

}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>Ticket Detail Edit</title>
  <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
 
  <script language="javascript">
		var ddone;
			
	
	
  </script>
</head>

<body>
  <div align="center" id="mainWrapper">
    <?php 
      //include_once("../header.php");
      ?>

    <div id="Page_Content">
              <h2>Edit Ticket Detail</h2>

              <form action="#" enctype="multipart/form-data" name="add_new_Ticket_form" id=
              "add_new_Ticket_form" method="post">

                <div class="detail" style="display:block;border:thin solid navy;width:100%">
				<form method="POST" action="#">
                  
				  <?php
					
						  echo '<h4>Employee</h4><select name="detail_employeeid" />';
						   $employees = new EmployeeData();
						   $list = $employees->Search('employeeid,first_name,last_name',"1=1");
						   while($e = $list->fetch()){
								echo '<option value="'.$e["employeeid"].'" '. ($detail->employeeid == $e["employeeid"]  ? "SELECTED": "") .'  >'.$e["first_name"]." ".$e["last_name"]. "</option>";
						  }
						  echo "</select>";
						  
						  echo '<h4>Service</h4><input type="text" name="detail_serviceid" value="'.$detail->serviceid.'" />'; 
						  echo '<h4>Equipment</h4><input type="text" name="detail_equipmentid"  value="'.$detail->equipmentid.'" />'; 
						  echo '<h4>Description</h4><input type="text" name="detail_description" id="detail_description"  value="'.$detail->description.'" />'; 

				  
				  ?>
				
                </div><br />
                <br />
                <input name="action" type="hidden" value="save" />
				<input name="ticketid" type="hidden" value="<?php echo $ticket1->ticketid; ?>" />
				<input name="ticketdetailid" type="hidden" value="<?php echo $detail->ticketdetailid; ?>" />
				<input type="submit" name=
                "button" id="button" value="Save" /> 
				<input type="button" onclick="confirm('Delete this Ticket Detail?')" name=
                "btnDelete" id="button" class="delete_button" value="Delete" />
				<input type="button" onclick="ddone()" name=
                "btnDelete2" id="button" class="delete_button" value="Done" />
              </form>
            </div>
          </td>
        </tr>
      </table>
    </div>
	<?php 
		include_once("../footer.php");
		//cleanup and save state
	$_SESSION['ticket'] = json_encode($ticket1);
	echo "<br>Serialized value: ".$_SESSION['ticket'] ;
		?>
  </div>
</body>
</html>
