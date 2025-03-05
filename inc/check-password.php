<?php
require_once('config.php');
$password = $_POST['password'];

 if(empty($password)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Enter Password </span>";
		}
 else if(strlen($_POST["password"]) < 8){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'>Please Enter password Max 8 Characters </span>";
		}

 else if(strlen($_POST["password"]) <= 10){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:green;'> Good </span>";
		} 

  else if(strlen($_POST["password"]) <= 10000){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:green;'> Very Strong </span>";
		} 

        else{
			echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
            <span style='color:green;'> Good </span>";
		}
 
?>