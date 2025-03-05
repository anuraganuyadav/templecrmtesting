<?php
// $domain ="http://localhost/CRM";
//  date_default_timezone_set('Asia/Kolkata');      
// $timestamp = date('Y-m-d H:i:s'); 


// 	$DB_HOST = 'localhost';
// 	$DB_USER = 'temple54crm';
// 	$DB_PASS = 'XbSZTQ[h8Q}(X575bSZTQ[h8Q}(';
// 	$DB_NAME = 'templemitracrm_@temple';

// 	$db = mysqli_connect("$DB_HOST","$DB_USER","$DB_PASS","$DB_NAME"); 
// 	$conn = mysqli_connect("$DB_HOST","$DB_USER","$DB_PASS","$DB_NAME");
//     mysqli_select_db($conn, $DB_NAME);

// 	try{
// 		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
// 		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	}
// 	catch(PDOException $e){
// 		echo $e->getMessage();
// 	}






$domain = "http://localhost/CRM";
date_default_timezone_set('Asia/Kolkata');
$timestamp = date('Y-m-d H:i:s');


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'templecrm';

$db = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASS", "$DB_NAME");
$conn = mysqli_connect("$DB_HOST", "$DB_USER", "$DB_PASS", "$DB_NAME");
mysqli_select_db($conn, $DB_NAME);

try {
	$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
	$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
}
