<?php
require_once('../inc/config.php');
require_once '../inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {

  $id =  $_SESSION['potential_id'];

  $query_r = mysqli_query($db, "SELECT id, status_id, status_detail, status_date FROM  potential_status_history WHERE status_id = $id ORDER BY id DESC");
  while ($row = mysqli_fetch_array($query_r)) {
?>
    <!--tabale row-->
    <tr>
      <td> <?php echo $row['status_detail']; ?></td>
      <td class="text-center"> <?php
                                $time = $row['status_date'];
                                echo  date('d M Y, g;i A', strtotime($time));
                                //type1  echo  date('g:i A, l - d M Y', strtotime($time));
                                //type2 echo  date("m-d-Y", strtotime($time)); 
                                ?></td>
      <td>
        <!--calculate days-->
        <?php
        $time = $row['status_date'];
        $date1 = date_create(date('Y-m-d', strtotime($time)));
        $date2 = date_create(date('Y-m-d'));
        //difference between two dates
        $diff = date_diff($date1, $date2);
        //count days
        echo $diff->format("%a");
        ?>
      </td>
    </tr>
<?php
  }
} else {
  header("Location:index.php");
}

?>