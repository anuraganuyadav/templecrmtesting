 <?php 
session_start();
//for conn
include "inc/config.php";	
?>  
              <?php
                // sms count alert
               $res =mysqli_query($db, "SELECT * FROM chat WHERE chatStatus= '1' and ReceivedPerson = '".$_SESSION['user_name']."'") or die(mysqli_error());
               echo mysqli_num_rows($res);  
                    ?>