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


 ?>
 
<?php include_once("layouts/header.php");?>

 



    <table id="fresh-table" class="table">
      <thead>
<!--        <th data-field="id">ID</th>-->
         <th data-field="name" data-sortable="true">Name</th>
        <th data-field="email" data-sortable="true">Email</th>
        <th data-field="phone" data-sortable="true">Phone No</th>
        <th data-field="destinations" data-sortable="true">Destinations</th>
        <th data-field="person" data-sortable="true">Person</th>
        <th data-field="travelDate" data-sortable="true">Travel Date</th>  
        <th data-field="amount" data-sortable="true">Amount</th>  
        <th data-field="Status" data-sortable="true">Status</th>
        <th data-field="createdDate" data-sortable="true">Created Date</th>
        <th data-field="LastActivity" data-sortable="true">Last Activity</th> 
        <th data-field="SalesPerson" data-sortable="true">Sales Person</th> 
                    
<!--        <th data-field="actions" data-formatter="operateFormatter" data-events="operateEvents">Actions</th>-->
      </thead> 
         <tbody>               
  <?php
  if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 500;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 
    $user_name = $_SESSION['user_name'];  
             
//  filter
   $userID = $_SESSION['userID'];            
   $sql = "SELECT * FROM filter WHERE filterID = $userID";
   $sth = $db->query($sql);
   $result=mysqli_fetch_array($sth); 
   $statusfilter =$result['PotentialFilter'];     
   $filter = $_POST["PotentialFilter"];          
   $Fdate = $_POST["FdateFilter"];          
   $Ldate = $_POST["LdateFilter"];          
   $filterRow = $_POST["filterRow"];          
   $filterBeforeDate = $_POST["filterBeforeDate"];     
   $filterDestination = $_POST["filterDestination"];     
            
    
$filter = $statusfilter;             
if((empty($filter)) and (empty($filterDestination)) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  $filterRow >= '$Fdate' AND $filterRow <= '$Ldate'  ");  
}
           
           
// if  status 'All' and destination 'value' and between date are available and filter before dare are empty            
else if((empty($filter)) and ($filterDestination) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  destination = '$filterDestination' and $filterRow >= '$Fdate' AND $filterRow <= '$Ldate'  ");  
}
           
           
// if  status 'value' and destination 'All' and between date are available and filter before dare are empty 
else if(($filter) and (empty($filterDestination)) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  status = '$filter' and $filterRow >= '$Fdate' AND $filterRow <= '$Ldate' ");  
}
           
// if status 'value' and destination 'value' and between date are available and filter before dare are empty           
 else if(($filter) and ($filterDestination) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  status = '$filter' and destination = '$filterDestination'  and $filterRow >= '$Fdate' AND $filterRow <= '$Ldate'  ");  
}

