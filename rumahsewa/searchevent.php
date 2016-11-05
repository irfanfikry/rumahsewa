<?php 
	session_start();
	include("_conn.php");
	include "listmenu.php";
	require 'loggedin.php';

	if( is_logged_in() )
	{
		$name = $_SESSION['username'];
		$id = $_SESSION['id'];
		$role = $_SESSION['role'];
	} 
	
	if(isset($_POST['submit']))
	{
		$e_name = $_POST['name'];
		$e_date = $_POST['date'];
		
		$_SESSION['notfound'] = "no";
		
		if( $e_name == null && $e_date == null)
		{
			$_SESSION['notfound'] = null;
			header('Location: viewevent.php');
		}
		else if( $e_date == null )
		{
			$search = dbConnect()->prepare("SELECT * FROM event 
										WHERE e_name = ?");
			$search->bindParam(1, $e_name);
		
			$search->execute();
			
			if($search->rowCount() == 0)
			{
				$_SESSION['eName'] = "Not Found";
			}
			else
			{
				$_SESSION['eName'] = $e_name;
			}
			$_SESSION['notfound'] = $e_name;
			$_SESSION['eDate'] = "none";
		}
		else if( $e_name == null )
		{
			$search = dbConnect()->prepare("SELECT * FROM event 
										WHERE e_date = ?");
			$search->bindParam(1, $e_date);
		
			$search->execute();
			
			if($search->rowCount() == 0)
			{
				$_SESSION['eDate'] = "Not Found";
			}
			else
			{
				$_SESSION['eDate'] = $e_date;
			}
			$_SESSION['notfound'] = $e_date;
			$_SESSION['eName'] = "none";
		}
		else
		{
			$search = dbConnect()->prepare("SELECT * FROM event 
										WHERE e_date = ?
										AND e_name = ?");
			$search->bindParam(1, $e_date);
			$search->bindParam(2, $e_name);
		
			$search->execute();
			
			if($search->rowCount() == 0)
			{
				$_SESSION['eName'] = "Not Found";
				$_SESSION['eDate'] = "Not Found";
			}
			else
			{
				$_SESSION['eName'] = $e_name;
				$_SESSION['eDate'] = $e_date;
			}
		}
		
		header('Location: viewevent.php');
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Search Event</title>
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
			<div class="row"><div class="col-lg-3"></div>
					<div class="col-lg-6">
						<ol class="breadcrumb">
							<i class="fa fa-male"></i><i class="fa fa-female"></i> Please enter name or date of event to search
						</ol>
					</div>
				</div>
				<div class="row"><div class="col-lg-4"></div>
					<div class="col-lg-4">
						<form name="myForm" method="post" action="" autocomplete="off" >
							<div class="form-group input-group">
								<span class="input-group-addon">Event Name</span>
								<input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name of Event" size="100%">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Event Date</span>
								<input type="date" name="date" class="form-control" autocomplete="off" "/>
							</div>
							<button type="submit" name="submit" class="btn btn-default"><i class="fa fa-search"></i> Search </button>
							<input type="reset" name="clear" class="btn btn-default" value="Clear" />
						</form>
					</div>
				</div>
		</div>
	</div>
</div>
</center></body>
</html>