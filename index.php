 
<?php 
require_once('inc/config.php'); 

require_once 'inc/session.php';
	
	if(!isset($_SESSION['userID'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}		
?>
<?php 
//only visible to admin and editor
		if($_SESSION['user_role_id'] == 1 ){
		
          header("Location:dashboard.php");  
		 }
     elseif($_SESSION['user_role_id'] == 0 ){
          header("Location:dashboard.php");  
		 } 
      elseif($_SESSION['user_role_id'] == 2 ){
          header("Location:dashboard.php");  
		 } 
    else{
        echo "You are not an Active User";
       }
?>
