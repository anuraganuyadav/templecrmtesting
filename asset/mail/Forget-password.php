<?php 
// Turn off error reporting
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
?>
 


<?php
 // Turn off error reporting
error_reporting(0);   
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
if(isset($_POST['forgetPass'])){  
    
		$email = $_POST['email'];//  email   
//		$email=$_REQUEST["email"];
$query=mysqli_query($db,"select * from users where email='$email'");
$row=mysqli_fetch_array($query);   
         $headers = "From:" .$row['full_name'] ;    
        $messages = "Your Password is".$row['password'] ;       
   
$query=mysqli_query($db,"select * from php_mailer where id='1'");
$row=mysqli_fetch_array($query); 

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug =0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $row['Host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $row['Username'];                 // SMTP username
    $mail->Password = $row['password'];                           // SMTP password
    $mail->SMTPSecure = $row['SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $row['Port'];                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($row['setFrom']);
    $mail->addAddress($email);     // Add a recipient
//    $mail->addAddress('info@templemitra.com');               // Name is optional
    $mail->addReplyTo($row['addReplyTo'], 'Information');
//    $mail->addCC($bcc);
//    $mail->addBCC($bcc); 

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $headers;
    $mail->Body    = $messages ;

    $mail->send();
     echo "<script>alert('Message has been sent')</script>" ; 
} catch (Exception $e) {
    echo "<script>alert('Email Not send Please Confirm Email Configure!')</script>", $mail->ErrorInfo;
}
}
?>
<!--end-->
 