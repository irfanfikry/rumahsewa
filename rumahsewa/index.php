<?php
	include "listmenu.php";
	require 'loggedin.php';
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Index</title>
    <link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
			<h1>Jalan Platinum Seksyen 7</h1>
		</div>
	</div>
</div>
</center></body>
</html>