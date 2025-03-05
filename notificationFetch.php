   
           
           
           
<?php 
session_start();
//for conn
include "inc/config.php";	
?> 
           <!-- Nav Item notification- Alerts -->
        <?php 
            $user = $_SESSION["user_name"]; 
        if($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2){ 

           $query = mysqli_query($db, "SELECT * FROM itinerary  WHERE sales_person = '$user' and status_now = '1' ORDER by id LIMIT 3") or die(mysqli_error());
              // notification count 
	
              if(mysqli_num_rows($query) > 0)
              {
                while($row=mysqli_fetch_array($query))
                { 
                  ?>
                <a class="dropdown-item d-flex align-items-center" href="Itinerary-view.php?view_itinerary=<?php echo $row['id']; ?>">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary"> 
  <!-- php echo first name letter -->
 <p class="first-chr"> 
  <?php
 //Example string.
$string = $row['name']; 
//generate  mb_substr to the get first letter of the character.
$GetfirstChar = mb_substr($string, 0, 1, "UTF-8");
 
//now Print the first character.
echo $GetfirstChar;
 ?> 
 </p>
        </div>
                  </div>
                  <div>
                    <span class="font-weight-bold"><?php echo $row['name']. "<b style='color:red;'> For </b>"   .$row['destination'];     ?></span>
                    <!-- notifaction date -->
                    <div class="small text-gray-500"> 
                    <?php 
                    $time= $row['date']; 
                    echo date('d-m-Y, g:i A',  strtotime($time));
                    ?>
                    </div>


                  </div>
                </a>  
              <?php
              } 
            }
            else
            {
              ?>
          <div class="alert alert-warning">
           No Notification Found ...
           </div>
               <?php
            }
            }
            
          ?> 
     
             
         
