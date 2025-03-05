<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);



require_once('asset/exelupload/php-excel-reader/excel_reader2.php');
require_once('asset/exelupload/SpreadsheetReader.php');


if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'asset/exelupload/uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
               //  for name
                $name = "";
                if(isset($Row[0])) {
                    $name = mysqli_real_escape_string($conn,$Row[0]);
                }
               //  for description 
                $email = "";
                if(isset($Row[1])) {
                    $email = mysqli_real_escape_string($conn,$Row[1]);
                }
                   //  for mo_number 
                $mo_number = "";
                if(isset($Row[2])) {
                    $mo_number = mysqli_real_escape_string($conn,$Row[2]);
                }
                
              //  destination 
                $destination = "";
                if(isset($Row[3])) {
                    $destination = mysqli_real_escape_string($conn,$Row[3]);
                }
                
                
               //  for sales_person 
                $sales_person = "";
                if(isset($Row[4])) {
                    $sales_person = mysqli_real_escape_string($conn,$Row[4]);
                }
                
                
                
                
                
                
                if (!empty($name) || !empty($email) || !empty($mo_number)|| !empty($destination)|| !empty($sales_person) ){
                    $query = "insert into all_contact(name, email, mo_number, destination, sales_person, date) values('".$name."','".$email."','".$mo_number."','".$destination."','".$sales_person."','".$timestamp."')";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "";
                    } else {
                        $type = "error";
                        $message = "";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}












if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'asset/exelupload/uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
               //  for name
                $name = "";
                if(isset($Row[0])) {
                    $name = mysqli_real_escape_string($conn,$Row[0]);
                }
               //  for description 
                $email = "";
                if(isset($Row[1])) {
                    $email = mysqli_real_escape_string($conn,$Row[1]);
                }
                   //  for mo_number 
                $mo_number = "";
                if(isset($Row[2])) {
                    $mo_number = mysqli_real_escape_string($conn,$Row[2]);
                }
                
              //  destination 
                $destination = "";
                if(isset($Row[3])) {
                    $destination = mysqli_real_escape_string($conn,$Row[3]);
                }
                
                
               //  for sales_person 
                $sales_person = "";
                if(isset($Row[4])) {
                    $sales_person = mysqli_real_escape_string($conn,$Row[4]);
                }
                
                
                
                
                
                
                if (!empty($name) || !empty($email) || !empty($mo_number)|| !empty($destination)|| !empty($sales_person) ){
                    $query = "insert into lead(name, email, mo_number, destination, sales_person, date, status_now) values('".$name."','".$email."','".$mo_number."','".$destination."','".$sales_person."','".$timestamp."','1')";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "<script>alert('Excel Data Imported into the Database')</script>";
                    } else {
                        $type = "error";
                        $message = "<script>alert('Problem in Importing Excel Data')</script>";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
 
 
 
?>
 
 
    <div id="alert" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
         

 