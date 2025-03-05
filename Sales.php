<?php
require_once 'inc/session.php';
require_once 'inc/config.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
  header('location:login.php?lmsg=true');
  exit;
}

//identyfied
if ($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 2) {

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
    <?php include_once("layouts/header.php"); ?>
    <title>Lead </title>

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
      <!-- Begin Page Content -->

      <div class="Mycontainer-fluid">

        <!-- back button -->
        <button onclick="callBack()" class="back-btn"> Back </button>
        <form method="POST">
          <div class="row">
            <?php
            //  filter
            $userID = $_SESSION['userID'];
            $sql = "SELECT * FROM filter WHERE userID = $userID";
            $sth = $db->query($sql);
            $result = mysqli_fetch_array($sth);
            ?>
            <!--for form-->



            <div class="col-sm-11">

              <div class="row">
                <div class="col-sm-2 col-6 padding-0">
                  <!--   destination filter  -->
                  <span class="filter-titile">Destination</span>
                  <select id="searchByDestination" class="form-control" name="sl_Destination">
                    <option class="bg-danger text-light" value="<?php echo $result['sl_Destination'];  ?>">
                      <?php if (empty($result['sl_Destination'])) {
                        echo "All";
                      } else if ($result['sl_Destination']) {
                        echo $result['sl_Destination'];
                      } ?> </option>
                    <option value="">All</option>
                    <?php
                    $query_list = mysqli_query($db, "SELECT * FROM destinations ORDER BY destinations_list");
                    while ($row = mysqli_fetch_array($query_list)) {
                    ?>
                      <option value="<?php echo $row['destinations_list']; ?>"><?php echo $row['destinations_list']; ?></option>

                    <?php
                    }
                    ?>
                    <?php ?>

                  </select>
                </div>
                <div class="col-sm-2 col-6 padding-0">
                  <!--  row filter-->
                  <span class="filter-titile">Date Type</span>
                  <select id="searchByDateWise" name="sl_DateWise" class="form-control">
                    <option class="bg-danger text-light" value="<?php echo $result['sl_DateWise']; ?>">
                      <?php if ($result['sl_DateWise'] == 'date') {
                        echo "Lead date";
                      } else if ($result['sl_DateWise'] == 'last_activity') {
                        echo "Last Activity";
                      } else if (empty($result['sl_DateWise'])) {
                        echo "All";
                      }  ?></option>
                    <option value="">All</option>
                    <option value="date">Lead date</option>
                    <option value="last_activity">Last Activity</option>
                  </select>

                </div>
                <div class="col-sm-2 col-6 padding-0">
                  <!--   current Filter Date-->
                  <span class="filter-titile">Filter Date</span>
                  <select id="searchByBeforeDate" class="form-control">

                    <option class="bg-danger text-light" value="<?php echo $result['sl_BeforeDate']; ?>" selected>
                      <?php
                      if (empty($result['sl_BeforeDate'])) {
                        echo "All";
                      } else if ($result['sl_BeforeDate'] == '>=( NOW() - INTERVAL 0 DAY )') {
                        echo "Today";
                      }
                      ?>
                    </option>

                    <option value="">All</option>
                    <option value=">=( NOW() - INTERVAL 0 DAY )">Today</option>
                  </select>

                </div>
                <div class="col-sm-2 col-6 padding-0">
                  <span class="filter-titile">Lead Status </span>
                  <!--    status filter-->
                  <select id="searchByStatus" class="form-control" name="sl_Status" required>
                    <option class="bg-danger text-light" value="<?php echo $result['sl_Status']; ?>">
                      <?php

                      if ($result['sl_Status'] == "Empty") {
                        echo "Empty";
                      } else if (empty($result['sl_Status'])) {
                        echo "All";
                      } else if ($result['sl_Status']) {
                        echo $result['sl_Status'];
                      } ?></option>
                    <option value="">All</option>
                    <option value="Empty">Empty</option>
                    <?php
                    $query_list = mysqli_query($db, "SELECT * FROM lead_status ORDER BY position_order");
                    while ($row = mysqli_fetch_array($query_list)) {
                    ?>
                      <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>

                    <?php
                    }
                    ?>

                  </select>

                </div>
                <div class="col-sm-3 col-6 padding-0">
                  <!--date between-->
                  <span class="filter-titile">Start Date To End Date</span>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <input type="text" id="daterange" data-theme="blue" class="form-control">
                      <input autocomplete="off" type="text" id="searchByFdate" name="daterangepicker_start" class="form-control  border-0" value="<?php echo $result['sl_Fdate']; ?>" placeholder="Enter First Date" <?php if ($result['sl_BeforeDate'] == "=CURDATE()") {
                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                      } ?>>
                      <span class="pt-2 border-0" id="to-date">To</span>
                      <input autocomplete="off" type="text" id="searchByLdate" name="daterangepicker_end" class="form-control border-0" value="<?php echo $result['sl_Ldate']; ?>" placeholder="Enter Last Date" <?php if ($result['sl_BeforeDate'] == "=CURDATE()") {
                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                  } ?>>
                    </div>
                  </div>
                </div>
                <div class="col-sm-1 padding-0">
                  <span class="filter-titile">Clear</span>
                  <button class="form-control rounded bg-primary text-light" id="FilterLeadSubmit" type="button">Clear</button>
                </div>
              </div>
            </div>

          </div>
        </form>
        <!-- end row -->
        <!--   Creative Tim Branding   -->
        <!-- <div class="insert-lead">
        <div class="heading-l">
          All Potential
        </div>
      </div> -->

        <!-- Custom Filter -->
        <div class="insert-lead">
          <div class="heading-l">
            All Leads
          </div>
        </div>


        <!-- Table -->
        <table id='fetchTable' class='display dataTable'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No.</th>
              <th>Destinations</th>
              <th>Pax</th>
              <th>Lead Date</th>
              <th>Activity</th>
              <th>Lead Status</th>
            </tr>
          </thead>

        </table>
      </div>

      <!-- Script -->
      <script>
        $(document).ready(function() {
          var dataTable = $('#fetchTable').DataTable({
            'processing': true,
            'serverSide': true,
            "responsive": true,
            "pageLength": 50,
            "scrollY": 350,
            // "scrollX": true,
            "order": [],
            "pagingType": "full_numbers",
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url': 'load-data/lead-ajax.php',
              'data': function(data) {
                // Read values
                var destination = $('#searchByDestination').val();
                var status = $('#searchByStatus').val();
                var date = $('#searchByBeforeDate').val();
                var dateWise = $('#searchByDateWise').val();
                var Fdate = $('#searchByFdate').val();
                var Ldate = $('#searchByLdate').val();

                // Append to data
                data.searchByDestination = destination;
                data.searchByStatus = status;
                data.searchByBeforeDate = date;
                data.searchByDateWise = dateWise;
                data.searchByFdate = Fdate;
                data.searchByLdate = Ldate;
              }
            },
          });

          $(document).on('click', '.applyBtn', function() {
            dataTable.draw();
          });

          $('#searchByDestination,#searchByStatus,#searchByBeforeDate,#searchByDateWise').change(function() {
            dataTable.draw();
          });
          // clear input all field 
          $(document).on('click', '#FilterLeadSubmit', function() {
            $(":input").val('');
            dataTable.draw();
          });
          // Date picker  
          duDatepicker('#daterange', {
            range: true,
            format: 'yyyy/mm/dd',
            outFormat: 'yyyy-mm-dd',
            fromTarget: '#searchByFdate',
            toTarget: '#searchByLdate',
            clearBtn: true,
            theme: 'yellow',
            inline: true,
            events: {
              ready: function() {
                // console.log('duDatepicker', this)

              },
              dateChanged: function(data) {
                //console.log('new date', data)
                dataTable.draw();
              }
            }
          })


          // if select today
          $('#searchByBeforeDate').on('change', function() {
            if ($(this).val() === '') {
              $("#searchByFdate").prop('disabled', false);
              $("#searchByLdate").prop('disabled', false);
              $("#searchByFdate").val('');
              $("#searchByLdate").val('');
            } else if ($(this).val() === '=CURDATE()') {
              $("#searchByFdate").prop('disabled', true);
              $("#searchByLdate").prop('disabled', true);

              $("#searchByFdate").val('');
              $("#searchByLdate").val('');
            }
          });
        });
      </script>

      <script type="text/javascript" src="asset/date-range/dist/duDatepicker.min.js"></script>
    </div>

  <?php
  include_once("layouts/footer.php");
} else {
  echo "<h4>You can't acccess this page </h4>";
}
  ?>