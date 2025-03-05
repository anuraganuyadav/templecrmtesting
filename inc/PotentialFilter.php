<?php
session_start();
//include db configuration file
include_once("config.php");


//use any post value for subbmission if empty submission not work
	 
	$contentToSave = filter_var($_POST["PotentialFilter"]); 
	$fdateSave = filter_var($_POST["FdateFilter"]); 
	$LdateSave = filter_var($_POST["LdateFilter"]); 
    $contentTouserID = filter_var($_POST["userID"]);  
    $filterRow = filter_var($_POST["filterRow"]);  
    $filterBeforeDate = filter_var($_POST["filterBeforeDate"]);  
    $filterDestination = filter_var($_POST["filterDestination"]); 
    
    
     $dest = "SELECT * FROM `filter` WHERE filterID='$contentTouserID'";
		$data = mysqli_query($conn, $dest);
		$count = mysqli_num_rows($data);
    
 // condition 1    
  if($count != 1){ 
   if(mysqli_query($conn,"INSERT INTO filter (filterID, sPotentialFilter, sFdateFilter, sLdateFilter, sfilterRow, sfilterBeforeDate, silterDestination) VALUES ('$contentTouserID','$contentToSave','$fdateSave','$LdateSave','$filterRow','$filterBeforeDate','$filterDestination')")){
       
       echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'> New Filter Success </i> ";   
           } 
      
      else{
          echo "Try Again";
           }

       }
 //end  condition 1 
        
// condition 2     
  else if($count == 1){
     if(mysqli_query($conn,"UPDATE filter SET sPotentialFilter = '$contentToSave', sFdateFilter = '$fdateSave', sLdateFilter = '$LdateSave' , sfilterRow = '$filterRow' , sfilterBeforeDate = '$filterBeforeDate' , sfilterDestination = '$filterDestination'  WHERE filterID= $contentTouserID")){
      
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

?> 
   
 










  <script> 
        setTimeout(function() {
            $('#message_alert').fadeOut('slow');
        }, 1400);
    </script>