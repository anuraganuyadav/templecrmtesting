<?php 
session_start();
//include db configuration file
include_once("config.php");
if($_POST['id']!=""):
    extract($_POST);
    $id=mysqli_real_escape_string($db,$id);
    $sql = $db->query("DELETE FROM chat WHERE id='$id'");
endif;
?>