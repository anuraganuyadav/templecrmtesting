 <?php 	  
	require_once 'inc/session.php';
	
	if(!isset($_SESSION['userID'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}	
//identyfied
		if($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2){
		
          header("Location:index.php");  
		 } 

?>
<?php

require_once('inc/config.php');
         

 
      if(isset($_POST['submit'])  ){
        $user_role_id = $_POST['user_role_id'];
        $user_name = $_POST['user_name'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
          
 
 $check_user_name = mysqli_query($db, "SELECT user_name FROM users where user_name = '$user_name' "); 
 $check_email = mysqli_query($db, "SELECT Email FROM users where Email = '$email' ");  

if(mysqli_num_rows($check_user_name) > 0){
   $errMSG ="User Name Already exists";
  }
else if(preg_match('/\s/',$user_name)){
   $errMSG ="Space is Not allow In User Name";
  }        
else if(mysqli_num_rows($check_email) > 0){
   $errMSG ="Email Already exists";
  }
          
else if(strlen($_POST["password"]) < 8){
   $errMSG ="Password Must 8 characters!";
  }
       
else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = mysqli_query($db,"INSERT INTO users (user_role_id, user_name, full_name, email, password ) VALUES ('$user_role_id', '$user_name', '$full_name', '$email', '$password')");
}
    $successMSG = "User Successfully Created";
}  
          
   
          
     
//echo "<meta http-equiv='refresh' content='0'>";   
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create New User</title>
  <?php include_once("layouts/header.php");?>
</head>
<body id="page-top">
  <?php include_once("layouts/sidebar.php");?>
    <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php");?>
  <div class="container">
    <!-- call back  -->
  <button onclick="callBack()" class="back-btn"> Back </button>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
      
 <?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?> 
           
                
                
              <form class="user"  method="post">
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" autocomplete="off" name="user_name"  class="form-control form-control-user-style" id="username"   placeholder="User Name*" required>   
                    <span id="usernameLoading" class="input-group-addon"><img src="images/img/loading.gif" height="30px" alt="Ajax Indicator" /></span>  
                   <b id="usernameResult"></b>    
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="full_name" class="form-control form-control-user-style" id="exampleLastName"  placeholder="Full Name*" required>  
                  </div>
                </div>
                  
                <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="email" name="email" class="form-control form-control-user-style" id="checkEmail"   placeholder="Email Address*" required> 
                    <span id="emailLoading" class="input-group-addon"><img src="images/img/loading.gif" height="30px" alt="Ajax Indicator" /></span>  
                   <b id="emailResult"></b> 
                </div>
             <div class="col-sm-6">
            <select type="text" name="user_role_id" class="form-control form-control-user-style" required>
                  <option value="">Select Role</option>
                  <option value="1">Admin</option>
                  <option value="0">Employee</option>
                  <option value="2">Admin + Employee</option>
                  </select> 
                  </div>  
                 </div> 
                  
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                     
                    <input type="password"  name="password" class="form-control form-control-user-style" id="checkPassword" placeholder="Password*" required>
                   <span onclick="show()"><img src="https://i.stack.imgur.com/Oyk1g.png" id="EYE">
                      </span> 
                    </div> 
                    <div class="col-sm-12 mb-3 mb-sm-0">
                   <span id="PasswordLoading" class="input-group-addon">
                       <img src="images/img/loading.gif" height="30px" alt="Ajax Indicator" /></span>
                   <b id="PasswordResult"></b>     
                  </div> 
                 <!--  userpic  -->  
            </div>
              <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Register Account"> 
                <hr> 
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.php">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
   
   <?php  
    include_once("layouts/footer.php");
    ?>
</body>

</html>
