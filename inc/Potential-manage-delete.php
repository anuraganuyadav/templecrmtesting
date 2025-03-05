<?php
include "config.php"; 
if(isset($_POST["rows_to_be_deleted"]))
{ 
	$array = json_decode($_POST['rows_to_be_deleted']);
	for($ctr = 0;$ctr < sizeof($array);$ctr++)
		$conn->query("delete FROM potential where id=".$array[$ctr]);
}else 
	echo 'Unknown Error Occured While Deletion!';


?>