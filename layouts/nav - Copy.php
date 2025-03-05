
<!-- Main Content -->
      <div id="content">        
<!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

    

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">
                <?php
                if($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2){

                $user = $_SESSION['user_name'];
                $query =mysqli_query($db, "SELECT * FROM itinerary WHERE sales_person = '$user' and status_now = '1'") or die(mysqli_error());
               echo mysqli_num_rows($query);
                 }
                ?>
                </span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>

                <?php 
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
                <a class="dropdown-item text-center small text-gray-500" href="index.php">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                  
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
                 <img class="rounded-circle" src="images/user_images/<?php echo $row['userPic']?>">
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
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500"><?php echo $row['full_name']?> · 58m</div>
                  </div>
                </a>
<?php
}
?>
                  
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION["full_name"]);?></span>
                  <?php 
                   $userID = $_SESSION['userID'];            
                    $sql = "SELECT * FROM users WHERE userID = $userID";
                    $sth = $db->query($sql);
                    $result=mysqli_fetch_array($sth);
                  if(empty($result['userPic'])){
                      echo"<img class='img-profile rounded-circle' src='images/img/avtar.png'>";
                  }
                  else{   
                    echo "<img class='img-profile rounded-circle' src='images/user_images/" . $result['userPic']."' alt='Usr profile'>";
                  }
                  
                  
                    ?></a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="My-profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                 <a class="dropdown-item" href="upload-profile.php?edit_profile=<?php echo htmlspecialchars($_SESSION["userID"]);?>" title="click for update Profile" onclick="return confirm('Are sure want to Upload..?')">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                 Update Profile
                </a>
                  
                  
                  
                 
               <?php    
               if($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2 ){
                     
                echo "<a class='dropdown-item' href='Setting.php'>
                  <i class='fas fa-cogs fa-sm fa-fw mr-2 text-gray-400'></i>
                  Settings
                </a>";
                echo "<a class='dropdown-item' href='#'>
                  <i class='fas fa-list fa-sm fa-fw mr-2 text-gray-400'></i>
                  Activity Log
                </a>";
                 }
                  else{
                      echo "";
                  }
                 ?> 
                 
                  
                  
                  
                  
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
