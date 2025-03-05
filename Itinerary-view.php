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



	error_reporting( ~E_NOTICE );
require_once 'inc/config.php';	
	if(isset($_GET['view_itinerary']) && !empty($_GET['view_itinerary']))
	{
		$id = $_GET['view_itinerary'];
		$stmt_edit = $DB_con->prepare('SELECT id, name, email, mo_number, destination, no_person, response_client, description, date FROM itinerary WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
//for deleted 	
 
	if(isset($_POST['delete']))
	{  
   $name = $_POST['name'];// 
	 $id = $_POST['id'];// 
  $stmt_delete = $DB_con->prepare("DELETE FROM itinerarynotes WHERE id = '$id' LIMIT 1"); 
  $stmt_delete->execute();    
   echo "<meta http-equiv='refresh' content='0'>";     
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
                   <td> 

<!--name-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#nameSubmit<?php echo $id; ?>").click(function (e) {
			e.preventDefault();
			if($("#name<?php echo $id; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var name = $("#name<?php echo $id; ?>").val(); //build a post data structure
		 	var id = $("#nameid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateName.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {name: name, id: id},      
			success:function(response){
				$("#nameResponse<?php echo $id; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="nameResponse<?php echo $id; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#nameModal<?php echo $id;?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $name;?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit name!"></i> 
        </a>
         
         
        <div id="nameModal<?php echo $id;?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="nameid<?php echo $id; ?>" name="id" value="<?php echo $id; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="name<?php echo $id; ?>" class="form-control form-control-user-style1" value="<?php echo $name; ?>" type="text" placeholder="Enter Name"  name="name" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="nameSubmit<?php echo $id; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>   
   </form>
        </div>
          </div>
        </div>
      </li> 
                    </td>
                    <td>

<!--email-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#emailSubmit<?php echo $id; ?>").click(function (e) {
			e.preventDefault();
			if($("#email<?php echo $id; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var email = $("#email<?php echo $id; ?>").val(); //build a post data structure
		 	var id = $("#emailid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateEmail.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {email: email, id: id},      
			success:function(response){
				$("#emailResponse<?php echo $id; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="emailResponse<?php echo $id; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#emailModal<?php echo $id;?>" aria-expanded="true" aria-controls="collapseTwo" onClick ="this.style.display= 'none';">
          <?php echo $email;?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email!"></i> 
        </a>
         
         
        <div id="emailModal<?php echo $id;?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="emailid<?php echo $id; ?>" name="id" value="<?php echo $id; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="email<?php echo $id; ?>" class="form-control form-control-user-style1" value="<?php echo $email; ?>" type="text" placeholder="Enter email"  name="email" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="emailSubmit<?php echo $id; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>   
   </form>
        </div>
          </div>
        </div>
      </li>    
                  </td> 
                  <td>
<!--mo_number-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#mo_numberSubmit<?php echo $id; ?>").click(function (e) {
			e.preventDefault();
			if($("#mo_number<?php echo $id; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var mo_number = $("#mo_number<?php echo $id; ?>").val(); //build a post data structure
		 	var id = $("#mo_numberid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updatePhone.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {mo_number: mo_number, id: id},      
			success:function(response){
				$("#mo_numberResponse<?php echo $id; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="mo_numberResponse<?php echo $id; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#mo_numberModal<?php echo $id;?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $mo_number;?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Number!"></i> 
        </a>
         
         
        <div id="mo_numberModal<?php echo $id;?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="mo_numberid<?php echo $id; ?>" name="id" value="<?php echo $id; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="mo_number<?php echo $id; ?>" class="form-control form-control-user-style1" value="<?php echo $mo_number; ?>" type="text" placeholder="Enter mo_number"  name="mo_number" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="mo_numberSubmit<?php echo $id; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>   
   </form>
        </div>
          </div>
        </div>
      </li>    
    
                  </td>
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
                        <td>             
<!--destination-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#destinationSubmit<?php echo $id; ?>").click(function (e) {
			e.preventDefault();
			if($("#destination").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var destination = $("#destination").val(); //build a post data structure
		 	var id = $("#destinationid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateDestintion.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {destination: destination, id: id},      
			success:function(response){
				$("#destinationResponse<?php echo $id; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="destinationResponse<?php echo $id; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#destinationModal<?php echo $id;?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $destination;?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit  Destintion!"></i> 
        </a>
         
         
        <div id="destinationModal<?php echo $id;?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="destinationid<?php echo $id; ?>" name="id" value="<?php echo $id; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="destination" class="form-control form-control-user-style1" value="<?php echo $destination; ?>" type="text" placeholder="Enter destination"  name="destination" required> 
<ul class="list-group" id="result"></ul>    
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="destinationSubmit<?php echo $id; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>   
   </form>
        </div>
          </div>
        </div>
      </li>    
   
<!--  search destination  -->
 
<script>
$(document).ready(function(){
 $.ajaxSetup({ cache: false });
 $('#destination').keyup(function(){
  $('#result').html('');
  $('#state').val('');
  var searchField = $('#destination').val();
  var expression = new RegExp(searchField, "i");
  $.getJSON('inc/destinationjson.php', function(data) {
   $.each(data, function(key, value){
    if (value.name.search(expression) != -1 )
    {
     $('#result').append('<li class="list-group-item link-class">'+value.name+' </li>');
    }
   });   
  });
 });
 
 $('#result').on('click', 'li', function() {
  var click_text = $(this).text().split('|');
  $('#destination').val($.trim(click_text[0]));
  $("#result").html('');
 });
});
</script>                         
                            
 </td>     
 <td> 
<!--no_person-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#no_personSubmit<?php echo $id; ?>").click(function (e) {
			e.preventDefault();
			if($("#no_person<?php echo $id; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var no_person = $("#no_person<?php echo $id; ?>").val(); //build a post data structure
		 	var id = $("#no_personid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateNumberPerson.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {no_person: no_person, id: id},      
			success:function(response){
				$("#no_personResponse<?php echo $id; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="no_personResponse<?php echo $id; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#no_personModal<?php echo $id;?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $no_person;?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit  Destintion!"></i> 
        </a>
         
         
        <div id="no_personModal<?php echo $id;?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="no_personid<?php echo $id; ?>" name="id" value="<?php echo $id; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="no_person<?php echo $id; ?>" class="form-control form-control-user-style1" value="<?php echo $no_person; ?>" type="text" placeholder="Enter no_person"  name="no_person" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="no_personSubmit<?php echo $id; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>   
   </form>
        </div>
          </div>
        </div>
      </li>    
  
                        </td>   
                        <td> 
<!-- status response                           -->
 <div class="btn-delete-div2"> 
<script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#FormSubmit").click(function (e) {
			e.preventDefault();
			if($("#response_client").val()==='')
			{
				alert("Please select!");
				return false;
			}
		 	var response_client = $("#response_client").val(); //build a post data structure
		 	var id = $("#id").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/response-client.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {response_client: response_client, id: id},      
			success:function(response){
				$("#statusResponse").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>
   
<div> 
  <span class="resp" id="statusResponse"></span>    
<form> 
<!-- delet-btn-->
 <div class="mb-width-side">    
     <div class="right-send">
        <button class="send btn-success" id="FormSubmit"  type="submit">Apply</button> 
         
    <a href="Create-Potential.php?create_potential=<?php echo $id;?>"  class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Create Potential!" ><i class="fas fa-plus-circle add-client"></i></a> 
    </div>
     
     
 <input type="hidden" id="id" name="id" value="<?php echo $id;?>"> 
 
 <select id="response_client" class="form-control form-control-user-style1 fr-select" name="response_client" required>
 <option class="selected-cr" value=""><?php echo $response_client;?></option>         

     
     
  <?php  
$query_list = mysqli_query($db,"SELECT * FROM response ORDER BY response_list") 
or die(mysqli_error()); 
while ($row = mysqli_fetch_array( $query_list )) 
{
?>
<option value="<?php echo $row['response_list'];?>"><?php echo $row['response_list'];?></option>        

<?php   
}    
 ?> 
 <?php ?>    
     
 </select>       

 </div>   
   </form> 
 
    </div>
    </div>     
                            
                        </td>
                       </tr>
                     </tbody>
                </table> 
            
      </div>
<!--  End div-->
      <br> 
      
    <div class="row">
<!--notes-->
      <div class="col-sm-7">
        <div class="card shadow"> 
            
           <div class="card-header-note d-block" > 
    <script type="text/javascript">
$(document).ready(function() { 
	//##### Add record when Add Record Button is click #########
	$("#NoteAdd").click(function (e) {
			e.preventDefault();
			if($("#note<?php echo $id; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var note = $("#note<?php echo $id; ?>").val(); //build a post data structure
		 	var id = $("#noteid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateItineraryNote.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {note: note, id: id},
            success:function(response){
				$("#noteResponse<?php echo $id; ?>").prepend(response);
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>
                
          <form id="cmdline"> 
       <input type="hidden" id="noteid<?php echo $id; ?>" name="note_id" value="<?php echo $id; ?>">    
 <div class="input-group"> 
    <div class="input-group-prepend add-prepend">
        <a href="#ViewNotes" class="card-header btn-success input-group-text font-weight-bold add-note" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" class="">Add</a>
  </div>  
         <input type="text" id="note<?php echo $id; ?>" placeholder="Type notes..." class="note-control" name="note"> 
          
  </div>
              <button class="send btn-success btn-add button-note hide" id="NoteAdd"  type="submit">Add</button> 
              
   </form>
               
 <script>
    $('#cmdline').bind('keyup', function(e) {
  if (e.keyCode === 13) {
    $('#cmdline').find('input[type="text"]').val('');
  }
});    
   </script>            
               
               
   </div> 
            <!-- Card note history --> 
 <div class="collapse show" id="ViewNotes">       
  <div class="card-body">  
<!--// notes-->
 <!-- table   --> 
    <div class="table-responsive">                  
    
         
<table id="noteResponse<?php echo $id; ?>"  class="table table-bordered table-danger"  width="100%" cellspacing="0">               
  <?php
$id = $_GET['view_itinerary'];                                   
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
  <td>
<!--  delete    -->
 <!-- delet-btn-->  
 <form method="post">
<input type="hidden" name="id" value="<?php echo $row['id'];?>">
      <button class="btn btn-danger btn-circle btn-sm btn-delete" type="submit"  name="delete"><i class="fas fa-trash"></i></button>
      </form>         
 </td>     
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
  <script type="text/javascript">
$(document).ready(function() { 
	//##### Add record when Add Record Button is click #########
	$("#descriptionSubmit<?php echo $id; ?>").click(function (e) {
			e.preventDefault();
			if($("#description<?php echo $id; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var description = $("#description<?php echo $id; ?>").val(); //build a post data structure
		 	var id = $("#descriptionid<?php echo $id; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateDescription.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {description: description, id: id},      
			success:function(response){
				$("#descriptionResponse<?php echo $id; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
          <div class="card shadow mb-4">
                  
                <!-- Card Header - Accordion -->
                <a href="#collapseDescription" class="d-block card-header py-3 bg-blue" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                  <h6 class="m-0 font-weight-bold text-light">View Description</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseDescription">
                  <div class="card-body">
     <div class="travel-descript">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#Description" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $description;?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Description"></i> 
        </a>
<div id="Description" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
<!-- response   message-->
    <span class="resp" id="descriptionResponse<?php echo $id; ?>"></span>    
<div class="bg-white py-2 collapse-inner rounded">
 <form> 
 <input type="hidden" name="id" id="descriptionid<?php echo $id; ?>" value="<?php echo $id; ?>">    
<div class="input-group"> 
 
<textarea id="description<?php echo $id; ?>" class="form-control form-control-user-style1 fr-date" name="description" rows="9" cols="3">
    <?php echo $description; ?>
    </textarea>   
  <div class="input-group-prepend">
          <div class="right-send2">
            <button class="send btn-success" id="descriptionSubmit<?php echo $id; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>  
   </form>
   </div>
                        </div>
                      </div> 
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
$id = $_GET['view_itinerary'];                                   
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