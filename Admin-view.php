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



error_reporting(~E_NOTICE);
require_once 'inc/config.php';
if (isset($_GET['view_potential']) && !empty($_GET['view_potential'])) {
  $id = $_GET['view_potential'];
  $stmt_edit = $DB_con->prepare('SELECT id, name, email, mo_number, destination, no_person, response_client, status, amount, description, date, status, travel_date FROM potential WHERE id =:uid');
  $stmt_edit->execute(array(':uid' => $id));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);
} else {
  header("Location: index.php");
}
//for deleted 	

if (isset($_POST['delete'])) {
  $name = $_POST['name']; // 
  $id = $_POST['id']; // 
  $stmt_delete = $DB_con->prepare("DELETE FROM notes WHERE id = '$id' LIMIT 1");
  $stmt_delete->execute();
  echo "<meta http-equiv='refresh' content='0'>";
}

?>
<?php
require_once('layouts/header.php');
?>
<script src="asset/css/editor.js"></script>

<script>
  $(document).ready(function() {
    $("#txtEditor").Editor();
  });
</script>
<link href="asset/css/editor.css" type="text/css" rel="stylesheet" />

<style>
  #txtEditorContent {
    visibility: hidden;
  }

  #txtEditor {
    visibility: hidden;
  }
</style>

