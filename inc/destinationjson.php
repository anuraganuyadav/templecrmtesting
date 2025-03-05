[
  <?php
include "config.php";
$query_list = mysqli_query($db,"SELECT * FROM destinations ORDER BY id") 
or die(mysqli_error()); 
while ($row = mysqli_fetch_array( $query_list )) 
{
?> 
  {
    "name":"<?php echo $row['destinations_list'] ?>"
  },
  

<?php
}
?>
 {
    "name":"Bill Burke" 
  }
] 