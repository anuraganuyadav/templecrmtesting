<?php
require_once 'inc/session.php';
error_reporting(~E_NOTICE);

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] == 0 && $_SESSION['user_role_id'] == 1 && $_SESSION['user_role_id'] == 2) {

  header("Location:index.php");
}

error_reporting(~E_NOTICE);
require_once 'inc/config.php';

if (isset($_GET['view_potential']) && !empty($_GET['view_potential'])) {

  $uid = $_GET['view_potential'];
  $_SESSION['potential_id'] = $_GET['view_potential'];
  $_SESSION['clid'] = $_GET['view_potential'];

  // Prepare the query
  $stmt_edit = $DB_con->prepare('SELECT * FROM potential WHERE id = :uid');
  $stmt_edit->execute(array(':uid' => $uid));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);

  // Check if the query returned a result
  if ($edit_row) {
    // If data is found, extract the result
    extract($edit_row);
  } else {
    // If no result is found, redirect or handle error
    echo "No data found for the given ID.";

    exit;
  }
} else {
  header("Location: index.php");
  exit;
}

// error_reporting(~E_NOTICE);
// require_once 'inc/config.php';
// if (isset($_GET['view_potential']) && !empty($_GET['view_potential'])) {

//   $uid = $_GET['view_potential'];
//   $_SESSION['potential_id'] = $_GET['view_potential'];
//   $_SESSION['clid'] = $_GET['view_potential'];

//   $stmt_edit = $DB_con->prepare('SELECT * FROM potential WHERE id =:uid');
//   $stmt_edit->execute(array(':uid' => $uid));
//   $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
//   extract($edit_row);
// } else {
//   header("Location: index.php");
// }

