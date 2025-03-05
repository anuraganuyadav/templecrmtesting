<?php
require_once('../inc/config.php');
require_once '../inc/session.php';
$user_name = $_SESSION['user_name'];

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {
  header("Location:index.php");
}
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page 
$searchValue = $_POST['search']['value']; // Search value


## Custom Field value


## Search 
$searchQuery = " ";

if ($searchValue != '') {
  $searchQuery .= " and (name like '%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "select count(*) as allcount from manage_sales_target ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from manage_sales_target WHERE 
 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// as desc order colom setting
$columns = array('name', 'target', 'id' ,'Fdate', 'Ldate', 'id');

## Fetch records
if (isset($_POST["order"])) {
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $columns[$_POST['columns'][$columnIndex]['data']]; // Column name set
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $order = "ORDER BY  $columnName  $columnSortOrder ";
} else if (!empty($searchByDateWise)) {
  $order = 'ORDER BY ' . $searchByDateWise . ' DESC ';
} else {
  $order = 'ORDER BY timestamp(date) DESC ';
}

$potentialQuery = "select * from manage_sales_target WHERE 1 " . $searchQuery . $order . " limit " . $row . "," . $rowperpage;


$potentialRecords = mysqli_query($conn, $potentialQuery);
$data = array();

while ($row = mysqli_fetch_assoc($potentialRecords)) {
  $sub_array = array();
  //get name 
  // $getuser = mysqli_query($conn, "select * from users where userID =" . $row['userID'] . "");
  // $getName = mysqli_fetch_array($getuser);

  $sub_array[] = $row['name'];
  $sub_array[] = "<span></span>Rs. " . number_format($row['target']);

  // days between date calculator 
  
  $startDateTime = strtotime($row['Fdate']);
  $endDateTime = strtotime($row['Ldate']);
  $timeDiff = abs($endDateTime - $startDateTime);
  $numberDays = $timeDiff/86400;  // 86400 seconds in one day
  // and you might want to convert to integer
  $numberDays = intval($numberDays); 

     //get minimum days
     date_default_timezone_set('Asia/Kolkata');      
     $times= date('Y/m/d'); 
     $today = strtotime($times);
     $end = strtotime($row['Ldate']);
     $dayDiff = abs($end - $today);
     $midays = $dayDiff / 86400;  // 86400 seconds in one day
    
     if($today>$end){
       $days = "<span class='text-danger ml-3'>Target End</span>";
     }
     else{
      $days = "<span class='text-danger ml-3'> You Have ". $midays." left </span>";
     }



  $sub_array[] = "<span class='text-success'> Total ".$numberDays." Days</span>".$days;
  $sub_array[] = date('d-M/Y, g;i A', strtotime($row['Fdate']));
  $sub_array[] = date('d-M/Y, g;i A', strtotime($row['Ldate']));
  $sub_array[] = '<button type="button" name="delete" class="btn btn-sm btn-danger delete" id="' . $row["id"] . '"><i class="fas fa-trash"></i></button>';;

  $data[] = $sub_array;
}

## Activity
$activity = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($activity);
