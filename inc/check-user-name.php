<?php
require_once('config.php');
$user_name = $_POST['user_name'];
$user = "SELECT * FROM `users` WHERE user_name='$user_name'";
		$username = mysqli_query($conn, $user);
		$count = mysqli_num_rows($username);

   if(empty($user_name)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Enter User Name </span>";
		} 
   else if(preg_match('/\s/',$user_name)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Space Not Allow in User Name </span>";
		}
	else if($count == 1){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:red;'> User Name Already Exixts Please Try Another  </span>";
		} 
        else{
			echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
            <span style='color:green;'> User Name Availabe </span>";
		}
 
?>