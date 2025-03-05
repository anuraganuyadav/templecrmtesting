<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}
    //identyfied
	if(($_SESSION['user_role_id'] != 0) && ($_SESSION['user_role_id'] != 2) && ($_SESSION['user_role_id'] != 3) ){
		
          header("Location:index.php");  
		 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
  <?php include_once("layouts/header.php");?>
</head>
<body id="page-top">
  <?php include_once("layouts/sidebar.php");?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php");?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- 404 Error Text -->
          <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            <a href="index.html">&larr; Back to Dashboard</a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
 <?php 
     include "inc/insert-send.php";
    include_once("layouts/footer.php");
    ?>