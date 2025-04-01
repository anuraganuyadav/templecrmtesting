<?php
session_start();
require_once('../inc/config.php');
require_once '../inc/session.php';

if (isset($_POST['note_id'])) {
	$note_id = $_POST['note_id'];

	// Mark the note as checked in lead_notes
	$query_lead = "UPDATE lead_notes SET is_checked = 1 WHERE note_id = '$note_id'";
	$query_potential = "UPDATE potential_notes SET is_checked = 1 WHERE note_id = '$note_id'";

	// Execute queries for both tables
	$lead_result = mysqli_query($db, $query_lead);
	$potential_result = mysqli_query($db, $query_potential);

	// Check if both queries were successful
	if ($lead_result || $potential_result) {
		echo "Notification marked as read.";
	} else {
		echo "Error updating notification: " . mysqli_error($db);
	}
}