//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
  //permission access page 
  if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2 || $sales_person == $_SESSION['user_name']) {

?>
    <title>Potential View</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <script src="asset/js/createaccount-validation.js"> </script>
    <!--end  from header-->

    <!--  css from asset-->
    <link rel="stylesheet" href="asset/css/style-Admin.css">

    <script src="asset/js/jquery.form.js"></script>
    <!--timepick-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="asset/css/picktim.css" rel="stylesheet" type="text/css">

    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker.min.css">
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker-theme.css">
    </head>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      <?php include_once("layouts/sidebar.php"); ?>
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php"); ?>
        <!-- satart conatainer       -->

        <div class="container-fluid text-light bg-client mt-o pt-1">

          <a class="btn btn-info active" data-toggle="tab" href="#Client">Potential View</a>
          <!-- call back  -->
          <button onclick="callBack()" class="back-btn"> Back </button>
          <!-- client detail     -->
          <div class="card shadow card-login mx-auto mt-2">
            <div class="card-header bg-primary text-light">View Detail</div>
            <!-- insert itinearay Modal-->

            <div id="alert_message"></div>


            <div class="row p-2">
              <div class="col-sm-4">
                <h6> Name</h6>
                <input class="update w-100" data-id="<?php echo $id; ?>" id="name" data-column="name" value="<?php echo $name; ?>">
              </div>
              <div class="col-sm-2">
                <h6> Person</h6>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input class="update with-100" data-id="<?php echo $id; ?>" id="no_person" data-column="no_person" value="<?php echo $no_person; ?>">
                </div>
              </div>
              <div class="col-sm-3">
                <h6> Phone No.</h6>
                <input class="update  w-100" data-id="<?php echo $id; ?>" id="mo_number" data-column="mo_number" value="<?php echo $mo_number; ?> ">
              </div>
              <div class="col-sm-3">
                <h6> Destinations</h6>
                <div class="travel-date">
                  <div class="input-group ">
                    <div class="input-group">
                      <div id="apply"></div>
                      <select data-id="<?php echo $id; ?>" data-column="destination" id="menuID" class="form-control update w-100" data-toggle="tooltip" data-original-title="Select Destination">
                        <?php
                        if (empty($destination)) {
                          echo "<option value=''>Select Destination</option>";
                        } else {
                          echo "<option value='" . $destination . "'>$destination</option>";
                        }
                        ?>

                        <?php
                        $dest = mysqli_query($conn, "SELECT * FROM destinations ORDER BY destinations_list ASC");
                        while ($location = mysqli_fetch_array($dest)) {
                        ?>
                          <option value="<?php echo $location['destinations_list']; ?>">
                            <?php echo $location['destinations_list']; ?>
                          </option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <h6> Email</h6>
                <input class="update w-100" data-id="<?php echo $id; ?>" id="email" data-column="email" value="<?php echo $email; ?> ">
              </div>
              <div class="col-sm-2">
                <h6> Amount</h6>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                  </div>
                  <input class="amount update with-100" id="amount" data-id="<?php echo $id; ?>" data-column="amount" value="<?php echo $amount; ?>">
                </div>
              </div>
              <div class="col-sm-3">
                <h6> Travel Date</h6>
                <input id="daterange" data-theme="blue" class="datepicker update w-100" value="<?php echo  date('Y/m/d', strtotime($travel_date)); ?>" type="text" placeholder="DD/MM/YYYY">
              </div>
              <div class="col-sm-3">
                <h6> Potential Status</h6>
                <!--  status  -->
                <select id="status" class="form-control update w-100" data-id="<?php echo $id; ?>" data-column="status">
                  <option class="selected-cr" value=""><?php echo $status; ?></option>

                  <?php
                  $query_list = mysqli_query($db, "SELECT * FROM potential_status ORDER BY position_order");
                  while ($row = mysqli_fetch_array($query_list)) {
                  ?>
                    <option value="<?php echo $row['status']; ?>">
                      <?php echo $row['status']; ?>
                    </option>

                  <?php
                  }

                  ?>
                </select>
                <div class="addInAccount text-right mt-5">
                  <?php
                  // $CDB_HOST = 'localhost';
                  // $CDB_USER = 'account_crm';
                  // $CDB_PASS = 'q^Qgm8%uOH!e';
                  // $CDB_NAME = 'account_crm';
                  $CDB_HOST = 'localhost';
                  $CDB_USER = 'root';
                  $CDB_PASS = '';
                  $CDB_NAME = 'account_crm';

                  $connAcc = mysqli_connect("$CDB_HOST", "$CDB_USER", "$CDB_PASS", "$CDB_NAME");
                  mysqli_select_db($connAcc, $CDB_NAME);

                  $check = mysqli_query($connAcc, "SELECT * FROM leads WHERE client_id = '$id'");

                  if (mysqli_num_rows($check) > 0) {
                    echo ' <i id="message_descr" class="text-success"><img src="images/img/small-done.gif" width="25px">Added In Accounts</i>';
                  } else {
                    if ($status == 'Payment Received') {

                      if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {


                        echo '<div class="input-group"><input type="number" class="form-control received_amount update" data-id="' . $id . '" data-column="received_amount"  placeholder="enter amount*" value="' . $received_amount . '">
                      <button type="button" data-id="' . $id . '" class="btn btn-sm btn-success AddInAcount">Add In Account</button></div>';
                      } else {
                        echo '<div class="input-group"><input type="number" data-id="' . $id . '" data-column="received_amount"  class="form-control received_amount update" placeholder="enter amount*" value="' . $received_amount . '"></div>';
                      }
                    }
                  }
                  ?>
                </div>

                <span id="paymentResponse"></span>
              </div>
              <div class="col-sm-4">
                <h6 class="mt-1">Whatsapp Number</h6>
                <div class="input-group  mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="whatsapp_n"> </span>
                  </div>
                  <input type="number" class="update form-control wtp_no" data-id="<?php echo $id; ?>" data-column="wtp_no" value="<?php echo $wtp_no; ?>">
                </div>
              </div>
              <?php
              if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {
              ?>
                <div class="col-sm-3">
                  <h6 class="mt-1">Potential Send To</h6>
                  <select class="update form-control send-to-po" data-id="<?php echo $id; ?>" data-column="sales_person">

                    <?php
                    $salse = 0;
                    $both = 2;
                    $query_list = mysqli_query($db, "SELECT * FROM users WHERE (user_role_id ='$salse' || user_role_id ='$both')");
                    while ($row = mysqli_fetch_array($query_list)) {
                    ?>
                      <option value="<?php echo $row['user_name']; ?>" <?php if ($sales_person == $row['user_name']) {
                                                                          echo 'selected';
                                                                        } ?>><?php echo $row['user_name']; ?></option>

                    <?php
                    }
                    ?>
                    <?php ?>

                  </select>
                </div>
              <?php
              }
              ?>
              <!--end insert itinearay Modal-->
            </div>
            <!--emd client detail     -->
            <!--client status-->
            <div class="card shadow mt-2">
              <div class="row">
                <!--notes-->
                <div class="col-sm-7">
                  <div class="card shadow">

                    <div class="card-header-note d-block">
                      <form id="cmdline">
                        <div class="input-group">
                          <input autocomplete="off" type="text" id="noteTEXT" placeholder="Type notes..." class="p-2 w-100 m-2" name="note">
                        </div>
                        <button class="send btn-success btn-add button-note hide" id="NoteAdd" type="submit">Add</button>

                      </form>

                    </div>
                    <!-- Card note history -->
                    <div class="collapse show" id="ViewNotes">
                      <div class="card-body">
                        <!--// notes-->
                        <!-- table   -->
                        <div id="notes"></div>

                      </div>
                    </div>
                  </div>

                  <script type="text/javascript">
                    $(document).ready(function() {

                      $("#notes").load("load-data/add-potential-notes.php");
                      //##### Add record when Add Record Button is click #########
                      $("#NoteAdd").click(function(e) {
                        e.preventDefault();
                        if ($("#noteTEXT").val() === '') {
                          alert("Please Enter Text!");
                          return false;
                        }
                        var note = $("#noteTEXT").val(); //build a post data structure
                        var id = "<?php echo $id; ?>"; //build a post data structure
                        jQuery.ajax({
                          type: "POST", // Post / Get method
                          url: "load-data/add-potential-notes.php", //Where form data is sent on submission
                          dataType: "text", // Data type, HTML, json etc.   
                          data: {
                            note: note,
                            id: id
                          },
                          success: function(response) {
                            $("#noteResponse<?php echo $id; ?>").prepend(response);
                            $("#notes").load("load-data/add-potential-notes.php");
                            $("#noteTEXT").val("");
                          },
                          error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                          }
                        });
                      });
                      // delete notes 
                      $(document).on('click', '.deleteNote', function() {
                        var id = $(this).attr("id");
                        if (confirm("Are you sure you want to delete note?")) {
                          $.ajax({
                            url: "inc/delete-potential-notes.php",
                            method: "POST",
                            data: {
                              id: id
                            },
                            success: function(data) {
                              $('#messageAlert').html('<div class="alert alert-success">' + data + '</div>');

                              fetch_data();
                            }
                          });
                          $(this).parents("tr").animate({
                              backgroundColor: "#003"
                            }, "slow")
                            .animate({
                              opacity: "hide"
                            }, "slow");
                          setInterval(function() {
                            $('#messageAlert').html('');
                          }, 5000);
                        }
                      });

                    });
                  </script>
                  <!--   Reminder note     -->
                  <div class="card text-white bg-reminder mb-3 mt-4">
                    <div class="card-header bg-primary">Add Reminder</div>
                    <div class="card-body">

                      <input type="hidden" id="dataid" name="note_id" value="<?php echo $id; ?>">
                      <input type="hidden" id="dataName" value="<?php echo $name; ?>">

                      <!-- //get user name -->
                      <?php
                      $getU = mysqli_query($conn, "SELECT sales_person from potential where id ='$id' ");
                      $u_name = mysqli_fetch_array($getU);
                      ?>
                      <input type="hidden" id="sales" value="<?php echo $u_name['sales_person']; ?>">
                      <input type="hidden" id="page" value="potential">

                      <div class="row">
                        <div class="col-sm-6">
                          <textarea type="text" id="dataNote" cols="31" rows="05" placeholder="Note"></textarea>
                        </div>
                        <div class="col-sm-6">
                          <input autocomplete="off" type="text" id="date-format" class="form-control mb-2" placeholder="Date">

                          <script>
                            $('#date-format').datepicker({
                              weekStart: 1,
                              daysOfWeekHighlighted: "6,0",
                              autoclose: true,
                              todayHighlight: true,
                              format: 'yyyy-mm-dd',
                              startDate: 'day'
                            });
                          </script>
                          <div class="timepicker mb-4" id="timepicker"></div>

                          <button type="button" name="insert" id="insert" class="btn btn-success btn-xs float-right">Add</button>
                        </div>
                      </div>

                      <!--  time picker   -->
                      <script src="asset/js/jquery-migrate-3.1.0.min.js"></script>
                      <script src="asset/js/picktim.js"></script>
                      <script>
                        $(".timepicker").picktim({
                          mode: 'h12'
                        });
                      </script>



                      <div id="messageAlert"></div>

                      <!--     sho table reminder-->
                      <div id="Alarm"></div>

                      <script>
                        $(document).ready(function() {
                          $("#Alarm").load("load-data/reminderFetch.php");

                          function update_data(id, column_name, value) {
                            $.ajax({
                              url: "inc/update-REMINDER.php",
                              method: "POST",
                              data: {
                                id: id,
                                column_name: column_name,
                                value: value
                              },
                              success: function(data) {
                                $('#messageAlert').html('<div class="alert alert-success">' + data + '</div>');
                                $("#Alarm").load("load-data/reminderFetch.php");
                              }
                            });
                            setInterval(function() {
                              $('#messageAlert').html('');
                            }, 5000);
                          }
                          $(document).on('blur', '.rupdate', function() {
                            var id = $(this).data("id");
                            var column_name = $(this).data("column");
                            var value = $(this).val();
                            update_data(id, column_name, value);
                          });


                          // $(document).on('click', '#insert', function() {
                          //   var DataID = $('#dataid').val();
                          //   var name = $('#dataName').val();
                          //   var note = $('#dataNote').val();
                          //   var date = $('#date-format').val();
                          //   var time = $('.time-input').val();
                          //   var sales = $('#sales').val();
                          //   var page = $('#page').val();
                          //   if (name != '' && note != '' && date != '' && time != '' && DataID != '') {
                          //     $.ajax({
                          //       url: "inc/insert-REMINDER.php",
                          //       method: "POST",
                          //       data: {
                          //         name: name,
                          //         note: note,
                          //         time: time,
                          //         date: date,
                          //         DataID: DataID,
                          //         sales: sales,
                          //         page: page
                          //       },
                          //       success: function(data) {
                          //         $('#messageAlert').html('<div class="alert alert-success">' + data + '</div>');

                          //         $("#reminder").load("reminder.php");
                          //         //for reminder

                          //         $("#Alarm").load("load-data/reminderFetch.php");
                          //       }
                          //     });
                          //     setInterval(function() {
                          //       $('#messageAlert').html('');
                          //     }, 5000);
                          //   } else {
                          //     alert("Some Fields is required");
                          //   }
                          // });


                          $(document).on('click', '#insert', function() {
                            var DataID = $('#dataid').val();
                            var name = $('#dataName').val();
                            var note = $('#dataNote').val();
                            var date = $('#date-format').val();
                            var time = $('.time-input').val();
                            var sales = $('#sales').val();
                            var page = $('#page').val();

                            // Check if time is between 9 AM and 9 PM
                            var timeRegex = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/; // Regex to match time format "HH:MM"
                            var timeMatch = time.match(timeRegex);

                            if (timeMatch) {
                              var hour = parseInt(timeMatch[1]);
                              if (hour < 9 || hour > 21) {
                                alert("Please select a time between 9 AM and 9 PM only. If there are any updates, please contact the admin to correct it.");
                                return; // Stop further execution if time is invalid
                              }
                            } else {
                              alert("Please enter a valid time.");
                              return;
                            }

                            // Proceed with the AJAX request if all fields are valid
                            if (name != '' && note != '' && date != '' && time != '' && DataID != '') {
                              $.ajax({
                                url: "inc/insert-REMINDER.php",
                                method: "POST",
                                data: {
                                  name: name,
                                  note: note,
                                  time: time,
                                  date: date,
                                  DataID: DataID,
                                  sales: sales,
                                  page: page
                                },
                                success: function(data) {
                                  $('#messageAlert').html('<div class="alert alert-success">' + data + '</div>');
                                  $("#reminder").load("reminder.php");
                                  // for reminder
                                  $("#Alarm").load("load-data/reminderFetch.php");
                                }
                              });
                              setInterval(function() {
                                $('#messageAlert').html('');
                              }, 5000);
                            } else {
                              alert("Some Fields are required");
                            }
                          });


                          // $(document).on('click', '.delete', function() {
                          //   var id = $(this).attr("id");
                          //   if (confirm("Are you sure you want to remove this?")) {
                          //     $.ajax({
                          //       url: "inc/delete-REMINDER.php",
                          //       method: "POST",
                          //       data: {
                          //         id: id
                          //       },
                          //       success: function(data) {
                          //         $('#messageAlert').html('<div class="alert alert-success">' + data + '</div>');
                          //       }
                          //     });

                          //     $(this).parents('tr').fadeOut("2000");
                          //     setInterval(function() {
                          //       $('#messageAlert').html('');
                          //     }, 5000);
                          //   }
                          // });
                          
                          $(document).on('click', '.delete', function() {
                            var id = $(this).attr("id");
                            var row = $(this).parents("tr"); // Store the row element to remove later
                            if (confirm("Are you sure you want to remove this?")) {
                              $.ajax({
                                url: "inc/delete-REMINDER.php",
                                method: "POST",
                                data: {
                                  id: id
                                },
                                success: function(response) {
                                  console.log(response); // Debugging line to check the response

                                  if (response == 'Data Deleted') {
                                    // Fade out and remove the row from the UI after successful delete
                                    row.animate({
                                      backgroundColor: "#003"
                                    }, "slow").animate({
                                      opacity: "hide"
                                    }, "slow", function() {
                                      $(this).remove(); // Remove the row after the animation
                                    });

                                    // Optionally, refresh the data to ensure consistency
                                    fetch_data();
                                  } else {
                                    $('#messageAlert').html('<div class="alert alert-danger">' + response + '</div>');
                                  }
                                },
                                error: function(xhr, status, error) {
                                  console.log("Error: " + error); // Log the error to debug
                                  $('#messageAlert').html('<div class="alert alert-danger">Error: ' + error + '</div>');
                                }
                              });
                            }
                          });


                        });
                      </script>
                    </div>
                  </div>

                </div>

                <div class="col-sm-5">
                  <!-- Collapsable Description -->
                  <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <span class="d-block card-header py-3 bg-blue">
                      <h6 class="m-0 font-weight-bold text-light">View Description</h6>
                    </span>
                    <!-- Card Content - Collapse -->
                    <div class="card-body">
                      <!-- response   message-->
                      <textarea cols="5" rows="3" class="update descri text-dark form-control" data-id="<?php echo $id; ?>" data-column="description"><?php echo $description; ?></textarea>
                    </div>


                    <!-- status history   -->

                    <div class="card bg-reminder shadow">
                      <!-- Card status history -->
                      <div class="collapse show" id="ViewNotes">
                        <!--// notes-->
                        <!-- table   -->
                        <div class="table-responsive">
                          <table class="table table-bordered table-success" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>Status</th>
                                <th class="text-center">Date</th>
                                <th>days</th>
                              </tr>
                            </thead>
                            <tbody id="potential-status-history">

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--end client status-->
            </div>

          </div>
          <br>
        </div>
        <script type="text/javascript" src="asset/date-range/dist/duDatepicker.min.js"></script>

        <!-- update-->
        <script>
          $(document).ready(function() {
            $("#potential-status-history").load("load-data/potential-status-history.php");

            function update_data(id, column_name, value) {
              if (column_name == 'status') {

                <?php
                if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {

                ?>
                  if (value == 'Payment Received') {
                    $('.addInAccount').html('<div class="input-group"><input type="number" data-id="' + id + '" data-column="received_amount" class="form-control received_amount update" placeholder="enter amount*"><button data-id="' + id + '" class="btn btn-sm btn-success AddInAcount">Add In Account</button></div>');
                  } else {
                    $('.addInAccount').html('');
                  }
                <?php
                } else {
                ?>
                  if (value == 'Payment Received') {
                    $('.addInAccount').html('<div class="input-group"><input type="number" data-id="' + id + '" data-column="received_amount" class="form-control received_amount update" placeholder="enter amount*"></div>');
                  } else {
                    $('.addInAccount').html('');
                  }

                <?php
                }
                ?>


              }

              $.ajax({
                url: "inc/potential/update.php",
                method: "POST",
                data: {
                  id: id,
                  column_name: column_name,
                  value: value
                },
                success: function(data) {
                  $('#alert_message').html('<div class="alert alert-size alert-success">' + data + '</div>');

                  $("#potential-status-history").load("load-data/potential-status-history.php");
                }
              });
              setInterval(function() {
                $('#alert_message').html('');
              }, 3000);
            }

            $(document).on('change', '.update', function() {
              var id = $(this).data("id");
              var column_name = $(this).data("column");
              var value = $(this).val();
              update_data(id, column_name, value);
            });


            // whats app number  
            $("#whatsapp_n").load("load-data/potential-whatsapp-number.php");
            $(".wtp_no").keyup(function() {
              var id = $(this).data("id");
              var column_name = $(this).data("column");
              var value = $(this).val();
              update_data(id, column_name, value);
              $("#whatsapp_n").load("load-data/potential-whatsapp-number.php");
            });

            // Date picker  
            duDatepicker('#daterange', {
              range: false,
              format: 'yyyy/mm/dd',
              outFormat: 'yyyy-mm-dd',
              fromTarget: '.datepicker',
              clearBtn: false,
              theme: 'yellow',
              inline: true,
              events: {
                ready: function() {
                  // console.log('duDatepicker', this)

                },
                dateChanged: function(data) {
                  //console.log('new date', data)
                  var id = "<?php echo $id; ?>";
                  var column_name = "travel_date";
                  var value = $("#daterange").val();
                  update_data(id, column_name, value);
                }
              }
            });
          });
        </script>


        <!-- send mail payment received -->
        <?php
        if ($_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2) {

        ?>

          <script>
            $(document).ready(function() {
              //#AddInAcount
              $(document).on('click', '.AddInAcount', function() {
                var userId = $(this).data('id');
                var received_amount = $('.received_amount').val();


                if (received_amount != '') {
                  jQuery.ajax({
                    type: "POST", // Post / Get method
                    url: "inc/potential/AddInAcount.php", //Where form data is sent on submission
                    dataType: "text", // Data type, HTML, json etc.   
                    data: {
                      userId: userId,
                      received_amount: received_amount
                    },
                    success: function(response) {
                      $("#paymentResponse").html(response);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                      alert(thrownError);
                    }
                  });
                } else {
                  alert('Please enter received amount first');
                }
              });
            });



            $(document).ready(function() {
              //##### Add record when Add Record Button is click #########
              $("#statusResponse").click(function(e) {
                e.preventDefault();

                var name = $("#name").text(); //build a post data structure 
                var full_name = $("#full_name").val(); //build a post data structure 
                var email = $("#email").text(); //build a post data structure 
                var amount = $(".amount").text(); //build a post data structure 
                var status = $("#status").val(); //build a post data structure 


                jQuery.ajax({
                  type: "POST", // Post / Get method
                  url: "asset/mail/PaymentReceived.php", //Where form data is sent on submission
                  dataType: "text", // Data type, HTML, json etc.   
                  data: {
                    name: name,
                    full_name: full_name,
                    email: email,
                    amount: amount,
                    status: status
                  },
                  success: function(response) {
                    $("#paymentResponse").html(response);

                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                  }
                });
              });

            });
          </script>
    <?php
        }
        include_once("layouts/footer.php");
      } else {
        header("Location: index.php");
      }
    } else {
      echo "<h4>You can't acccess this page </h4>";
    }
    ?>