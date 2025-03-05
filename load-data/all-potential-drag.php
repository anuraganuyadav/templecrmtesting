<?php 
include_once("../inc/config.php");
$position = $_POST['position'];
$i=1;
foreach($position as $k=>$v){
    $sql  = "Update potential_status SET position_order=".$i." WHERE id=".$v;
    if($conn->query($sql)){
        $msg = '<span class="text-success">Successful update for sequence </span>';
    }
    else{
        $msg = '<span class="text-danger">something went wrong</span>';   
    } 
	$i++;
}
 echo $msg; 
 ?>