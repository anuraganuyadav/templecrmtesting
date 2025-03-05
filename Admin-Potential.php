<?php
require_once 'inc/session.php';
require_once 'inc/config.php';
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
    <?php include_once("layouts/header.php"); ?>
    <title>Admin Potential</title>

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
        <div class="row">
          <?php
          //  filter
          $userID = $_SESSION['userID'];
          $sql = "SELECT * FROM filter WHERE userID = $userID";
          $sth = $db->query($sql);
          $result = mysqli_fetch_array($sth);
          ?>
          <!--for form-->
          <div class="col-sm-1 col-6 padding-0 offset-1">
            <!--   destination filter  -->
            <span class="filter-titile">Sales</span>
            <select id="searchBySales" class="form-control" name="ap_Sales">
              <option class="bg-danger text-light" value="<?php echo $result['ap_Sales']; ?>">
                <?php if (empty($result['ap_Sales'])) {
                  echo "All";
                } else if ($result['ap_Sales']) {
                  echo $result['ap_Sales'];
                } ?> </option>
              <option value="">All</option>
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
          <!-- back button -->
          <button onclick="callBack()" class="back-btn"> Back </button>
          <div class="col-sm-8">
            <div class="row">
              <div class="col-sm-2 col-6 padding-0">
                <!--   destination filter  -->
                <span class="filter-titile">Destination</span>
                <select id="searchByDestination" class="form-control">
                  <option class="bg-danger text-light" value="<?php echo $result['ap_Destination'];  ?>">
                    <?php if (empty($result['ap_Destination'])) {
                      echo "All";
                    } else if ($result['ap_Destination']) {
                      echo $result['ap_Destination'];
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
                <span class="filter-titile">Date Wise</span>
                <select id="searchByDateWise" class="form-control">
                  <option class="bg-danger text-light" value="<?php echo $result['ap_DateWise']; ?>">
                    <?php if ($result['ap_DateWise'] == 'date') {
                      echo "Created date";
                    } else if ($result['ap_DateWise'] == 'last_activity') {
                      echo "Last Activity";
                    } else if ($result['ap_DateWise'] == 'travel_date') {
                      echo "Travel Date";
                    } else if (empty($result['ap_DateWise'])) {
                      echo "All";
                    }  ?></option>
                  <option value="">All</option>
                  <option value="date">Created date</option>
                  <option value="last_activity">Last Activity</option>
                  <option value="travel_date">Travel Date</option>
                </select>

              </div>
              <div class="col-sm-2 col-6 padding-0">
                <!--   current before dat-->
                <span class="filter-titile">Before Date</span>
                <select id="searchByBeforeDate" class="form-control">

                  <option class="bg-danger text-light" value="<?php echo $result['ap_BeforeDate']; ?>" selected>
                    <?php
                    if (empty($result['ap_BeforeDate'])) {
                      echo "All";
                    }
                    if ($result['ap_BeforeDate'] == "Today") {
                      echo "Today";
                    }
                    if ($result['ap_BeforeDate'] == "Before") {
                      echo "Before Date";
                    }
                    if ($result['ap_BeforeDate'] == "After") {
                      echo "After Date";
                    }
                    ?>
                  </option>

                  <option value="">All</option>
                  <option value="Today">Today</option>
                  <option value="Before">Before Date</option>
                  <option value="After">After Date</option>
                </select>

              </div>
              <div class="col-sm-2 col-6 padding-0">
                <span class="filter-titile">Potential Status</span>
                <!--    status filter-->
                <select id="searchByStatus" class="form-control">
                  <option class="bg-danger text-light" value="<?php echo $result['ap_Status']; ?>">
                    <?php if (empty($result['ap_Status'])) {
                      echo "All";
                    } else if ($result['ap_Status']) {
                      echo $result['ap_Status'];
                    } ?></option>
                  <option value="">All</option>
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
              <div class="col-sm-3 col-6 padding-0">
                <!--date between-->
                <span class="filter-titile">Start Date To End Date</span>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <input type="text" id="daterange" data-theme="blue" class="form-control">
                    <input autocomplete="off" type="text" id="searchByFdate" name="daterangepicker_start" class="form-control  border-0" value="<?php echo $result['ap_Fdate']; ?>" placeholder="Enter First Date" <?php if ($result['ap_BeforeDate'] == "Today") {
                                                                                                                                                                                                                      echo "disabled";
                                                                                                                                                                                                                    } ?>>
                    <span class="pt-2 border-0" id="to-date">To</span>
                    <input autocomplete="off" type="text" id="searchByLdate" name="daterangepicker_end" class="form-control border-0" value="<?php echo $result['ap_Ldate']; ?>" placeholder="Enter Last Date" <?php if ($result['ap_BeforeDate'] == "Today") {
                                                                                                                                                                                                                  echo "disabled";
                                                                                                                                                                                                                } ?>>
                  </div>
                </div>
              </div>
              <div class="col-sm-1 padding-0">
                <span class="filter-titile">Clear</span>
                <button class="form-control rounded bg-primary text-light" id="FilterLeadClear" type="button">Clear</button>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->
        <!--   Creative Tim Branding   -->
        <div class="insert-lead">
          <div class="heading-l">
            All Potential
          </div>
        </div>

        <!-- Custom Filter -->

        <!-- Table -->
        <table id='fetchTable' class='display dataTable'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No.</th>
              <th>Destinations</th>
              <th>Person</th>
              <th>Travel Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Created</th>
              <th>Activity</th>
              <th>Sales</th>
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
            "scrollY": 380,
            "order": [],
            "scrollX": true,
            "pagingType": "full_numbers",
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url': 'load-data/admin-potential-ajax.php',
              'data': function(data) {
                // Read values
                var Sales = $('#searchBySales').val();
                var destination = $('#searchByDestination').val();
                var status = $('#searchByStatus').val();
                var date = $('#searchByBeforeDate').val();
                var dateWise = $('#searchByDateWise').val();
                var Fdate = $('#searchByFdate').val();
                var Ldate = $('#searchByLdate').val();

                // Append to data
                data.searchBySales = Sales;
                data.searchByDestination = destination;
                data.searchByStatus = status;
                data.searchByBeforeDate = date;
                data.searchByDateWise = dateWise;
                data.searchByFdate = Fdate;
                data.searchByLdate = Ldate;

              }
            },
          });

          $(document).on('click', '.dudp__button', function() {
            dataTable.draw();
          });

          $('#searchByDestination,#searchByStatus,#searchByBeforeDate,#searchByDateWise,#searchBySales').change(function() {
            dataTable.draw();
          });
          // clear input all field 
          $(document).on('click', '#FilterLeadClear', function() {
            $("#searchByFdate").prop('disabled', false);
            $("#searchByLdate").prop('disabled', false);
            $("#searchByFdate").val('');
            $("#searchByLdate").val('');
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

            if ($(this).val() === 'Today') {
              $("#searchByFdate").prop('disabled', true);
              $("#searchByLdate").prop('disabled', true);

              $("#searchByFdate").val('');
              $("#searchByLdate").val('');
            } else {
              $("#searchByFdate").prop('disabled', false);
              $("#searchByLdate").prop('disabled', false);
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