<title>Client View</title>
<script src="asset/js/jquery.form.js"></script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?php include_once("layouts/sidebar.php"); ?>
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <?php include_once("layouts/nav.php"); ?>
    <!-- satart conatainer       -->
    <div class="container">
      <div class="card shadow card-login mx-auto mt-5 under-cr">
        <div class="card-header">View Detail</div>
        <!-- insert itinearay Modal-->
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Destinations</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $name; ?></td>
                <td> <?php echo $email; ?></td>
                <td><?php echo $mo_number; ?></td>
                <td><?php echo $destination; ?></td>
              </tr>
            </tbody>
            <thead>
              <tr>
                <th>Person</th>
                <th>Travel Date</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> <?php echo $no_person; ?></td>
                <td> <?php echo $travel_date; ?></td>
                <td><?php echo $amount; ?></td>
                <td><?php echo $status; ?></td>
              </tr>
            </tbody>
          </table>

          <!--end insert itinearay Modal-->
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-7">
          <!--          Notes start-->
          <div class="card shadow">

            <!--  show notes          -->
            <a href="#ViewNotes" class="card-header input-group-text font-weight-bold add-note" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" class="">Add</a>
            <!-- Card note history -->
            <div class="collapse show" id="ViewNotes">
              <div class="card-body">
                <!--// notes-->
                <!-- table   -->
                <div class="table-responsive">
                  <table class="table table-bordered table-danger" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Notes</th>
                        <th class="text-center">Date</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $id = $_GET['view_potential'];
                      $query_r = mysqli_query($db, "SELECT id, note_id, note, create_date FROM notes WHERE note_id = $id ORDER BY id DESC")
                        or die(mysqli_error());
                      while ($row = mysqli_fetch_array($query_r)) {
                      ?>
                        <!--tabale row-->
                        <tr>
                          <td> <?php echo $row['note']; ?></td>
                          <td class="text-center"> <?php
                                                    $time = $row['create_date'];
                                                    echo  date('d M Y, g;i A', strtotime($time));
                                                    //type1  echo  date('g:i A, l - d M Y', strtotime($time));
                                                    //type2 echo  date("m-d-Y", strtotime($time)); 
                                                    ?></td>
                          <td>
                            <!--  delete    -->
                            <!-- delet-btn-->
                            <!--
 <form method="post">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <button class="btn btn-danger btn-circle btn-sm btn-delete" type="submit"  name="delete"><i class="fas fa-trash"></i></button>
      </form>         
-->
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--  end notes        -->

          <br>
          <br>
          <div class="card shadow">
            <a href="#ViewHistory" class="card-header input-group-text font-weight-bold add-note" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" class="">Email Hisory</a>
            <!-- Card note history -->
            <div class="collapse show" id="ViewHistory">
              <div class="card-body">
                <!--// notes-->
                <!-- table   -->
                <div class="table-responsive">
                  <table class="table table-bordered table-success" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th class="text-center">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $id = $_GET['view_potential'];
                      $query_r = mysqli_query($db, "SELECT id, mail_id, name, email, file, date, Written_Itinerary, subject, bcc, bcc2 FROM email_history WHERE mail_id = $id ORDER BY id DESC")
                        or die(mysqli_error());
                      while ($row = mysqli_fetch_array($query_r)) {
                      ?>
                        <!--tabale row-->
                        <tr>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#insertLead<?php echo $id; ?>">
                              <i class="fas fa-eye"></i>
                            </a>
                            <!-- view email-->
                            <div class="modal fade" id="insertLead<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dilogue-full" role="document">
                                <div class="modal-content">
                                  <div class="modal-header modal-header bg-primary text-light">
                                    <h5 class="modal-title" id="exampleModalLabel">Sent Email </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card">
                                      <table>
                                        <tr>
                                          <td> <b> Name: <?php echo $row['name']; ?></b> </td>
                                          <td> <b> Email: <?php echo $row['email']; ?></b> </td>
                                          <td> <b> CC1: <?php echo $row['bcc']; ?></b> </td>
                                          <td> <b> CC2: <?php echo $row['bcc2']; ?></b> </td>
                                          <td> <b> Date: <?php echo $row['date']; ?></b> </td>
                                        </tr>
                                      </table>
                                    </div>

                                    <br>
                                    <br>

                                    <?php echo $row['Written_Itinerary']; ?>
                                    <br>
                                    <a href="images/Attachment/<?php echo $row['file']; ?>">
                                      <?php
                                      if (empty($row['file'])) {
                                        echo "";
                                      } else {
                                        echo "<img src='images/img/file.gif'>";
                                      }
                                      ?>



                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--end view email-->
                            <?php echo $row['name']; ?>
                          </td>
                          <td><?php echo $row['subject']; ?></td>

                          <td class="text-center"> <?php
                                                    $time = $row['date'];
                                                    echo  date('d M Y, g;i A', strtotime($time));
                                                    //type1  echo  date('g:i A, l - d M Y', strtotime($time));
                                                    //type2 echo  date("m-d-Y", strtotime($time)); 
                                                    ?></td>

                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
          <!-- Collapsable Description -->
          <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseDescription" class="d-block card-header py-3 bg-blue" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
              <h6 class="m-0 font-weight-bold text-light">View Description</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseDescription">
              <div class="card-body">
                <div class="travel-descript">
                  <?php echo $description; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- status history   -->

          <div class="card shadow">
            <!-- Card status history -->
            <div class="collapse show" id="ViewNotes">
              <div class="card-body">
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
                    <tbody>
                      <?php
                      $id = $_GET['view_potential'];
                      $query_r = mysqli_query($db, "SELECT id, status_id, status_detail, status_date FROM  status_history WHERE status_id = $id ORDER BY id DESC")
                        or die(mysqli_error());
                      while ($row = mysqli_fetch_array($query_r)) {
                      ?>
                        <!--tabale row-->
                        <tr>
                          <td> <?php echo $row['status_detail']; ?></td>
                          <td class="text-center"> <?php
                                                    $time = $row['status_date'];
                                                    echo  date('d M Y, g;i A', strtotime($time));
                                                    //type1  echo  date('g:i A, l - d M Y', strtotime($time));
                                                    //type2 echo  date("m-d-Y", strtotime($time)); 
                                                    ?></td>
                          <td>

                            <!--calculate days-->
                            <?php
                            $time = $row['status_date'];
                            $date1 = date_create(date('Y-m-d', strtotime($time)));
                            $date2 = date_create(date('Y-m-d'));
                            //difference between two dates
                            $diff = date_diff($date1, $date2);

                            //count days
                            echo $diff->format("%a");


                            ?>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--end Card note history -->

          </div>



        </div>
      </div>
    </div>






    <?php
    include_once("inc/move_perposal.php");
    include_once("layouts/footer.php");
    include("asset/mail/data.php");
    ?>