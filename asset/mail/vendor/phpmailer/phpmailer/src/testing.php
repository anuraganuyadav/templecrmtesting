MAIL_MAILER=smtp
MAIL_HOST=mail.templemitracrm.in
MAIL_PORT=465
MAIL_USERNAME=accounts@templemitracrm.in
MAIL_PASSWORD=B+U1i3gyFW@Z
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=accounts@templemitracrm.in
MAIL_FROM_NAME="${APP_NAME}"






















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
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

	header("Location:index.php");
}
//header
// include_once("layouts/header.php"); 


$columns = array('name', 'email', 'mo_number', 'destination', 'no_person', 'LeadSource', 'date', 'sales_person');

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
	$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' 
 ';
} else {
	$query .= 'ORDER BY timestamp(date) DESC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
	$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));


// get all user name in select option
$query_list = mysqli_query($conn, "SELECT * FROM users WHERE (user_role_id ='0' || user_role_id ='2') ORDER BY user_name ASC");
while ($u = mysqli_fetch_array($query_list)) {
	//$i. this value prient like wile loop when use dot after var
	$i .= "<option value='" . $u['user_name'] . "'>" . $u['user_name'] . "</option>";
};




$result = mysqli_query($conn, $query . $query1);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$sub_array = array();
	//  name   
	$sub_array[] = '<div class="form-group m-0"><div class="input-group-prepend"><a href="lead-view.php?lead=' . $row['id'] . '"  class="user pr-2 pl-2"><i class="fas fa-user"></i></a><input class="update " data-id="' . $row["id"] . '" data-column="name" value="' . htmlentities($row["name"]) . '"></div></div>';
	// email   
	$sub_array[] = '<input class="update" data-id="' . $row["id"] . '" data-column="email" value="' . htmlentities($row["email"]) . '">';
	//mo_number    
	$sub_array[] = '<input class="update mo-responsive" data-id="' . $row["id"] . '" data-column="mo_number" value="' . htmlentities($row["mo_number"]) . '">';

	//destination    
	$sub_array[] = '<input class="update" data-id="' . $row["id"] . '" data-column="destination" value="' . htmlentities($row["destination"]) . '">';

	//no_person    
	$sub_array[] = '<input class="update pax" data-id="' . $row["id"] . '" data-column="no_person"  value="' . htmlentities($row["no_person"]) . '">';


	//LeadSource    
	$sub_array[] = '<input class="update w-100" data-id="' . $row["id"] . '" data-column="LeadSource"  value="' . htmlentities($row["LeadSource"]) . '">';

	//date no update   
	$sub_array[] = "<span class='date-adata'>" . date('d/M/y,g:i,a', strtotime($row['date'])) . "</span>";

	//sales_person   
	$sub_array[] = "<select class='update' data-id='" . $row["id"] . "' data-column='sales_person'><option class='selected' value='" . htmlentities($row['sales_person']) . "'>" . $row['sales_person'] . "</option>" . $i . "</select>";


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


?>

<!-- for reminder old -->

