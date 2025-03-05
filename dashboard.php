<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
     header('location:login.php?lmsg=true');
     exit;
}
include "inc/config.php";
//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
?>
     <!DOCTYPE html>
     <html lang="en">

     <head>
          <title>Dashboard</title>
          <!-- from header-->
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="description" content="">
          <meta name="author" content="">

          <!--  favicon -->
          <link rel="shortcut icon" href="asset/img/fav-icon.png" type="image/x-icon">
          <link rel="icon" href="asset/img/fav-icon.png" type="image/x-icon">

          <!-- Custom fonts for this template-->
          <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
          <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
          <!-- Page level plugin CSS-->

          <!-- Custom styles for this template-->
          <link href="asset/css/sb-admin-2.css" rel="stylesheet">
          <link href="asset/css/style.css" rel="stylesheet">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

          <!--datepicker-->
          <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js">
          </script>
          <script src="asset/js/createaccount-validation.js"> </script>
          <!--end  from header-->

          <link rel="stylesheet" href="asset/css/style-Admin.css">
          <!-- Datatable CSS -->
          <link href='asset/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
          <!-- Datatable JS -->
          <script src="asset/DataTables/datatables.min.js"></script>
     </head>

     <body id="page-top">
          <?php include_once("layouts/sidebar.php"); ?>
          <!-- Content Wrapper -->
          <div id="content-wrapper" class="d-flex flex-column">
               <?php include_once("layouts/nav.php"); ?>
               <!-- Begin Page Content -->

               <div class="d-flex justify-content-center">
                    <img src="images/img/logo.png" class="img-fluid w-25">
               </div>
               <?php
               //identyfied
               if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {
               ?>

                    <div class="container-fluid">
                         <?php include_once("Price-list.php"); ?>
                    </div>

               <?php
               }
               if (($_SESSION['user_role_id'] == 0 || $_SESSION['user_role_id'] == 2)) {
               ?>
                    <div class="container-fluid p-0">
                         <div class="border bg-success text-light pt-4">
                              <h4 class="text-center">Update</h4>

                              <div class="d-flex justify-content-center comming-soon">
                                   <img src="images/update.png" class="img-fluid w-25">

                              </div>
                         </div>
                    </div>
               <?php
               } else {
                    header("Location:index.php");
               }
               ?>

          </div>
          <!-- End of Main Content -->
     <?php

     include_once("layouts/footer.php");
} else {
     echo "<h4>You can't acccess this page </h4>";
}
     ?>