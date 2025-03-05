   <!-- Content Row -->
          <div class="row">
       <h2></h2>
                <?php
$query = mysqli_query($db,"SELECT * FROM potential_status ORDER BY id"); 
while($row = mysqli_fetch_array( $query ))
{
?>             
        <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
             <a class="price-list" href="Price-list-reposrt.php?getreport=<?php echo $row['status']?>">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">       
                       <?php echo $row['status']; ?> 
                       <span class="text-danger">( 
                       <?php
                  $status = $row['status']; 
                  $qry =mysqli_query($db, "select * from potential WHERE status ='$status'");
                 echo mysqli_num_rows($qry); 
                       ?>
                          )</span> 
                          
                         </div>                      
                           <div class="h5 mb-0 font-weight-bold text-gray-800">  
                  <?php
                  $status = $row['status']; 
                  $qry =mysqli_query($db, "select  sum(amount) from potential WHERE status ='$status'");
                  $row = mysqli_fetch_array($qry);
                  echo $sum = $row[0];
 
 
                 ?>
                    </div>     
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
<?php
}
?>  </div>

          <!-- Content Row -->
