<?php 
	session_start();
	require 'loggedin.php';
	include("_conn.php");
	include "listmenu.php";

	if( !is_logged_in() )
	{
		header('Location: logout.php');
	} 
	
	$username = $_SESSION['username'];
	$name = $_SESSION['name'];
	$id = $_SESSION['id'];
	$role = $_SESSION['role'];
	
	$select = dbConnect()->prepare("SELECT * 
									FROM penghuni");
		$select->execute();
	
	if(isset($_POST['submit']))
	{
		$_SESSION['icNum'] = $_POST['stu_ic'];
		header('Location: viewstudent.php');
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>View All Residents</title>
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
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-list"></i> View All Residents</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
									<tr>
										<th><center>No</center></th>
										<th><center>Name</center></th>
										<th><center>Nickname</center></th>
										<th><center>Contact Number</center></th>
										<th><center>Role</center></th>
										<th><center>Status</center></th>  
									</tr>
									</thead>
									<tbody>
								
									<?php 
									$x = 1;
										while( $result = $select->fetch(PDO::FETCH_LAZY))
										{
											echo "<tr>";
											echo "<td><center>$x</center></td>";
											echo "<td><center>".$result['pName']."</center></td>";
											echo "<td><center>".$result['pNickName']."</center></td>";
											echo "<td><center>".$result['pTel']."</center></td>";
											echo "<td><center>".$result['pRole']."</center></td>";
											echo "<td><center>".$result['pStatus']."</center></td>";
											echo "</tr>";
										$x++;
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</center></body>
</html>