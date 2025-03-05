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
$ap_Sales = filter_var($_POST["searchBySales"]);
$ap_Status = filter_var($_POST["searchByStatus"]);
$ap_Fdate = filter_var($_POST["searchByFdate"]);
$ap_Ldate = filter_var($_POST["searchByLdate"]);
$userID = filter_var($_SESSION["userID"]);
$ap_DateWise = filter_var($_POST["searchByDateWise"]);
$ap_BeforeDate = filter_var($_POST["searchByBeforeDate"]);
$ap_Destination = filter_var($_POST["searchByDestination"]);


$dest = "SELECT * FROM `filter` WHERE userID='$userID'";
$data = mysqli_query($conn, $dest);
$count = mysqli_num_rows($data);

// condition 1
if ($count != 1) {
  if (mysqli_query($conn, "INSERT INTO filter (userID, ap_Sales, ap_Status, ap_Fdate, ap_Ldate, ap_DateWise, ap_BeforeDate, ap_Destination) VALUES ('$userID','$ap_Sales','$ap_Status','$ap_Fdate','$ap_Ldate','$ap_DateWise','$ap_BeforeDate','$ap_Destination')")) {
  }
}
//end  condition 1

// condition 2
elseif ($count == 1) {
  if (mysqli_query($conn, "UPDATE filter SET ap_Sales = '$ap_Sales', ap_Status = '$ap_Status', ap_Fdate = '$ap_Fdate', ap_Ldate = '$ap_Ldate' , ap_DateWise = '$ap_DateWise' , ap_BeforeDate = '$ap_BeforeDate' , ap_Destination = '$ap_Destination'  WHERE userID= $userID")) {
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
$searchBySales = $_POST["searchBySales"];
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

// search by detination
if ($searchBySales != '') {
  $searchQuery .= " and (sales_person='" . $searchBySales . "') ";
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
  $searchQuery .= " and (name like '%" . $searchValue . "%' or 
        email like '%" . $searchValue . "%' or 
        mo_number like '%" . $searchValue . "%' or 
        name like'%" . $searchValue . "%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn, "select count(*) as allcount from potential ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn, "select count(*) as allcount from potential WHERE 
 1 " . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

// as desc order colom setting
$columns = array('name', 'email', 'mo_number', 'destination', 'no_person', 'travel_date', 'amount', 'status', 'date', 'last_activity', 'ap_Sales');

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

$potentialQuery = "select * from potential WHERE 1 " . $searchQuery . $order . " limit " . $row . "," . $rowperpage;


$potentialRecords = mysqli_query($conn, $potentialQuery);
$data = array();

while ($row = mysqli_fetch_assoc($potentialRecords)) {
  $sub_array = array();
  $sub_array[] = '<a href="potential-view.php?view_potential=' . $row['id'] . '"  class="user">' . $row["name"] . '</a>';
  $sub_array[] = $row["email"];
  // $sub_array[] = $row['mo_number'];
  // Fetch the corresponding mo_number from the lead table
  $leadQuery = "SELECT mo_number FROM lead WHERE mo_number = '" . $row['mo_number'] . "'";
  $leadResult = mysqli_query($conn, $leadQuery);
  $leadData = mysqli_fetch_assoc($leadResult);

  // Check if the mo_number from potential matches the mo_number from lead
  $mo_number_style = '';
  if ($leadData && $row['mo_number'] == $leadData['mo_number']) {
    $mo_number_style = 'style="background-color: red; color: white;"';  // Apply red color if mo_number matches
  }

  // Display mo_number with the red color if condition is met
  $sub_array[] = '<span ' . $mo_number_style . '>' . htmlentities($row['mo_number']) . '</span>';



  //check destination if not mach
  if (empty($row['destination'])) {
    $sub_array[] = "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
       <span style='color:#ffa500;'> Add Destination </span>";
  } else {
    $dest =  mysqli_query($conn, "SELECT * FROM `destinations` WHERE 
       destinations_list = '" . $row['destination'] . "'");
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
  $sub_array[] =  date('d/M/Y', strtotime($row['travel_date']));
  $sub_array[] = '<span class="font-weight-bold">Rs. ' . htmlentities($row['amount']) . '</span>';
  $sub_array[] = htmlentities($row['status']);
  $sub_array[] = "<span class='date-data-break '>" . date('d-M/Y, g;i A', strtotime($row['date'])) . "</span>";
  $sub_array[] = "<span class='date-data-break '>" . date('d/M/Y, g;i A', strtotime($row['last_activity'])) . "</span>";
  $sub_array[] = htmlentities($row['sales_person']);
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
