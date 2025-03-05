
    <form class="popup_form"  method="post">  
        
   
      <input type="text" name="name"   placeholder="Your Name Here*" required> <br> 
       <input type="text" name="Phone_number" pattern="[0-9]{1}[0-9]{9}" title="Please Enter Your 10 Digit Mobile Number"  placeholder="Mobile Number*" required>
    <br> 
        <input type="email" name="email" placeholder="Your Email*">
      <br>
   <select name="package">
    
        <option value="Goa Special Package">Goa Special Package</option>
        <option value="Goa Romantic Honeymoon  Package  ">Goa Romantic Honeymoon  Package  </option>
        <option value="Goa Amazing Family  Package ">Goa Amazing Family  Package </option>
        <option value="Goa Adventure  Package ">Goa Adventure  Package </option>
        <option value="Goa Special Honeymoon  Package  ">Goa Special Honeymoon  Package  </option>
        <option value=" Goa Special Holiday  Package  "> Goa Special Holiday  Package  </option>
        <option value="Goa Package with Dudhsagar ">Goa Package with Dudhsagar </option>
       <option value="Goa Holiday Delight Package">Goa Holiday Delight Package</option>
       <option value="Customize Goa Package(Need To Discuss)">Customize Goa Package(Need To Discuss)</option>
       
       
       </select>
    <br>
     <input type="hidden" name="subject" value="Goa page"> <br>  
    <input type="hidden" value=" <?php if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set("Asia/Kolkata");
} echo date("l jS \of F Y h:i:s A"); ?>" name="detail" > <br>
 <!--  ======================hidden=============   --> 
      
       <textarea style="height:60px;" name="message" placeholder="Type Your Message"></textarea><br>
    

 <input name="submit" type="submit" value="Send"> 
 
       
</form>      
<?php
include ("data.php");
?>

