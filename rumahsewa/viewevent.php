<?php 

	session_start();
	include "listmenu.php";
	include("_conn.php");
	require 'loggedin.php';
	
	if( is_logged_in() )
	{
		$name = $_SESSION['username'];
		$id = $_SESSION['id'];
		$role = $_SESSION['role'];
	}   
	
	$e_name   = $_SESSION['eName'];
	$e_date   = $_SESSION['eDate'];
	$notfound = $_SESSION['notfound'];
	
	if( $e_name == $notfound )
	{
		$select = dbConnect()->prepare("SELECT *
									FROM event
									WHERE e_name = ?");
		$select->bindParam(1, $e_name);
		$select->execute();
	}
	else if( $e_date == $notfound )
	{
		$select = dbConnect()->prepare("SELECT *
									FROM event
									WHERE e_date = ?");
		$select->bindParam(1, $e_date);
		$select->execute();
	}
	else
	{
		$select = dbConnect()->prepare("SELECT *
									FROM event
									WHERE e_date = ?
									AND e_name = ?");
		$select->bindParam(1, $e_date);
		$select->bindParam(2, $e_name);
		$select->execute();
	}
		
	if(isset($_POST['details']))
	{
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>View Event</title>
    <link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
	
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
				<div class="row">
				<div class="col-lg-2"></div>
					<div class="col-lg-8">
						<?php
							if($notfound == null)
							{
								echo "Please fill the form<br/><br/>";
								echo "<a class='btn btn-primary active' href='searchevent.php' > Search Again </a>";
							}
							else if($e_name == "Not Found")
							{
								echo "The event named <strong>$notfound</strong> does not exist!<br/><br/>";
								echo "<a class='btn btn-primary active' href='searchevent.php' > Search Again </a>";
							}
							else if($e_date == "Not Found")
							{
								echo "The event dated <strong>$notfound</strong> does not exist!<br/><br/>";
								echo "<a class='btn btn-primary active' href='searchevent.php' > Search Again </a>";
							}
							else
							{
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"> 
									<i class="fa fa-indent"></i> View Event's Details
								</h3>
							</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
									<tr>
										<th><center>No</center></th>
										<th><center>Event Name</center></th>
										<th><center>Date</center></th>
										<th><center>Time</center></th>
										<th><center>Venue</center></th>
										<th><center>No of Occupants</center></th>
									</tr>
									</thead>
									<tbody>
								
									<?php 
									$x = 1;
										while( $result = $select->fetch(PDO::FETCH_LAZY))
										{
											echo "<tr>";
											echo "<td><center>$x</center></td>";
											echo "<td><center>".$result['e_name']."</center></td>";
											echo "<td><center>".$result['e_date']."</center></td>";
											echo "<td><center>".$result['e_time']."</center></td>";
											echo "<td><center>".$result['e_venue']."</center></td>";
											$e_id = $result['e_id'];
											$stmt = dbConnect()->prepare("SELECT e.*, o.*, s.*
																			FROM event e
																			JOIN schedule s
																			ON e.e_id = s.e_id
																			JOIN occupants o
																			ON o.o_id = s.o_id
																			WHERE s.e_id = ?");
											$stmt->bindParam(1,$e_id);
											$stmt->execute();
											$no = 0;
											while( $any = $stmt->fetch(PDO::FETCH_LAZY))
											{
												$no++;
											}
											echo "<td><center>".$no."</center></td>";
											echo "</tr>";
										$x++;
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
						</div>
						<a class='btn btn-primary active' href='searchevent.php' > Search Again </a>
						<?php
							}
						?>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</center>
</body>
</html>