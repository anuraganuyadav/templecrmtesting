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


//for deleted
include "inc/config.php";	
	if(isset($_GET['delete_id']))
	{
	
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM itinerary WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
//		header("Location:menu_management.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sales Mail Setting</title>
  <?php include_once("layouts/header.php");?>
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
        <div class="card shadow mb-3">
          <div class="card-header"> 
            Mailer Setting</div>
          <div class="card-body">
              
         <!-- Content Row -->
              
   <div class="row">             
  <?php                                    
$query = mysqli_query($db,"SELECT * FROM users ORDER BY userID, user_name, full_name, email_id, password_set") 
or die(mysqli_error()); 
while($row = mysqli_fetch_array( $query ))
{
?>            
                        <!-- name -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">name</div>
                         <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show full_name      -->
  <a  class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#full_name<?php echo $row['userID']; ?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
       <input class="border-0" type="full_name" value="<?php echo $row['full_name'];?>">
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit full_name      -->
        <div id="full_name<?php echo $row['userID']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['full_name']; ?>" type="text" id="<?php echo $row['userID']; ?>"  name="full_name" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updatefull_name" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updatefull_name'])  ){
               $userID = $_POST['userID'];
               $full_name = $_POST['full_name'];
               $result = mysqli_query($db,"UPDATE users SET full_name = '$full_name' WHERE userID='$userID'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
      </li> 
                         </div> 
                       </div>
                       </div>
                     </div>
                </div> 
                     <!-- end full_name --> 
       
                        <!-- email_id -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">email_id</div>
                         <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email_id      -->
  <a  class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#email_id<?php echo $row['userID']; ?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
       <input class="border-0" type="email_id" value="<?php echo $row['email_id'];?>">
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email_id      -->
        <div id="email_id<?php echo $row['userID']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['email_id']; ?>" type="text" id="<?php echo $row['userID']; ?>"  name="email_id" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updateemail_id" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updateemail_id'])  ){
               $userID = $_POST['userID'];
               $email_id = $_POST['email_id'];
               $result = mysqli_query($db,"UPDATE users SET email_id = '$email_id' WHERE userID='$userID'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
      </li> 
                         </div> 
                       </div>
                       </div>
                     </div>
                </div> 
                     <!-- end email_id --> 
      
                  <!-- password_set -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Set Password </div>
                         <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show password_set      -->
  <a  class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#password_set<?php echo $row['userID']; ?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
       <input class="border-0" type="password" value="<?php echo $row['password_set'];?>">
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit password_set      -->
        <div id="password_set<?php echo $row['userID']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['password_set']; ?>" type="text" id="<?php echo $row['userID']; ?>"  name="password_set" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updatepassword_set" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updatepassword_set'])  ){
               $userID = $_POST['userID'];
               $password_set = $_POST['password_set'];
               $result = mysqli_query($db,"UPDATE users SET password_set = '$password_set' WHERE userID='$userID'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
      </li> 
                         </div> 
                       </div>
                       </div>
                     </div>
                </div> 
                     <!-- end password_set --> 
      
      
      
 <?php
}
  ?>
  </div>

          <!-- Content Row -->      
              
              
              
              
              
              
              
          </div> 
        </div> 
          </div> 
        </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
    
 
    
    
    
    
    
    
    
   
         
    
    
 <?php 
     include "inc/insert-send.php";
    include_once("layouts/footer.php");
    ?>
     