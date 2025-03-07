<?php
require_once 'inc/session.php';

error_reporting(0);
ini_set('display_errors', 0);

require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}



//identyfied
if ($_SESSION['user_role_id'] == 0 && $_SESSION['user_role_id'] == 1 && $_SESSION['user_role_id'] == 2) {

  header("Location:index.php");
}



require_once 'inc/config.php';
if (isset($_GET['lead']) && !empty($_GET['lead'])) {
  $uid = $_GET['lead'];
  $stmt_edit = $DB_con->prepare('SELECT * FROM lead WHERE id =:uid');
  $stmt_edit->execute(array(':uid' => $uid));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);
} else {
  header("Location: index.php");
}
//for deleted 	
$_SESSION['clid'] = $_GET['lead'];
$_SESSION['id'] = $_GET['lead'];


//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
  //permission access page 
  if ($id == $_GET['lead'] && $_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2 || $sales_person == $_SESSION['user_name']) {

?>
    <?php
    require_once('layouts/header.php');
    ?>

    <title>Admin Lead View</title>
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

    <script src="asset/js/bt4-table/jquery.dataTables.min.js"></script>
    <script src="asset/js/bt4-table/dataTables.bootstrap4.min.js"></script>
    <script src="asset/ckeditor/ckeditor.js"></script>
    <script src="asset/js/jquery.form.js"></script>
    <!--timepick-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="asset/css/picktim.css" rel="stylesheet" type="text/css">
    <style>
      .update {
        border: 1px solid #cac1c1;
        padding: 5px;
      }

      a:hover {
        color: white;
        text-decoration: none;
      }
    </style>
    </head>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      <?php include_once("layouts/sidebar.php"); ?>
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php"); ?>
        <!-- satart conatainer       -->

        <!--   filter path-->

        <div class="container-fluid text-light bg-client mt-o">

          <a class="btn btn-info active" data-toggle="tab" href="#Client">Lead View</a>
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
              <div class="col-sm-3">
                <h6> Phone No.</h6>
                <input class="update  w-100" data-id="<?php echo $id; ?>" id="mo_number" data-column="mo_number" value="<?php echo $mo_number; ?> ">
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

              <div class="col-sm-3">
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
                <div class="col-sm-2">
                  <h6 class="mt-1">Lead Send To</h6>
                  <select class="update form-control send-to-po" data-id="<?php echo $id; ?>" data-column="sales_person">

                    <option value="<?php echo $sales_person; ?>"> <?php echo $sales_person; ?> </option>
                    <?php
                    $salse = 0;
                    $both = 2;
                    $query_list = mysqli_query($db, "SELECT * FROM users WHERE (user_role_id ='$salse' || user_role_id ='$both')");
                    while ($row = mysqli_fetch_array($query_list)) {
                    ?>
                      <option value="<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></option>

                    <?php
                    }
                    ?>
                    <?php ?>

                  </select>
                </div>
              <?php
              }
              ?>
              <div class="col-sm-3">
                <h6> Lead Status</h6>
                <!--  status  -->
                <div class="input-group">
                  <div class="input-group-prepend w-100">
                    <select data-id="<?php echo $id; ?>" data-column="last_response" id="last_response" class="form-control form-control-user-style1 fr-select update " name="last_response" required>
                      <option class="selected-cr" value="<?php echo $last_response; ?>"><?php if (empty($last_response)) {
                                                                                          echo "Please Select Status";
                                                                                        } else {
                                                                                          echo $last_response;
                                                                                        }
                                                                                        ?>
                      </option>

                      <?php
                      $query_list = mysqli_query($db, "SELECT * FROM lead_status ORDER BY position_order");
                      while ($row = mysqli_fetch_array($query_list)) {
                      ?>
                        <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>

                      <?php
                      }
                      ?>
                      <?php ?>

                    </select>
                    <a href="Create-Potential.php?create_potential=<?php echo $id; ?>" class="btn btn-success res_interest" data-toggle="tooltip" data-placement="top" title="Create Potential!">
                      <i class="fas fa-plus-circle add-client"></i></a>
                  </div>
                </div>
              </div>

              <!--end insert itinearay Modal-->
            </div>
            <!--  End div-->
            <br>

            <div class="row">
              <!--notes-->
              <div class="col-sm-7">
                <div class="card shadow">

                  <div class="card-header-note d-block">
                    <form id="cmdline">
                      <div class="input-group">
                        <input autocomplete="off" type="text" id="noteTEXT" placeholder="Type notes..." class="p-2 w-100 m-2" name="note">
                      </div>
                      <button class="send btn-success btn-add button-not hide" id="NoteAdd" type="submit">Add</button>

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
                <div class="card text-white bg-reminder mb-3 mt-4">
                  <div class="card-header bg-primary">Add Reminder</div>
                  <div class="card-body">

                    <input type="hidden" id="dataid" name="note_id" value="<?php echo $id; ?>">
                    <input type="hidden" id="dataName" value="<?php echo $name; ?>">
                    <!-- //get user name -->
                    <?php
                    $getU = mysqli_query($conn, "SELECT sales_person from lead where id ='$id' ");
                    $u_name = mysqli_fetch_array($getU);
                    ?>
                    <input type="hidden" id="sales" value="<?php echo $u_name['sales_person']; ?>">
                    <input type="hidden" id="page" value="lead">

                    <div class="row">
                      <div class="col-sm-6">
                        <textarea type="text" id="dataNote" cols="31" rows="05" placeholder="Note"></textarea>
                      </div>
                      <div class="col-sm-6">
                        <input autocomplete="off" type="text" id="date-format" class="form-control mb-2" placeholder="Date">
                        <div class="timepicker mb-4" id="timepicker"></div>

                        <button type="button" name="insert" id="insert" class="btn btn-success btn-xs float-right">Add</button>
                      </div>
                    </div>
                    <div class="mt-3" id="messageAlert"></div>
                    <div class="mt-3" id="Alarm"></div>

                  </div>
                </div>
              </div>

              <div class="col-sm-5">
                <div class="card shadow mb-4">
                  <!-- Card Header - Accordion -->
                  <span class="d-block card-header py-3 bg-blue">
                    <h6 class="m-0 font-weight-bold text-light">View Description</h6>
                  </span>
                  <div class="card-body">
                    <textarea class="update descri form-control" data-id="<?php echo $id; ?>" data-column="description"> <?php echo $description; ?> </textarea>
                  </div>
                </div>

                <br>
                <br>
                <br>

                <div class="card shadow">
                  <!-- Card status history -->
                  <div class="collapse show" id="ViewNotes">
                    <div class="card-body">

                      <div class="table-responsive">
                        <table class="table table-bordered table-success" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Status</th>
                              <th class="text-center">Date</th>
                              <th>days</th>
                            </tr>
                          </thead>
                          <tbody id="lead-status-history">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!--end Card note history -->

                </div>


              </div>
            </div>
            <br>
          </div>


        </div>
        <!--  end container -->

        <script>
          $('#cmdline').bind('keyup', function(e) {
            if (e.keyCode === 13) {
              $('#cmdline').find('input[type="text"]').val('');
            }
          });
        </script>

        <script>
          $('#date-format').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            startDate: 'day'
          });
          $('#');
        </script>

        <!--  time picker   -->
        <script src="asset/js/jquery-migrate-3.1.0.min.js"></script>
        <script src="asset/js/picktim.js"></script>
        <script>
          $(".timepicker").picktim({
            mode: 'h12'
          });
        </script>
        <script>
          // if select today  
          var interest = $(document).ready(function() {
            $("#lead-status-history").load("load-data/lead-status-history.php");
            $('#last_response').on('change', function() {
              if ($(this).val() === 'Interested') {
                $(".res_interest").show();
              } else {
                $(".res_interest").hide();
              }
            });
            if ($('#last_response').val() === 'Interested') {
              $(".res_interest").show();
            } else {
              $(".res_interest").hide();
            }
          });
        </script>
        <script type="text/javascript">
          $(document).ready(function() {

            $("#notes").load("load-data/add-lead-notes.php");
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
                url: "load-data/add-lead-notes.php", //Where form data is sent on submission
                dataType: "text", // Data type, HTML, json etc.   
                data: {
                  note: note,
                  id: id
                },
                success: function(response) {
                  $("#noteResponse<?php echo $id; ?>").prepend(response);
                  $("#notes").load("load-data/add-lead-notes.php");
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
                  url: "inc/delete-lead-notes.php",
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

        <!-- update-->
        <script>
          function update_data(id, column_name, value) {
            $.ajax({
              url: "inc/update-lead.php",
              method: "POST",
              data: {
                id: id,
                column_name: column_name,
                value: value
              },
              success: function(data) {
                $('#alert_message').html('<div class="alert alert-size alert-success">' + data + '</div>');
                $("#lead-status-history").load("load-data/lead-status-history.php");
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
          $("#whatsapp_n").load("load-data/lead-whatsapp-number.php");
          $(".wtp_no").keyup(function() {
            var id = $(this).data("id");
            var column_name = $(this).data("column");
            var value = $(this).val();
            update_data(id, column_name, value);
            $("#whatsapp_n").load("load-data/lead-whatsapp-number.php");
          });

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

            $(document).on('click', '#insert', function() {
              var DataID = $('#dataid').val();
              var name = $('#dataName').val();
              var note = $('#dataNote').val();
              var date = $('#date-format').val();
              var time = $('.time-input').val();
              var sales = $('#sales').val();
              var page = $('#page').val();
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
                    //for reminder
                    $("#Alarm").load("load-data/reminderFetch.php");
                  }
                });
                setInterval(function() {
                  $('#messageAlert').html('');
                }, 5000);
              } else {
                alert("Some Fields is required");
              }
            });
            // $(document).on('click', '#insert', function() {
            //   var DataID = $('#dataid').val();
            //   var name = $('#dataName').val();
            //   var note = $('#dataNote').val();
            //   var date = $('#date-format').val();
            //   var time = $('.time-input').val();
            //   var sales = $('#sales').val();
            //   var page = $('#page').val();
            //   var remark = $('#remark').val(); // Get the value of the remark field

            //   // Check if all necessary fields are filled in
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
            //         page: page,
            //         remark: remark // Include the remark field in the request
            //       },
            //       success: function(data) {
            //         // Show success message
            //         $('#messageAlert').html('<div class="alert alert-success">' + data + '</div>');

            //         // Reload relevant sections of the page
            //         $("#reminder").load("reminder.php");
            //         $("#Alarm").load("load-data/reminderFetch.php");
            //       }
            //     });

            //     // Clear the success message after 5 seconds
            //     setInterval(function() {
            //       $('#messageAlert').html('');
            //     }, 5000);

            //   } else {
            //     alert("Some Fields are required");
            //   }
            // });

            // delete reminder 
            $(document).on('click', '.delete', function() {
              var id = $(this).attr("id");
              if (confirm("Are you sure you want to remove this?")) {
                $.ajax({
                  url: "inc/delete-REMINDER.php",
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
    <?php
    include_once("layouts/footer.php");
  } else {
    header("Location: index.php");
  }
} else {
  echo "<h4>You can't acccess this page </h4>";
}
    ?>