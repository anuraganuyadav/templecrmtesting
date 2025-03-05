
<?php  
//export.php 
require_once('inc/config.php');
$output = '';
if(isset($_POST["export"]) && strlen($_POST["export"])) 
{ 
 //  filter
   $userID = $_POST['userID'];  
   if(empty($_POST["filterDateBefore"])){
     $filterDateBefore = "All";  
       } 
        else{
          $filterDateBefore =$_POST["filterDateBefore"];  
           }   
   if(empty($_POST['leadFdate'])){
     $Fdate ="All";  
       }
    else{
        $Fdate =$_POST['leadFdate'];  
         } 
   if(empty($_POST['leadLdate'])){
      $Ldate ="All";  
       }
      else{
       $Ldate = $_POST['leadLdate'];
         } 
    
    
    $filterSales = $_POST["filterSales"];  
    $filterStatus = $_POST["filterStatus"];     
    $filterType =$_POST['filterType']; 
      
//filter range 

// (1) if  $filterSales "All" and $filterType "All"  and $filterDateBefore "All" and $filterStatus "All" and $Fdate or $Ldate date "disabled
if(( $filterSales === "All") && ($filterType === "All")  &&  ( $filterDateBefore === "All") &&  ($filterStatus === "All")){   
$query = "SELECT * FROM lead";      
} 
            
// (2) if $filterSales "All" and $filterType "All" and $filterDateBefore "All" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if( ($filterSales === "All") && ($filterType === "All") && ( $filterDateBefore === "All") &&  ($filterStatus === "Empty")){   
$query = "SELECT * FROM lead WHERE  last_response = '' ";      
} 
            
// (3) if $filterDateBefore "All" and $filterType "All" and  $filterSales "All" and $filterStatus "valid" and $Fdate or $Ldate date "disabled
else if( ($filterSales === "All") && ($filterType === "All") && ( $filterDateBefore === "All") &&  ($filterStatus != "Empty" && $filterStatus != "All")){   
$query = "SELECT * FROM lead WHERE  last_response = '$filterStatus' ";      
} 
           
// (4) if $filterSales "valid" and $filterType "All" and $filterDateBefore "All" and $filterStatus "All" and $Fdate or $Ldate date "disabled
else if(($filterSales) &&  ($filterType === "All") && ( $filterDateBefore === "All") &&  ($filterStatus === "All")){   
$query = "SELECT * FROM lead WHERE sales_person = '$filterSales' ";      
} 
           
 // (5) if $filterSales "valid" and $filterType "All" and $filterDateBefore "All" and $filterStatus "All" and $Fdate or $Ldate date "disabled
else if(($filterSales) &&  ($filterType === "All") && ( $filterDateBefore === "All") &&  ($filterStatus === "Empty")){   
$query = "SELECT * FROM lead WHERE 	sales_person = '$filterSales' and last_response = '' ";      
} 
            
 // (6) if $filterSales "valid" and $filterType "All" and $filterDateBefore "All" and $filterStatus "valid" and $Fdate or $Ldate date "disabled
else if(($filterSales) &&  ($filterType === "All") && ( $filterDateBefore === "All") &&  ($filterStatus)){   
$query = "SELECT * FROM lead WHERE 	sales_person = '$filterSales' and last_response = '$filterStatus' ";      
} 
           
// (7) if $filterSales "All" and $filterType "valid" and $filterSales "All" and $filterStatus "all" and $Fdate or $Ldate date "disabled
else if(($filterSales === "All") && ($filterType) &&  ( $filterDateBefore === "All") &&  ($filterStatus === "All")){   
$query = "SELECT * FROM lead";      
} 
 // (8) if $filterSales "valid" and $filterType "valid" and $filterSales "All" and $filterStatus "all" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "All") &&  ($filterStatus === "All")){   
