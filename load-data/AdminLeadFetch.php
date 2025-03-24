<?php
//fetch.php
error_reporting(0);
ini_set('display_errors', 0);
require_once '../inc/config.php';
require_once '../inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
	header('location:login.php?lmsg=true');
	exit;
}

// Identified
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {
	header("Location:index.php");
}

// Columns to be fetched
$columns = array('name', 'email', 'mo_number', 'destination', 'no_person', 'LeadSource', 'date', 'sales_person');

// Query to fetch data
$query = "SELECT * FROM lead ";

if (isset($_POST["search"]["value"])) {
	$query .= '
    WHERE name LIKE "%' . $_POST["search"]["value"] . '%" 
    OR email LIKE "%' . $_POST["search"]["value"] . '%" 
    OR mo_number LIKE "%' . $_POST["search"]["value"] . '%" 
    OR destination LIKE "%' . $_POST["search"]["value"] . '%" 
    OR no_person LIKE "%' . $_POST["search"]["value"] . '%" 
    OR LeadSource LIKE "%' . $_POST["search"]["value"] . '%" 
    OR date LIKE "%' . $_POST["search"]["value"] . '%" 
    OR sales_person LIKE "%' . $_POST["search"]["value"] . '%" 
    ';
}

if (isset($_POST["order"])) {
	$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= 'ORDER BY timestamp(date) DESC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
	$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

// Get all user names for the sales person dropdown
$query_list = mysqli_query($conn, "SELECT * FROM users WHERE (user_role_id ='0' || user_role_id ='2') ORDER BY user_name ASC");
while ($u = mysqli_fetch_array($query_list)) {
	$i .= "<option value='" . $u['user_name'] . "'>" . $u['user_name'] . "</option>";
}

// Find duplicate mobile numbers in the 'lead' table
$duplicate_query_lead = "SELECT mo_number, COUNT(*) as count FROM lead GROUP BY mo_number HAVING COUNT(*) > 1";
$duplicate_result_lead = mysqli_query($conn, $duplicate_query_lead);
$duplicate_numbers_lead = array();

while ($row = mysqli_fetch_array($duplicate_result_lead)) {
	$duplicate_numbers_lead[] = $row['mo_number'];
}

// Find common mobile numbers between 'lead' and 'potential' tables
$common_numbers_query = "SELECT mo_number FROM potential WHERE mo_number IN (SELECT mo_number FROM lead)";
$common_numbers_result = mysqli_query($conn, $common_numbers_query);
$common_numbers = array();

while ($row = mysqli_fetch_array($common_numbers_result)) {
	$common_numbers[] = $row['mo_number'];
}

$result = mysqli_query($conn, $query . $query1);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$sub_array = array();

	// Check if the mobile number is a duplicate or common between 'lead' and 'potential'
	$mo_number_style = '';
	if (in_array($row['mo_number'], $duplicate_numbers_lead)) {
		$mo_number_style = 'style="background-color: yellow;"';
	}
	if (in_array($row['mo_number'], $common_numbers)) {
		$mo_number_style = 'style="background-color: red; color: white;"'; // Red highlight for common numbers
	}

	// Name
	$sub_array[] = '<div class="form-group m-0"><div class="input-group-prepend"><a href="lead-view.php?lead=' . $row['id'] . '" class="user pr-2 pl-2"><i class="fas fa-user"></i></a><input class="update" data-id="' . $row["id"] . '" data-column="name" value="' . htmlentities($row["name"]) . '"></div></div>';

	// Email
	$sub_array[] = '<input class="update" data-id="' . $row["id"] . '" data-column="email" value="' . htmlentities($row["email"]) . '">';

	// Mobile number with duplicate and common check
	// $sub_array[] = '<input class="update mo-responsive" data-id="' . $row["id"] . '" data-column="mo_number" value="' . htmlentities($row["mo_number"]) . '" ' . $mo_number_style . '>';
	// Mobile number with duplicate and common check
	$mo_number_display = ltrim($row["mo_number"], '0'); // Strip leading zero
	$sub_array[] = '<input class="update mo-responsive" data-id="' . $row["id"] . '" data-column="mo_number" value="' . htmlentities($mo_number_display) . '" ' . $mo_number_style . '>';


	// Destination
	$sub_array[] = '<input class="update" data-id="' . $row["id"] . '" data-column="destination" value="' . htmlentities($row["destination"]) . '">';

	// No. of persons
	$sub_array[] = '<input class="update pax" data-id="' . $row["id"] . '" data-column="no_person" value="' . htmlentities($row["no_person"]) . '">';

	// Lead source
	$sub_array[] = '<input class="update w-100" data-id="' . $row["id"] . '" data-column="LeadSource" value="' . htmlentities($row["LeadSource"]) . '">';

	// Date (no update)
	$sub_array[] = "<span class='date-adata'>" . date('d/M/y,g:i,a', strtotime($row['date'])) . "</span>";

	// Sales person
	$sub_array[] = "<select class='update' data-id='" . $row["id"] . "' data-column='sales_person'><option class='selected' value='" . htmlentities($row['sales_person']) . "'>" . $row['sales_person'] . "</option>" . $i . "</select>";

	// Delete button
	$sub_array[] = '<button type="button" name="delete" class="btn btn-sm btn-danger delete" id="' . $row["id"] . '"><i class="fas fa-trash"></i></button>';

	$data[] = $sub_array;
}

function get_all_data($conn)
{
	$query = "SELECT * FROM lead";
	$result = mysqli_query($conn, $query);
	return mysqli_num_rows($result);
}

$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"  =>  get_all_data($conn),
	"recordsFiltered" => $number_filter_row,
	"data"    => $data
);

echo json_encode($output);