<li class="nav-item dropdown no-arrow mx-1">
	<a class="nav-link dropdown-toggle" href="#" id="reminderDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fas fa-stopwatch fa-fw notifi-text"></i>

		<!-- Counter - remerk -->
		<span id="notificationReminderCount" class="badge badge-danger badge-counter">
			<!-- Counter number - reminder -->
			<?php
			// r count alert
			date_default_timezone_set('Asia/Kolkata');
			$timestamp = date('Y-m-d H:i:s');
			$res = mysqli_query($db, "SELECT * FROM reminder WHERE remark= '' and sales_person = '" . $_SESSION['user_name'] . "' and reminder_date <= '$timestamp'");
			echo mysqli_num_rows($res);
			?>
		</span>
	</a>
	<!-- Dropdown - reminder -->
	<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="reminderDropdown">
		<h6 class="dropdown-header">
			Reminder Center
		</h6>


		<div id="notificationReminder">
			<!--   notification show   -->
			<?php
			$user = $_SESSION["user_name"];
			if ($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2) {

				$query = mysqli_query($db, "SELECT * FROM reminder WHERE remark= '' and sales_person = '" . $_SESSION['user_name'] . "' and  reminder_date <= '$timestamp' ORDER by id");
				// notification count 

				if (mysqli_num_rows($query) > 0) {
					while ($row = mysqli_fetch_array($query)) {
			?>
						<a class="dropdown-item d-flex align-items-center" href="<?php
																					if ($row['page'] == "potential") {
																						echo "Potential-view.php?view_potential=" . $row['reminderID'];
																					} else if ($row['page'] == "lead") {
																						echo "lead-view.php?lead=" . $row['reminderID'];
																					} else {
																					} ?>">
							<div class="mr-3">
								<div class="icon-circle bg-primary">
									<!-- php echo first name letter -->
									<p class="first-chr">
										<?php
										//Example string.
										$string = $row['name'];
										//generate  mb_substr to the get first letter of the character.
										$GetfirstChar = mb_substr($string, 0, 1, "UTF-8");

										//now Print the first character.
										echo $GetfirstChar;
										?>
									</p>
								</div>
							</div>
							<div>
								<span class="font-weight-bold"><?php echo $row['name'] .
																	" <i>(PENDIND)</i> "

																?></span><br>
								<span class="font-weight-bold"><?php echo $row['note'];     ?></span>

								<!-- notifaction date -->
								<div class="small text-gray-500">
									<?php
									$time = $row['time'];
									echo date('d-m-Y, g:i A',  strtotime($time));
									?>
								</div>


							</div>
						</a>
					<?php
					}
				} else {
					?>
					<div class="alert alert-warning">
						No Notification Found ...
					</div>
			<?php
				}
			}

			?>


		</div>

		<a class="dropdown-item text-center small text-gray-500 bg-theme" href="#">Read More Messages</a>
	</div>
</li>


$query = "
SELECT *
FROM reminder
WHERE remark = ''
AND sales_person = '" . $_SESSION['user_name'] . "'
AND reminder_date <= '$timestamp'
	GROUP BY customer_id
	ORDER BY reminder_date DESC ";


	eminder Center
R

Ranjit (PENDING)
testing6
06-03-2025, 3:30 PM
a

Sashi (PENDING)
testing6
06-03-2025, 3:35 PM
a


anurag (PENDING)
a
06-03-2025, 5:02 PM


<?php
require_once 'config.php';

if (isset($_POST["name"])) {
	// Sanitize input data
	$name = mysqli_real_escape_string($conn, $_POST["name"]);
	$note = mysqli_real_escape_string($conn, $_POST["note"]);
	$date = mysqli_real_escape_string($conn, $_POST["date"]);
	$time = mysqli_real_escape_string($conn, $_POST["time"]);
	$DataID = mysqli_real_escape_string($conn, $_POST["DataID"]);
	$sales_person = mysqli_real_escape_string($conn, $_POST["sales"]);
	$page = mysqli_real_escape_string($conn, $_POST["page"]);

	// Check if 'remark' exists and sanitize it, if not set it to NULL
	$remark = isset($_POST["remark"]) ? mysqli_real_escape_string($conn, $_POST["remark"]) : null;

	// Get current timestamp
	$timestamp = date('Y-m-d H:i:s');

	// Query to get the last reminder based on 'name'
	// $check_reminder_query = "SELECT * FROM reminder WHERE name = '$name' ORDER BY reminderID DESC LIMIT 2";
	$check_reminder_query = "SELECT * FROM reminder WHERE name = '$name' ORDER BY reminderID DESC LIMIT 2";
	$check_reminder_result = mysqli_query($conn, $check_reminder_query);

	if ($check_reminder_result) {
		$reminders = mysqli_fetch_all($check_reminder_result, MYSQLI_ASSOC);

		// Check if there is a previous reminder and its remark
		if (count($reminders) > 0) {
			$previous_reminder = $reminders[1]; // Last reminder

			// If the previous reminder has no remark and the new reminder also has no remark
			if (empty($previous_reminder['remark']) && empty($remark)) {
				echo 'Please fill in the remark of the previous reminder before adding a new one.';
				exit;
			}
		}
		// If there is no previous reminder, it's the first reminder, so no remark is required
	} else {
		echo 'Error fetching previous reminders: ' . mysqli_error($conn);
		exit;
	}

	// Insert the new reminder into the database
	$query = "INSERT INTO reminder (reminderID, name, note, date, time, sales_person, page, created_date, reminder_date, remark) 
              VALUES ('$DataID', '$name', '$note', '$date', '$time:00', '$sales_person', '$page', '$timestamp', '$date $time:00', '$remark')";

	if (mysqli_query($conn, $query)) {
		echo 'Reminder set successfully';
	} else {
		echo 'Error setting reminder: ' . mysqli_error($conn);
	}
}
