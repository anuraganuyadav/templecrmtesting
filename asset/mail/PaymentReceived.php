 
<?php
include_once("../../inc/config.php");

// php mailer include
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 


if(isset($_POST["full_name"]) && strlen($_POST["full_name"])>1) {
  
  $name =$_POST["name"];
  $full_name =$_POST["full_name"];
  $email =$_POST["email"];
  $amount =$_POST["amount"];
  $status =$_POST["status"];

if($status == 'Payment Received'){
    
$query_r = mysqli_query($db,"SELECT * FROM  otp_mailer WHERE id='1'  ORDER BY id DESC") 
or die(mysqli_error());          
$row = mysqli_fetch_array( $query_r);


  $headers = "Payment Received $full_name";    
  $messages = "<div style='width:100%; border: 1px solid #03A9F4; background-color: #03A9F4; color: #fff; text-shadow: 2px 2px 2px black; padding: 59px 61px; font-size: 20px; font-weight: bold;'>
  Payment Received <br> 
  By $full_name <br>
  Name : $name<br>
  Email :<a href='mailto:$email' style='color:white;'> $email </a><br> 
  Amount : <span style='color: #fbff00; padding: 5px; background-color: #a90c0c; border-radius: 5px; margin: 5px;'> $amount </span>  <br>  
  </span> 
  
  </div>"; 
     

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    
  try {
    $mail->SMTPDebug =0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $row['Host'];  // Specify main and backup SMTP servers
  //  for live host
//  $mail->SMTPAuth = false;   
 //  for local host
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username =  $row['Username'];
		$mail->Password =  $row['Password'];                          // SMTP password
    $mail->SMTPSecure = $row['SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port =  $row['Port']; 
 // on for live host
    // $mail->SMTPSecure = false;
     //$mail->SMTPAutoTLS = false;                                 // TCP port to connect to

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
  echo "<span id='Payment' style='color:green;'> Hey..! $full_name Good Job</span> <br>";
}
 catch (Exception $e) {
 echo 'OTP Sent Error ', $mail->ErrorInfo;
    }
    
    
  }  
  }  
  
// end mailer  
 
?>
<script> 
      setTimeout(function() {
          $('#Payment').fadeOut('slow'); 
      }, 5500);  	 
</script>