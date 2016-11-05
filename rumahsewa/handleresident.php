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
									FROM penghuni WHERE pStatus = 'pending'");
		$select->execute();
		$rows = $select->fetch();
		$select->execute();
	
	if(isset($_POST['submit']))
	{
		$id = $_POST['id']; 
		$status = $_POST['submit']; 
		
		$update = dbConnect()->prepare("UPDATE penghuni SET pStatus = ? WHERE pID = ?");
			$update->bindParam(1, $status);
			$update->bindParam(2, $id);
		$update->execute();
		 
		$success[] = "Successfully update requested account";
		$_SESSION['success'] = $success;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Requested Residents</title>
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
						<?php
						if($rows == 0)
						{
							echo "Do not have requested account!";
						}
						else
						{?>
					<div class="panel panel-default">  
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-list"></i> View Requested Residents</h3>
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
										<th colspan="2"><center>Handle</center></th>  
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
											echo '<form name="myForm" method="post" action="" autocomplete="off" >';
											echo '<input type="hidden" name="id" value="'.$result['pID'].'">';
											echo '<td><center><button type="submit" name="submit" onclick="return confirm(&quot;Are sure to approve?&quot;);" class="btn btn-default" value="active">Approve</button></center></td>';
											echo '<td><center><button type="submit" name="submit" onclick="return confirm(&quot;Are sure to reject?&quot;);"  class="btn btn-default" value="rejected">Reject</button></center></td>';
											echo '</form>';
											echo "</tr>";
										$x++;
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
						<?php } ?>
						<?php
							if(isset($_SESSION['success']))
							{
								$success = $_SESSION['success'];
								foreach($success as $success)
								{
									echo '<p class="bg-success">'.$success.'</p>';
								}
							}
							echo "</br>";
							unset($_SESSION['success']);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</center></body>
</html>