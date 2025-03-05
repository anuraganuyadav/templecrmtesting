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
    <title>Potential Manage</title>
    <!-- Datatable CSS -->
    <link href='asset/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <!-- Datatable JS -->
    <script src="asset/DataTables/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker.min.css">
    <link rel="stylesheet" type="text/css" href="asset/date-range/dist/duDatepicker-theme.css">

    <style>
      .container-fluid,
      .table,
      .card-footer,
      .copyright {
        color: #000 !important;
        background-color: #5c2219;
      }

      .dataTables_filter label {
        margin-top: -27px;
      }

      .page-item.disabled .page-link {
        color: #ffffff;
        pointer-events: none;
        cursor: auto;
        background-color: #fff0;
        border-color: #dddfeb47;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: 0.5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        *cursor: hand;
        color: #fff !important;
        border: 1px solid transparent;
        border-radius: 2px;
      }

      .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
        padding-top: 0px;
      }




      .insert-lead {
        z-index: 99;
        left: 48%;
        top: 11%;
        position: absolute;
      }
    </style>
  </head>

  <body id="page-top">
    <?php include_once("layouts/sidebar.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <?php include_once("layouts/nav.php"); ?>
      <!-- Begin Page Content -->
      <div class="container-fluid p-0">
        <!-- call back  -->

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
            <div class="row">
              <div class="col-sm-2 col-6 ml-4">
                <!--   Sales filter  -->
                <span class="filter-titile text-light">Sales</span>
                <select id="searchBySales" class="form-control" name="pm_Sales">
                  <option class="bg-danger text-light" value="<?php echo $result['pm_Sales']; ?>">
                    <?php if (empty($result['pm_Sales'])) {
                      echo "All";
                    } else {
                      echo $result['pm_Sales'];
                    } ?></option>
                  <option value=""> All</option>
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
              <div class="col-sm-9 col-6 padding-0">
                <div class="row">
                  <div class="col-sm-2 col-6 padding-0">
                    <!--   destination filter  -->
                    <span class="filter-titile text-light">Destination</span>
                    <select id="searchByDestination" class="form-control" name="pm_Destination">
                      <option class="bg-danger text-light" value="<?php echo $result['pm_Destination'];  ?>">
                        <?php if (empty($result['pm_Destination'])) {
                          echo "All";
                        } else if ($result['pm_Destination']) {
                          echo $result['pm_Destination'];
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
                    <!--  Date Type filter-->
                    <span class="filter-titile text-light">Date Type</span>
                    <select id="searchByDateWise" name="pm_DateWise" class="form-control">
                      <option class="bg-danger text-light" value="<?php echo $result['pm_DateWise']; ?>">
                        <?php if ($result['pm_DateWise'] == 'date') {
                          echo "Potential date";
                        } else if ($result['pm_DateWise'] == 'last_activity') {
                          echo "Last Activity";
                        } else if (empty($result['pm_DateWise'])) {
                          echo "All";
                        }  ?></option>
                      <option value="">All</option>
                      <option value="date">Potential date</option>
                      <option value="last_activity">Last Activity</option>
                    </select>
                  </div>
                  <div class="col-sm-2 col-6 padding-0">
                    <!--   current Filter Date-->
                    <span class="filter-titile text-light">Filter Date</span>
                    <select id="searchByBeforeDate" class="form-control">
                      <option class="bg-danger text-light" value="<?php echo $result['pm_BeforeDate']; ?>" selected>
                        <?php
                        if (empty($result['pm_BeforeDate'])) {
                          echo "All";
                        }
                        if ($result['pm_BeforeDate'] == "Today") {
                          echo "Today";
                        }
                        if ($result['pm_BeforeDate'] == "Before") {
                          echo "Before Date";
                        }
                        if ($result['pm_BeforeDate'] == "After") {
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
                    <!--   lead_status filter  -->
                    <span class="filter-titile text-light">Potential Status</span>
                    <select id="searchByStatus" class="form-control">
                      <option class="bg-danger text-light" value="<?php echo $result['pm_Status']; ?>">
                        <?php if (empty($result['pm_Status'])) {
                          echo "All";
                        } else if ($result['pm_Status']) {
                          echo $result['pm_Status'];
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
                    <span class="filter-titile text-light">Start Date To End Date</span>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <input type="text" id="daterange" data-theme="blue" class="form-control">
                        <input autocomplete="off" type="text" id="searchByFdate" name="daterangepicker_start" class="form-control  border-0" value="<?php echo $result['pm_Fdate']; ?>" placeholder="Enter First Date" <?php if ($result['pm_BeforeDate'] == "Today") {
                                                                                                                                                                                                                          echo "disabled";
                                                                                                                                                                                                                        } ?>>
                        <span class="pt-2 border-0" id="to-date">To</span>
                        <input autocomplete="off" type="text" id="searchByLdate" name="daterangepicker_end" class="form-control border-0" value="<?php echo $result['pm_Ldate']; ?>" placeholder="Enter Last Date" <?php if ($result['pm_BeforeDate'] == "Today") {
                                                                                                                                                                                                                      echo "disabled";
                                                                                                                                                                                                                    } ?>>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-1 padding-0">
                    <span class="filter-titile text-light">Clear</span>
                    <button class="form-control rounded bg-primary btn-sm text-light" id="FilterLeadClear" type="button">Clear</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- end row -->
        <!--   Creative Tim Branding   -->
        <div class="select-box-lead">
          <div class="input-group">
            <input class="mybtn myCheck " id="ck_All" type="checkbox" onchange="checkUncheckAll()" />
            <div class="input-group-prepend">
              <p class="rows_selected mybtn" id="select_count">0 Selected</p>
            </div>
            <div class="input-group-prepend">
              <button class="mybtn" id="delete_link" onclick="alert('No Row Selected')">Delete</button>
            </div>
          </div>
        </div>
        <!-- Custom Filter -->
        <div class="insert-lead">
          <div class="heading-l">
            All Potential
          </div>
        </div>
        <!-- Table -->
        <table id='fetchTable' class='display dataTable'>
          <thead>
            <tr>
              <th>Select</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No.</th>
              <th>Destinations</th>
              <th>Person</th>
              <th>Potential Date</th>
              <th>Activity</th>
              <th>Potential Status</th>
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
            "searchable": true,
            "scrollY": 380,
            "scrollX": true,
            "order": [],
            'serverMethod': 'post',
            dom: 'lBfrtip',
            buttons: [
              'excel', 'csv', 'copy'
            ],
            "lengthMenu": [
              [10, 25, 50,100,200,300,500, -1],
              ['10', '25', '50','100','200','300','500', "All"]
            ],
            bLengthChange: true,
            // buttons: [
            //   'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            //'searching': false, // Remove default Search Control
            'ajax': {
              dataType: 'json',
              'url': 'load-data/admin-potential-manage-ajax.php',
              'data': function(data) {
                // Read values
                var sales = $('#searchBySales').val();
                var destination = $('#searchByDestination').val();
                var status = $('#searchByStatus').val();
                var date = $('#searchByBeforeDate').val();
                var dateWise = $('#searchByDateWise').val();
                var Fdate = $('#searchByFdate').val();
                var Ldate = $('#searchByLdate').val();
                // Append to data
                data.searchBySales = sales;
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
      <!-- selete select   -->
      <script>
        function checkUncheckAll() {
          var chks = document.getElementsByName("ck");
          if (document.getElementById("ck_All").checked) {
            $("#delete_link").on("click", deleteSelectedRows);
            for (i = 0; i < chks.length; i++)
              document.getElementsByName("ck")[i].checked = true;
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
          } else {
            for (i = 0; i < chks.length; i++)
              document.getElementsByName("ck")[i].checked = false;
            document.getElementById("delete_link").onclick = function() {
              deleteSelectedRows();
            };
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
          }
        }

        function selectUnselect(checked) {
          if (checked) {
            document.getElementById("delete_link").onclick = function() {
              deleteSelectedRows();
            };
            var chks = $("input[name='ck']");
            var all_checked = true;
            for (i = 0; i < chks.length; i++)
              if (chks[i].checked)
                continue;
              else {
                all_checked = false;
                break;
              }
            if (all_checked)
              document.getElementById("ck_All").checked = true;
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
          } else {
            document.getElementById("delete_link").onclick = function() {
              deleteSelectedRows();
            };
            var chks = $("input[name='ck']");
            var all_checked = true;
            for (i = 0; i < chks.length; i++)
              if (chks[i].checked)
                continue;
              else {
                all_checked = false;
                break;
              }
            if (all_checked)
              document.getElementById("ck_All").checked = true;
            $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
          }
        }

        function deleteSelectedRows() {
          var cks = $("input[name='ck']");
          var checked = [];
          for (i = 0; i < cks.length; i++)
            if (cks[i].checked)
              checked.push(cks[i].id);
          var jsonob = JSON.stringify(checked);
          $.post("inc/Potential-manage-delete.php", {
            rows_to_be_deleted: jsonob
          }, function(data) {
            for (i = 0; i < checked.length; i++)
              $("#" + checked[i]).parents('tr').fadeOut('slow', function() {
                $(this).parents('tr').remove();
              });
          });
        }
      </script>
    </div>
  <?php
  include_once("layouts/footer.php");
} else {
  echo "<h4>You can't acccess this page </h4>";
}
  ?>