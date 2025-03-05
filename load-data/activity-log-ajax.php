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
?>
<?php


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
$sel = mysqli_query($conn, "select count(*) as allcount from activity_log ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from activity_log WHERE 
 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// as desc order colom setting
$columns = array('name', 'loginTime');

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

$potentialQuery = "select * from activity_log WHERE 1 " . $searchQuery . $order . " limit " . $row . "," . $rowperpage;


$potentialRecords = mysqli_query($conn, $potentialQuery);
$data = array();

while ($row = mysqli_fetch_assoc($potentialRecords)) {
  $sub_array = array(); 

  $sub_array[] = $row['name'];
  $sub_array[] = date('d-M/Y, g;i A', strtotime($row['loginTime']));

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
