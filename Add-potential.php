<?php
require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

  header("Location:index.php");
}


//for deleted
include "inc/config.php";
if (isset($_GET['delete_id'])) {

  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM status WHERE id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  //		header("Location:menu_management.php");
}
//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Add Status</title>
    <?php include_once("layouts/header.php"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  </head>

  <body id="page-top">
    <?php include_once("layouts/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <?php include_once("layouts/nav.php"); ?>
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <button onclick="callBack()" class="back-btn"> Back </button>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-response_list-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Manage Potential Status</h1>
        </div>

        <!-- response -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Potential status</h6>
              </div>
              <div class="response_list_wrapper form-add">
                <div class="row">
                  <div class="col-lg-6">
                    <form id="cmdline">
                      <div class="input-group">
                        <input type="text" placeholder="Press Enter For Add" class="p-2 mb-1 w-100 form-control-user-style1" name="InsertValue" id="sms">
                        <div class="input-group-prepend">
                          <div class="right-send">
                            <button type="submit" class="send btn-success hide" id="FormSubmit"><i class="fas fa-plus-circle add-client"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>
                    <script>
                      $('#cmdline').bind('keyup', function(e) {
                        if (e.keyCode === 13) {
                          $('#cmdline').find('input[type="text"]').val('');
                        }
                      });
                    </script>

                    <span id="alert"></span>
                    <table class="table table-sm table-bordered table-responsive">
                      <tr>
                        <th>status</th>
                        <th>Action</th>
                      </tr>
                      <tbody id="potentials" class="tb-row-position">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--    end col-->
        </div>
        <!--            end row-->
      </div>
      <!-- /.container-fluid -->

    </div>

    <!--add response    -->

    <script>
      $(document).ready(function() {
        $("#potentials").load("load-data/all_potential.php");
        //##### Add record when Add Record Button is click #########
        $("#FormSubmit").click(function(e) {
          e.preventDefault();
          if ($("#sms").val() === '') {
            alert("Please enter some text!");
            return false;
          }
          var myData = 'InsertValue=' + $("#sms").val(); //build a post data structure
          jQuery.ajax({
            type: "POST", // Post / Get method
            url: "load-data/all_potential.php", //Where form data is sent on submission
            dataType: "text", // Data type, HTML, json etc.
            data: myData, //Form variables
            success: function(response) {
              $("#potentials").load("load-data/all_potential.php");
            }
          });
        });

      });

      $(".tb-row-position").sortable({
        delay: 150,
        stop: function() {
          var selectedData = new Array();
          $('.tb-row-position>tr').each(function() {
            selectedData.push($(this).attr("id"));
          });
          updateOrder(selectedData);
        }
      });

      function updateOrder(data) {
        $.ajax({
          url: "load-data/all-potential-drag.php",
          type: 'post',
          data: {
            position: data
          },
          success: function(data) {
            $("#alert").html(data);
          }
        })
      }
    </script>

  <?php
  include_once("layouts/footer.php");
} else {
  echo "<h4>You can't acccess this page </h4>";
}
  ?>