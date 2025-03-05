<?php
require_once 'config.php';
if(isset($_POST["name"]))
{
 $name = mysqli_real_escape_string($conn, $_POST["name"]);
 $email = mysqli_real_escape_string($conn, $_POST["email"]);
 $mo_number = mysqli_real_escape_string($conn, $_POST["mo_number"]);
 $destination = mysqli_real_escape_string($conn, $_POST["destination"]);
 $description = mysqli_real_escape_string($conn, $_POST["description"]);
 $no_person = mysqli_real_escape_string($conn, $_POST["no_person"]);
 $LeadSource = mysqli_real_escape_string($conn, $_POST["LeadSource"]); 
 $sales_person = mysqli_real_escape_string($conn, $_POST["sales_person"]); 
    
 $it = mysqli_query($conn,"SELECT * FROM lead WHERE mo_number ='$mo_number'");
 $po = mysqli_query($conn,"SELECT * FROM potential WHERE mo_number ='$mo_number'");
 if(mysqli_num_rows($it)>=1){
 echo "This Person Allready Inserted in Lead";   
 }
 else if(mysqli_num_rows($po)>=1){
 echo "This Person Allready Inserted In potential";    
 }   
 else{
  
        if($query =mysqli_query($conn, "INSERT INTO all_contact (name, email, mo_number, destination, no_person, LeadSource, date, sales_person) VALUES('$name', '$email', '$mo_number', '$destination', '$no_person','$LeadSource', '$timestamp', '$sales_person')"))
              {
           echo "";
              } 
           else{
              echo 'History Not Insert';  
              }   
    
       if($query =mysqli_query($conn,"INSERT INTO lead (name, email, mo_number, destination,description, no_person, LeadSource, date, sales_person, last_activity,status_now) VALUES('$name', '$email', '$mo_number', '$destination','$description', '$no_person', '$LeadSource', '$timestamp', '$sales_person','$timestamp','1')"))
       {  
     echo 'Lead Inserted';    
       }
    else{
      echo 'Please Try Again';  
       }   
     
}
}
?>

<!--   if(name != '' && email != '' && mo_number != '' && destination != ''&& no_person != ''&& LeadSource != ''&& date != ''&& sales_person != '')-->