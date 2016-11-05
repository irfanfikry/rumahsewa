<?php 

	session_start();
	include "listmenu.php";
	include("_conn.php");
	require 'loggedin.php';
	
	if( is_logged_in() )
	{
		$name = $_SESSION['username'];
		$s_id = $_SESSION['id'];
		$role = $_SESSION['role'];
	}
	else
	{
		$s_id = 0;
	}
		
	if(isset($_POST['submit'])) 
	{
		//Occupant
		$name 	   = $_POST['name']; 
		$nickname  = $_POST['nickname']; 
		$username  = $_POST['username'];
		$password  = $_POST['password'];
		$password2 = $_POST['password2'];
		$phone 	   = $_POST['phone'];
		$role      = 'Crew';
		$status      = 'pending';
		
		$encrypted 	   = md5($password);
		
		 
						
		$sthandler = dbConnect()->prepare("SELECT * FROM penghuni WHERE username = ?");
		$sthandler->bindParam(1, $username);
		$sthandler->execute();
				
		$rows = $sthandler->fetch();
						 
		if( $password != $password2)
		{
			$error[] = 'Password and Confirm Password not Match!';
		}
		else if($sthandler->rowCount() > 0)
		{
			$error[] = 'Username already exist.';
		}
		else
		{
			$insert = dbConnect()->prepare("INSERT INTO penghuni (pID, pName, pNickName, username, password, pTel, pRole, pStatus) 
											VALUES ('',?,?,?,?,?,?,?)");
				$insert->bindParam(1, $name);
				$insert->bindParam(2, $nickname);
				$insert->bindParam(3, $username);
				$insert->bindParam(4, $encrypted);
				$insert->bindParam(5, $phone);
				$insert->bindParam(6, $role);
				$insert->bindParam(7, $status); 
				
				$insert->execute();
			
			$success[] = "Successfully apply account for resident named $name";
			$_SESSION['success'] = $success;
			header("Location: successinsert.php");
		}
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Apply Account</title>
    <link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
	
	<script src="js/validate.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	
	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>  
</head>
<body>
<center>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
				 <?php home(); ?>
				</div>
				<div class="nav navbar-nav navbar-right">
						<?php listmenu(); ?>
				</div>
			</div>
		</nav>
		<div class="jumbotron">
			<div class="container-fluid">
				<div id="row"><div class="col-lg-2"></div>
					<div class="col-lg-8">
						<h2>Apply for Account</h2><br/>
						<?php
							if(isset($error))
							{
								foreach($error as $error)
								{
									echo '<p class="bg-danger">'.$error.'</p>';
								}
							}
						?>
						<form role="form" method="post"  name="myForm" id="myForm" data-toggle="validator" action="">
							<span class="input-group-addon">Resident Details </span>
							<div class="form-group input-group">
								<span class="input-group-addon">Full Name</span>
								<input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}?>"  required pattern="[a-zA-Z][a-zA-Z\s]*" oninvalid="setCustomValidity('Please enter name(without numberic)')" oninput="setCustomValidity('')">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Nick Name</span>
								<input type="text" name="nickname" class="form-control" placeholder="Nick Name" value="<?php if(isset($_POST['nickname'])){ echo $_POST['nickname'];}?>"  required pattern="[a-zA-Z][a-zA-Z\s]*" oninvalid="setCustomValidity('Please enter nickname(without numberic)')" oninput="setCustomValidity('')">
							</div>							
							<div class="form-group input-group">
								<span class="input-group-addon">Username</span>
								<input type="text" name="username" class="form-control" placeholder="Username"   required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Password</span>
								<input type="password" name="password" id="password1" size="30" class="form-control" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Confirm Password</span>
								<input type="password" name="password2" id="password2" size="30"   class="form-control" required="required">
							</div>
							<p id="validate-status"></p>
							<div class="form-group input-group">
								<span class="input-group-addon">No Phone</span>
								<input type="text" name="phone" value="<?php if(isset($_POST['phone'])){ echo $_POST['phone'];}?>" class="form-control" placeholder="No Phone" required oninvalid="setCustomValidity('Please enter contact number')" oninput="setCustomValidity('')">
							</div>
							<br><br>
							  <button type="submit" name="submit" class="btn btn-default" onclick="return confirm(&quot;Are sure to create this occupant account?&quot;);">Create</button> 
							  <button type="reset" name="reset" class="btn btn-default">Clear</button>
						 </form> 
					</div> 
				</div>
			</div>
		</div>
	</div> 
</center>
</body>
</html>