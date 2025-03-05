 
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
 

 ?>
 
<?php include_once("layouts/header.php");?>
 <!-- selete select   -->
    
<script>
function checkUncheckAll(){
var chks = document.getElementsByName("ck");
if(document.getElementById("ck_All").checked)
	{
		$("#delete_link").on("click" , deleteSelectedRows);
		for( i = 0;i < chks.length;i++)
			document.getElementsByName("ck")[i].checked = true;
        
        
 
 
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
    }   
 
  
else {
		 for( i = 0;i < chks.length;i++)
			document.getElementsByName("ck")[i].checked = false;
			document.getElementById("delete_link").onclick = function(){deleteSelectedRows();};
    $("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
	}
}
function selectUnselect(checked){

if(checked) {
		document.getElementById("delete_link").onclick = function(){deleteSelectedRows();};
		var chks = $("input[name='ck']");
		var all_checked = true;
		for(i=0;i<chks.length;i++)
			if(chks[i].checked)
				continue;
			else {all_checked = false; break;}
		if(all_checked)
			document.getElementById("ck_All").checked = true;
     $("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
    
	 }
    
  else {
     document.getElementById("delete_link").onclick = function(){deleteSelectedRows();};
		var chks = $("input[name='ck']");
		var all_checked = true;
		for(i=0;i<chks.length;i++)
			if(chks[i].checked)
				continue;
			else {all_checked = false; break;}
		if(all_checked)
			document.getElementById("ck_All").checked = true;
     $("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
	}
    
    
}
    
    
function deleteSelectedRows(){
	var cks = $("input[name='ck']");
	var checked = [];
	for(i = 0;i<cks.length;i++)
		if(cks[i].checked)
			checked.push(cks[i].parentNode.parentNode.id);
	
	var jsonob = JSON.stringify(checked);
	$.post("delete.php" , {rows_to_be_deleted:jsonob} , function(data){
		for(i=0;i<checked.length;i++)
			$("#" + checked[i]).fadeOut('slow' , function(){$(this).remove();});
		});
	} 
	</script>     
 
    <table id="fresh-table" class="table">
      <thead>
<!--        <th data-field="id">ID</th>-->
        <th>Select</th>   
        <th data-field="name" data-sortable="true">Name</th>
        <th data-field="email" data-sortable="true">Email</th>
        <th data-field="phone" data-sortable="true">Phone No</th>
        <th data-field="destinations" data-sortable="true">Destinations</th>
        <th data-field="person" data-sortable="true">Person</th>
        <th data-field="source" data-sortable="true">Source</th>
        <th data-field="date" data-sortable="true">Date</th>
        <th data-field="send">Send To</th>
          
          
<!--        <th data-field="actions" data-formatter="operateFormatter" data-events="operateEvents">Actions</th>-->
      </thead>
      <tbody>
  <?php
  if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 50;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `itinerary`");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1        
          
          
          
          
          
          
          
          
$query = mysqli_query($db,"SELECT id, name, email, mo_number, destination, no_person, response_client, sales_person, description, date, LeadSource FROM itinerary ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error()); 
while($row = mysqli_fetch_array( $query ))
{
?>  
  <tr id="<?php echo $row['id'] ?>" >
    <td><input name="ck" class="emp_checkbox" onchange="selectUnselect(this.checked)" type = "checkbox"  id="<?php echo $row["id"]; ?>"></td>
                    <td>     
<!--name-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#nameSubmit<?php echo $row['id']; ?>").click(function (e) {
			e.preventDefault();
			if($("#name<?php echo $row['id']; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var name = $("#name<?php echo $row['id']; ?>").val(); //build a post data structure
		 	var id = $("#nameid<?php echo $row['id']; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateName.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {name: name, id: id},      
			success:function(response){
				$("#nameResponse<?php echo $row['id']; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="nameResponse<?php echo $row['id']; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#nameModal<?php echo $row['id'];?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $row['name'];?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit name!"></i> 
        </a>
         
         
        <div id="nameModal<?php echo $row['id'];?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="nameid<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id']; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="name<?php echo $row['id']; ?>" class="form-control form-control-user-style1" value="<?php echo $row['name']; ?>" type="text" placeholder="Enter Name"  name="name" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="nameSubmit<?php echo $row['id']; ?>"  type="submit">Done</button> 
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
	$("#emailSubmit<?php echo $row['id']; ?>").click(function (e) {
			e.preventDefault();
			if($("#email<?php echo $row['id']; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var email = $("#email<?php echo $row['id']; ?>").val(); //build a post data structure
		 	var id = $("#emailid<?php echo $row['id']; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateEmail.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {email: email, id: id},      
			success:function(response){
				$("#emailResponse<?php echo $row['id']; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="emailResponse<?php echo $row['id']; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#emailModal<?php echo $row['id'];?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $row['email'];?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit email!"></i> 
        </a>
         
         
        <div id="emailModal<?php echo $row['id'];?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="emailid<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id']; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="email<?php echo $row['id']; ?>" class="form-control form-control-user-style1" value="<?php echo $row['email']; ?>" type="text" placeholder="Enter email"  name="email" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="emailSubmit<?php echo $row['id']; ?>"  type="submit">Done</button> 
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
 <li class="nav-item list-non mo-number">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#mo_numberSubmit<?php echo $row['id']; ?>").click(function (e) {
			e.preventDefault();
			if($("#mo_number<?php echo $row['id']; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var mo_number = $("#mo_number<?php echo $row['id']; ?>").val(); //build a post data structure
		 	var id = $("#mo_numberid<?php echo $row['id']; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updatePhone.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {mo_number: mo_number, id: id},      
			success:function(response){
				$("#mo_numberResponse<?php echo $row['id']; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="mo_numberResponse<?php echo $row['id']; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#mo_numberModal<?php echo $row['id'];?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $row['mo_number'];?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Number!"></i> 
        </a>
         
         
        <div id="mo_numberModal<?php echo $row['id'];?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="mo_numberid<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id']; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="mo_number<?php echo $row['id']; ?>" class="form-control form-control-user-style1" value="<?php echo $row['mo_number']; ?>" type="text" placeholder="Enter mo_number"  name="mo_number" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="mo_numberSubmit<?php echo $row['id']; ?>"  type="submit">Done</button> 
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
<!--destination-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#destinationSubmit<?php echo $row['id']; ?>").click(function (e) {
			e.preventDefault();
			if($("#destination<?php echo $row['id']; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var destination = $("#destination<?php echo $row['id']; ?>").val(); //build a post data structure
		 	var id = $("#destinationid<?php echo $row['id']; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateDestintion.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {destination: destination, id: id},      
			success:function(response){
				$("#destinationResponse<?php echo $row['id']; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="destinationResponse<?php echo $row['id']; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#destinationModal<?php echo $row['id'];?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $row['destination'];?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit destination!"></i> 
        </a>
         
         
        <div id="destinationModal<?php echo $row['id'];?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="destinationid<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id']; ?>">    
<div class="input-group "> 
 
<input autocomplete="off" id="destination<?php echo $row['id']; ?>" class="form-control form-control-user-style1" value="<?php echo $row['destination']; ?>" type="text" placeholder="Enter destination"  name="destination" required>   
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="destinationSubmit<?php echo $row['id']; ?>"  type="submit">Done</button> 
          </div>
        </div>
 </div>   
   </form>
        </div>
          </div>
        </div>
      </li>    
    
                    </td>
                    <td><?php echo $row['no_person'];?></td>
                    <td>
<!--LeadSource-->
 <li class="nav-item list-non">
   <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#LeadSourceSubmit<?php echo $row['id']; ?>").click(function (e) {
			e.preventDefault();
			if($("#LeadSource<?php echo $row['id']; ?>").val()==='')
			{
				alert("Please Enter Text!");
				return false;
			}
		 	var LeadSource = $("#LeadSource<?php echo $row['id']; ?>").val(); //build a post data structure
		 	var id = $("#LeadSourceid<?php echo $row['id']; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/updateLeadSource.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {LeadSource: LeadSource, id: id},      
			success:function(response){
				$("#LeadSourceResponse<?php echo $row['id']; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>    
     
     
     <span id="LeadSourceResponse<?php echo $row['id']; ?>"></span> 
     
     <div  class="travel-date">
  <a class="nav-link hide-datepicker" href="#" data-toggle="collapse" data-target="#LeadSourceModal<?php echo $row['id'];?>" aria-expanded="true" aria-controls="collapseTwo" onClick = "this.style.display= 'none';">
          <?php echo $row['LeadSource'];?>
          <i class="fas fa-pencil-alt ma-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit LeadSource!"></i> 
        </a>
         
         
        <div id="LeadSourceModal<?php echo $row['id'];?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
 <form> 
 <input type="hidden" id="LeadSourceid<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id']; ?>">    
<div class="input-group "> 
 
<select autocomplete="off" id="LeadSource<?php echo $row['id']; ?>" class="form-control form-control-user-style1"  type="text"  name="LeadSource" required>
 <option value=""><?php echo $row['LeadSource']; ?></option>   
 <option value="HT">HT</option>   
 <option value="Ad">Ad</option>   
    
    </select>    
  <div class="input-group-prepend">
      
          <div class="right-send">
              <button class="send btn-success" id="LeadSourceSubmit<?php echo $row['id']; ?>"  type="submit">Done</button> 
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
                        <?php
                      date_default_timezone_set('Asia/Kolkata'); 
                       $time = $row['date']; 
                       echo  date('d M Y, g;i A', strtotime($time));
                         ?>
                     </td> 
<td>
 <script type="text/javascript">
$(document).ready(function() {

	//##### Add record when Add Record Button is click #########
	$("#FormSubmit<?php echo $row['id']; ?>").click(function (e) {
			e.preventDefault();
			if($("#send_client<?php echo $row['id']; ?>").val()==='')
			{
				alert("Please select!");
				return false;
			}
		 	var sales_person = $("#send_client<?php echo $row['id']; ?>").val(); //build a post data structure
		 	var id = $("#id<?php echo $row['id']; ?>").val(); //build a post data structure
			jQuery.ajax({
			type: "POST", // Post / Get method
			url: "inc/send-tinerary.php", //Where form data is sent on submission
			dataType:"text", // Data type, HTML, json etc.   
            data: {sales_person: sales_person, id: id},      
			success:function(response){
				$("#statusResponse<?php echo $row['id']; ?>").html(response);
               
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}   
			});
	});

});    
</script>   
    
    
<div> 
  <span class="resp" id="statusResponse<?php echo $row['id']; ?>"></span>    
<form> 
<!-- delet-btn-->
 <div class="mb-width">    
     <div class="right-send">
        <button class="send btn-success" id="FormSubmit<?php echo $row['id']; ?>"  type="submit">Apply</button>   
    </div> 
     
 <input type="hidden" id="id<?php echo $row['id']; ?>" name="id" value="<?php echo $row['id'];?>"> 
     
 <select id="send_client<?php echo $row['id']; ?>" class="form-control form-control-user-style1 fr-select" name="sales_person" required>
 <option class="selected-cr" value=""><?php echo $row['sales_person'];?></option>        
        
  <?php  
 $salse=0;
 $both= 2;
 
$query_list = mysqli_query($db,"SELECT * FROM users WHERE (user_role_id ='$salse' || user_role_id ='$both')") 
or die(mysqli_error()); 
while ($row = mysqli_fetch_array( $query_list )) 
{
?>
<option value="<?php echo $row['user_name'];?>"><?php echo $row['user_name'];?></option>        

 <?php   
}
 
 ?>        
 </select> 
 </div>   
    
    
    
 
   </form>
    </div>
 </td>
 </tr>  
  
 <?php
}        
?>                  
</tbody>
    </table>
<div class="fixed-table-pagination"> 
  
<ul class="pagination">
    <li class="nav-item">
     <div class="footfilter">
<strong>
    Page <?php echo $page_no." of ".$total_no_of_pages; ?>  
    <?php  
 $query_r = mysqli_query($db,"SELECT * FROM potential ORDER BY id DESC") 
or die(mysqli_error());
$Totalrow = mysqli_num_rows($query_r); 
echo "<span class='btn btn-info'> Total $Totalrow </span>";      
    ?> 
</strong>
</div> 
    </li>
    
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li class="nav-item" <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a class="nave-pagination" <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='nav-item active'><a class='nave-pagination'>$counter</a></li>";	
				}else{
           echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='nav-item active'><a class='nave-pagination'>$counter</a></li>";	
				}else{
           echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li class='nav-item'><a class='nave-pagination'>...</a></li>";
		echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=1'>1</a></li>";
		echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=2'>2</a></li>";
        echo "<li class='nav-item'><a class='nave-pagination'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='nav-item active'><a class='nave-pagination'>$counter</a></li>";	
				}else{
           echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li class='nav-item'><a class='nave-pagination'>...</a></li>";
	   echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=1'>1</a></li>";
		echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=2'>2</a></li>";
        echo "<li class='nav-item'><a class='nave-pagination'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='nav-item active'><a class='nave-pagination'>$counter</a></li>";	
				}else{
           echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li class='nav-item' <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a class="nave-pagination" <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='nav-item'><a class='nave-pagination' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>  
      </div>      
 
        <!-- /.container-fluid --> 
    
<script>
  var $table = $('#fresh-table')

  window.operateEvents = {
    'click .like': function (e, value, row, index) {
      alert('You click like icon, row: ' + JSON.stringify(row))
      console.log(value, row, index)
    },
    'click .edit': function (e, value, row, index) {
      alert('You click edit icon, row: ' + JSON.stringify(row))
      console.log(value, row, index)
    },
    'click .remove': function (e, value, row, index) {
      $table.bootstrapTable('remove', {
        field: 'id',
        values: [row.id]
      })
    }
  }

  function operateFormatter(value, row, index) {
    return [
      '<a rel="tooltip" title="Like" class="table-action like" href="javascript:void(0)" title="Like">',
        '<i class="fa fa-heart"></i>',
      '</a>',
      '<a rel="tooltip" title="Edit" class="table-action edit" href="javascript:void(0)" title="Edit">',
        '<i class="fa fa-edit"></i>',
      '</a>',
      '<a rel="tooltip" title="Remove" class="table-action remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-remove"></i>',
      '</a>'
    ].join('')
  }

    
    
  $(function () {
    $table.bootstrapTable({ 
      cache: false,  
      search: true,
      showRefresh: true,
      showToggle: true,
      showColumns: true,
      pagination: false,
      striped: true,
      sortable: true,
      height: $(window).height(),
      pageSize: 25, 
      toolbar: ".toolbar",
      clickToSelect: true,    
      pageList: [8,10,25,50,100],  

      formatShowingRows: function (pageFrom, pageTo, totalRows) {
        return ''
      },
      formatRecordsPerPage: function (pageNumber) {
        return pageNumber + ' rows visible'
      },
       formatShowingRows: function(pageFrom, pageTo, totalRows){
                    //do nothing here, we don't want to show the text "showing x of y from..."
                    return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' ';
                }  
        
    }) 
      
    $(window).resize(function () {
      $table.bootstrapTable('resetView', {
        height: $(window).height()
      })
    })
  })

 
 
</script>  
    
      <!-- End of Main Content -->
 
   <script src="asset/js/external.js"></script>  
  <!-- Bootstrap core JavaScript--> 
  <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="asset/js/sb-admin-2.min.js"></script>
 











 