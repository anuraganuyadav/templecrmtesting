<?php 

    if(isset($_POST['sendMail']))
	{  
		$name = $_POST['name'];// 
        $email = $_POST['email'];//
        $mail_id = $_POST['mail_id'];//  
		$sales_person = $_POST['sales_person'];//  
		$subject = $_POST['subject'];//  
		$bcc = $_POST['bcc'];//  
		$bcc2 = $_POST['bcc2'];//  
		$Written_lead = $_POST['Written_lead'];//     
	   
        $imgFile = $_FILES['file']['name'];
		$tmp_dir = $_FILES['file']['tmp_name'];
		$imgSize = $_FILES['file']['size'];
		 
        if(empty($imgFile)){
			$errMSG = "Please Select File.";
            }
               
        else{ 	
            $upload_dir = 'images/Attachment/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png','png', 'gif', 'pdf'); // valid extensions
			$file =rand(1000,1000000).$imgFile;
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$file);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only php page files are allowed.";		
			}
        
         } 
        
       
	  $result = mysqli_query($db,"INSERT INTO email_history (name, email, mail_id, sales_person, Written_lead, subject, bcc, bcc2, file ) VALUES ('$name', '$email', '$mail_id', '$sales_person', '$Written_lead', '$subject', '$bcc', '$bcc2', '$file')");	

		 
	 
        
	}







// Turn off error reporting
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

$query_r = mysqli_query($db,"SELECT id, SMTPDebug, Host, SMTPSecure, Port, recived1, recived2 FROM  php_mailer WHERE id='1'  ORDER BY id DESC") 
or die(mysqli_error());          
while($row = mysqli_fetch_array( $query_r ))
{
?>

 


<?php
 // Turn off error reporting
error_reporting(0);   
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
if(isset($_POST['sendMail'])){  
		$name = $_POST['name'];//  name
		$email = $_POST['email'];//  email   
		$bcc = $_POST['bcc'];//  bcc  
		$bcc2 = $_POST['bcc2'];//  bcc     
		$subject = $_POST['subject'];//  subject 
		$signature = $_POST['signature'];// signature
    
        $imgFile = $_FILES['file']['name'];
		$tmp_dir = $_FILES['file']['tmp_name'];
		$imgSize = $_FILES['file']['size'];
        $uploaddir = 'images/attachment'; 
    
    
    
    
          
    
		$Written_lead = $_POST['Written_lead'];//  cheld
    
        $headers = "From:$name  ( $subject )";    
        $messages = "$Written_lead <br>
                     $signature "; 
   


//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $row['Host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
    $mail->Username = $_SESSION["email_id"];                 // SMTP username
    $mail->Password = $_SESSION["password_set"];                          // SMTP password
   $mail->SMTPSecure = $row['SMTPSecure'];
//   accepted
   $mail->SMTPSecure = false;
   $mail->SMTPAutoTLS = false; 
    $mail->Port = $row['Port'];                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($_SESSION["email_id"], $name);
    $mail->addAddress($email);     // Add a recipient
//    $mail->addAddress($row['recived1']);     // Add a recipient
//    $mail->addAddress($row['recived2']);     // Add a recipient
//    $mail->addAddress('info@templemitra.com');               // Name is optional
    $mail->addReplyTo($_SESSION["email_id"], 'Information');
//    $mail->addCC($bcc);
  if(empty($bcc)){
      
     }
  else{     
    $mail->addBCC($bcc);
  } 
 if(empty($bcc2)){
      
     }
  else{     
    $mail->addBCC($bcc2);
  }

    //Attachments
    
  if(empty($imgFile)){
      
     }
  else{ 
      $mail->addAttachment("$uploaddir/$file");         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      }
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $headers;
    $mail->Body    = $messages ;

    $mail->send();
     echo "<script>alert('Message has been sent')</script>" ; 
     echo "<meta http-equiv='refresh' content='0'>";
} catch (Exception $e) {
    echo "<script>alert('Email Not send Please Confirm Email Configure!')</script>", $mail->ErrorInfo;
}
}
?>
<!--end-->

<?php
}                 
?> 