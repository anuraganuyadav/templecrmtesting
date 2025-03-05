
<!--  reminder        -->       
<div class="Clock">
 <span class="time" id="Time"> </span>
 <span class="date"  id="Date"> </span>  
</div> 
 <div id="showAlarm">
  <div id="alt"></div>  
 <?php
session_start(); 
//for conn
include "inc/config.php";	    
     
     
  $query1 = mysqli_query($conn," SELECT * FROM reminder WHERE sales_person = '".$_SESSION['user_name']."'");   
       while($getid=mysqli_fetch_array($query1))
                {
             ?>
 <div class="card mb-2 alarmON" id="hide<?php echo $getid['id']; ?>">
 <input id="deactivate" type="hidden" value="<?php echo $getid['id']; ?>">
 <div class="card-header bg-danger ">Reminder Time Up <button onclick="myFunction<?php echo $getid['id']; ?>()" class="btn btn-sm btn-danger float-right">Ok</button></div><?php echo $getid['note'] ?> <br> <a class="btn btn-sm btn-success text-center" href="<?php
 if($getid['page']=="lead"){ echo "lead-view.php?lead=".$getid['reminderID']; } elseif($getid['page']=="potential")
 echo "potential-view.php?view_potential=".$getid['reminderID']; ?>"> Go To </a>
 </div> 

<!-- end php     -->
 <script>
 document.getElementById("hide<?php echo $getid['id']; ?>").style.display = "none";
     
function myFunction<?php echo $getid['id']; ?>() {
    document.getElementById("hide<?php echo $getid['id']; ?>").style.display = "none";
} 
 </script>

 
  <?php     
  }   
 ?>  
 </div>
             
 <!-- DATE -->
 <script>     
setInterval(function() {
var d = new Date();
//var date = document.getElementById('Date');
//var time = document.getElementById('Time');
var show = document.getElementById('showAlarm'); 
//date current with format    
var date =(d.getFullYear()+ '-' + ("0" + d.getMonth() + 1).slice(-2) +'-'+ ("0" + d.getDate()).slice(-2));    

//time current with format    
var time = (("0" +d.getHours()).slice(-2) +':' + ("0" + d.getMinutes()).slice(-2) + ':' + ("0" + d.getSeconds()).slice(-2));  



//start php    
<?php  
//for conn
include "inc/config.php";	
   
  $query = mysqli_query($conn," SELECT * FROM reminder WHERE sales_person = '".$_SESSION['user_name']."' ");   
      if(mysqli_num_rows($query) > 0)
              {
                while($res=mysqli_fetch_array($query))
                {
                    
   ?>
 <?php
$date = $res['date'];
$time = $res['time'];    
$reminderID =$res['reminderID'];    
$dir =$res['id'];    
  ?>
    
    
//if time match    
  if(date ==='<?php echo $date;  ?>'){ 
     if(time ==='<?php echo $time;  ?>'){
        document.getElementById("hide<?php echo $dir; ?>").style.display = "block";   	    
      }      
   }  
    
//end php     
  <?php     
  }   
  }   
 ?>     
//end js    
 }, 1000);      
</script>  
 
<!-- end reminder -->