<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once 'inc/session.php';

// For deleted
include "inc/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Contact</title>
	<?php include_once("layouts/header.php"); ?>
	<!-- Datatable CSS -->
	<link href='asset/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
	<!-- Datatable JS -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

	<!-- <script src="asset/DataTables/datatables.min.js"></script> -->
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
			<table id='fetchTables' class='display dataTable'>
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
					<!-- Data will be populated by AJAX -->
				</tbody>
			</table>
		</div>

		<!-- Script to initialize DataTable with AJAX -->
		<script>
			$(document).ready(function() {
				// Initialize DataTable with AJAX to fetch data
				$('#fetchTables').DataTable({
					'processing': true,
					'responsive': true,
					'scrollY': 450,
					'order': [],
					'pagingType': 'full_numbers',
					'serverMethod': 'post',
					'pageLength': 100, // Set the number of records per page to 100
					'ajax': {
						'url': 'load-data/contact-log-ajax.php', // The path to the PHP file for fetching data
						'type': 'POST',
						'dataSrc': function(json) {
							return json.data; // Ensure the JSON returned is in the format { data: [...] }
						},
						'error': function(xhr, error, thrown) {
							console.error('AJAX error: ' + error + ' - ' + thrown);
						}
					},
					'columns': [{
							'data': 'name'
						},
						{
							'data': 'email'
						},
						{
							'data': 'mo_number'
						},
						{
							'data': 'wtp_no'
						},
						{
							'data': 'destination'
						}
					]
				});
			});
		</script>
	</div>

	<?php include_once("layouts/footer.php"); ?>
</body>

</html>