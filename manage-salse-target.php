<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'inc/session.php';
include "inc/config.php";

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}
//identyfied
if ($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

  header("Location:index.php");
}
//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Pending Activity</title>
    <?php include_once("layouts/header.php"); ?>
    <!-- Datatable CSS -->
    <link href='asset/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <!-- Datatable JS -->
    <script src="asset/DataTables/datatables.min.js"></script>
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker.min.css">
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker-theme.css">
  </head>

  <body id="page-top">
    <?php include_once("layouts/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <?php include_once("layouts/nav.php"); ?>
      <div class="container-fluid p-0">
        <!-- back button -->
        <button onclick="callBack()" class="back-btn"> Back </button>
        <!-- call back  -->
        <div class="row">
          <!--for form-->
          <div class="col-sm-2 col-6">
            <span id="alert"></span>
          </div>
          <div class="col-sm-2 col-6 p-0">
            <!--   sales filter  -->
            <span class="filter-titile">Target Amount</span>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="amt">RS.</span>
                <input id="target" type="text" class="form-control" placeholder="35000">

              </div>
            </div>

          </div>
          <div class="col-sm-2 col-6">
            <!--   sales filter  -->
            <span class="filter-titile">Sales</span>
            <select id="uid" class="form-control" name="ap_Sales">
              <option value="">Select sales person</option>
              <?php
              $salse = 0;
              $both = 2;
              $query_list = mysqli_query($db, "SELECT * FROM users WHERE (user_role_id ='$salse' || user_role_id ='$both')");
              while ($row = mysqli_fetch_array($query_list)) {
              ?>
                <option value="<?php echo $row['userID']; ?>"><?php echo $row['user_name']; ?></option>

              <?php
              }
              ?>
              <?php ?>
            </select>
          </div>
          <div class="col-sm-3 col-6 padding-0">
            <!--date between-->
            <span class="filter-titile">Start Date To End Date</span>
            <div class="input-group">
              <div class="input-group-prepend">
                <input type="text" id="daterange" data-theme="blue" class="form-control">
                <input autocomplete="off" type="text" id="Fdate" name="daterangepicker_start" class="form-control  border-0" value="" placeholder="Enter First Date">
                <span class="pt-2 border-0" id="to-date">To</span>
                <input autocomplete="off" type="text" id="Ldate" name="daterangepicker_end" class="form-control border-0" value="" placeholder="Enter Last Date">
              </div>
            </div>
          </div>
          <div class="col-sm-1 padding-0">
            <span class="filter-titile">Apply</span>
            <button class="form-control rounded bg-primary text-light" id="apply" type="button">Apply</button>
          </div>
        </div>
      </div>

      <!-- Table -->
      <table id='fetchTable' class='display dataTable'>
        <thead>
          <tr>
            <th>Name</th>
            <th>Target</th>
            <th>Target Days</th>
            <th>First date</th>
            <th>Last Date</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>

      <script>
        $(document).ready(function() {


          var dataTable = $('#fetchTable').DataTable({
            'processing': true,
            'serverSide': true,
            "responsive": true,
            "scrollY": 350,
            "order": [],
            "pagingType": "full_numbers",
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url': 'load-data/fetch-sales-target.php',

              'data': function(data) {
                // Read values
                // var target = $("#target").val();
                // var userID = $("#uid").val();
                // var Fdate = $("#Fdate").val();
                // var Ldate = $("#Ldate").val();

                // // Append to data 
                // data.target = target;
                // data.userID = userID;
                // data.Fdate = Fdate;
                // data.Ldate = Ldate;
              },

            },
          });
          $(document).on('click', '#apply', function() {
            var target = $("#target").val();
            var userID = $("#uid").val();
            var Fdate = $("#Fdate").val();
            var Ldate = $("#Ldate").val();
            $.ajax({
              url: 'inc/insert-target.php',
              method: "POST",
              data: {
                target: target,
                userID: userID,
                Fdate: Fdate,
                Ldate: Ldate
              },
              success: function(data) {
                $("#alert").html(data);

                dataTable.draw();
              }
            });
          });

          // Date picker  
          duDatepicker('#daterange', {
            range: true,
            format: 'yyyy/mm/dd',
            outFormat: 'yyyy-mm-dd',
            fromTarget: '#Fdate',
            toTarget: '#Ldate',
            clearBtn: true,
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
          // delete 

          $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to remove this?")) {
              $.ajax({
                url: "inc/delete-salse-target.php",
                method: "POST",
                data: {
                  id: id
                },
                success: function(data) {
                  $('#alert').html(
                    '<div class="alert alert-size alert-success">' +
                    data + '</div>');
                  dataTable.draw();
                }
              });
              setInterval(function() {
                $('#alert').html('');
              }, 5000);
            }
          });
        })
      </script>
      <script type="text/javascript" src="asset/date-range/dist/duDatepicker.min.js"></script>
    </div>

    <?php
    include_once("layouts/footer.php");
  } else {
    echo "<h4>You can't acccess this page </h4>";
  }
    ?>>