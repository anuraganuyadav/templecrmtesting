<?php
require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
error_reporting(~E_NOTICE);

require_once 'inc/config.php';


if (isset($_GET['create_potential']) && !empty($_GET['create_potential'])) {
  $uid = $_GET['create_potential'];
  $stmt_edit = $DB_con->prepare('SELECT * FROM lead WHERE id =:uid');
  $stmt_edit->execute(array(':uid' => $uid));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);
} else {
  header("Location: index.php");
}



//identyfied
if ($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 1  && $_SESSION['user_role_id'] != 2) {
  header("Location:index.php");
}

//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {


  //permission access page 
  if ($id ==  $uid && $_SESSION['user_role_id'] == 1 || $_SESSION['user_role_id'] == 2 || $sales_person == $_SESSION['user_name']) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <?php
      require_once('layouts/header.php');
      ?>
      <title>Create Potential</title>
      <!-- Date-time picker css -->
      <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker.min.css">
      <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker-theme.css">
    </head>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      <?php include_once("layouts/sidebar.php"); ?>
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php"); ?>

        <div class="container">
          <button onclick="callBack()" class="back-btn"> Back </button>
          <div class="card shadow card-login mx-auto mt-5 under-cr">
            <div class="card-header">Create Potential</div>
            <!-- insert itinearay Modal-->
            <div id="msg"></div>

            <div class="row">
              <!-- name-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-male"></i></span>
                  </div>
                  <input class="form-control form-control-user-style1" type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Name" required>
                </div>
              </div>
              <!-- email-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-envelope-open-text"></i></span>
                  </div>
                  <input class="form-control form-control-user-style1" type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email id">
                </div>
              </div>

              <!-- MO Number-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-mobile-alt"></i></span>
                  </div>
                  <input class="form-control form-control-user-style1" type="text" id="mo_number" name="mo_number" value="<?php echo $mo_number; ?>" placeholder="Mobile Number">
                </div>
              </div>
              <!-- destination-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-map-marker-alt"></i></span>
                  </div>
                  <input class="form-control form-control-user-style1" type="text" id="destination" name="destination" value="<?php echo $destination; ?>" placeholder="Enter Destination">
                </div>
              </div>
              <!-- Number of person-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-users"></i></span>
                  </div>
                  <input class="form-control form-control-user-style1" type="text" id="no_person" name="no_person" value="<?php echo $no_person; ?>" placeholder="Number of person">
                </div>
              </div>

              <!-- status-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic">
                      <i class="fas fa-sticky-note"></i></span>
                  </div>


                  <select class="form-control form-control-user-style1 fr-select" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <?php
                    $query_list = mysqli_query($db, "SELECT * FROM potential_status ORDER BY position_order");
                    while ($row = mysqli_fetch_array($query_list)) {
                    ?>
                      <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>

                    <?php
                    }
                    ?>
                    <?php ?>

                  </select>
                </div>
              </div>
              <!-- Amount-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-rupee-sign"></i></span>
                  </div>
                  <input class="form-control form-control-user-style1" type="number" id="amount" name="amount" placeholder="Enter Package Amount">
                </div>
              </div>


              <!-- trvel date-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-calendar"></i></span>
                  </div>
                  <input id="datepickerCreate" autocomplete="off" data-theme="blue" class="form-control datepicker form-control-user-style1" type="text" placeholder="DD/MM/YYYY">
                </div>
              </div>

              <!-- Description-->
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text fa-ic"><i class="fas fa-comments"></i></span>
                  </div>
                  <textarea class="form-control form-control-user-style1" id="description" name="description" placeholder="description"><?php echo $description; ?> </textarea>
                </div>
              </div>
              <input type="hidden" value="<?php echo $sales_person; ?>" id="sales_person" name="sales_person">

              <input type="hidden" value="<?php echo $last_response; ?>" id="last_response" name="last_response">
              <input type="hidden" value="<?php echo $wtp_no; ?>" id="wtp_no" name="wtp_no">
              <input type="hidden" value="<?php echo $id; ?>" id="proposal_id" name="proposal_id">



              <button class="submit btn btn-success btn-icon-split move_value" type="submit" name="move_perposal">
                <span class="icon text-white-50">
                  <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Create Potential</span>
              </button>


            </div>



            <!--end insert itinearay Modal-->



          </div>
        </div>
      </div>

      <script>
        //tooltrip 
        $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();

          //datepicker
          // Date picker  
          duDatepicker('#datepickerCreate', {
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

              }
            }
          });

          $(document).on('click', '.submit', function() {

            var name = $("#name").val();
            var email = $("#email").val();
            var mo_number = $("#mo_number").val();
            var destination = $("#destination").val();
            var no_person = $("#no_person").val();
            var status = $("#status").val();
            var amount = $("#amount").val();
            var travel_date = $("#datepickerCreate").val();
            var description = $("#description").val();
            var sales_person = $("#sales_person").val();
            var last_response = $("#last_response").val();
            var wtp_no = $("#wtp_no").val();
            var proposal_id = $("#proposal_id").val();
            if (status != '' && travel_date != '') {
              $.ajax({
                type: "POST",
                url: "inc/move-perposal.php",
                data: {
                  name: name,
                  email: email,
                  mo_number: mo_number,
                  destination: destination,
                  no_person: no_person,
                  status: status,
                  amount: amount,
                  travel_date: travel_date,
                  description: description,
                  sales_person: sales_person,
                  last_response: last_response,
                  wtp_no: wtp_no,
                  proposal_id: proposal_id
                },
                success: function(data) {
                  $("#msg").html('<div class="alert alert-success">' + data + '</div>');
                  setInterval(function() {
                    <?php
                    if ($_SESSION['user_role_id'] == 2) {
                    ?>

                      window.location.href = "Potential.php";
                    <?php
                    } else if ($_SESSION['user_role_id'] == 1) {
                    ?>
                      window.location.href = "Admin-Potential.php";
                    <?php
                    } else if ($_SESSION['user_role_id'] == 0) {
                    ?>
                      window.location.href = "Potential.php";
                    <?php
                    } else {
                      header("Location:index.php");
                    }
                    ?>
                  }, 1500);
                }
              });
            } else {
              alert("Please..! Check First Status and Travel date");
              if (status == '') {
                $('#status').focus($("#status").css({
                  'border': '1px solid red'
                }));
              } else if (travel_date == '') {
                $("#datepickerCreate").focus();
              }
            }
          });
        });
      </script>
      <script type="text/javascript" src="asset/date-range/dist/duDatepicker.min.js"></script>
    <?php
    include_once("layouts/footer.php");
  } else {
    ?>
    <script>
      <?php
      if ($_SESSION['user_role_id'] == 2) {
      ?>

        window.location.href = "Potential.php";
      <?php
      } else if ($_SESSION['user_role_id'] == 1) {
      ?>
        window.location.href = "Admin-Potential.php";
      <?php
      } else if ($_SESSION['user_role_id'] == 0) {
      ?>
        window.location.href = "Potential.php";
      <?php
      } else {
        header("Location:index.php");
      }
      ?>
      </script>
  <?php
  }
} else {
  echo "<h4>You can't acccess this page </h4>";
}
  ?>