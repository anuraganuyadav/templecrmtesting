<?php
include_once("config.php");
if(isset($_POST["insertSales_person"]) && strlen($_POST["insertSales_person"])>1) 
{
    
$insertName = filter_var($_POST["insertName"]);
$insertEmail = filter_var($_POST["insertEmail"]);
$insertMo_number = filter_var($_POST["insertMo_number"]); 
$insertDestination = filter_var($_POST["insertDestination"]); 
$insertNo_person = filter_var($_POST["insertNo_person"]); 
$insertLeadSource = filter_var($_POST["insertLeadSource"]); 
$insertDescription = filter_var($_POST["insertDescription"]); 
$insertSales_person = filter_var($_POST["insertSales_person"]);    
 
    
mysqli_query($conn,"INSERT INTO all_contact (name, email, mo_number, destination, no_person, LeadSource, description, sales_person, date, lastActivity) VALUES('$insertName', '$insertEmail' , '$insertMo_number', '$insertDestination' , '$insertNo_person' , '$insertLeadSource' , '$insertDescription' , '$insertSales_person', '$timestamp', '$timestamp')");    
    
    
if(mysqli_query($conn,"INSERT INTO itinerary (name, email, mo_number, destination, no_person, LeadSource, description, sales_person, date, lastActivity, status_now) VALUES('$insertName', '$insertEmail' , '$insertMo_number', '$insertDestination' , '$insertNo_person' , '$insertLeadSource' , '$insertDescription' , '$insertSales_person', '$timestamp', '$timestamp', '1')"))
 {
    
?> 
<i id="message_descr" class="text-success"><img src="images/img/small-done.gif" width="25px">success</i>   

<?php   
}
else{
   echo "Try Again";
}   
    
    
    
    
}
 
?>
<script> 
        setTimeout(function() {
            $('#message_descr').fadeOut('slow');
        }, 1400);
</script>
