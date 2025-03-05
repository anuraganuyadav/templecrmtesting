<?php
	require_once 'inc/session.php';
	
	if(!isset($_SESSION['userID'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}		
    //identyfied
	 if($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2 ){
		
          header("Location:index.php");  
		 }



	error_reporting( ~E_NOTICE );
require_once 'inc/config.php';	
	if(isset($_GET['Lead_manage_view']) && !empty($_GET['Lead_manage_view']))
	{
		$id = $_GET['Lead_manage_view'];
		$stmt_edit = $DB_con->prepare('SELECT id, name, email, mo_number, destination, no_person, response_client, description, date FROM itinerary WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
 
?>
<?php 	  
require_once('layouts/header.php');
?>   
 
<title>Client View</title>
<script src="asset/js/jquery.form.js"></script>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <?php include_once("layouts/sidebar.php");?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php");?>
<!-- satart conatainer       -->
  <div class="container">
    <div class="card shadow card-login mx-auto mt-5 under-cr">
      <div class="card-header">View Detail</div>
     <!-- insert itinearay Modal-->
          
  <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No.</th> 
                  </tr>
                </thead>
                <tbody>
                  <tr>
                <td><?php echo $name; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $mo_number; ?></td>
                 </tr>
                  </tbody>
                        <thead>
                        <tr>
                     <th>Destinations</th>        
                    <th>Person</th>   
                    <th>Lead Status</th>
                        </tr>    
                        </thead>                      
                      <tbody>  
                        <tr>
                <td><?php echo $destination; ?></td>
                <td><?php echo $no_person; ?></td>
                <td><?php echo $response_client; ?></td>
                       </tr>
                     </tbody>
                </table> 
            
      </div>
<!--  End div-->
      <br> 
      
    <div class="row">
<!--notes-->
      <div class="col-sm-7">
      <div class="card shadow mb-4">
                  
                  <!-- Card Header - Accordion -->
                  <a href="#ViewNotes" class="d-block card-header py-3 bg-blue" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-light">Notes</h6>
                  </a>
        
            <!-- Card note history --> 
 <div class="collapse show" id="ViewNotes">       
  <div class="card-body">  
<!--// notes-->
 <!-- table   --> 
    <div class="table-responsive">                  
    
         
<table id="noteResponse<?php echo $id; ?>"  class="table table-bordered table-danger"  width="100%" cellspacing="0">               
  <?php
$id = $_GET['Lead_manage_view'];                                   
$query_r = mysqli_query($db,"SELECT id, note_id, note, create_date FROM itinerarynotes WHERE note_id = $id ORDER BY id DESC") 
or die(mysqli_error());          
while($row = mysqli_fetch_array( $query_r ))
{
?>
       
 <tr>            
<!--tabale row-->     
  <td> <?php echo $row['note']; ?></td>
  <td> <?php 
 $time = $row['create_date'];
  echo  date('g;i A, d M Y', strtotime($time)); 
//type1  echo  date('g:i A, l - d M Y', strtotime($time));
//type2 echo  date("m-d-Y", strtotime($time)); 
?></td>     
  </tr> 
      
  <?php
}                 
?>  
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
                      <p><?php echo $description; ?>
                    </div>
                </div>
              </div>   
   <div class="card shadow"> 
            <!-- Card status history --> 
 <div class="collapse show" id="ViewNotes">       
  <div class="card-body">  
<!--// notes-->
 <!-- table   -->
    <div class="table-responsive">                  
    <table class="table table-bordered table-success"  width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Status</th>
                    <th class="text-center">Date</th> 
                    <th>days</th> 
                  </tr>
                </thead> 
        <tbody> 
  <?php
$id = $_GET['Lead_manage_view'];                                   
$query_r = mysqli_query($db,"SELECT id, status_id, status_detail, status_date FROM  lead_status_history WHERE status_id = $id ORDER BY id DESC") 
or die(mysqli_error());          
while($row = mysqli_fetch_array( $query_r ))
{
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
$diff = date_diff($date1,$date2);

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
        
           
    </div>
<!--  end container -->   
    
 <?php  
    include_once("layouts/footer.php");
  ?>