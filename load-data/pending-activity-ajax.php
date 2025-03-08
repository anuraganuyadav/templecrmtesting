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

//use any post value for subbmission if empty submission not work  
$pending_activity = filter_var($_POST["searchByPendingActivity"]);
$leadType = filter_var($_POST["searchByleadType"]);
$userID = filter_var($_SESSION["userID"]);

// Get the salesperson filter (if provided)
$searchBySalesPerson = isset($_POST["searchBySalesPerson"]) ? $_POST["searchBySalesPerson"] : '';

// Handle filter storage (same logic as before)
$dest = "SELECT * FROM `filter` WHERE userID='$userID'";
$data = mysqli_query($conn, $dest);
$count = mysqli_num_rows($data);

// condition 1
if ($count != 1) {
  if (mysqli_query($conn, "INSERT INTO filter (userID, pending_activity, sl_Status) VALUES ('$userID','$pending_activity','$leadType')")) {
  }
}
//end  condition 1
// condition 2
elseif ($count == 1) {
  if (mysqli_query($conn, "UPDATE filter SET pending_activity = '$pending_activity' ,  sl_Status = '$leadType'  WHERE userID= $userID")) {
  }
}
//end  condition 2

?>
<?php

// Read value for DataTables
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page 
$searchValue = $_POST['search']['value']; // Search value


// Custom Filters
$searchByPendingActivity = $_POST["searchByPendingActivity"];
$searchByleadType = $_POST["searchByleadType"];


// Building the search query
$searchQuery = " ";

if ($searchByleadType != '') {
  $searchQuery .= " and page = '$searchByleadType'";
}

// search by searchByPendingActivity

if (!empty($searchByPendingActivity)) {
  if ($searchByPendingActivity = 'Pending Activity') {
    $searchQuery .= " and remark = '' and TIMESTAMP(reminder_date) <= NOW() ";
  } else if ($searchByPendingActivity = 'Past Activity') {
    $searchQuery .= " and TIMESTAMP(reminder_date) <= NOW() ";
  } else if ($searchByPendingActivity = 'Next Activity') {
    $searchQuery .= " TIMESTAMP(reminder_date) >= NOW() ";
  }
}

// Salesperson filter - Only apply if selected
if (!empty($searchBySalesPerson)) {
  $searchQuery .= " and sales_person = '$searchBySalesPerson' ";
}


// Generic Search (by name, email, or phone number)
if ($searchValue != '') {
  $searchQuery .= " and (name like '%" . $searchValue . "%' or 
        email like '%" . $searchValue . "%' or 
        mo_number like '%" . $searchValue . "%' or 
        name like'%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "select count(*) as allcount from reminder ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from reminder WHERE 
 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// as desc order colom setting
$columns = array('name', 'note', 'reminder_date', 'remark', 'sales_person', 'remark');

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

// Final query to fetch records with filters

$potentialQuery = "select * from reminder WHERE 1 " . $searchQuery . $order . " limit " . $row . "," . $rowperpage;


$potentialRecords = mysqli_query($conn, $potentialQuery);
$data = array();

while ($row = mysqli_fetch_assoc($potentialRecords)) {
  $sub_array = array();
  //lead page
  if ($row['page'] == "lead") {
    $sub_array[] = '<a href="lead-view.php?lead=' . $row['reminderID'] . '"  class="user">' . $row["name"] . '</a>';
  } else if ($row['page'] == "potential") {
    $sub_array[] = '<a href="Potential-view.php?view_potential=' . $row['reminderID'] . '"  class="user">' . $row["name"] . '</a>';
  };
  //end lead page
  $sub_array[] = $row['note'];
  $sub_array[] = date('d-M/Y, g;i A', strtotime($row['reminder_date']));
  $sub_array[] = $row['remark'];
  $sub_array[] = $row['sales_person'];

  // If remark is empty, display pending status
  if (empty($row['remark'])) {
    $sub_array[] = "pending";
  } else {
    $sub_array[] = "<span class='text-success'>success</span>";
  };
  //end if pending remark
  $data[] = $sub_array;
}

// Output data in JSON format for DataTables
$activity = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($activity);
