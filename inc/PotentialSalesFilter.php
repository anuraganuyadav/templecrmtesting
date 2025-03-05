<?php
session_start();
//include db configuration file
include_once("config.php");


//use any post value for subbmission if empty submission not work
if(isset($_POST["userID"]) && strlen($_POST["userID"])>1) 
{	
	$filterDateBefore = filter_var($_POST["filterDateBefore"]); 
	$AdminfilterSales = filter_var($_POST["AdminfilterSales"]);   
    $userID = filter_var($_POST["userID"]);  
    $filterStatus = filter_var($_POST["filterStatus"]);  
    $filterType = filter_var($_POST["filterType"]);  
    $leadFdate = filter_var($_POST["leadFdate"]);  
    $leadLdate = filter_var($_POST["leadLdate"]);  
 
    
    
    
  $dest = "SELECT * FROM `filter` WHERE filterID='$userID'";
		$data = mysqli_query($conn, $dest);
		$count = mysqli_num_rows($data);
    
 // condition 1    
  if($count != 1){ 
   if(mysqli_query($conn,"INSERT INTO filter (filterID, filterDateBefore, AdminfilterSales, filterStatus, filterType, leadFdate, leadLdate) VALUES ('$userID','$filterDateBefore','$AdminfilterSales', '$filterStatus', '$filterType', '$leadFdate', '$leadLdate')")){
       
       echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'>New Filter Success </i> ";   
           } 
      
      else{
          echo "Try Again";
           }

       }
 //end  condition 1 
        
// condition 2     
  else if($count == 1){
     if(mysqli_query($conn,"UPDATE filter SET filterDateBefore = '$filterDateBefore', AdminfilterSales = '$AdminfilterSales', filterStatus = '$filterStatus', filterType = '$filterType', leadFdate = '$leadFdate', leadLdate = '$leadLdate' WHERE filterID= $userID")){
      
     echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'>Filter Success </i> "; 
       }
    else{
        echo "try Again";
       }
    }
//end  condition 2 
//last else part    
 else{
   echo "Try Again";
      }
//end last else part   
}
?> 
      
 
  
  <script> 
        setTimeout(function() {
            $('#message_alert').fadeOut('slow');
        }, 1400);
    </script>