<?php 
	require_once 'inc/session.php';
	
	if(!isset($_SESSION['userID'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}
    //identyfied
		if($_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2){
		
          header("Location:index.php");  
		 }



//for deleted
include "inc/config.php";	
	if(isset($_GET['delete_id']))
	{
	
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM lead WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
//		header("Location:menu_management.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Setting</title>
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
   
            <!-- Host -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Host</div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, Host FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#Host" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['Host'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="Host" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['Host']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="Host" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updateHost" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updateHost'])  ){
               $id = $_POST['id'];
               $Host = $_POST['Host'];
               $result = mysqli_query($db,"UPDATE php_mailer SET Host = '$Host' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end Host -->
                
                <!-- SMTPDebug -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">SMTPDebug</div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, SMTPDebug FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#SMTPDebug" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['SMTPDebug'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="SMTPDebug" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['SMTPDebug']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="SMTPDebug" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updateSMTPDebug" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updateSMTPDebug'])  ){
               $id = $_POST['id'];
               $SMTPDebug = $_POST['SMTPDebug'];
               $result = mysqli_query($db,"UPDATE php_mailer SET SMTPDebug = '$SMTPDebug' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end SMTPDebug -->
                
              
             <!-- SMTPAuth -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">SMTPAuth</div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, SMTPAuth FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#SMTPAuth" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['SMTPAuth'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="SMTPAuth" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['SMTPAuth']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="SMTPAuth" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updateSMTPAuth" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updateSMTPAuth'])  ){
               $id = $_POST['id'];
               $SMTPAuth = $_POST['SMTPAuth'];
               $result = mysqli_query($db,"UPDATE php_mailer SET SMTPAuth = '$SMTPAuth' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end SMTPAuth -->
                
             <!-- SMTPSecure -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">SMTPSecure</div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, SMTPSecure FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#SMTPSecure" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['SMTPSecure'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="SMTPSecure" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['SMTPSecure']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="SMTPSecure" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updateSMTPSecure" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updateSMTPSecure'])  ){
               $id = $_POST['id'];
               $SMTPSecure = $_POST['SMTPSecure'];
               $result = mysqli_query($db,"UPDATE php_mailer SET SMTPSecure = '$SMTPSecure' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end SMTPSecure -->
                
              
             <!-- Port -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Port</div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, Port FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#Port" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['Port'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="Port" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['Port']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="Port" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updatePort" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updatePort'])  ){
               $id = $_POST['id'];
               $Port = $_POST['Port'];
               $result = mysqli_query($db,"UPDATE php_mailer SET Port = '$Port' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end Port -->
                
              <!-- recived1 -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Recived mail 1 </div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, recived1 FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#recived1" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['recived1'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="recived1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['recived1']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="recived1" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updaterecived1" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updaterecived1'])  ){
               $id = $_POST['id'];
               $recived1 = $_POST['recived1'];
               $result = mysqli_query($db,"UPDATE php_mailer SET recived1 = '$recived1' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end recived1 -->
             
              
           
             <!-- recived2 -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-4">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Recived mail 2</div>
<?php                                    
$query_r = mysqli_query($db,"SELECT id, recived2 FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
while($row = mysqli_fetch_array( $query_r ))
{
?>                             
 <li class="nav-item email-list">
     <div class="travel-date">
         
<!--   show email      -->
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#recived2" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
         <?php echo $row['recived2'];?>
        <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email Id!"></i> 
        </a>
         
<!--   edit email      -->
        <div id="recived2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
<form method="post" enctype="multipart/form-data" class="form-horizontal"> 
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
            <div class="input-group mb-mail">  
            <input class="form-control form-control-user-style1 fr-email" value="<?php echo $row['recived2']; ?>" type="text" id="<?php echo $row['id']; ?>"  name="recived2" required>   
           <div class="input-group-prepend">
          <div class="right-send">
              <input class="send btn-success"  type="submit" name="updaterecived2" value="Done"> 
          </div>
        </div>
     </div>   
   </form>
           <?php           
               if(isset($_POST['updaterecived2'])  ){
               $id = $_POST['id'];
               $recived2 = $_POST['recived2'];
               $result = mysqli_query($db,"UPDATE php_mailer SET recived2 = '$recived2' WHERE id='1'");
               echo "<meta http-equiv='refresh' content='0'>";   
                }              
            ?>  
            </div>
       </div>
      </div>
     </li>
 <?php
}                 
?>  </div> 
          </div>
             </div>
              </div>
            </div> 
            <!-- end recived2 -->
                
              
              
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
     