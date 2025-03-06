<table class="table table-dark shadow text-light table-bordered ">
  <thead>
    <tr>
      <th>Note</th>
      <th>Time</th>
      <th>Remark</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php
    error_reporting(null);
    //fetch.php 
    require_once '../inc/session.php';
    include_once("../inc/config.php");
    if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
      header('location:login.php?lmsg=true');
      exit;
    }


    // $dataid = $_SESSION['potential_id'];
    $dataid = $_SESSION['clid'];


    // user veryfied and get sales name 
    $getU = mysqli_query($conn, "SELECT sales_person from lead where id ='$dataid' ");
    $u_nameI = mysqli_fetch_array($getU);
    if (!empty($u_nameI['sales_person'])) {
      $user = $u_nameI['sales_person'];
    } else {
      $getP = mysqli_query($conn, "SELECT sales_person from potential where id ='$dataid' ");
      $u_nameP = mysqli_fetch_array($getP);
      $user = $u_nameP['sales_person'];
    }
    //end user veryfied and get sales name 




    $query = mysqli_query($conn, "SELECT * FROM reminder WHERE sales_person = '$user' and reminderID = '$dataid' ORDER BY timestamp(date) DESC");

    while ($row = mysqli_fetch_array($query)) {
    ?>
      <tr class="text-light">
        <td>
          <div class="rupdate" data-id="<?php echo $row["id"] ?>" data-column="note"><?php echo $row["note"] ?></div>
        </td>
        <td class="time-r">
          <div class="rupdate" data-id="<?php echo $row["id"] ?>" data-column="date">
            <?php

            $alarm = $row["reminder_date"];
            echo date('d M Y g:i A', strtotime($alarm));

            ?>
          </div>
        </td>
        <td class="remark">
          <input class="rupdate" type="text" data-id="<?php echo $row["id"] ?>" data-column="remark" value="<?php echo $row["remark"] ?>">
        </td>
        <td>
          <button type="button" name="delete" class="btn btn-danger btn-circle btn-sm btn-delete delete" id="<?php echo $row["id"] ?>"><i class="fas fa-trash"></i></button>
        </td>
      </tr>

    <?php
    }


    ?>

  </tbody>
</table>