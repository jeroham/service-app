<?php
session_start();

//load classes automagically
function __autoload($class_name) {
    include "../" . $class_name . '.php';
}

//logged in?
if (false) {
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

    if (false) {//!$employee1->CheckLogin(true)) {
        echo "Your login session data is not on record <a href='../'>Click Here</a>.";
        exit();
    }
}
//get action if any
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
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
$ticket1->ticketid = 0;
if (isset($_SESSION['ticket'])) {
    $ticket1 = new TicketData(json_decode($_SESSION['ticket']));
    echo "restored, details: " . $_SESSION['ticket'];
    $list = $ticket1->GetDetails();
}


// Gather this tickets's full information for inserting automatically into the edit form below on page
if (isset($_GET['ticketid']) & ($action == 'view' | $action == 'edit')) {
    $targetID = $_GET['ticketid'];
    $ticket1 = new TicketData();
    $ticket1->Get($targetID);
}
//get values from UI
if (isset($_POST['description']))
    $ticket1->description = $_POST['description'];
if (isset($_POST['employeeid']))
    $ticket1->employeeid = ($_POST['employeeid']);
if (isset($_POST['customerid']))
    $ticket1->customerid = ($_POST['customerid']);
if (isset($_POST['status']))
    $ticket1->status = ($_POST['status']);
if (isset($_POST['ticketid']))
    $ticket1->ticketid = ($_POST['ticketid']);

//add detail when receiving data from popup
if ($action = "editdetail") {
    $detailindex = ($_GET['index']);
    $detail = $ticket1->GetDetail($detailindex);
    $detail->ticketid = $ticket1->ticketid;
    $detail->equipmentid = ($_GET['equipmentid']);
    $detail->employeeid = ($_GET['employeeid']);
    $detail->serviceid = ($_GET['serviceid']);
    $detail->description = ($_GET['description']);
} 

  
    $detail = new TicketdetailData();
    $detail->ticketid = $ticket1->ticketid;
    $detail->equipmentid = 1;
    $detail->employeeid = 2;
    $detail->serviceid = 1;
    $detail->description = "Detalle de ejemplo";
    $ticket1->AddDetail($detail);
    
     $detail = new TicketdetailData();
    $detail->ticketid = $ticket1->ticketid;
    $detail->equipmentid = 1;
    $detail->employeeid = 2;
    $detail->serviceid = 1;
    $detail->description = "Detalle de ejemplo2";
    $ticket1->AddDetail($detail);
    
