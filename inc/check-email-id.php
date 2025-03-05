<?php
require_once('config.php');

$email = $_POST['email'];
$checkMail = "SELECT * FROM `users` WHERE email='$email'";
		$emailcheck = mysqli_query($conn, $checkMail);
		$count = mysqli_num_rows($emailcheck);
    if(empty($email)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Enter Your Email Id </span>";
		}
   else if(preg_match('/\s/',$email)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Space Not Allow in Email Id </span>";
		}
    else if($count == 1){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
            <span style='color:red;'> Email Not Availabe </span>";
		}else{
			echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
            <span style='color:green;'> Email Availabe </span>";
		}
?>