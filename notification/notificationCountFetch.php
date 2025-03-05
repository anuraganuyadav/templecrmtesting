 <?php 
session_start();
//for conn
include "inc/config.php";	
?> 
           <!--Item notification- count --> 
            <?php
                $user = $_SESSION["user_name"];
                if($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2){

                $user = $_SESSION['user_name'];
                $query = mysqli_query($db, "SELECT * FROM itinerary WHERE sales_person = '$user' and status_now = '1'");
               echo mysqli_num_rows($query);
                 }
                ?>