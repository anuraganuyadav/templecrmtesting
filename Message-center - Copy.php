<?php 
	require_once 'inc/session.php';
	
	if(!isset($_SESSION['userID'],$_SESSION['user_role_id']))
	{
		header('location:login.php?lmsg=true');
		exit;
	}
    //identyfied
 	if($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2 ){
		
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
		
		header("Location:menu_management.php");
	}

if(isset($_GET['chat']) && !empty($_GET['chat']))
	{
		$userID = $_GET['chat'];
		$stmt_edit = $DB_con->prepare('SELECT userID, userPic, user_name, full_name FROM users WHERE userID=:uuserID');
		$stmt_edit->execute(array(':uuserID'=>$userID));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin:Dashboard</title>
  <?php include_once("layouts/header.php");?>
</head>
<body id="page-top">
  <?php include_once("layouts/sidebar.php");?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once("layouts/nav.php");?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

 
          <div class="row">
        <!--  earning view  -->
    <!-- Begin Page Content -->
   <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="card shadow mb-3 box-sms">
 
 
<script type="text/javascript">
$(document).ready(function() {
	//##### Add record when Add Record Button is click #########
	$("#FormSubmit").click(function (e) {
        
			e.preventDefault();
			if($("#sms").val()==='')
			{
				alert("Please enter some text!");
				return false;
			}
        
		 	var message = $("#sms").val(); //build a post data structure
		 	var SMSuserID = $("#userID").val(); //build a post data structure
		 	var SendPerson = $("#SendPerson").val(); //build a post data structure
		 	var ReceivedPerson = $("#ReceivedPerson").val(); //build a post data structure
        
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/caht-response.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {message: message, SMSuserID: SMSuserID, SendPerson: SendPerson, ReceivedPerson: ReceivedPerson},      
			success:function(response){
				$("#response").append(response);
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}
                
			});
        
      
	});

});
    
//send and filter data every second refresh   
$(document).ready(function update(){       
var ReceivedPerson = $("#ReceivedPerson").val(); //build a post data structure
    
$.ajax({
url:"Message-fetch.php",
method:"POST",
data: {ReceivedPerson: ReceivedPerson},
success:function(data)
{
$('#smsFetch').html(data);
}
}).then(function() {           // on completion, restart
        setTimeout(update, 1000);  // function refers to itself
    }); 
});   
    
    
</script>
             
 
<!--
<script type="text/javascript">
function Load_external_content()
{
      $('#smsFetch').load('Message-fetch.php').hide().fadeIn(200);
}
setInterval('Load_external_content()', 2200);
</script>       
 
-->
            
   
<div class="content_wrapper">
<div class="content_wrapper">
<div class="row">
    <div class="col-sm-4 side-chat">
       
              <!-- Dropdown - Messages -->
 
                <h6 class="message-header">
                  Message Center
                </h6>
                  
<!-- Message Center                  -->
 <?php
$user = $_SESSION["userID"];                 
$query = mysqli_query($db,"SELECT * FROM users WHERE userID != $user ORDER BY userID") 
or die(mysqli_error()); 
while($row = mysqli_fetch_array( $query ))
{
?>           
                <a class="dropdown-item d-flex align-items-center chat-person" href="Message-center.php?chat=<?php echo $row['userID'];?>">
                  <div class="dropdown-list-image mr-3">
                 <img class="rounded-circle img-50" src="images/user_images/<?php echo $row['userPic']?>">
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate"><?php echo $row['full_name']?></div>
                    <div class="small text-gray-500">  <?php 
                    if($row['online'] == '1'){  
                    echo"<div class='text-success'>Online</div>";
                   }
                  else{
                    echo"<div class='text-secondary'>Offline</div>";   
                  }
                  ?></div>
                  </div>
                </a>
<?php
}
?>
              
    </div>
 <div class="col-sm-8 response"> 
<div id="response-out"> 
<span id="response"></span> 
 </div>   
<ul id="smsFetch"> 
<!--response send message-->

<!-- show  chat message -->
</ul> 
 
 
  <div class="form_style">
  <form id="cmdline">
    <input type="hidden" value="<?php echo $_SESSION["userID"]; ?>"  id="userID" name="SMSuserID">
    <input type="hidden" value="<?php echo $_SESSION["user_name"]; ?>" id="SendPerson" name="SendPerson">
    <input type="hidden" value="<?php echo $user_name; ?>" id="ReceivedPerson" name="ReceivedPerson">
   
     <div class="input-group mb-3">
    <input type="text" autocomplete="off" placeholder="Type...." onfocus="this.value=''"  name="message" class="control-form" id="sms"> 
      <div class="input-group-prepend">
      <span class="input-group-text"><button type="submit" id="FormSubmit"><i class="fas fa-arrow-up"></i></button></span> 
    </div>    
  </div>
   </form>  
    <button class="input-refresh" onclick="location.reload();"><i class="fas fa-sync-alt fa-refresh"></i></button>  
    </div>     
      
    </div>    
</div> 
</div>            
 <script>
//using for scroll auto
var scroll = document.getElementById('smsFetch');
   scroll.scrollTop = scroll.scrollHeight;
   scroll.animate({scrollTop: scroll.scrollHeight});
     
//var response = document.querySelector('#response');
//response.scrollTop = response.scrollHeight - response.clientHeight;
     
 
// Using for enter press submit and clear input by id
$('#cmdline').bind('keyup', function(e) {
  if (e.keyCode === 13) {
    $('#cmdline').find('input[type="text"]').val('');
  }
});     
     
</script>    
      
       
            
            
            
   
        </div> 
          </div> 
        </div>
        </div>
        <!-- /.container-fluid -->
   </div>
      </div>
      <!-- End of Main Content -->
   
    
 <?php 
    include_once("layouts/footer.php");
    ?>
     