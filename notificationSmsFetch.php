                 
  <?php 
session_start();
//for conn
include "inc/config.php";	
?>                 
                  
<!-- Message Center                  -->
 <?php
$user = $_SESSION["userID"];                 
$query = mysqli_query($db,"SELECT * FROM users WHERE userID != $user ORDER BY userID") 
or die(mysqli_error()); 
while($row = mysqli_fetch_array( $query ))
{
?>           
                <a class="dropdown-item d-flex align-items-center" href="Message-center.php?chat=<?php echo $row['userID'];?>">
                  <div class="dropdown-list-image mr-3">
                 <!--  user pic -->
                   <?php
                  if(empty($row['userPic'])){
                      echo"<img class='rounded-circle' src='images/img/avtar.png'>";
                  }
                  else{   
                    echo "<img class='rounded-circle' src='images/user_images/" . $row['userPic']."' alt='Usr profile'>";
                  }   
                   ?>
                 <!-- end user pic -->  
                  <?php 
                    if($row['online'] == '1'){  
                    echo"<div class='status-indicator bg-success'></div>";
                   }
                  else{
                    echo"<div class='status-indicator bg-secondary'></div>";   
                  } 
                  ?>  
                </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">
                    <span class="sms-count">
                 <?php 
               // sms count alert
               $res =mysqli_query($db, "SELECT * FROM chat WHERE chatStatus= '1' and SendPerson = '".$row['user_name']."'") or die(mysqli_error());
                  if(mysqli_num_rows($res)== 0){
                      echo "No New Message";  
                  }
                  else{ 
                  echo mysqli_num_rows($res);    
                  }
                  
                 ?> 
                    </span> 
                    
                    <?php
            $que =mysqli_query($db, "SELECT * FROM chat WHERE chatStatus= '1' and  SendPerson = '".$row['user_name']."' LIMIT 1") or die(mysqli_error()); 
                  $count = mysqli_num_rows($que);
                   while($res = mysqli_fetch_array( $que))
                       { 
                       ?>
                    <span> 
                    <!--  if message empty-->
                    <?php   echo $res['message']; ?>
                       </span> 
                  <!--  show message from-->
                  <div class="small text-gray-500">From: <?php echo $row['full_name']?> <?php echo $res['chatDate']?></div>
                         
                        <?php    
                          }
                        ?>       
                    </div> 
                  </div>
                </a>
<?php
}
?>
   
    