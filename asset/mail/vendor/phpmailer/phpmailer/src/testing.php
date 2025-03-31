<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once 'inc/session.php';

// For deleted
include "inc/config.php";

// Prepare SQL query to join the lead and potential tables based on mobile number
$sql = "
    SELECT 
        l.id, 
        l.name, 
        l.email, 
        l.mo_number, 
        COALESCE(p.wtp_no, l.wtp_no) AS wtp_no,  -- Use potential's WhatsApp number if available
        l.destination
    FROM lead l
    LEFT JOIN potential p ON l.mo_number = p.mo_number  -- Join by mobile number
    
    UNION
    SELECT 
        p.id, 
        p.name, 
        p.email, 
        p.mo_number, 
        p.wtp_no, 
        p.destination
    FROM potential p
   
";

// Execute the query
$result = mysqli_query($conn, $sql);

// Store the data in an array
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
	$data[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Contact</title>
	<?php include_once("layouts/header.php"); ?>
</head>

<body id="page-top">
	<?php include_once("layouts/sidebar.php"); ?>
	<!-- Content Wrapper -->
	<div id="content-wrapper" class="d-flex flex-column">
		<?php include_once("layouts/nav.php"); ?>
		<!-- Begin Page Content -->
		<div class="container-fluid p-0">
			<!-- Back button -->
			<button onclick="callBack()" class="back-btn"> Back </button>
			<br>

			<!-- Table -->
			<table id='fetchTable' class='display dataTable'>
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile Number</th>
						<th>WhatsApp Number</th>
						<th>Destinations</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $row): ?>
						<tr>
							<td><?php echo htmlspecialchars($row['name']); ?></td>
							<td><?php echo htmlspecialchars($row['email']); ?></td>
							<td><?php echo htmlspecialchars($row['mo_number']); ?></td>
							<td><?php echo htmlspecialchars($row['wtp_no']); ?></td>
							<td><?php echo htmlspecialchars($row['destination']); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- Script -->
		

	</div>

	<?php include_once("layouts/footer.php"); ?>
</body>

</html>