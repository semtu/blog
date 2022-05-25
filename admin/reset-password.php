<?php
include('includes/header.php');
include('database/dbconfig.php');

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
$key = $_GET["key"];
$email = $_GET["email"];
$curDate = date("Y-m-d H:i:s");
$query = mysqli_query($connection,"SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';");
$row = mysqli_num_rows($query);
if ($row==""){
$error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link from the email, 
or you have already used the key in which case it is deactivated.</p>
<p><a href="http://localhost/ALLPHPTRICKS/admin/forgot-password.php">Click here</a> to reset password.</p>';
	}else{
	$row = mysqli_fetch_assoc($query);
	$expDate = $row['expDate'];
	if ($expDate >= $curDate){
	?>
    <br />
	<body class="bg-gradient-primary">
		<div class="container">
			<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12 col-md-9">
				<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<div class="row">
					<div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
					<div class="col-lg-6">
						<div class="p-5">
						<form class="user" method="post" action="" name="update"><br /><br />
							<input type="hidden" name="action" value="update" />
							<br /><br />
							<div class="form-group">
								<label><strong>Enter New Password:</strong></label><br /><br />
								<input type="password" class="form-control form-control-user" name="pass1" maxlength='15' required/>
							</div>
							<div class="form-group">
								<label><strong>Re-Enter New Password:</strong></label><br /><br />
								<input type="password" class="form-control form-control-user" name="pass2" maxlength='15' required/>
							</div>
							<input type="hidden" name="email" value="<?php echo $email;?>"/>
							<input type="submit" value="Reset Password" class="btn btn-primary btn-user btn-block"/> 
						</form>
						</div>
					</div>
					</div>
				</div>
				</div>

			</div>
			</div>

		</div>
	</body>
<?php
}else{
$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).<br /><br /></p>";
				}
		}
if($error!=""){
	echo "<div class='error'>".$error."</div><br />";
	}			
} // isset email key validate end


if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($connection,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($connection,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:s");
if ($pass1!=$pass2){
		$error .= "<p>Password do not match, both password should be same.<br /><br /></p>";
		}
	if($error!=""){
		echo "<div class='error'>".$error."</div><br />";
		}else{

$pass1 = md5($pass1);
mysqli_query($connection, "UPDATE `register` SET `password`='".$pass1."', `trn_date`='".$curDate."' WHERE `email`='".$email."';");	

mysqli_query($connection,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");		
	
echo '
	<body class="bg-gradient-primary">
		<div class="container">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="row">
					<div class="col-md-8 mr-auto ml-auto text-center py-5 mt-5">
						<div class="card">
							<div class="card-body">
								<h1 class="card-title bg-success text-white"> Congratulations! </h1>
								<h2 class="card-title"> Your password has been updated successfully. </h2>
								<p><a href="http://localhost/BLOG/admin/login.php">Click here</a> to Login.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
';
		}		
}
?>

</div>



<?php
include('includes/scripts.php');
?>
