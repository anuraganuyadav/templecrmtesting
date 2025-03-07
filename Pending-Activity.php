<?php
error_reporting(0);
ini_set('display_errors', 0);

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
  $stmt_delete = $DB_con->prepare('DELETE FROM lead WHERE id =:uid');
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
      <!-- Begin Page Content -->
      <!-- Begin Page Content -->
      <div class="container-fluid p-0">
        <!-- call back  -->
        <button onclick="callBack()" class="back-btn"> Back </button>
        <br>

        <div class="row">

          <div class="col-sm-2 mb-2 mt-4 offset-sm-2">
            <!--    alert -->
            <?php
            //  filter
            $userID = $_SESSION['userID'];
            $sql = "SELECT * FROM filter WHERE userID = $userID";
            $sth = $db->query($sql);
            $result = mysqli_fetch_array($sth);
            $lead_type = $result['lead_type'];
            $pending_activity = $result['pending_activity'];
            // end filter      

            ?>
            <div class="input-group">
              <select class="form-control" id="searchByleadType">
                <option class="bg-danger text-light" value="<?php echo $lead_type; ?>">
                  <?php if (empty($lead_type)) {
                    echo "All Type";
                  } else if ($lead_type = 'lead') {
                    echo "Lead";
                  } else if ($lead_type = 'potential') {
                    echo "Potential";
                  }
                  ?></option>
                <option value="">All Type</option>
                <option value="lead">Lead</option>
                <option value="potential">Potential</option>
              </select>
            </div>
            <!--  end  alert -->
          </div>
          <div class="col-sm-2 mb-2 mt-4">
            <div class="input-group">
              <select class="form-control" id="searchByPendingActivity">
                <option class="bg-danger text-light" value="<?php echo $pending_activity; ?>"><?php if (empty($pending_activity)) {
                                                                                                echo "All Activity";
                                                                                              } else {
                                                                                                echo $pending_activity;
                                                                                              } ?></option>
                <option value="">All Activity</option>
                <option value="Pending Activity">Pending Activity</option>
                <option value="Past Activity">Past Activity</option>
                <option value="Next Activity">Next Activity</option>
              </select>
            </div>
            <!--  end  alert -->
          </div>

          <!--  searching salespersonwise start-->

          <div class="col-sm-2 mb-2 mt-4">
            <div class="input-group">
              <select class="form-control" id="searchByPendingActivity">
                <option class="bg-danger text-light">Search Person Wise</option>
                <?php
                $salse = 0;
                $both = 2;
                $query_list = mysqli_query($conn, "SELECT * FROM users WHERE (user_role_id ='$salse' || user_role_id ='$both') ORDER by user_name ASC");
                while ($row = mysqli_fetch_array($query_list)) {
                ?><option value="<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>


          <!--  searching salespersonwise end-->
        </div>

        <!-- Table -->
        <table id='fetchTable' class='display dataTable'>
          <thead>
            <tr>
              <th>Name</th>
              <th>Note</th>
              <th>Time</th>
              <th>Remark</th>
              <th>Person</th>
              <th>status</th>
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
            'responsive': true,
            'scrollY': 350,
            'order': [],
            'pagingType': 'full_numbers',
            'serverMethod': 'post',
            'ajax': {
              'url': 'load-data/pending-activity-ajax.php',
              'data': function(data) {
                var activity = $('#searchByPendingActivity').val();
                var leadType = $('#searchByleadType').val();
                // Pass the filter parameters to the server
                data.searchByPendingActivity = activity;
                data.searchByleadType = leadType;
              },
              'error': function(xhr, error, thrown) {
                console.log("Error fetching data: " + error);
                console.log("Response: " + xhr.responseText);
              }
            }
          });

          // Refresh the DataTable when filters change
          $('#searchByPendingActivity, #searchByleadType').change(function() {
            dataTable.draw();
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
    ?>>