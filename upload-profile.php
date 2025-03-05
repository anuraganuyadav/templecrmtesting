<?php
require_once 'inc/session.php';

if (!isset($_SESSION['userID'], $_SESSION['user_role_id'])) {
	header('location:login.php?lmsg=true');
	exit;
}

//identifie
if ($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

	header("Location:index.php");
}



error_reporting(~E_NOTICE);

require_once 'inc/config.php';

if (isset($_GET['edit_profile']) && !empty($_GET['edit_profile'])) {
	$userID = $_GET['edit_profile'];
	$stmt_edit = $DB_con->prepare('SELECT userPic FROM users WHERE userID=:uuserID');
	$stmt_edit->execute(array(':uuserID' => $userID));
	$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
	extract($edit_row);
} else {
	header("Location: index.php");
}

if ($_SESSION['user_role_id'] != 0 && $_SESSION['user_role_id'] != 1 && $_SESSION['user_role_id'] != 2) {

	header("Location:index.php");
}


?>
<?php


if (isset($_POST['update_profile'])) {

	$imgFile = $_FILES['user_image']['name'];
	$tmp_dir = $_FILES['user_image']['tmp_name'];
	$imgSize = $_FILES['user_image']['size'];

	if ($imgFile) {
		$upload_dir = 'images/user_images/'; // upload directory	
		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
		$valid_extensions = array('jpeg', 'jpg', 'png', 'png', 'gif'); // valid extensions
		$userpic = rand(1000, 1000000) . "." . $imgExt;
		if (in_array($imgExt, $valid_extensions)) {
			if ($imgSize < 5000000) {
				unlink($upload_dir . $edit_row['userPic']);
				move_uploaded_file($tmp_dir, $upload_dir . $userpic);
			} else {
				$errMSG = "Sorry, your file is too large it should be less then 5MB";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	} else {
		// if no image selected the old image remain as it is.
		$userpic = $edit_row['userPic']; // old image from database
	}


	// if no error occured, continue ....
	if (!isset($errMSG)) {
		$stmt = $DB_con->prepare('UPDATE users 
									     SET userPic=:upic 
								       WHERE userID=:uuserID');

		$stmt->bindParam(':upic', $userpic);
		$stmt->bindParam(':uuserID', $userID);

		if ($stmt->execute()) {
?>
			<script>
				alert('Successfully Updated ...');
				window.location.href = 'index.php';
			</script>
	<?php
		} else {
			$errMSG = "Sorry Data Could Not Updated !";
		}
	}
}
//page veryfied by user status
$getUser = mysqli_query($conn, "SELECT status from users where userID = " . $_SESSION['userID'] . "");
$getStatus = mysqli_fetch_array($getUser);
if ($getStatus['status'] == 0) {
	?>
	<?php
	require_once('layouts/header.php');
	?>
	<title>Upload Profile</title>
	</head>

	<body class="fixed-nav sticky-footer bg-dark" id="page-top">
		<?php include_once("layouts/sidebar.php"); ?>
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<?php include_once("layouts/nav.php"); ?>

			<div class="container">
				<div class="card shadow card-login mx-auto mt-5">
					<div class="card-header">Update Profile</div>
					<form method="post" enctype="multipart/form-data" class="form-horizontal">
						<?php
						if (isset($errMSG)) {
						?>
							<div class="alert alert-danger">
								<span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
							</div>
						<?php
						}
						?>


						<table>
							<tr>
								<th> Old </th>
								<th> New </th>
							</tr>
							<tr>
								<td>
									<div class="outer-upload">
										<?php
										if (empty($result['userPic'])) {
											echo "<img class='image-upload' src='images/img/avtar.png'>";
										} else {
											echo "<img class='image-upload' src='images/user_images/" . $result['userPic'] . "' alt='Usr profile'>";
										}
										?>
									</div>
								</td>
								<td>
									<div class="outer-upload">
										<img class="image-upload" id="output" />
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<input class="form-control" type="file" name="user_image" onchange="loadFile(event)" accept="image/*" />
								</td>
							</tr>

							<tr>
								<td colspan="2"><button type="submit" name="update_profile" class="btn btn-primary">
										<span class="glyphicon glyphicon-save"></span> Update
									</button>

									<a class="btn btn-primary" href="index.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>

								</td>
							</tr>

						</table>

					</form>

					<script>
						var loadFile = function(event) {
							var reader = new FileReader();
							reader.onload = function() {
								var output = document.getElementById('output');
								output.src = reader.result;
							};
							reader.readAsDataURL(event.target.files[0]);
						};
					</script>
				</div>
			</div>




		<?php
		include_once("layouts/footer.php");
	} else {
		echo "<h4>You can't acccess this page </h4>";
	}
		?>