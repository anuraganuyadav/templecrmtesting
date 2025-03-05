<?php
if(isset($_POST['move_perposal'])  ){
        $status_id = $_POST['proposal_id'];
        $status_detail = $_POST['status']; 
        $result = mysqli_query($db,"INSERT INTO status_history (id, status_id, status_detail, status_date) VALUES ('$status_id', '$status_id', '$status_detail', '$timestamp')");    
    }    
?>

<!--  move  -->
<?php  

	if(isset($_POST['move_perposal']))
	{  
		$name = $_POST['name'];// 
		$id = $_POST['id'];// 
        $email = $_POST['email'];//
        $proposal_id = $_POST['proposal_id'];//
        $mo_number = $_POST['mo_number'];// 
		$destination = $_POST['destination'];//     
		$no_person = $_POST['no_person'];//  
		$description = $_POST['description'];//   
		$status = $_POST['status'];//   
		$amount = $_POST['amount'];//   
		$date = $_POST['date'];//   
		$sales_person = $_POST['sales_person'];//   
		$response_client = $_POST['response_client'];//   
		$travel_date = $_POST['travel_date'];//   
	     
	 
      
  $stmt_delete = $DB_con->prepare("DELETE FROM itinerary WHERE id = '$id' LIMIT 1"); 
  $stmt_delete->execute();  
        
        
        
        
        
        
        
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
            
         
			$stmt = $DB_con->prepare('INSERT INTO potential (id, proposal_id, name, email, mo_number, destination, no_person, description, status, amount, sales_person, response_client, travel_date, date ) VALUES(:uproposal_id, :uid, :uname,:uemail,:umo_number,:udestination,:uno_person, :udescription, :ustatus, :uamount, :usales_person, :uresponse_client, :utravel_date, :udate)');
            
			$stmt->bindParam(':uid',$proposal_id); 
			$stmt->bindParam(':uproposal_id',$proposal_id); 
			$stmt->bindParam(':uname',$name); 
            $stmt->bindParam(':uemail',$email); 
			$stmt->bindParam(':umo_number',$mo_number);   
			$stmt->bindParam(':udestination',$destination);   
			$stmt->bindParam(':uno_person',$no_person);    
			$stmt->bindParam(':udescription',$description);   
			$stmt->bindParam(':ustatus',$status);   
			$stmt->bindParam(':uamount',$amount);   
			$stmt->bindParam(':usales_person',$sales_person);   
			$stmt->bindParam(':uresponse_client',$response_client);   
			$stmt->bindParam(':utravel_date',$travel_date); 
            $stmt->bindParam(':udate', $date);

        
 
            
            
            
				if($stmt->execute()){  
				?>
                <script>
				alert('Potential Successfully generate...');
 			       window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}
	}



?>  
