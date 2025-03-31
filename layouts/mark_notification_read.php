<?php
session_start();
require_once('../inc/config.php');
require_once '../inc/session.php';

if (isset($_POST['note_id'])) {
	$note_id = $_POST['note_id'];

	// Mark the note as checked
	$query = "UPDATE lead_notes SET is_checked = 1 WHERE note_id = '$note_id'";
	$query .= " OR UPDATE potential_notes SET is_checked = 1 WHERE note_id = '$note_id'";

	if (mysqli_query($db, $query)) {
		echo "Notification marked as read.";
	} else {
		echo "Error updating notification: " . mysqli_error($db);
	}
}
