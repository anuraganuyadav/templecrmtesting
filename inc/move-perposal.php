<?php  
require_once ('config.php');
	if(isset($_POST['proposal_id']))
	    {  
		$name = $_POST['name'];// 
        $email = $_POST['email'];//
        $proposal_id = $_POST['proposal_id'];//
        $mo_number = $_POST['mo_number'];// 
		$destination = $_POST['destination'];//     
		$no_person = $_POST['no_person'];//  
		$description = $_POST['description'];//   
		$status = $_POST['status'];//   
		$amount = $_POST['amount'];//    
		$sales_person = $_POST['sales_person'];//   
		$last_response = $_POST['last_response'];//   
		$travel_date = $_POST['travel_date'];//   
		$wtp_no = $_POST['wtp_no'];//   
        
		// if veryfie potential dublicate lead .... 
$po = mysqli_query($conn,"SELECT * FROM potential WHERE mo_number ='$mo_number'");
if(mysqli_num_rows($po)>=1){
 echo "This Person Allready Inserted In potential";    
 }
 else{
     if($que =mysqli_query($conn,"INSERT INTO potential (proposal_id, name, email, mo_number, wtp_no, destination, no_person, description, status, amount, sales_person, last_response, travel_date, date, last_activity ) VALUES('$proposal_id', '$name','$email','$mo_number','$wtp_no','$destination','$no_person', '$description', '$status', '$amount', '$sales_person', '$last_response', '$travel_date', '$timestamp', '$timestamp')")){  


         //delete reminder
         $stmt_delete =mysqli_query($conn, "DELETE FROM reminder WHERE reminderID = '$proposal_id'");

            if($stmt_delete =mysqli_query($conn, "DELETE FROM lead WHERE id = '$proposal_id' LIMIT 1")){
             if($query = mysqli_query($conn,"SELECT * FROM potential WHERE proposal_id ='$proposal_id'")){     
                 $res = mysqli_fetch_array($query);
                  $idd = $res['id']; 
                  $status_id = $idd;
                   $status_detail = $_POST['status']; 
                   if($insert = mysqli_query($conn,"INSERT INTO potential_status_history (status_id, status_detail, status_date) VALUES ('$status_id', '$status_detail', '$timestamp')")){ 
                      echo "Your Potential Successfully Created";
                      }
                   }
                }    
             }  
        }  
    }  
  ?>  
