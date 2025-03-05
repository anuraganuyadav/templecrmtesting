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

          <title>Admin:Dashboard</title>

          <!-- from header-->

          <meta charset="utf-8">

          <meta http-equiv="X-UA-Compatible" content="IE=edge">

          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

          <meta name="description" content="">

          <meta name="author" content="">



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

          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js">

          </script>

          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



          <script src="asset/js/createaccount-validation.js"> </script>

          <!--end  from header-->



          <link rel="stylesheet" href="asset/css/style-Admin.css">

          <!-- Datatable CSS -->

          <link href='asset/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>

          <!-- Datatable JS -->

          <script src="asset/DataTables/datatables.min.js"></script>

          <style>
               .was-validated .form-control:valid,
               .form-control.is-valid {

                    background-image: none !important;

               }

               .was-validated .form-control:invalid,
               .form-control.is-invalid {

                    background-image: none !important;

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

                    <button onclick="callBack()" class="back-btn"> Back </button>

                    <div class="leadInssert">

                         <div class="row">

                              <div class="col-sm-6 col-6">

                                   <!--    alert -->

                                   <div id="alert_message"></div>

                                   <!--  end  alert -->

                              </div>

                              <div class="col-sm-3 col-3">

                                   <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#insertExel">

                                        <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Upload Exel Data!"></i>

                                   </a>

                              </div>

                              <div class="col-sm-3 col-3">

                                   <div class="float-right">

                                        <button type="button" name="add" id="add" class="btn btn-sm btn-info" data-toggle="modal" data-target="#insertLead">Add</button>

                                   </div>

                              </div>

                         </div>

                    </div>

                    <br>

                    <div class="container-fluid mt-4 p-0">



                         <div class="table-responsive">

                              <table id="fetchTable" class="table table-border table-sm table-fixed">

                                   <thead>

                                        <tr>

                                             <th>Name</th>

                                             <th>Email</th>

                                             <th>Phone No</th>

                                             <th>Destinations</th>

                                             <th>Pax</th>

                                             <th>By</th>

                                             <th>Date</th>

                                             <th>Send To</th>

                                             <th>Action</th>

                                        </tr>

                                   </thead>

                              </table>

                         </div>

                    </div>

               </div>

          </div>

          <!-- /.container -->

          <!-- End of Main Content -->

          <!-- insertExel Modal-->

          <div class="modal fade" id="insertExel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

               <div class="modal-dialog" role="document">

                    <div class="modal-content">

                         <div class="modal-header modal-header bg-primary text-light">

                              <h5 class="modal-title" id="exampleModalLabel">Insert Lead</h5>

                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                                   <span aria-hidden="true">×</span>

                              </button>

                         </div>

                         <div class="modal-body">

                              <form action="" method="post" id="frmExcelImport" enctype="multipart/form-data">

                                   <div>

                                        <a href="images/img/Exele%20File%20Image%20for%20Help.PNG" target="_blank" class="btn btn-success"> Help! </a>

                                        <br>

                                        <br>

                                        <br>

                                        <div class="input-group">

                                             <input type="file" name="file" id="file" accept=".xls,.xlsx">

                                             <div class="input-group-prepend">

                                                  <button type="submit" id="submit" name="import" class="btn-submit"> <i class="fas fa-upload fa-2x"></i> </button>

                                             </div>

                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>

          </div>

          <!--insertExel Modal-->


          <!-- insertLead Modal-->

          <div class="modal fade" id="insertLead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

               <div class="modal-dialog" role="document">

                    <div class="modal-content">

                         <div class="modal-header modal-header insertLead-head text-light">

                              <h5 class="modal-title" id="exampleModalLabel">Insert Lead</h5>

                              &nbsp;&nbsp;&nbsp;<small class="ml-25 d-block" id="insertert_message"></small>

                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                                   <span aria-hidden="true">×</span>

                              </button>

                         </div>

                         <div class="modal-body">

                              <form id="form" action="javascript(void)" method="post" class="needs-validation " novalidate="">

                                   <div class="insertLead">

                                        <div class="row lead-row">

                                             <div class="col-sm-6 col-6">

                                                  <input class="leadInput form-control" autocomplete="off" type="text" contenteditable placeholder="Name" id="data1" required>

                                                  <div class="invalid-feedback">

                                                       <span class="badge badge-danger">

                                                            Enter Your Name
                                                       </span>
                                                  </div>

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <input class="leadInput form-control" autocomplete="off" type="text" contenteditable placeholder="Email" id="data2">

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <input class="leadInput form-control" autocomplete="off" type="text" contenteditable placeholder="Number" id="data3" pattern="^[0-9]{5,15}$" required>

                                                  <div class="invalid-feedback">

                                                       <span class="badge badge-danger">

                                                            Enter Mobile Number

                                                       </span>

                                                  </div>

                                                  <span id="Loading" class="input-group-addon"><img src="images/img/loading.gif" height="30px" alt="Ajax Indicator" /></span>

                                                  <b id="NumberResult"></b>

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <input class="leadInput form-control" autocomplete="off" type="text" contenteditable placeholder="Person" id="data6">

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <select id="data4" class="leadInput form-control" required>

                                                       <option value="">Select Destinations</option>

                                                       <?php $query_list = mysqli_query($db, "SELECT * FROM destinations ORDER BY destinations_list ASC");

                                                       while ($row = mysqli_fetch_array($query_list)) {

                                                       ?>

                                                            <option value="<?php echo $row['destinations_list']; ?>">

                                                                 <?php echo $row['destinations_list']; ?></option>

                                                       <?php

                                                       }

                                                       ?>

                                                  </select>

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <select id="data7" autocomplete="off" type="text" class="leadInput form-control" type="text" required>
                                                       <option value="">Select Source</option>
                                                       <option value="HT">HT</option>
                                                       <option value="Google Ads">Google Ads</option>
                                                       <option value="Facebook">Facebook</option>
                                                       <option value="Instagram">Instagram</option>
                                                       <option value="Reference">Reference</option>
                                                       <option value="Direct from Website">Direct from Website</option>
                                                       <option value="Other Source">Other Source</option>

                                                  </select>

                                                  <div class="invalid-feedback">

                                                       <span class="badge badge-danger">

                                                            Select Source

                                                       </span>

                                                  </div>

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <textarea class="leadInput form-control" contenteditable placeholder="Description" id="data5"></textarea>

                                             </div>

                                             <div class="col-sm-6 col-6">

                                                  <select id="data9" class="leadInput form-control" required>

                                                       <option class="selected-cr" value="">Select Person</option>

                                                       <?php

                                                       $salse = 0;

                                                       $both = 2;

                                                       $query_list = mysqli_query($conn, "SELECT * FROM users WHERE (user_role_id ='$salse' || user_role_id ='$both') ORDER by user_name ASC");

                                                       while ($row = mysqli_fetch_array($query_list)) { ?><option value="<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></option> <?php } ?>

                                                  </select>

                                                  <div class="invalid-feedback">

                                                       <span class="badge badge-danger">

                                                            Select Person

                                                       </span>

                                                       </span>

                                                  </div>

                                             </div>

                                             <button type="submit" name="insert" id="insert" class="btn btn-success insert-btn">Insert</button>

                                        </div>

                                   </div>

                              </form>

                         </div>

                    </div>

               </div>

          </div>

          <!--insertLead  Modal-->

          <script>
               $(document).ready(function() {

                    $('#Loading').hide();

                    $("#data3").keyup(function() {


                         if ($('#data3').val().length > 8) {
                              $('#Loading').show();
                              $.post("inc/Lead-validation.php", {

                                   Monumber: $('#data3').val()

                              }, function(response) {

                                   $('#Loading').fadeOut();

                                   $('#NumberResult').fadeOut();

                                   setTimeout("finishAjax('NumberResult', '" + escape(response) + "')", 400);
                              });
                              return false;
                         }
                    });

               });
          </script>

          <script>
               $(document).ready(function() {

                    fetch_data();

                    function fetch_data() {

                         var dataTable = $('#fetchTable').DataTable({

                              "responsive": true,

                              "processing": true,

                              "serverSide": true,

                              "scrollY": 380,

                              "lengthMenu": [

                                   [20, 30, 100, -1],

                                   [20, 30, 100, "All"]

                              ],

                              //"scrollX": true,

                              "order": [],

                              "ajax": {

                                   url: "load-data/AdminLeadFetch.php",

                                   type: "POST"

                              },

                              error: function(xhr, error, code) {

                                   console.log(xhr, code);

                              }

                         });

                    }

                    function update_data(id, column_name, value) {

                         $.ajax({

                              url: "inc/update.php",

                              method: "POST",

                              data: {

                                   id: id,

                                   column_name: column_name,

                                   value: value

                              },

                              success: function(data) {

                                   $('#alert_message').html(

                                        '<div class="alert-success">' +

                                        data + '</div>');

                              }

                         });

                         setInterval(function() {

                              $('#alert_message').html('');

                         }, 50000);

                    }

                    $(document).on('change', '.update', function() {

                         var id = $(this).data("id");

                         var column_name = $(this).data("column");

                         var value = $(this).val();

                         update_data(id, column_name, value);

                    });

                    $('#form').submit(function(e) {

                         e.preventDefault();

                         var name = $('#data1').val();

                         var email = $('#data2').val();

                         var mo_number = $('#data3').val();

                         var destination = $('#data4').val();

                         var description = $('#data5').val();

                         var no_person = $('#data6').val();

                         var LeadSource = $('#data7').val();

                         var sales_person = $('#data9').val();

                         if (name != '' && destination != '' && LeadSource != '' && sales_person !=

                              '') {

                              $.ajax({

                                   url: "inc/insert.php",

                                   method: "POST",

                                   data: {

                                        name: name,

                                        email: email,

                                        mo_number: mo_number,

                                        destination: destination,

                                        description: description,

                                        no_person: no_person,

                                        LeadSource: LeadSource,

                                        sales_person: sales_person

                                   },

                                   success: function(data) {

                                        $('#insertert_message').html(

                                             '<div class="alert alert-size alert-success">' +

                                             data + '</div>');

                                        $('#fetchTable').DataTable().destroy();

                                        fetch_data();
                                   }

                              });

                              setInterval(function() {

                                   $('#insertert_message').html('');

                              }, 5000);

                         } else {

                              return false;

                         }

                         // clear input filed

                         $(this).closest('form').find("input[type=text], textarea, select").val("");

                         $('.needs-validation').removeClass('was-validated');

                    });

                    $(document).on('click', '.delete', function() {

                         var id = $(this).attr("id");

                         if (confirm("Are you sure you want to remove this?")) {

                              $.ajax({

                                   url: "inc/delete.php",

                                   method: "POST",

                                   data: {

                                        id: id

                                   },

                                   success: function(data) {

                                        $('#alert_message').html(

                                             '<div class="alert alert-size alert-success">' +

                                             data + '</div>');

                                        $('#fetchTable').DataTable().destroy();

                                        fetch_data();

                                   }

                              });

                              setInterval(function() {

                                   $('#alert_message').html('');

                              }, 5000);
                         }
                    });

               });
          </script>
     <?php

     include_once("layouts/footer.php");

     include "asset/uloadExel.php";

     //     include "inc/insert-send.php";

} else {

     echo "<h4>You can't acccess this page </h4>";
}

     ?>