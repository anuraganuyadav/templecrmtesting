<?php
require_once '../inc/session.php';
include_once("../inc/config.php");

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}

if ($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {
  $id = $_SESSION['clid']; // Lead ID
  $userID = $_SESSION['userID']; // User ID from session

  if (isset($_POST["note"]) && strlen($_POST["note"]) > 1) {
    $contentToSave = $_POST["note"];
    $id = $_POST["id"];
    $timestamp = date("Y-m-d H:i:s");

    // Update last activity time for the lead
    mysqli_query($conn, "UPDATE lead SET last_activity = '$timestamp' WHERE id = '$id'");

    $addedByAdmin = ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) ? '<span class="by-admin">Admin</span>' : '';

    // Insert note along with user ID
    if (mysqli_query($conn, "INSERT INTO lead_notes (note, note_id, create_date, lead_user_id) VALUES('$contentToSave $addedByAdmin', '$id', '$timestamp', '$userID')")) {
      // echo "Note added successfully.";
    }
  }
}
?>

<div class="table-responsive">
  <table id="noteResponse<?php echo $id; ?>" class="table-bordered table-danger" width="100%" cellspacing="0">
    <?php
    // Fetch notes from the lead_notes table, joining with the users table to get the user name
    $query_r = mysqli_query($db, "SELECT lead_notes.id, lead_notes.note_id, lead_notes.note, lead_notes.create_date, lead_notes.lead_user_id, users.user_name FROM lead_notes LEFT JOIN users ON lead_notes.lead_user_id = users.userID WHERE lead_notes.note_id = $id ORDER BY lead_notes.id DESC");

    while ($row = mysqli_fetch_array($query_r)) {
    ?>
      <tr>
        <td class="pl-2"><?php echo $row['note']; ?></td>
        <td class="note-date pl-2"><?php
                                    $time = $row['create_date'];
                                    echo date('d M Y, g;i A', strtotime($time));
                                    ?></td>
        <td class="note-user pl-2"><?php echo $row['user_name']; ?></td>
        <td class="note-del pl-2">
          <!-- Delete button for the note -->
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-delete deleteNote" id="<?php echo $row["id"] ?>"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    <?php
    }
    ?>
  </table>
</div>