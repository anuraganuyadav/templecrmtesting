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
  $stmt_delete = $DB_con->prepare('DELETE FROM destinations WHERE id =:uid');
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
    <title>Add Destination</title>
    <?php include_once("layouts/header.php"); ?>
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
          <h1 class="h3 mb-0 text-gray-800">Manage Destination</h1>
        </div>

        <!-- response -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Destinations</h6>
              </div>
              <div class="response_list_wrapper form-add">
                <div class="row">
                  <div class="col-lg-6">
                    <form id="cmdline">
                      <div class="input-group">
                        <input type="text" placeholder="Press Enter For Add" class="form-control form-control-user-style1" name="InsertValue" id="sms">
                        <div class="input-group-prepend">
                          <div class="right-send">
                            <button type="submit" class="send btn-success hide" id="FormSubmit"><i class="fas fa-plus-circle add-client"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  </div>
                    <script>
                      $('#cmdline').bind('keyup', function(e) {
                        if (e.keyCode === 13) {
                          $('#cmdline').find('input[type="text"]').val('');
                        }
                      });
                    </script>


                    <div id="responds">

                      <?php
                      //include db configuration file 
                      //MySQL query
                      $Result = mysqli_query($conn, "SELECT id, destinations_list FROM destinations ");
                      //get all records from add_delete_record table
                      while ($row = mysqli_fetch_array($Result)) {
                      ?>
                      <div class="row mt-1"> 
                          <div class="col-sm-6"><?php echo $row["destinations_list"]; ?></div>
                          <div class="col-sm-6"> <a href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></div>  
                      </div> 
                      <?php
                      }
                      ?>
                    </div>
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

    <script type="text/javascript">
      $(document).ready(function() {

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
            url: "inc/add_distination.php", //Where form data is sent on submission
            dataType: "text", // Data type, HTML, json etc.
            data: myData, //Form variables
            success: function(response) {
              $("#responds").append(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError);
            }
          });
        });

      });
    </script>

  <?php
  include_once("layouts/footer.php");
} else {
  echo "<h4>You can't acccess this page </h4>";
}
  ?>