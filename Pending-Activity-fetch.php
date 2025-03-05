<?php
//fetch.php

//error_reporting(0);
//ini_set('display_errors', 0);

require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

  header("Location:index.php");
}
require_once "inc/config.php";


?>

  <table id="user_data" class="table table-border">
    <thead>
      <tr>
        <th>Name</th>
        <th>Note</th>
        <th>Time</th>
        <th>Remark</th>
        <th>Person</th>
        <th>status</th>
      </tr>
    </thead>
    <tbody>

      <?php
      //  filter
      $userID = $_SESSION['userID'];
      $sql = "SELECT * FROM filter WHERE userID = $userID";
      $sth = $db->query($sql);
      $result = mysqli_fetch_array($sth);
      $pending_sctivity = $result['pending_sctivity'];

      // end filter  
      if ($pending_sctivity == "Pending Activity") {
        $query = mysqli_query($db, "SELECT * FROM reminder_potential WHERE remark= '' and TIMESTAMP(reminder_date) <= NOW() ORDER by id");
      } else if ($pending_sctivity == "Past Activity") {
        $query = mysqli_query($db, "SELECT * FROM reminder_potential WHERE TIMESTAMP(reminder_date) <= NOW() ORDER by id");
      } else if ($pending_sctivity == "Next Activity") {
        $query = mysqli_query($db, "SELECT * FROM reminder_potential WHERE TIMESTAMP(reminder_date) >= NOW() ORDER by id");
      } else if ($pending_sctivity == "All Activity") {
        $query = mysqli_query($db, "SELECT * FROM reminder_potential  ORDER by id");
      }


      // notification count 

      if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
      ?>
          <tr>
            <td><a href="<?php echo $row['page'] . $row['reminderID']; ?>"><?php echo $row['name'] ?></a></td>
            <td><?php echo $row['note'] ?></td>
            <td>
              <?php
              $time = $row['reminder_date'];
              echo date('d-m-Y, g:i A',  strtotime($time));
              ?>
            </td>
            <td><?php echo $row['remark'] ?></td>
            <td><?php echo $row['sales_person'] ?></td>
            <td>
              <?php
              if (empty($row['remark'])) {
                echo "pending";
              } else {
                echo "<span class='text-success'>Success</span>";
              }
              ?>
            </td>
          </tr>

        <?php
        }
      } else {
        ?>
        <div class="alert alert-warning">
          No Notification Found ...
        </div>
      <?php
      }


      ?>

    </tbody>
  </table>
  <script>
    $('#user_data').DataTable({
      "responsive": true,
      "processing": true,
      //    "serverSide" : true,
      "scrollY": 380,
      //   "scrollX": true,   

    });
  </script>