$query = "SELECT * FROM lead WHERE sales_person = '$filterSales' ORDER BY $filterType" ;      
} 
           
           
             
 // (9) if $filterSales "All" and $filterType "valid" and $filterSales "All" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if(($filterSales === "All") && ($filterType) &&  ( $filterDateBefore === "All") &&  ($filterStatus === "Empty")){   
$query = "SELECT * FROM lead WHERE sales_person = '$filterSales' and last_response = ''";      
} 
           
              
 // (10) if $filterSales "valid" and $filterType "valid" and $filterSales "All" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "All") &&  ($filterStatus === "Empty")){   
$query = "SELECT * FROM lead WHERE last_response = ''";      
} 
           
           
 // (11) if $filterSales "All" and $filterType "valid" and $filterSales "All" and $filterStatus "valid" and $Fdate or $Ldate date "disabled
else if(($filterSales === "All") && ($filterType) &&  ( $filterDateBefore === "All") &&  ($filterStatus != "Empty" && $filterStatus != "All")){   
$query = "SELECT * FROM lead WHERE last_response = '$filterStatus'";      
}
           
            
 // (12) if $filterSales "valid" and $filterType "valid" and $filterSales "All" and $filterStatus "valid" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "All") &&  ($filterStatus != "Empty" && $filterStatus != "All")){   
$query = "SELECT * FROM lead WHERE sales_person = '$filterSales' and last_response = '$filterStatus'";      
}
           
           
 
// (13) if $filterSales "All" and $filterType "valid" and $filterDateBefore "Today" and $filterStatus "All" and $Fdate or $Ldate date "disabled
else if(($filterSales === "All") && ($filterType) &&  ( $filterDateBefore === "Today") &&  ($filterStatus === "All")){   
$query = "SELECT * FROM lead WHERE TIMESTAMP(`$filterType`) >=( NOW() - INTERVAL 0 DAY ) ";      
} 
             
// (14) if $filterSales "All"  $filterType "valid" and $filterDateBefore "Today" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if(($filterSales === "All") && ($filterType) &&  ( $filterDateBefore === "Today") &&  ($filterStatus === "Empty")){   
$query = "SELECT * FROM lead WHERE TIMESTAMP(`$filterType`) >=( NOW() - INTERVAL 0 DAY ) and  last_response = '' ";      
} 
             
// (15) if $filterSales "All"  and $filterType "valid" and $filterDateBefore "Today" and $filterStatus "valid" and $Fdate or $Ldate date "disabled
else if(($filterSales === "All") && ($filterType) &&  ( $filterDateBefore === "Today") &&  ($filterStatus != "Empty" && $filterStatus != "All")){   
$query = "SELECT * FROM lead WHERE TIMESTAMP(`$filterType`) >=( NOW() - INTERVAL 0 DAY ) and  last_response = '$filterStatus' ";      
} 
 
// (16) if $filterSales "valid" and $filterType "valid" and $filterDateBefore "Today" and $filterStatus "All" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "Today") &&  ($filterStatus === "All")){   
$query = "SELECT * FROM lead WHERE 	sales_person ='$filterSales' and TIMESTAMP(`$filterType`) >=( NOW() - INTERVAL 0 DAY ) ";      
} 
             
// (17) if $filterSales "valid"  $filterType "valid" and $filterDateBefore "Today" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "Today") &&  ($filterStatus === "Empty")){   
$query = "SELECT * FROM lead WHERE 	sales_person ='$filterSales' and TIMESTAMP(`$filterType`) >=( NOW() - INTERVAL 0 DAY ) and  last_response = '' ";      
} 
 
// (18) if $filterSales "valid"  and $filterType "valid" and $filterDateBefore "Today" and $filterStatus "valid" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "Today") &&  ($filterStatus != "Empty" && $filterStatus != "All")){   
$query = "SELECT * FROM lead WHERE 	sales_person = '$filterSales' and TIMESTAMP(`$filterType`) >=( NOW() - INTERVAL 0 DAY ) and  last_response = '$filterStatus' ";      
} 
 
 // (19) if $filterSales "All"  and $filterType "valid" and $filterDateBefore "Custom Date" and $filterStatus "All" and $Fdate or $Ldate date "disabled
