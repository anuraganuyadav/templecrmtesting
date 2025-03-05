<?php
 require_once('config.php');

if (isset($_POST['id'])>0) {
    $id = $_POST['id'];
    $status = $_POST['status']; 


     
        $result ="UPDATE users SET status = '$status' WHERE userID ='$id'";
        if (mysqli_query($conn, $result)) {
            if($status==1){
                echo  "<span class='text-danger'>De-active</span>";
            }
            else{
                echo  "<span class='text-success'>Active</span>";
            }
            
        } else {
            echo "Comment not created";
        }
    }
