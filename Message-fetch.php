<?php 
session_start();
//for deleted
include "inc/config.php";	

 
//	$contentToSave = $_POST["message"]; 
//	$AlluserID = $_POST["SMSuserID"]; 
//	$SendSMS = $_POST["SendPerson"]; 



	
	$sendSms = $_SESSION['user_name'] ;

$quer = mysqli_query($conn,"SELECT * FROM users WHERE user_name ='$sendSms'");
$res = mysqli_fetch_array($quer);

$ReceivedSMS = $_SESSION['receivedSMS'] ;
$query = mysqli_query($conn,"SELECT * FROM users WHERE user_name ='$ReceivedSMS'");
$result = mysqli_fetch_array($query);

 
?>

<ul>   
<?php
$Sperson = $_SESSION['user_name'];    
$Rperson = $ReceivedSMS;  
    
$Result = mysqli_query($conn,"SELECT * FROM chat WHERE (SendPerson = '$Sperson' and ReceivedPerson='$Rperson') or (ReceivedPerson = '$Sperson' and SendPerson='$Rperson')");
//get all records from chat table
if(mysqli_num_rows($Result)>0){    
while($row = mysqli_fetch_array($Result)){    
?>    
 <li id="messageBox" class="nav-item list-none">    
      <span class=" nav-link d-flex align-items-center">
                  <div class="dropdown-list-image mr-3 profile_user">
                 <img class="rounded-circle img-50" src="images/user_images/<?php 
    $Simg= $row['SendPerson'];  
    if($Simg == $_SESSION['user_name']){ 
    echo $res['userPic'];
      }
   
else if($Simg= $sendSms){ 
    echo $result['userPic'];
      } 
    
 ?>">  </div>
            <div class="font-weight-bold chat-bg" id="<?php
                               if($Simg == $_SESSION['user_name']){ 
                               echo "send";
                               }
                               else if($Simg= $result['full_name']){ 
                               echo "received";
                                 }?>">
                    <div class="text-truncate"><?php echo $row["message"]; ?></div>
                    <div class="small text-gray-500"><?php
                            if($Simg == $_SESSION['user_name']){ 
                               echo $_SESSION['full_name'];
                               }
   
                           else if($Simg= $result['full_name']){ 
                               echo $result['full_name'];
                                 }
                        ?>· 
 <?php 
$time = $row['chatDate']; 
$date1 = strtotime("$time");    
$date2 = strtotime(date('Y-m-d H:i:s'));
$seconds_diff = $date2 - $date1; 
// echo round(abs($seconds_diff) / 60,2);    
?>    
    
<span id="time"> <?php  echo date('Y-m-d H:i:s', strtotime($time)); ?> </span> 
      </div>
                  </div>
            <?php
               if($row['SendPerson'] == $_SESSION['user_name']){
             ?>         
             <button data-id="<?php echo $row['id'] ?>" id="delsms" class="delete" type="submit" value=""><i class="fas fa-times"></i></button>  
              <?php   
                }
              ?>
                </span>
                 
        </li>   
    
    
    
<?php
}
}
else{
    echo "No Messages";
}
    
?>
    
</ul> 
 <script> 
//delete ajax    
$(document).on('click','.delete',function(){
var element = $(this);
var del_id = element.attr("data-id");
var info = 'id=' + del_id;
 
 $.ajax({
   type: "POST",
   url: "inc/sms_delete.php",
   data: info,
   success: function(){

 }
});
  $(this).parents("li").animate({ backgroundColor: "#003" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 
});
    
    
// for sms bottom    
//var scroll = document.getElementById('smsFetch');
//   scroll.scrollTop = scroll.scrollHeight;
//   scroll.animate({scrollTop: scroll.scrollHeight});
 var element = document.getElementById("smsFetch");
    element.scrollTop = element.scrollHeight;
     
     
 </script>  