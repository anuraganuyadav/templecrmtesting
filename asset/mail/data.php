<?php 
session_start();
// Turn off error reporting 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

                    $userID = $_SESSION['userID'];            
                     $sql = "SELECT * FROM users WHERE userID = $userID";
                     $sth = $db->query($sql);
                     $row=mysqli_fetch_array($sth);
                     { 
                     $signature =  $row['signature']; 
                     }

$query_r = mysqli_query($db,"SELECT * FROM  php_mailer WHERE id='1'  ORDER BY id DESC");          
$row = mysqli_fetch_array( $query_r );

 // Turn off error reporting
error_reporting(0);   
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
if(isset($_POST['sendMail'])){  
		$name = $_POST['name'];// 
        $email = $_POST['email'];//
        $mail_id = $_POST['mail_id'];//  
		$sales_person = $_POST['sales_person'];//  
		$subject = $_POST['subject'];//  
		$bcc = $_POST['bcc'];//  
		$bcc2 = $_POST['bcc2'];//  
	 	$Written_lead = $_POST['Written_lead'];//     
		$file = $_POST['file'];// 
    
    
    
    	if(empty($name)){
			$errMSG = "Please Enter Name.";
		}
		else if(empty($email)){
			$errMSG = "Please Enter Email.";
		}
        else if(empty($subject)){
			$errMSG = "Please Enter Subject";
		}  
      else if(empty($Written_lead)){
			$errMSG = "Please Write Something";
		} 
    else{
        
    }
    	// if no error occured, continue ....
		if(!isset($errMSG))
		{ 
      
 $stmt = $DB_con->prepare("INSERT INTO email_history (name, email, mail_id, sales_person, Written_lead, subject, bcc, bcc2, file) VALUES(:uname, :uemail, :umail_id, :usales_person, :uWritten_lead, :usubject, :ubcc, :ubcc2, '$file')");
			$stmt->bindParam(':uname',$name);
			$stmt->bindParam(':uemail',$email);
            $stmt->bindParam(':umail_id', $mail_id);
            $stmt->bindParam(':usales_person', $sales_person);
            $stmt->bindParam(':uWritten_lead', $Written_lead);
            $stmt->bindParam(':usubject', $subject);
            $stmt->bindParam(':ubcc', $bcc);
            $stmt->bindParam(':ubcc2', $bcc2); 
			
			if($stmt->execute())
			{
				 //$successMSG = "new record succesfully inserted ...";
				//header("refresh:5;blog_dashboard.php"); // redirects image view page after 5 seconds.
   
 $headers = "$name  ( $subject )";    
 $messages = '<section>'.$Written_lead.'  '.$signature.'</section>';           
//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $row['Host'];  // Specify main and backup SMTP servers
  //  for live host
   $mail->SMTPAuth = false;   
 //  for local host
 //   $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $_SESSION["email_id"];                 // SMTP username
    $mail->Password = $_SESSION["password_set"];                          // SMTP password
   $mail->SMTPSecure = $row['SMTPSecure'];
//   accepted
    $mail->Port =  $row['Port']; 

 // on for live host
     $mail->SMTPSecure = false;
     $mail->SMTPAutoTLS = false;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($_SESSION["email_id"], $_SESSION['full_name']);
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
    
  if(empty($file)){
      
     }
  else{ 
      $mail->addAttachment("$file");         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      }
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $headers;
    $mail->Body    = $messages ;

    $mail->send();
     echo "<script>alert('Message has been sent')</script>" ; 
     echo "<meta http-equiv='refresh' content='0'>";

          }
      catch (Exception $e) {
    echo "<script>alert('Email Not send Please Confirm Email Configure!')</script>", $mail->ErrorInfo;
       }
   }
  else
     {
      $errMSG = "error while inserting....";
      }         
 } 
            
  mysqli_query($db,"UPDATE potential SET last_activity = '$timestamp' WHERE id ='$mail_id'"); 
 }
               
?>

 <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
 