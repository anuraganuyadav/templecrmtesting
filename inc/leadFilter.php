<?php
session_start();
//include db configuration file
include_once("config.php");

// filter 
 
        
 
if(isset($_POST["LeadFilter"]) && strlen($_POST["LeadFilter"])>1) 
{	
	$contentToSave = filter_var($_POST["LeadFilter"]); 
    $contentTouserID = filter_var($_POST["userID"]);   
    
        $dest = "SELECT * FROM `filter` WHERE filterID='$contentTouserID'";
		$data = mysqli_query($conn, $dest);
		$count = mysqli_num_rows($data);
    
// condition 1  
 if($count != 1){ 
   if(mysqli_query($conn,"INSERT INTO filter (filterID, LeadFilter) VALUES ('$contentTouserID','$contentToSave')")){
      
  echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'> New Added </i> "; 
        }
    else{
        echo "Try Again"; 
      } 
    } 
//end condition 1
    
// condition 2     
  else if($count == 1){
     if(mysqli_query($conn,"UPDATE filter SET LeadFilter = '$contentToSave' WHERE filterID= $contentTouserID")){ 
     echo "<i id='message_alert' class='text-success'><img src='images/img/small-done.gif' width='40px'> Added </i> "; 
            }
       else{
        echo "Try Again"; 
            }
          }
//end condition 1
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