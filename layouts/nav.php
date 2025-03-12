<!-- Main Content -->
<div id="content">
  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-black topbar mb-2 static-top shadow fixed-top">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
    <div id="reminder">
      <!--  reminder        -->
      <div class="Clock">
        <span class="time" id="Time"> </span>
        <span class="date" id="Date"> </span>
      </div>
      <div id="showAlarm">
        <div id="alt"></div>
        <?php
        //for conn
        include "inc/config.php";

        $query1 = mysqli_query($conn, " SELECT * FROM reminder WHERE sales_person = '" . $_SESSION['user_name'] . "'");
        while ($getid = mysqli_fetch_array($query1)) {
        ?>
          <div class="card mb-2 alarmON hide" id="hide<?php echo $getid['id']; ?>">
            <input id="deactivate" type="hidden" value="<?php echo $getid['id']; ?>">
            <div class="card-header bg-danger ">Reminder Time Up <button onclick="myFunction<?php echo $getid['id']; ?>()" class="btn btn-sm btn-danger float-right">Ok</button></div><?php echo $getid['note'] ?> <br> <a class="btn btn-sm btn-success text-center" href="<?php
                                                                                                                                                                                                                                                                            if ($getid['page'] == "lead") {
                                                                                                                                                                                                                                                                              echo "lead-view.php?lead=" . $getid['reminderID'];
                                                                                                                                                                                                                                                                            } elseif ($getid['page'] == "potential")
                                                                                                                                                                                                                                                                              echo "potential-view.php?view_potential=" . $getid['reminderID']; ?>"> Go To </a>
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
          // var date = document.getElementById('Date');
          // var time = document.getElementById('Time');
          var show = document.getElementById('showAlarm');
          //date current with format    
          var date = (d.getFullYear() + '-' + ("0" + d.getMonth() + 1).slice(-2) + '-' + ("0" + d.getDate()).slice(-2));

          //time current with format    
          var time = (("0" + d.getHours()).slice(-2) + ':' + ("0" + d.getMinutes()).slice(-2) + ':' + ("0" + d.getSeconds()).slice(-2));


          //start php    
          <?php
          //for conn
          include "inc/config.php";
          $query = mysqli_query($conn, " SELECT * FROM reminder WHERE sales_person = '" . $_SESSION['user_name'] . "' ");
          if (mysqli_num_rows($query) > 0) {
            while ($res = mysqli_fetch_array($query)) {

          ?>
              <?php
              $date = $res['date'];
              $time = $res['time'];

              $reminderID = $res['reminderID'];
              $dir = $res['id'];
              ?>

              //if time match    
              if (date === '<?php echo $date;  ?>') {
                if (time === '<?php echo $time;  ?>') {
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
      <!-- end reminder        -->
    </div>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - remider remark -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="reminderDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-stopwatch fa-fw notifi-text"></i>

          <!-- Counter - reminder -->
          <span id="notificationReminderCount" class="badge badge-danger badge-counter">
            <!-- Counter number - reminder -->
            <?php
            // r count alert
            date_default_timezone_set('Asia/Kolkata');
            $timestamp = date('Y-m-d H:i:s');

            // Admin will see all reminders, others will see only their own
            if ($_SESSION['user_role_id'] == 2) {
              // Admin: Show all reminders where the remark is empty and the reminder date is in the past or present
              $res = mysqli_query($db, "SELECT * FROM reminder WHERE remark = '' AND reminder_date <= '$timestamp'");
            } else {
              // Other users: Show only their own reminders
              $res = mysqli_query($db, "SELECT * FROM reminder WHERE remark = '' AND sales_person = '" . $_SESSION['user_name'] . "' AND reminder_date <= '$timestamp'");
            }

            echo mysqli_num_rows($res);
            ?>
          </span>
        </a>

        <!-- Dropdown - reminder -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="reminderDropdown">
          <h6 class="dropdown-header">
            Reminder Center
          </h6>

          <div id="notificationReminder">
            <!-- Notification show -->
            <?php
            // Admin: show all reminders, others: show only their own
            if ($_SESSION['user_role_id'] == 2) {
              $query = mysqli_query($db, "SELECT * FROM reminder WHERE remark = '' AND reminder_date <= '$timestamp' ORDER BY id");
            } else {
              $query = mysqli_query($db, "SELECT * FROM reminder WHERE remark = '' AND sales_person = '" . $_SESSION['user_name'] . "' AND reminder_date <= '$timestamp' ORDER BY id");
            }

            // Check if there are any reminders
            if (mysqli_num_rows($query) > 0) {
              while ($row = mysqli_fetch_array($query)) {
            ?>
                <a class="dropdown-item d-flex align-items-center" href="<?php
                                                                          if ($row['page'] == "potential") {
                                                                            echo "Potential-view.php?view_potential=" . $row['reminderID'];
                                                                          } else if ($row['page'] == "lead") {
                                                                            echo "lead-view.php?lead=" . $row['reminderID'];
                                                                          } else {
                                                                          } ?>">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <p class="first-chr">
                        <?php
                        // Get the first character of the name to display
                        $string = $row['name'];
                        $GetfirstChar = mb_substr($string, 0, 1, "UTF-8");
                        echo $GetfirstChar;
                        ?>
                      </p>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold"><?php echo $row['name'] . " <i>(PENDING)</i>"; ?></span><br>
                    <span class="font-weight-bold"><?php echo $row['note']; ?></span>

                    <!-- Notification date -->
                    <div class="small text-gray-500">
                      <?php
                      $time = $row['reminder_date'];
                      echo date('d-m-Y, g:i A',  strtotime($time));
                      ?>
                    </div>
                  </div>
                </a>
              <?php
              }
            } else {
              ?>
              <div class="alert alert-warning">
                No Notification Found ...
              </div>
            <?php
            }
            ?>

          </div>

          <a class="dropdown-item text-center small text-gray-500 bg-theme" href="#">Read More Messages</a>
        </div>
      </li>

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

      <!-- Nav Item notification- Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw notifi-text"></i>
          <!-- Counter - Alerts -->
          <span id="notificationCount" class="badge badge-danger badge-counter">
            <?php
            $user = $_SESSION["user_name"];
            if ($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2) {

              // Check if the user is a sales person or an admin
              if ($_SESSION['user_role_id'] == 0) {
                // Sales Person: Get the leads for today
                $query = mysqli_query($db, "SELECT * FROM lead WHERE sales_person = '$user' AND status_now = '1' AND DATE(date) = CURDATE()");
              } else {
                // Admin: Get the lead notes for today
                $query = mysqli_query($db, "SELECT * FROM lead_notes WHERE DATE(create_date) = CURDATE()");
              }

              echo mysqli_num_rows($query);
            }
            ?>
          </span>
        </a>

        <!-- notification Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
          <!-- Dropdown - Alerts -->
          <h6 class="dropdown-header">
            Alerts Center
          </h6>

          <!-- notification alert fetch -->
          <div id="notification" style="max-height: 300px; overflow-y: auto;">
            <?php
            $user = $_SESSION["user_name"];
            if ($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2) {

              // Check if the user is a sales person or an admin
              if ($_SESSION['user_role_id'] == 0) {
                // Sales Person: Get the leads for today
                $query = mysqli_query($db, "SELECT * FROM lead WHERE sales_person = '$user' AND status_now = '1' AND DATE(date) = CURDATE() ORDER BY id LIMIT 5");

                // Show lead notifications
                if (mysqli_num_rows($query) > 0) {
                  while ($row = mysqli_fetch_array($query)) {
            ?>
                    <a class="dropdown-item d-flex align-items-center" href="lead-view.php?lead=<?php echo $row['id']; ?>">
                      <div class="mr-3">
                        <div class="icon-circle bg-primary">
                          <p class="first-chr">
                            <?php
                            // Get the first character of the lead name
                            $string = $row['name'];
                            $GetfirstChar = mb_substr($string, 0, 1, "UTF-8");
                            echo $GetfirstChar;
                            ?>
                          </p>
                        </div>
                      </div>
                      <div>
                        <span class="font-weight-bold"><?php echo $row['name'] . "<b style='color:red;'> For </b>" . $row['destination']; ?></span>
                        <div class="small text-gray-500">
                          <?php
                          $time = $row['date'];
                          echo date('d-m-Y, g:i A', strtotime($time));
                          ?>
                        </div>
                      </div>
                    </a>
                  <?php
                  }
                } else {
                  echo '<div class="alert alert-warning">No Notification Found...</div>';
                }
              } else {
                // Admin: Get the lead notes for today
                $query = mysqli_query($db, "SELECT * FROM lead_notes WHERE DATE(create_date) = CURDATE() ORDER BY note_id DESC ");

                // Show lead notes notifications
                if (mysqli_num_rows($query) > 0) {
                  while ($row = mysqli_fetch_array($query)) {
                  ?>
                    <a class="dropdown-item d-flex align-items-center" href="<?php
                                                                              if ($row['page'] == "potential") {
                                                                                echo "Potential-view.php?view_potential=" . $row['reminderID'];
                                                                              } else if ($row['page'] == "lead") {
                                                                                echo "lead-view.php?lead=" . $row['reminderID'];
                                                                              } else {
                                                                              } ?>">
                      <div class="mr-3">
                        <div class="icon-circle bg-warning">
                          <p class="first-chr">
                            <?php
                            // Get the first character of the note description
                            $string = $row['note'];
                            $GetfirstChar = mb_substr($string, 0, 1, "UTF-8");
                            echo $GetfirstChar;
                            ?>
                          </p>
                        </div>
                      </div>
                      <div>
                        <span class="font-weight-bold"><?php echo $row['note']; ?></span>
                        <div class="small text-gray-500">
                          <?php
                          $time = $row['create_date'];
                          echo date('d-m-Y, g:i A', strtotime($time));
                          ?>
                        </div>
                      </div>
                    </a>
            <?php
                  }
                } else {
                  echo '<div class="alert alert-warning">No Notification Found...</div>';
                }
              }
            }
            ?>
          </div>
          <a class="dropdown-item text-center small text-gray-500" href="index.php">Show All Alerts</a>
        </div>
      </li>



      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-light small"><?php echo htmlspecialchars($_SESSION["full_name"]); ?></span>
          <?php
          $userID = $_SESSION['userID'];
          $sql = "SELECT * FROM users WHERE userID = $userID";
          $sth = $db->query($sql);
          $result = mysqli_fetch_array($sth);
          if (empty($result['userPic'])) {
            echo "<img class='img-profile rounded-circle' src='images/img/avtar.png'>";
          } else {
            echo "<img class='img-profile rounded-circle' src='images/user_images/" . $result['userPic'] . "' alt='Usr profile'>";
          }


          ?></a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="My-profile.php">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <a class="dropdown-item" href="upload-profile.php?edit_profile=<?php echo htmlspecialchars($_SESSION["userID"]); ?>" title="click for update Profile" onclick="return confirm('Are sure want to Upload..?')">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Update Profile
          </a>




          <?php
          if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {

            echo "<a class='dropdown-item' href='Setting.php'>
                  <i class='fas fa-cogs fa-sm fa-fw mr-2 text-gray-400'></i>
                  Settings
                </a>";
            echo "<a class='dropdown-item' href='activity-log.php'>
                  <i class='fas fa-list fa-sm fa-fw mr-2 text-gray-400'></i>
                  Activity Log
                </a>";
          } else {
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
  <div style="margin-top: 70px;"></div>