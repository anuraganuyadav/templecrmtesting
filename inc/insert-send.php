<!--  insert  -->
<?php

	error_reporting( ~E_NOTICE ); // avoid notice 
	
	if(isset($_POST['insert']))
	{  
		$name = $_POST['name'];// 
        $email = $_POST['email'];//
        $userID = $_POST['userID'];//
        $mo_number = $_POST['mo_number'];// 
		$destination = $_POST['destination'];//     
		$no_person = $_POST['no_person'];//  
		$description = $_POST['description'];//   
		$LeadSource = $_POST['LeadSource'];//   
		$sales_person = $_POST['sales_person'];//   
	    	  
	
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO lead (name,email, mo_number, destination, no_person, description, LeadSource, date, last_activity, sales_person ) VALUES(:uname,:uemail,:umo_number,:udestination,:uno_person, :udescription, :uLeadSource, :udate,:ulast_activity, :usales_person)');
            
			$stmt->bindParam(':uname',$name); 
            $stmt->bindParam(':uemail',$email); 
			$stmt->bindParam(':umo_number',$mo_number);   
			$stmt->bindParam(':udestination',$destination);   
			$stmt->bindParam(':uno_person',$no_person);    
			$stmt->bindParam(':udescription',$description);   
			$stmt->bindParam(':uLeadSource',$LeadSource);         
			$stmt->bindParam(':udate', $timestamp);         
			$stmt->bindParam(':ulast_activity', $timestamp);         
			$stmt->bindParam(':usales_person', $sales_person);         

 
				if($stmt->execute()){
				?>
                <script>
				alert('insert Successfully...');
 			window.location.href='admin.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}
	}
?>  
<!--  insert  -->
 <!--  insert in all history -->
<?php

	error_reporting( ~E_NOTICE ); // avoid notice 
	
	if(isset($_POST['insert']))
	{  
		$name = $_POST['name'];// 
        $email = $_POST['email'];//
        $userID = $_POST['userID'];//
        $mo_number = $_POST['mo_number'];// 
		$destination = $_POST['destination'];//     
		$no_person = $_POST['no_person'];//  
		$description = $_POST['description'];//   
		$LeadSource = $_POST['LeadSource'];//   
		$sales_person= $_POST['sales_person'];//   
	     
		

		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO all_contact (name,email, mo_number, destination, no_person, description, LeadSource, date , last_activity, sales_person ) VALUES(:uname,:uemail,:umo_number,:udestination,:uno_person, :udescription, :uLeadSource, :udate, :ulast_activity, :usales_person)');
            
			$stmt->bindParam(':uname',$name); 
            $stmt->bindParam(':uemail',$email); 
			$stmt->bindParam(':umo_number',$mo_number);   
			$stmt->bindParam(':udestination',$destination);   
			$stmt->bindParam(':uno_person',$no_person);    
			$stmt->bindParam(':udescription',$description);   
			$stmt->bindParam(':uLeadSource',$LeadSource);
            $stmt->bindParam(':udate', $timestamp);
            $stmt->bindParam(':ulast_activity', $timestamp);
            $stmt->bindParam(':usales_person', $sales_person);

 
				if($stmt->execute()){
				?> 
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}
	}
?>  
<!--  insert  -->
 