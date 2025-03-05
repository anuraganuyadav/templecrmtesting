<?php
require_once('config.php');
$Monumber = $_POST['Monumber'];
$Mo1 = mysqli_query($conn,"SELECT * FROM lead WHERE mo_number='$Monumber'");
$Mo2 = mysqli_query($conn,"SELECT * FROM potential WHERE mo_number='$Monumber'");
$count1 = mysqli_num_rows($Mo1);
$count2 = mysqli_num_rows($Mo2);

   if(empty($Monumber)){
		 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Enter Mobile Number </span>";
		} 
    else if(preg_match('/\s/',$Monumber)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ff9900;'> Space Not Allow in Mobile Number </span>";
		}
	else if($count1 >= 1){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#dbf300;'> Mobile No. Already in lead </span>";
		}  
    else if($count2 >= 1){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#dbf300;'> Mobile No. Already in potential </span>";
		} 


        else{
//			echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
//            <span style='color:#1cc88a;'> Mobile No. Availabe </span>";
		}
 
?>