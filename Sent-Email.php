<?php 
	require_once 'inc/session.php';
	
	if(!isset($_SESSION['userID'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}		
    //identyfied
	 if($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 2 ){
		
          header("Location:index.php");  
		 }

 


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include_once("layouts/header.php");?>
    <title>Admin: Dashboard</title>
</head>
<body id="page-top">
  <?php include_once("layouts/sidebar.php");?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php");?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

        
          <div class="row">
        <!--  earning view  -->
    <!-- Begin Page Content -->
   <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="card bg-green shadow mb-3">
          <div class="card-header">
               INBOX  </div>
           
          <div class="card-body">
            <div class="table-responsive">
      
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name </th>
                    <th>Email</th>  
                    <th>Subject</th>  
                    <th>Date</th>  
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Subject</th> 
                    <th>Date</th> 
                    
                  </tr>
                </tfoot>
                <tbody>                
  <?php
$user_name = $_SESSION['user_name'];                                    
$query_r = mysqli_query($db,"SELECT id, mail_id, name, email, file, date, Written_Itinerary, subject, bcc, bcc2 FROM email_history WHERE sales_person ='$user_name'") 
or die(mysqli_error()); 
while($row = mysqli_fetch_array( $query_r ))
{
?>  
<tr>
                    <td>
               <a href="#" data-toggle="modal" data-target="#insertLead<?php echo $row['id'];?>" >
                   <i class="fas fa-eye"></i> 
               </a>
         <!-- view email-->
  <div class="modal fade" id="insertLead<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dilogue-full" role="document">
      <div class="modal-content">
        <div class="modal-header modal-header bg-primary text-light">
          <h5 class="modal-title" id="exampleModalLabel">Sent Email  </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
         <div class="card">
          <table>
              
             <tr>
             <td> <b> Name: <?php echo $row['name'];?></b> </td>
             <td> <b> Email: <?php echo $row['email'];?></b> </td>
             <td> <b> BCC: <?php echo $row['bcc'];?></b> </td>
             <td> <b> BCC2: <?php echo $row['bcc2'];?></b> </td>
             <td> <b> Date: <?php echo $row['date'];?></b> </td>
             </tr>
             </table>  
            </div>   
            
             <br>
             <br>
            
           <?php echo $row['Written_Itinerary']; ?> 
            <br>
            <a href="images/Attachment/<?php echo $row['file'];?>">
                <?php
                if(empty($row['file'])){
                  echo "";  
                }
                else{
                  echo "<img src='images/img/file.gif'>"; 
                }
                ?>
                
                
            
            </a>
          </div> 
      </div>
    </div>
  </div>  
     <!--end view email-->  
                    <?php echo $row['name'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['subject'];?></td>
                     <td>
                      <?php
                       $time = $row['date']; 
                       echo  date('d M Y, g;i A', strtotime($time));
                         ?>
                      </td>  
 </tr>                    
 <?php
}        
?>                  
</tbody>
 </table>


<!-- page reload -->                          
 <?php           
    if(isset($_POST['apply'])  ){
        $id = $_POST['id'];
        $response_client = $_POST['response_client'];
        $result = mysqli_query($db,"UPDATE itinerary SET response_client = '$response_client' WHERE id= $id");
     
echo "<meta http-equiv='refresh' content='0'>";   
    }              
?>
      </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div> 
          </div> 
        </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
 
    
 <?php  
    include_once("layouts/footer.php");
    ?>
     