// if status 'All' and destination 'All' and between date are empty and filter before dare are available             
else if((empty($filter)) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` ");  
} 
           
  // if status 'All' and destination 'valid' and between date are empty and filter before dare are available             
else if((empty($filter)) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  destination = '$filterDestination' ");  
} 
// if status 'valid' and destination 'All' and between date are empty and filter before dare are available             
else if(($filter) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  status = '$filter' ");  
} 
 // if status 'valid' and destination 'valid' and between date are empty and filter before dare are empty             
else if(($filter) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  status = '$filter'and destination = '$filterDestination' ");  
} 
  
   // if status 'All' and destination 'All' and between date are empty and filter before dare are Today            
else if((empty($filter)) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today' )){   
$result_count = mysqli_query($db,"SELECT COUNT(*) As total_records  FROM potential WHERE  $filterRow >= ( CURDATE() - INTERVAL 1 DAY )") ;
 //  for row number

}           
         
 // if status 'valid' and destination 'All' and between date are empty and filter before dare are Today            
else if(($filter) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today')){   
 $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records  FROM potential WHERE  status = '$filter' and $filterRow >= ( CURDATE() - INTERVAL 1 DAY )") ;
 //  for row number

}           
         
           
  // if status 'empty' and destination 'valid' and between date are empty and filter before dare are Today            
else if((empty($filter)) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today')){ 
 $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records  FROM potential WHERE  destination= '$filterDestination' and $filterRow >= ( CURDATE() - INTERVAL 1 DAY )") ;
 //  for row number

}           

// if status 'valid' and destination 'valid' and between date are empty and filter before dare are Today            
else if(($filter) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today')){   
  $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM potential WHERE  status= '$filter'  and destination= '$filterDestination' and $filterRow >= ( CURDATE() - INTERVAL 1 DAY )");  
}           
          
          
           
 // if status 'All' and destination 'All' and between date are empty and filter before dare are available            
else if((empty($filter)) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){   $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ");  
} 
           
        
           
           
           
           
           
   // if status 'valid' and destination 'All' and between date are empty and filter before dare are available            
else if(($filter) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){ 
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  status = '$filter' and $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ");  
} 
           
           
           
           
           
 // if status 'All' and destination 'valid' and between date are empty and filter before dare are available            
else if((empty($filter)) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){ 
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  destination = '$filterDestination' and $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ");  
}           
           
  // if status 'valid' and destination 'valid' and between date are empty and filter before dare are available            
else if(($filter) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){ 
    $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM `potential` WHERE  status = '$filter' and destination = '$filterDestination' and $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ");  
}           
           
      
else{            
 
}           
           
           
           
           
           
           
           
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1        
          
 
           
           
           
               
//filter range 
// if  status 'All' and destination 'All' and between date are available and filter before dare are empty        
$user_name = $_SESSION['user_name'];  
if((empty($filter)) and (empty($filterDestination)) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$query_r = mysqli_query($db,"SELECT * FROM potential WHERE  $filterRow >= '$Fdate' AND $filterRow <= '$Ldate' ORDER BY id DESC LIMIT $offset, $total_records_per_page ") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}
           
           
// if  status 'All' and destination 'value' and between date are available and filter before dare are empty            
else if((empty($filter)) and ($filterDestination) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$query_r = mysqli_query($db,"SELECT * FROM potential WHERE  destination = '$filterDestination' and $filterRow >= '$Fdate' AND $filterRow <= '$Ldate' ORDER BY id DESC LIMIT $offset, $total_records_per_page ") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}
           
           
// if  status 'value' and destination 'All' and between date are available and filter before dare are empty 
else if(($filter) and (empty($filterDestination)) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' and $filterRow >= '$Fdate' AND $filterRow <= '$Ldate' ORDER BY id DESC LIMIT $offset, $total_records_per_page ") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}
           
// if status 'value' and destination 'value' and between date are available and filter before dare are empty           
 else if(($filter) and ($filterDestination) and ($Fdate) and ($Ldate) and (empty($filterBeforeDate))){            
$query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' and destination = '$filterDestination'  and $filterRow >= '$Fdate' AND $filterRow <= '$Ldate' ORDER BY id DESC LIMIT $offset, $total_records_per_page ") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}

// if status 'All' and destination 'All' and between date are empty and filter before dare are empty             
else if((empty($filter)) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $query_r = mysqli_query($db,"SELECT * FROM potential ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
} 
   
   
           
  // if status 'All' and destination 'valid' and between date are empty and filter before dare are empty             
else if((empty($filter)) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  destination = '$filterDestination' ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
} 
           
           
// if status 'valid' and destination 'All' and between date are empty and filter before dare are available             
else if(($filter) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
} 
 // if status 'valid' and destination 'valid' and between date are empty and filter before dare are empty             
else if(($filter) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and (empty($filterBeforeDate))){   
    $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' and destination = '$filterDestination' ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
} 
 
           
   // if status 'All' and destination 'All' and between date are empty and filter before dare are Today            
else if((empty($filter)) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today' )){   $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  $filterRow >= ( CURDATE() - INTERVAL 1 DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
         
 // if status 'valid' and destination 'All' and between date are empty and filter before dare are Today            
else if(($filter) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today')){   $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' and $filterRow >= ( CURDATE() - INTERVAL 1 DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
         
           
  // if status 'empty' and destination 'valid' and between date are empty and filter before dare are Today            
else if((empty($filter)) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today')){   $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  destination= '$filterDestination' and $filterRow >= ( CURDATE() - INTERVAL 1 DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           

// if status 'valid' and destination 'valid' and between date are empty and filter before dare are Today            
else if(($filter) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate =='Today')){   $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status= '$filter'  and destination= '$filterDestination' and $filterRow >= ( CURDATE() - INTERVAL 1 DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
         
           
           
           
 // if status 'All' and destination 'All' and between date are empty and filter before dare are available            
else if((empty($filter)) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){   $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
  
           
           
           
           
           
   // if status 'valid' and destination 'All' and between date are empty and filter before dare are available            
else if(($filter) and (empty($filterDestination)) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){ 
    $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' and $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
           
 // if status 'All' and destination 'valid' and between date are empty and filter before dare are available            
else if((empty($filter)) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){ 
    $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  destination = '$filterDestination' and $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
           
  // if status 'valid' and destination 'valid' and between date are empty and filter before dare are available            
else if(($filter) and ($filterDestination) and (empty($Fdate)) and (empty($Ldate)) and ($filterBeforeDate)){ 
    $query_r = mysqli_query($db,"SELECT * FROM potential WHERE  status = '$filter' and destination = '$filterDestination' and $filterRow <= ( CURDATE() - INTERVAL $filterBeforeDate DAY ) ORDER BY id DESC LIMIT $offset, $total_records_per_page") 
or die(mysqli_error());
 //  for row number
  $Numrow = mysqli_num_rows($query_r);  
}           
           
      
else{            
 
}           
             
while($row = mysqli_fetch_array( $query_r ))
{
?>   
<tr>
                    <td>
                   <a href="Admin-view.php?view_potential=<?php echo $row['id']; ?>"  class="user"><?php echo $row['name'];?></a>     
                    </td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['mo_number'];?></td>
                    <td>
                     <?php
        $dist = $row['destination']; 
        $dest = "SELECT * FROM `destinations` WHERE destinations_list='$dist'";
		$data = mysqli_query($conn, $dest);
		$count = mysqli_num_rows($data);

   if(empty($dist)){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:#ffa500;'> Add Destination </span>";
		}  
	else if($count == 1){
			 echo  "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span> 
             <span style='color:green;'> $dist  </span>";
		} 
        else{
			echo "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
            <span style='color:red;'> $dist (Change it) </span>";
		}  ?> 
                     </td>
                    <td><?php echo $row['no_person'];?></td>
                    <td><?php echo  $row['travel_date'];?></td>

  <td><i class="fas fa-rupee-sign"></i><?php echo $row['amount'];?></td>
  <td><?php echo $row['status'];?></td>
               <td><?php 
              $time = $row['date'];
               echo  date('d M Y, g;i A', strtotime($time));?> 
                 </td>
                    <td>
                    <?php
                        $time = $row['last_activity']; 
                       echo  date('d M Y, g;i A', strtotime($time));
                       ?>
                    </td> 
    <td><?php echo $row['sales_person'];?></td>
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
 $query_r = mysqli_query($db,"SELECT * FROM potential") 
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
    <span class="btn r-filter"><?php  echo " Now ". $Numrow; ?></span> 
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
 











 