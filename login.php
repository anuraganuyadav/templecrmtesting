<?php
include('inc/config.php');
include 'inc/session.php';
error_reporting(0);
ini_set('display_errors', 0);



if (isset($_SESSION['user_name'])) {
  header('location:index.php');
} else if (!empty($_COOKIE['loge']) && !empty($_COOKIE['logp']) && !empty($_COOKIE['logo'])) {

  $Email = $_COOKIE['loge'];
  $Pass = $_COOKIE['logp'];
  $Otp = $_COOKIE['logo'];

  $sql = "select * from users where email = '$Email' and password = '$Pass'";
  // $sql = "select * from users where email = '$Email' and password = '$Pass' and otp = '$Otp'";
  $rs = mysqli_query($conn, $sql);
  $getNumRows = mysqli_num_rows($rs);

  //		for online
  date_default_timezone_set('Asia/Kolkata');
  $date = date('Y-m-d H:i:s');


  // for user online
  $result = mysqli_query($db, "UPDATE users SET online = '1', 	firstSession = '$date' WHERE email='$email'");


  if ($getNumRows == 1) {
    $getUserRow = mysqli_fetch_assoc($rs);
    unset($getUserRow['password']);

    $_SESSION = $getUserRow;
    //  Activity log   
    $id = $getUserRow['userID'];
    $uname = $getUserRow['user_name'];
    $log = "INSERT INTO activity_log (name, userID, loginTime) VALUES ('$uname','$id','$date')";
    if (mysqli_query($conn, $log)) {
      header('location:index.php');
      exit;
    }
  } else {
    $errorMsg = "Wrong Cookie";
  }
}

//else if(($_SESSION['user_role_id'] =='0') || ($_SESSION['user_role_id'] =='1') || ($_SESSION['user_role_id'] =='2')){
//    header('location:index.php');  
// }



else if (isset($_POST['login'])) {
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
  // if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['otp'])) {
    $email     = trim($_POST['email']);
    $password   = trim($_POST['password']);
    // $otp   = trim($_POST['otp']);

    $md5Password = md5($password);

    // $sql = "select * from users where email = '$email' and password = '$md5Password' and otp = '$otp'  and  otp_date > NOW() - INTERVAL 15 MINUTE";

    $sql = "select * from users where email = '$email' and password = '$md5Password'";
    $rs = mysqli_query($conn, $sql);
    $getNumRows = mysqli_num_rows($rs);  
    //		for online
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');

    $result = mysqli_query($db, "UPDATE users SET online = '1', 	firstSession = '$date' WHERE email='$email'");

    //  Activity log 
    $log = mysqli_query($conn, "INSERT INTO activity_log (userID, loginTime) VALUES ('$id','$date')");

    if ($getNumRows == 1) {
      $getUserRow = mysqli_fetch_assoc($rs);
      unset($getUserRow['password']);

      $_SESSION = $getUserRow;

      //   set cookie
      if (isset($_POST['set'])) {
        setcookie("loge", "$email", time() + (86400 * 365), "/");
        setcookie("logp", "$md5Password", time() + (86400 * 365), "/");
        // setcookie("logo", "$otp", time() + (86400 * 365), "/");
      }
      //  Activity log   
      $id = $getUserRow['userID'];
      $uname = $getUserRow['user_name'];
      $log = "INSERT INTO activity_log (name, userID, loginTime) VALUES ('$uname','$id','$date')";
      if (mysqli_query($conn, $log)) {
        header('location:index.php');
        exit;
      }
    } else {
      $errorMsg = "Wrong Input";
    }
  }
}



//for clear session

if (isset($_GET['logout']) && $_GET['logout'] == true) {
  //for offline
  date_default_timezone_set('Asia/Kolkata');
  $date = date('Y-m-d H:i:s');
  $offline = $_SESSION["email"];
  $result = mysqli_query($db, "UPDATE users SET online = '0', lastSession = '$date' WHERE email='$offline'");


  //    clear cookie
  setcookie("loge", "", time() + (86400 * 365), "/");
  setcookie("logp", "", time() + (86400 * 365), "/");
  setcookie("logo", "", time() + (86400 * 365), "/");

  session_destroy();
  header("location:index.php");
  exit;
}


if (isset($_GET['lmsg']) && $_GET['lmsg'] == true) {
  $errorMsg = "Login required to access dashboard";
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <?php include_once("layouts/header.php"); ?>

</head>

<body class="bg-gradient-primary-body">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <?php

                  if (isset($errorMsg)) {
                    echo '<div class="alert alert-danger">';
                    echo $errorMsg;
                    echo '</div>';
                    unset($errorMsg);
                  }

                  ?>

                  <!-- otp message        -->
                  <script>
                    $(document).ready(function() {
                      //##### Add record when Add Record Button is click #########
                      $("#sendOTP").click(function(e) {
                        e.preventDefault();
                        var email = $('#email').val();
                        if ($.trim(email).length == 0) {
                          alert('All fields are mandatory');
                          e.preventDefault();
                        } else if (validateEmail(email)) {
                          $("#loading").show();

                          //  alert('Nice!! your Email is valid, now you can continue..');
                          jQuery.ajax({
                            type: "POST", // Post / Get method
                            url: "asset/mail/OTP-Send.php", //Where form data is sent on submission
                            dataType: "text", // Data type, HTML, json etc.   
                            data: {
                              email: email
                            },
                            success: function(response) {
                              $("#Response").html(response);
                              $("#loading").hide();

                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                              alert(thrownError);
                            }
                          });
                        } else {
                          alert('Invalid Email Address');
                          e.preventDefault();
                        }
                      });
                    });

                    // Function that validates email address through a regular expression.
                    function validateEmail(email) {
                      var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;

                      if (filter.test(email)) {
                        return true;
                      } else {
                        return false;
                      }
                    }
                  </script>
                  <!-- error message        -->
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="form-group">
                      <input type="email" id="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="otp-veryfied">
                      <img id="loading" src="images/img/loading.gif">
                      <div id="Response">
                        <!-- send otp -->
                        <input type="submit" id="sendOTP" name="sendOTP" class="btn btn-primary btn-user float-right" value="send OTP">
                      </div>
                    </div>
                    <!-- enter otp -->
                    <div class="form-group">
                      <input type="number" class="form-control form-control-user" id="exampleInputEmail" name="otp" aria-describedby="emailHelp" placeholder="Enter OTP">
                    </div>


                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="set" class="custom-control-input" id="customCheck">

                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <input type="submit" name="login" class="btn btn-primary btn-user btn-block" value="Login">
                    <hr>
                  </form>
                  <hr>
                  <div class="text-center">
                    <!--                    <a class="small" href="forgot-password.php">Forgot Password?</a>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>






  <!--history refresh null-->

</body>

</html>