<?php
require_once 'inc/session.php';
require_once "inc/config.php";
if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

  header("Location:index.php");
}
//for deleted
if (isset($_GET['delete_id'])) {


  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM users WHERE userID =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  //		header("Location:menu_management.php");
}

//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT * from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0 &&  $getStatus['user_role_id'] == '2') {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Manage Password Setting</title>
    <?php include_once("layouts/header.php"); ?>
  </head>

  <body id="page-top">
    <?php include_once("layouts/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <?php include_once("layouts/nav.php"); ?>
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <div class="btn-group float-right" role="group" aria-label="Basic example">
          <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal"> Clear Satatus </button>
          <button onclick="callBack()" class="btn btn-danger"> Back </button>
        </div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-betweenmb-2">
          <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <!-- DataTables Example -->
        <div class="card shadow mb-3 mt-4">
          <div class="card-header d-block">
            Manage Password
          </div>
          <span class="text-center" id="altU"></span>
          <div class="card-body">
            <!-- Content Row -->
            <?php
            $query = mysqli_query($db, "SELECT * FROM users WHERE 	user_role_id='0' || 	user_role_id = '1'  ORDER BY userID");
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <div class="row">
                <!-- name -->
                <div class="col-xl-3 col-md-6 mb-2">
                  <div class="card border-left-primary shadow">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col">
                          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">name</div>
                          <li class="nav-item email-list">

                            <!--   show user_name      -->
                            <a class="nav-link" href="#" data-toggle="collapse" data-target="#user_name<?php echo $row['userID']; ?>" aria-expanded="true" aria-controls="collapseTwo" onClick="this.style.display= 'none';">
                              <input class="border-0" type="user_name" value="<?php echo $row['user_name']; ?>">
                              <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i>
                            </a>

                            <!--   edit user_name      -->
                            <div id="user_name<?php echo $row['userID']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                              <div class="bg-white py-2 collapse-inner rounded">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                  <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">
                                  <div class="input-group mb-mail">
                                    <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['user_name']; ?>" type="text" id="<?php echo $row['userID']; ?>" name="user_name" required>
                                    <div class="input-group-prepend">
                                      <div class="right-send">
                                        <input class="send btn-success" type="submit" name="updateuser_name" value="Done">
                                      </div>
                                    </div>
                                  </div>
                                </form>
                                <?php
                                if (isset($_POST['updateuser_name'])) {
                                  $userID = $_POST['userID'];
                                  $user_name = $_POST['user_name'];
                                  //check name of user insert
                                  $user = mysqli_query($db, "SELECT user_name FROM users WHERE userID = '$userID'");
                                  $u = mysqli_fetch_array($user);
                                  $un = $u['user_name'];
                                  //update potential
                                  $potential = "UPDATE potential SET sales_person = '$user_name' WHERE sales_person ='$un'";
                                  if (mysqli_query($db, $potential)) {
                                    //update lead
                                    $lead = "UPDATE lead SET sales_person = '$user_name' WHERE sales_person ='$un'";
                                    if (mysqli_query($db, $lead)) {
                                      $result = "UPDATE users SET user_name = '$user_name' WHERE userID='$userID'";
                                      if (mysqli_query($db, $result)) {
                                        echo "<meta http-equiv='refresh' content='0'>";
                                      }
                                    }
                                  }
                                }
                                ?>
                              </div>
                            </div>
                          </li>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end user_name -->

                <!-- email -->
                <div class="col-xl-3 col-md-6 mb-2">
                  <div class="card border-left-primary shadow">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col">
                          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">email</div>
                          <li class="nav-item email-list">
                            <!--   show email      -->
                            <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#email<?php echo $row['userID']; ?>" aria-expanded="true" aria-controls="collapseTwo" onClick="this.style.display= 'none';">
                              <input class="border-0" type="email" value="<?php echo $row['email']; ?>">
                              <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i>
                            </a>

                            <!--   edit email      -->
                            <div id="email<?php echo $row['userID']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                              <div class="bg-white py-2 collapse-inner rounded">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                  <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">
                                  <div class="input-group mb-mail">
                                    <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['email']; ?>" type="text" id="<?php echo $row['userID']; ?>" name="email" required>
                                    <div class="input-group-prepend">
                                      <div class="right-send">
                                        <input class="send btn-success" type="submit" name="updateemail" value="Done">
                                      </div>
                                    </div>
                                  </div>
                                </form>
                                <?php
                                if (isset($_POST['updateemail'])) {
                                  $userID = $_POST['userID'];
                                  $email = $_POST['email'];
                                  $result = mysqli_query($db, "UPDATE users SET email = '$email' WHERE userID='$userID'");
                                  echo "<meta http-equiv='refresh' content='0'>";
                                }
                                ?>
                              </div>
                            </div>
                        </div>
                        </li>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end email -->
                <!-- password -->
                <div class="col-xl-3 col-md-6 mb-2">
                  <div class="card border-left-primary shadow">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col">
                          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">password</div>
                          <li class="nav-item email-list">
                            <!--   show password      -->
                            <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#password<?php echo $row['userID']; ?>" aria-expanded="true" aria-controls="collapseTwo" onClick="this.style.display= 'none';">
                              <input class="border-0" type="password" value="<?php echo md5($row['password']); ?>">
                              <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i>
                            </a> </span>

                            <!--   edit password      -->
                            <div id="password<?php echo $row['userID']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                              <div class="bg-white py-2 collapse-inner rounded">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                  <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">
                                  <div class="input-group mb-mail">
                                    <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['password']; ?>" type="text" id="<?php echo $row['userID']; ?>" name="password" required>
                                    <div class="input-group-prepend">
                                      <div class="right-send">
                                        <input class="send btn-success" type="submit" name="updatepassword" value="Done">
                                      </div>
                                    </div>
                                  </div>
                                </form>
                                <?php
                                if (isset($_POST['updatepassword'])) {
                                  $userID = $_POST['userID'];
                                  $password = md5($_POST['password']);
                                  $result = mysqli_query($db, "UPDATE users SET password = '$password' WHERE userID='$userID'");
                                  echo "<meta http-equiv='refresh' content='0'>";
                                }
                                ?>
                              </div>
                            </div>
                        </div>
                        </li>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- manage -->
                <div class="col-xl-3 col-md-6 mb-2">
                  <div class="card border-left-primary shadow">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col">
                          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Manage</div>
                          <li class="nav-item email-list">
                            <a href="?delete_id=<?php echo $row['userID']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')" class="btn btn-danger btn-circle btn-sm btn-delete"><i class="fas fa-trash"></i></a>
                            <span class="btn btn-primary btn-sm">OTP:-<?php echo $row['otp']; ?> </span>

                            <!-- SWITCH  -->
                            <?php
                            if ($row['status'] == 1) {
                            ?>

                              <div class="onoffswitch">

                                <input type="checkbox" id="togBtn<?php echo $row['userID'] ?>" data-id="<?php echo $row['userID'] ?>" name="onoffswitch" class="onoffswitch-checkbox userstatus" tabindex="0">

                                <label class="onoffswitch-label" for="togBtn<?php echo $row['userID'] ?>">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                                </label>
                              </div>
                            <?php
                            }
                            if ($row['status'] == 0) {
                            ?>
                              <div class="onoffswitch">

                                <input type="checkbox" id="togBtnn<?php echo $row['userID'] ?>" data-id="<?php echo $row['userID'] ?>" name="onoffswitch" class="onoffswitch-checkbox userstatus" tabindex="0" checked>

                                <label class="onoffswitch-label" for="togBtnn<?php echo $row['userID'] ?>">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                                </label>
                              </div>
                            <?php
                            }
                            ?>
                        </div>
                        </li>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
              <!-- end password -->
            <?php
            }
            ?>
            <!-- Content Row -->
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Clear User Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <select class="form-control" name="userName" id="userName">
                  <option value="">---select user---</option>
                  <?php
                  $query = mysqli_query($db, "SELECT * FROM users WHERE 	user_role_id='0' || 	user_role_id = '1'  ORDER BY userID");
                  while ($row = mysqli_fetch_array($query)) {
                  ?>
                    <option value="<?php echo $row['user_name'] ?>"><?php echo $row['user_name'] ?></option>
                  <?php
                  }
                  ?>
                </select>   
                
                <select class="form-control" name="data" id="data">
                  <option value="">---select Data---</option>
                  <option value="lead">Lead</option>
                  <option value="potential">Potential</option> 
                </select>


              </div>
              <button type="button" class="btn btn-primary active claear_data">Clear</button>
            </div>
            <span id="status"></span>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <script>
      $(document).ready(function() {
        $(document).on('click', '.claear_data', function() {
          var user_name = $("#userName").val();
          var data = $("#data").val(); 
          if(data !='' && user_name !=''){
            $("#status").html('<i class="fas fa-spinner fa-spin"></i> Please wait. The process takes some time during data clearing.');
          $.ajax({
            url: "inc/cear-user-data.php",
            method: "POST",
            data: {
              user_name: user_name,
              data:data
            },
            success:function(data){
              $("#status").html(data);
            }
          })
        }
        else{
          $("#status").html('Please Select All fields are Required');
        }
        });
      });


      $(".userstatus").on('change', function() {
        if ($(this).is(':checked')) {
          // approve comment 
          var element = $(this);
          var id = element.attr("data-id")
          var status = "0";
          $.ajax({
            url: "inc/user-approve.php",
            method: "POST",
            data: {
              id: id,
              status: status
            },
            success: function(data) {
              $("#altU").fadeIn().html("<span>" + data + "</span");
              setTimeout(function() {
                $("#altU").hide();
              }, 2000);
            }
          });
        } else {
          // dis-approved when uncheck 
          var element = $(this);
          var id = element.attr("data-id")
          var status = "1";
          $.ajax({
            url: "inc/user-approve.php",
            method: "POST",
            data: {
              id: id,
              status: status
            },
            success: function(data) {
              $("#altU").fadeIn().html("<span>" + data + "</span");
              setTimeout(function() {
                $("#altU").hide();
              }, 2000);
            }
          });
        }
      });
    </script>





  <?php
  include "inc/insert-send.php";
  include_once("layouts/footer.php");
} else {
  ?>
    <h4>You can't acccess this page </h4>
    <script>
      setInterval(function() {
        window.history.back();
      }, 2000)
    </script>
  <?php

}
  ?>