else if(($filterSales ==="All") && ($filterType) &&  ( $filterDateBefore === "Custom Date") &&  ($filterStatus === "All") && ($Fdate) && ($Ldate) ){   
$query = "SELECT * FROM lead WHERE $filterType >= '$Fdate' AND $filterType <= '$Ldate' ";      
} 
           
// (20) if $filterSales "All" and  $filterType "valid" and $filterDateBefore "Custom Date" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if(($filterSales ==="All") && ($filterType) &&  ( $filterDateBefore === "Custom Date") &&  ($filterStatus === "Empty") && ($Fdate) && ($Ldate)){   
$query = "SELECT * FROM lead WHERE $filterType >= '$Fdate' AND $filterType <= '$Ldate' and  last_response = '' ";      
} 
 
             
// (21) if $filterSales "All" and $filterType "valid" and $filterDateBefore "Custom Date" and $filterStatus "valid" and $Fdate or $Ldate date "valid"
else if(($filterSales ==="All") && ($filterType) &&  ( $filterDateBefore === "Custom Date") &&  ($filterStatus != "Empty" && $filterStatus != "All") && ($Fdate) && ($Ldate)){   
$query = "SELECT * FROM lead WHERE $filterType >= '$Fdate' AND $filterType <= '$Ldate' and  last_response = '$filterStatus' ";      
} 
   
 // (22) if $filterSales "valid"  and $filterType "valid" and $filterDateBefore "Custom Date" and $filterStatus "All" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "Custom Date") &&  ($filterStatus === "All") && ($Fdate) && ($Ldate) ){   
$query = "SELECT * FROM lead WHERE sales_person = '$filterSales' and $filterType >= '$Fdate' AND $filterType <= '$Ldate' ";      
} 
           
// (23) if $filterSales "valid" and  $filterType "valid" and $filterDateBefore "Custom Date" and $filterStatus "Empty" and $Fdate or $Ldate date "disabled
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "Custom Date") &&  ($filterStatus === "Empty") && ($Fdate) && ($Ldate)){   
$query = "SELECT * FROM lead WHERE 	sales_person = '$filterSales' and $filterType >= '$Fdate' AND $filterType <= '$Ldate' and  last_response = '' ";      
} 
            
// (24) if $filterSales "valid" and $filterType "valid" and $filterDateBefore "Custom Date" and $filterStatus "valid" and $Fdate or $Ldate date "valid"
else if(($filterSales) && ($filterType) &&  ( $filterDateBefore === "Custom Date") &&  ($filterStatus != "Empty" && $filterStatus != "All") && ($Fdate) && ($Ldate)){   
$query = "SELECT * FROM lead WHERE sales_person = '$filterSales' and $filterType >= '$Fdate' AND $filterType <= '$Ldate' and  last_response = '$filterStatus' ";      
}
else{            
 echo "No data found";
    
  }     
  if($result = mysqli_query($conn, $query))
 {
 
  $output .= '
   <table class="table" bordered="1">  
         <tr>  
        <th>Name</th> 
        <th>Email</th> 
        <th>Phone No</th>
        <th>Destinations</th>
        <th>Person</th>
        <th>Lead Date</th>  
        <th>Last Activity Date</th>
        <th>Response</th> 
        <th>Sales Name</th>  
        </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["name"].'</td>  
                         <td>'.$row["email"].'</td>  
                         <td>'.$row["mo_number"].'</td>  
                         <td>'.$row["destination"].'</td>  
                         <td>'.$row["no_person"].'</td>  
                         <td>'.$row["date"].'</td>  
                         <td>'.$row["last_activity"].'</td>  
                         <td>'.$row["last_response"].'</td>  
                         <td>'.$row["sales_person"].'</td>  
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}
?>
 