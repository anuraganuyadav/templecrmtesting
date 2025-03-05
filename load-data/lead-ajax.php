<?php
require_once('../inc/config.php');
require_once '../inc/session.php';
$user_name = $_SESSION['user_name'];
if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 2) {

  header("Location:index.php");
}


//use any post value for subbmission if empty submission not work  
$sl_Status = filter_var($_POST["searchByStatus"]);
$sl_Fdate = filter_var($_POST["searchByFdate"]);
$sl_Ldate = filter_var($_POST["searchByLdate"]);
$userID = filter_var($_SESSION["userID"]);
$sl_DateWise = filter_var($_POST["searchByDateWise"]);
$sl_BeforeDate = filter_var($_POST["searchByBeforeDate"]);
$sl_Destination = filter_var($_POST["searchByDestination"]);



$dest = "SELECT * FROM `filter` WHERE userID='$userID'";
$data = mysqli_query($conn, $dest);
$count = mysqli_num_rows($data);

// condition 1  
if ($count != 1) {
  if (mysqli_query($conn, "INSERT INTO filter (sl_Destination, userID, sl_Status,sl_DateWise,sl_BeforeDate, sl_Fdate, sl_Ldate) VALUES ($sl_Destination,'$userID','$sl_Status','$sl_DateWise', '$sl_BeforeDate', '$sl_Fdate', '$sl_Ldate')")) {
    // echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'> New  Filter Success </i> "; 
  }
}
//end condition 1 

// condition 2     
else if ($count == 1) {
  if (mysqli_query($conn, "UPDATE filter SET 	sl_Destination = '$sl_Destination' ,sl_Status = '$sl_Status' , sl_DateWise = '$sl_DateWise' , sl_BeforeDate = '$sl_BeforeDate', sl_Fdate = '$sl_Fdate', sl_Ldate = '$sl_Ldate' WHERE userID= $userID")) {
    //  echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'>  Filter Success </i> "; 
  }
}





## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page 
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
//$searchByDate = $_POST['searchByDate'];
$searchByStatus = $_POST['searchByStatus'];
$searchByDestination = $_POST['searchByDestination'];
$searchByBeforeDate = $_POST['searchByBeforeDate'];
$searchByDateWise = $_POST['searchByDateWise'];
$searchByFdate = $_POST['searchByFdate'];
$searchByLdate = $_POST['searchByLdate'];

## Search 
$searchQuery = " ";
// if($searchByDate != ''){
//     $searchQuery .= " and (emp_name like '%".$searchByDate."%' ) ";
// }

// search by detination
if ($searchByDestination != '') {
  $searchQuery .= " and (destination='" . $searchByDestination . "') ";
}
// serch status wise
if ($searchByStatus != '') {
  if ($searchByStatus == "Empty") {
    $searchQuery .= " and (last_response='') ";
  } else {
    $searchQuery .= " and (last_response='" . $searchByStatus . "') ";
  }
}
//search data under 2, 3, 5  days 
// condition if search date wise empty then auto date wise filter
if ($searchByBeforeDate != '') {
  if (empty($searchByDateWise)) {
    $searchQuery .= " and (TIMESTAMP(`date`) $searchByBeforeDate)";
  } else {
    $searchQuery .= " and (TIMESTAMP($searchByDateWise) $searchByBeforeDate)";
  }
}
// serch by bwtween date wise
if ($searchByFdate != '' && $searchByLdate != '') {
  if (empty($searchByDateWise)) {
    $searchQuery .= " and ( date >= '$searchByFdate' AND date <= '$searchByLdate')";
  } else {
    $searchQuery .= " and ( $searchByDateWise >= '$searchByFdate' AND $searchByDateWise <= '$searchByLdate')";
  }
}


if ($searchValue != '') {
  $searchQuery .= " and (name like '%" . $searchValue . "%' or 
        email like '%" . $searchValue . "%' or 
        mo_number like '%" . $searchValue . "%' or 
        name like'%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "select count(*) as allcount from lead  WHERE sales_person = '$user_name'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from lead WHERE sales_person = '$user_name' && 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// as desc order colom setting
$columns = array('name', 'email', 'mo_number', 'destination', 'no_person', 'date', 'last_activity', 'last_response');

## Fetch records
if (isset($_POST["order"])) {
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $columns[$_POST['columns'][$columnIndex]['data']]; // Column name set
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $order = "ORDER BY  $columnName  $columnSortOrder";
} else {
  $order = 'ORDER BY timestamp(date) DESC ';
}

$leadQuery = "select * from lead WHERE sales_person = '$user_name' && 1 " . $searchQuery . $order . " limit " . $row . "," . $rowperpage;


$leadRecords = mysqli_query($conn, $leadQuery);
$data = array();

while ($row = mysqli_fetch_assoc($leadRecords)) {
  $sub_array = array();
  $sub_array[] = '<a href="lead-view.php?lead=' . $row['id'] . '"  class="user">' . $row["name"] . '</a>';
  $sub_array[] = $row["email"];
  $sub_array[] = $row['mo_number'];

  //check destination if not mach
  if (empty($row['destination'])) {
    $sub_array[] = "<span class='date-data-break'> Add Destination </span>";
  } else {
    $dest =  mysqli_query($conn, "SELECT * FROM `destinations` WHERE 
         destinations_list = '" . $row['destination'] . "'");
    $count = mysqli_num_rows($dest);

    if ($count == 1) {
      $sub_array[] = "<span class='date-data-break text-success font-weight-bold'>" . $row['destination'] . "</span>";
    } else {
      $sub_array[] = "<span class='date-data-break text-danger font-weight-bold'>" . $row['destination'] . "(Change it) </span>";
    }
  };
  //end check destination if not mach
  
  $sub_array[] = $row['no_person'];
  $sub_array[] = "<span class='date-data-break '>" . date('d/M/Y, g;i A', strtotime($row['date'])) . "</span>";
  $sub_array[] = "<span class='date-data-break '>" . date('d/M/Y, g;i A', strtotime($row['last_activity'])) . "</span>"; 
  $sub_array[] = $row['last_response'];
  $data[] = $sub_array;
}

## lead
$lead = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($lead);
