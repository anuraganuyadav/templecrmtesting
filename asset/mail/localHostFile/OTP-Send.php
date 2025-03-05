<!-- otp message        -->
<script>
  $(document).ready(function() {
//##### Add record when Add Record Button is click #########
$("#sendOTP").click(function (e) {
    e.preventDefault();   
          var email = $('#email').val();
      if ($.trim(email).length == 0 ) {
          alert('All fields are mandatory');
          e.preventDefault();
      }
      else if (validateEmail(email)) {
        $("#loading").show();

//  alert('Nice!! your Email is valid, now you can continue..');
    jQuery.ajax({
    type: "POST", // Post / Get method
    url: "OTP-Send.php", //Where form data is sent on submission
    dataType:"text", // Data type, HTML, json etc.   
          data: {email: email},      
    success:function(response){
      $("#Response").html(response);
      $("#loading").hide(); 
             
    },
    error:function (xhr, ajaxOptions, thrownError){
      alert(thrownError);
    }   
    });
      }
      else {
          alert('Invalid Email Address');
          e.preventDefault();
      }      
});  
});
  
// Function that validates email address through a regular expression.
function validateEmail(email) {
  var filter =  /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
  
 if (filter.test(email)) {
      return true;
  }
  else {
      return false;
  }
}   
</script>
<!-- error message        -->








<?php
include_once("../../inc/config.php");

// php mailer include
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 


if(isset($_POST["email"]) && strlen($_POST["email"])>1) {
  
  $email =$_POST["email"];


	$result = mysqli_query($db,"SELECT * FROM users WHERE email='" . $_POST["email"] . "'");
  $count  = mysqli_num_rows($result);
  $result=mysqli_fetch_array($result);
  // given email id row user name fetch
  $fullName = $result['full_name'];

	if($count>0) {
		// generate OTP
		$otp = rand(100000,999999);
		// Send OTP
		// require_once("mail_function.php");
		// $mail_status = sendOTP($_POST["email"],$otp);
		 
     if($result =  mysqli_query($db,"UPDATE users SET otp = '$otp' ,  otp_date = '$timestamp' WHERE email='" . $_POST["email"] . "'")){ 
    //  php mailer  
    //Load Composer's autoloader
    
$query_r = mysqli_query($db,"SELECT * FROM  otp_mailer WHERE id='1'  ORDER BY id DESC");          
$row = mysqli_fetch_array( $query_r);


  $headers = "OTP to Login";    
  $messages = "<div style='width:100%; text-align: center; border: 1px solid #03A9F4; background-color: #03A9F4; color: #fff; text-shadow: 2px 2px 2px black; padding: 59px 0px; font-size: 20px; font-weight: bold;'>Hey..! $fullName <br> Your One Time OTP  Password is: <span style='font-weight: bold;color: #e4ff09;font-size: 30px'> $otp</span> </div>"; 
     

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    
  try {
    $mail->SMTPDebug =0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $row['Host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
		$mail->Username =  $row['Username'];
		$mail->Password =  $row['Password'];                          // SMTP password
    $mail->SMTPSecure = $row['SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port =  $row['Port']; 
    $mail->SMTPSecure = false;
    $mail->SMTPAutoTLS = false;                                  // TCP port to connect to

    //Recipients
		$mail->SetFrom($row['setFrom'], "CRM");
		$mail->AddAddress($row['addAddress']);     // Add a recipient
//    $mail->addAddress('info@templemitra.com');               // Name is optional
    $mail->addReplyTo($row['addReplyTo'], 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
 
  //Content
  $mail->isHTML(true);                                  // Set email format to HTML
  $mail->Subject = $headers;
  $mail->Body = $messages;

  $mail->send();
  echo "<span style='color:green;'>Check your email for the OTP </span>
  <span class='btn btn-sm btn-success' id='countdown'></span>
  <input style='display:none;' type='submit' id='sendOTP' name='sendOTP' class='btn btn-primary btn-user float-right' value='Resend OTP'><br>";
}
       catch (Exception $e) {
            echo 'OTP Sent Error ', $mail->ErrorInfo;
              }
  }  
}  
// end mailer  
else {
echo "<span id='error' style='color:red;'>Invalid Email Id Please Check..</span> <input style='display:none;' type='submit' id='sendOTP' name='sendOTP' class='btn btn-primary btn-user float-right showotp' value='send OTP'>";
  }
} 

?>
<script> 
      setTimeout(function() {
          $('#error').fadeOut('slow');
    $('.showotp').fadeIn('slow');
      }, 1500);  
  
// time second	 

var timeleft = 60;
var downloadTimer = setInterval(function(){
document.getElementById("countdown").innerHTML = timeleft + " seconds";
timeleft -= 1;
if(timeleft <= 0){
  clearInterval(downloadTimer);
  // document.getElementById("countdown").innerHTML = ""  
    $('#countdown').fadeOut('slow');
    $('#sendOTP').fadeIn('slow');  
    }
}, 1000);	 
</script>