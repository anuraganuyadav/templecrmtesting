<?php
require_once('../inc/config.php');
require_once '../inc/session.php';
$user_name = $_SESSION['user_name'];
if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] == 0 && $_SESSION['user_role_id'] == 1 && $_SESSION['user_role_id'] == 2) {

  header("Location:index.php");
}

$dataid = $_SESSION['clid'];   
    // user veryfied and get wtp_no 
    $getU = mysqli_query($conn, " SELECT wtp_no from lead where id ='$dataid' ");
    $u_wtp_noI = mysqli_fetch_array($getU);
 
    $wtp_no = $u_wtp_noI['wtp_no'];
    echo '<a href="https://api.whatsapp.com/send?phone=91'.$wtp_no.'&amp;text=Namastey from Templemitra.com !!"><img class="img-fluid w-75" src="images/wtp.png"></a>';
   //end user veryfied and get wtp_no
 
?>
