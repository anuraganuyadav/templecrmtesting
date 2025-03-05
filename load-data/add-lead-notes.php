<?php
require_once '../inc/session.php';
include_once("../inc/config.php");
if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
} 
//identyfied
if ($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {


  $id = $_SESSION['clid'];




  if (isset($_POST["note"]) && strlen($_POST["note"]) > 1) {
    $contentToSave = $_POST["note"];
    $id = $_POST["id"];


    mysqli_query($conn, "UPDATE lead SET last_activity = '$timestamp' , status_now = '0' WHERE id= $id");

    if (mysqli_query($conn, "INSERT INTO lead_notes
     (note, note_id, create_date) VALUES('$contentToSave', '$id', '$timestamp')")) {
    }
  }
?>


  <div class="table-responsive">
    <table id="noteResponse<?php echo $id; ?>" class="table-bordered table-danger" width="100%" cellspacing="0">
      <?php
      $query_r = mysqli_query($db, "SELECT id, note_id, note, create_date FROM lead_notes WHERE note_id = $id ORDER BY id DESC");
      while ($row = mysqli_fetch_array($query_r)) {
      ?>
        <tr>
          <!--tabale row-->
          <td class="pl-2"> <?php echo $row['note']; ?></td>
          <td class="note-date pl-2"> <?php
                                      $time = $row['create_date'];
                                      echo  date('d M Y, g;i A', strtotime($time));
                                      //type1  echo  date('g:i A, l - d M Y', strtotime($time));
                                      //type2 echo  date("m-d-Y", strtotime($time)); 
                                      ?></td>
          <td class="note-del pl-2">
            <!--  delete    -->
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-delete deleteNote" id="<?php echo $row["id"] ?>"><i class="fas fa-trash"></i></button>
          </td>
        </tr>

    <?php
      }
    } else {

      header("Location:index.php");
    }
    ?>
    </table>