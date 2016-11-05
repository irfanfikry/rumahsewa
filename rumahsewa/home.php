<?php 
	session_start();
	require 'loggedin.php';
	include "listmenu.php";

	if( !is_logged_in() )
	{
		header('Location: logout.php');
	} 
	
	$username = $_SESSION['username'];
	$name = $_SESSION['name'];
	$id = $_SESSION['id'];
	$role = $_SESSION['role'];	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Home</title>
    <link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet"> 
	<link href="css/navbar.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body><center>
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
			<h4>Welcome</h4>
			You are now logged in! <br/><?php echo $name." as ".$role;?>
		</div>
	</div>
</div>
</center></body>
</html>