// Parse the form data and add Ticket to the system
if (isset($_POST['ticketid']) &
        $action == "save") {

    $ticketid = ($_POST['ticketid']);
    if ($ticketid != 0) {
        $ticket1->Get($ticketid); //load
    }

    $result = $ticket1->Save();
    if ($result > 0) {
        //$sql = mysql_query("UPDATE customere SET company_name='$company_name', Ticket_first_name='$ticket_first_name', Ticket_last_name='$ticket_last_name', username='$username', password='$password' , phone='$phone', cell_phone='$cell_phone', email='$email', address1='$address1', address2='$address2', zip='$zip', state='$state'  WHERE id='$cid'");
        header("location: employee_index.php");
        // exit();
    } else {
        echo "Error: " . $result;
    }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="generator" content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Ticket Edit</title>
        <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
        <script language="javascript" src="../js/jquery.js"></script>

        <script language="javascript">
            var win;
            var details = [];
            var employeelist = [];
            var servicelist = [];
            var equipmentlist= [];
<?php
//load details here
    $details = "";
    
    $list = $ticket1->GetDetails();
    foreach ($list as $d){
        $details.= json_encode($d).",";
    }
    echo "details = [$details];";
    echo "\nvar ticketid = ".($ticket1->ticketid!=""?$ticket1->ticketid:0).";\n";
    
    $employees = new EmployeeData();
    $list = $employees->Search('employeeid,first_name,last_name', "1=1");
    while ($e = $list->fetch()) {
        echo 'employeelist.push({employeeid:'.$e["employeeid"] . ',';
        echo 'first_name:"' . $e["first_name"] . '",last_name:"' . $e["last_name"] . '"});';
        }
    
    $customer = new CustomerData($ticket1->customerid);
    $list = $customer->GetServicesList();
    foreach ($list as $e) {
        echo 'servicelist.push({serviceid:'.$e->serviceid . ',';
        echo 'description:"' . $e->description . '"});';
        }
    
    $list = $customer->GetEquipmentList();
     foreach ($list as $e) {
        echo 'equipmentlist.push({equipmentid:'.$e->equipmentid . ',';
        echo 'description:"' . $e->GetDescription() . '"});';
        }
    
?>
            function DetailPopUp(index) {
                win = window.open('ticket_detail.php?detailindex=' + index);
                win.ddone = addDetail;

            }

            function addDetail() {

                var index = $(win.document).find('#detail_index').val();
                var equipmentid = $(win.document).find('#detail_equipmentid').val();
                var serviceid = $(win.document).find('#detail_serviceid').val();
                var employeeid = $(win.document).find('#detail_employeeid').val();
                var description = $(win.document).find('#detail_description').val();
                
                win.close();
                win = null;
                if(index === -1){
                    details.push({
                        ticketdetailid: 0,
                        ticketid:  ticketid,
                        equipmentid : equipmentid,
                        serviceid : serviceid,
                         employeeid : employeeid,
                        description : description
                    });
                }else{
                    details[index].equipmentid = equipmentid;
                    details[index].serviceid = serviceid;
                    details[index].employeeid = employeeid;
                    details[index].description = description;
                   
                }

            }
            
         function  addNewDetail(){
             
         }
         function employeeDropDown(id){
            var html = "";
            html += '<select name="employeeid" >';
            for(var i=0;i<employeelist.length;i++){
                html += '<option value="' + employeelist[i].employeeid + '" ';
                if (id === employeelist[i].employeeid) {
                    html+= "SELECTED";
                }
                html+= '>' + employeelist[i].first_name + ' ' + employeelist[i].last_name
                        + '</option>';
            }
            html+= "</select>";
            return html;
         }
         
         function serviceDropDown(id){
            var html = "";
            html += '<select name="serviceid" >';
            for(var i=0;i<servicelist.length;i++){
                html += '<option value="' + servicelist[i].serviceid + '" ';
                if (id === servicelist[i].serviceid) {
                    html+= "SELECTED";
                }
                html+= '>' + servicelist[i].description 
                        + '</option>';
            }
            html+= "</select>";
            return html;
         }
         
         function equipmentDropDown(id){
            var html = "";
            html += '<select name="equipmentid" >';
            for(var i=0;i<equipmentlist.length;i++){
                html += '<option value="' + equipmentlist[i].equipmentid + '" ';
                if (id === equipmentlist[i].equipmentid) {
                    html+= "SELECTED";
                }
                html+= '>' + equipmentlist[i].description
                        + '</option>';
            }
            html+= "</select>";
            return html;
         }
         
         function  refreshDetails(){
             
             var html = "";
             alert(details.length);
            // $('#tdetail_body').html(html);
             for(var i=0;i<details.length;i++){
                html += "<tr><td><input type='button' value='edit' onclick='DetailPopUp("+ details[i].index +")'/></td>";
                html += "<td>"+employeeDropDown(details[i].employeeid)+"</td>";
                html += "<td>"+serviceDropDown(details[i].serviceid)+"</td>";
                html += "<td>"+equipmentDropDown(details[i].equipmentid)+"</td>";
                html += "</tr><td style='text-align:center'><b>Description:</b></td><td colspan='3'><textarea id='detail_description_"+details[i].ticketdetailid+"'> "+details[i].description+"</textarea></td></tr>";
                //$('#tdetail_body').append(html);
             }
             alert(html);
              $('#tdetail_body').html(html);
         }
         
       
        $(document).ready(function(){
            
        
        });

        </script>
    </head>

    <body>
        <div align="center" id="mainWrapper">
            <?php
            //include_once("../header.php");
            ?>

            <div id="Page_Content">
                <table width="100%" height="265" border="1" cellpadding="1">
                    <tr>
                        <td width="9%" bgcolor="#E7F7FF">
                            <h5><a href="admin_index.php">Back</a></h5>

                            <h5><a href="log_out.php">Log Out</a></h5>
                        </td>

                        <td width="91%" height="124" colspan="2" valign="top">
                            <div align="left" style="margin: 25px;">
                                <h2>Edit Ticket</h2>

                                <form action="#" enctype="multipart/form-data" name="add_new_Ticket_form" id=
                                      "add_new_Ticket_form" method="post">
                                    Customer:<br />
                                    <select name="customerid" id="customerid">
                                        <?php
                                        echo '<option value="0">-select a customer-</option>';
                                        $customer1 = new CustomerData();
                                        $list = $customer1->Search();

                                        while ($c = $list->fetch()) {
                                            echo '<option value="' . $c["customerid"] . '" ';
                                            if ($ticket1->customerid == $c["customerid"]) {
                                                echo "SELECTED";
                                            }
                                            echo '>' . $c["company_name"] . ' [' . $c["contact_first_name"] . ' ' . $c["contact_last_name"] . ']</option>';
                                        }
                                        ?>
                                    </select><input type="button" onclick="window.open('../admin_area/client_edit.php?action = new' ,'' )"
                                                    value="Add Customer" /><br />
                                    Employee:<br />
                                    <select name="employeeid" />
                                    <?php
                                    $employees = new EmployeeData();
                                    $list = $employees->Search('employeeid,first_name,last_name', "1=1");
                                    while ($e = $list->fetch()) {
                                        echo '<option value="' . $e["employeeid"] . '" ';
                                        if ($ticket1->employeeid == $e["employeeid"]) {
                                            echo "SELECTED";
                                        }
                                        echo '>' . $e["first_name"] . ' ' . $e["last_name"] . '</option>';
                                    }
                                    echo "</select><br/>";
                                    ?>
                                    Description:<br />
                                    <input name="description" type="text" id="description" size="70" value=
                                           "<?php echo $ticket1->description ?>" /><br />
                                    Status:<br />
                                    <select name="status" id="status">
                                        <?php
                                        echo '<option value="OPEN" ' . ($ticket1->status == "OPEN" ? " SELECTED " : "") . '>OPEN</option>';
                                        echo '<option value="CLOSED" ' . ($ticket1->status == "CLOSED" ? " SELECTED " : "") . '>CLOSED</option>';
                                        ?>
                                    </select>

                                    <br /> 
                                    Details:

                                    <div class="detail" style="display:block;border:thin solid navy;width:100%">
                                        <table id="tdetail" name="tdetail" class="table-detail" border="1" style="width:100%">
                                            <thead>
                                                <tr class="table-detail-header"><th>Actions</th><th>Employee</th><th>Service</th><th>Equipment</th></tr>
                                            </thead>
                                            <tbody id="tdetail_body">
                                                <?php
                                               /* $list = $ticket1->GetDetails();

                                                if (sizeof($list) == 0) {
                                                    echo '<tr class="table-detail-row"><td><input type="button" value="Add" onclick="DetailPopUp(-1)"></td>';
                                                    echo '<td><select name="detail_employeeid" />';
                                                    $employees = new EmployeeData();
                                                    $list = $employees->Search('employeeid,first_name,last_name', "1=1");
                                                    while ($e = $list->fetch()) {
                                                        echo '<option value="' . $e["employeeid"] . '">' . $e["first_name"] . " " . $e["last_name"] . "</option>";
                                                    }
                                                    echo "</select>";

                                                    echo '<td><input type="text" name="detail_serviceid" /></td>';
                                                    echo '<td><input type="text" name="detail_equipmentid" /></td>';
                                                    echo '<tr class="table-detail-row"><td colspan="4">Description: <input type="text" name="detail_description" /></td> ';
                                                } else {
                                                    foreach ($list as $d) {
                                                        echo '<tr class="table-detail-row"><td><input type="button" id="' . $d->ticketdetailid . '" value="Edit"><input type="button" value="Delete"></td>';
                                                        echo '<td>' . $d->GetEmployee()->employeename . '</td>';
                                                        echo '<td>' . $d->GetService()->servicename . '</td>';
                                                        echo '<td>' . $d->GetEquipment()->equipment . '</td>';
                                                        echo '<tr class="table-detail-row"><td colspan="4">Description: ' . $d->description . '</td> ';
                                                    }
                                                }*/
                                                ?>
                                            </tbody>
                                        </table>
                                    </div><br />
                                    <br />
                                    <input name="action" type="hidden" value="save" />
                                    <input name="ticketid" type="hidden" value="<?php echo $ticket1->ticketid; ?>" />
                                    <input type="submit" name="button1" id="button" value="Save" /> 


                                    <input type="button" onclick="confirm('Delete this Ticket?')" name=
                                           "btnDelete" id="button2" class="delete_button" value="Delete" />
                                    <input type="button" onclick="showMe()" name=
                                           "btnDelete" id="button3" class="delete_button" value="Show" />
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
?>
        </div>
    <?php 
    echo "<script>refreshDetails();</script>";
    ?>
    </body>
</html>
