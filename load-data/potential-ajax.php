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
$sp_Status = filter_var($_POST["searchByStatus"]);
$sp_Fdate = filter_var($_POST["searchByFdate"]);
$sp_Ldate = filter_var($_POST["searchByLdate"]);
$userID = filter_var($_SESSION["userID"]);
$sp_DateWise = filter_var($_POST["searchByDateWise"]);
$sp_BeforeDate = filter_var($_POST["searchByBeforeDate"]);
$sp_Destination = filter_var($_POST["searchByDestination"]);


$dest = "SELECT * FROM `filter` WHERE userID='$userID'";
$data = mysqli_query($conn, $dest);
$count = mysqli_num_rows($data);

// condition 1
if ($count != 1) {
  if (mysqli_query($conn, "INSERT INTO filter (userID, sp_Status, sp_Fdate, sp_Ldate, sp_DateWise, sp_BeforeDate, sp_Destination) VALUES ('$userID','$sp_Status','$sp_Fdate','$sp_Ldate','$sp_DateWise','$sp_BeforeDate','$sp_Destination')")) {
  }
}
//end  condition 1

// condition 2
elseif ($count == 1) {
  if (mysqli_query($conn, "UPDATE filter SET sp_Status = '$sp_Status', sp_Fdate = '$sp_Fdate', sp_Ldate = '$sp_Ldate' , sp_DateWise = '$sp_DateWise' , sp_BeforeDate = '$sp_BeforeDate' , sp_Destination = '$sp_Destination'  WHERE userID= $userID")) {
  }
}
//end  condition 2
//last else part

//end last else part

?>
<?php


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
  $searchQuery .= " and (status='" . $searchByStatus . "') ";
}


//search data under 2, 3, 5  days 
// condition if search date wise empty then auto date wise filter
if ($searchByBeforeDate != '') {

  if ($searchByBeforeDate == 'Today') {
    $BeforeDate = "Before";
    $date = ">=( NOW() - INTERVAL 0 DAY )";
  } else if ($searchByBeforeDate == 'Before') {
    $BeforeDate = "Before";
    $date = "<=";
  } else if ($searchByBeforeDate == 'After') {
    $BeforeDate = "After";
    $date = ">=";
  }



  if ($searchByBeforeDate == 'Today') {
    if (empty($searchByDateWise)) {
      $searchQuery .= " and (TIMESTAMP(`date`)  $date)";
    } else {
      $searchQuery .= " and (TIMESTAMP($searchByDateWise) $date)";
    }
  } else {

    if (empty($searchByDateWise) && $searchByBeforeDate == $BeforeDate && $searchByFdate  != '' && $searchByLdate != '') {
      $searchQuery .= " and ( date $date '$searchByFdate')";
    } else if (!empty($searchByDateWise) && $searchByBeforeDate == $BeforeDate && $searchByFdate  != '' && $searchByLdate != '') {

      $searchQuery .= " and ($searchByDateWise $date '$searchByFdate')";
    }
  }
}


// serch by bwtween date wise
if ($searchByFdate != '' && $searchByLdate != '' && empty($searchByBeforeDate)) {
  if (empty($searchByDateWise)) {
    $searchQuery .= " and ( date >= '$searchByFdate' AND date <= '$searchByLdate')";
  } else {
    $searchQuery .= " and ( $searchByDateWise >= '$searchByFdate' AND $searchByDateWise <= '$searchByLdate')";
  }
}


if ($searchValue != '') {
  $searchQuery .= " and (name LIKE '%" . $searchValue . "%' or 
        email LIKE '%" . $searchValue . "%' or 
        mo_number LIKE '%" . $searchValue . "%' or 
        name LIKE'%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "select count(*) as allcount from potential  WHERE sales_person = '$user_name'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from potential WHERE sales_person = '$user_name' && 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// as desc order colom setting
$columns = array('name', 'email', 'mo_number', 'destination', 'no_person', 'travel_date', 'amount', 'status', 'date', 'last_activity');

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

$potentialQuery = "select * from potential WHERE sales_person = '$user_name' && 1 " . $searchQuery . $order . " limit " . $row . "," . $rowperpage;


$potentialRecords = mysqli_query($conn, $potentialQuery);
$data = array();

while ($row = mysqli_fetch_assoc($potentialRecords)) {
  $sub_array = array();
  $sub_array[] = '<a href="potential-view.php?view_potential=' . $row['id'] . '"  class="user">' . htmlentities($row["name"]) . '</a>';
  $sub_array[] = htmlentities($row["email"]);
  $sub_array[] = htmlentities($row['mo_number']);

  //check destination if not mach
  if (empty($row['destination'])) {
    $sub_array[] = "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
       <span style='color:#ffa500;'> Add Destination </span>";
  } else {
    $dest =  mysqli_query($conn, "SELECT * FROM `destinations` WHERE 
       destinations_list = '" . htmlentities($row['destination']) . "'");
    $count = mysqli_num_rows($dest);

    if ($count == 1) {
      $sub_array[] = "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
       <span style='color:green;'>" . htmlentities($row['destination']) . "</span>";
    } else {
      $sub_array[] = "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
      <span style='color:red;'>" . htmlentities($row['destination']) . "(Change it) </span>";
    }
  };
  //end check destination if not mach

  $sub_array[] = htmlentities($row['no_person']);
  $sub_array[] =  htmlentities(date('d/M/Y', strtotime($row['travel_date'])));
  $sub_array[] = '<span class="font-weight-bold">Rs. ' . htmlentities($row['amount']) . '</span>';
  $sub_array[] = htmlentities($row['status']);
  $sub_array[] = "<span class='date-data-break '>" . htmlentities(date('d/M/Y, g;i A', strtotime($row['date']))) . "</span>";
  $sub_array[] = "<span class='date-data-break '>" . htmlentities(date('d/M/Y, g;i A', strtotime($row['last_activity']))) . "</span>"; 
  $data[] = $sub_array;
}

## potential
$potential = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($potential);
