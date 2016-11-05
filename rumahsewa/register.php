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
		$o_name 	   = $_POST['o_name'];
		$o_ic 	   	   = $_POST['o_ic'];
		$o_birthdate   = $_POST['o_birthdate'];
		$o_birthplace  = $_POST['o_birthplace'];
		$o_address 	   = $_POST['o_address'];
		$o_phone 	   = $_POST['o_phone'];
		$o_email 	   = $_POST['o_email'];
		$o_gender 	   = $_POST['o_gender'];
		$o_age 	   	   = $_POST['o_age'];
		$o_sibling 	   = $_POST['o_sibling'];
		$o_old_school  = $_POST['o_old_school'];
		$o_category    = $_POST['o_category'];
		$o_edu 	   	   = $_POST['o_edu'];
		$o_level 	   = $_POST['o_level'];
		$o_edu_level   = $o_edu." ".$o_level;
		$o_disease 	   = $_POST['o_disease'];
		$o_allergy 	   = $_POST['o_allergy'];
		
		//Guardian
		$g_name 	   = $_POST['g_name'];
		$g_username    = $_POST['g_username'];
		$g_password    = $_POST['g_password'];
		$password2 	   = $_POST['password2'];
		$g_ic 	  	   = $_POST['g_ic'];
		$g_age 	   	   = $_POST['g_age'];
		$g_address 	   = $_POST['g_address'];
		$g_phone 	   = $_POST['g_phone'];
		$g_job 	   	   = $_POST['g_job'];
		$g_job_add 	   = $_POST['g_job_add'];
		$g_job_phone   = $_POST['g_job_phone'];
		$g_income 	   = $_POST['g_income'];
		$encrypted 	   = md5($g_password);
		
		//Dependents
		$d_name 	   = $_POST['d_name'];
		$d_age 	   	   = $_POST['d_age'];
		$d_notes 	   = $_POST['d_notes'];
		
		//Heir
		$h_name 	   = $_POST['h_name'];
		$h_address 	   = $_POST['h_address'];
		$h_phone 	   = $_POST['h_phone'];
						
		$sthandler = dbConnect()->prepare("SELECT * FROM guardian WHERE g_username = ?");
		$sthandler->bindParam(1, $g_username);
		$sthandler->execute();
				
		$rows = $sthandler->fetch();
						
		//$emailDB = $rows['email'];
					
		/*if($emailDB == $email)
		{
			$error[] = 'Email already exist.';
		}*/
		if( $g_password != $password2)
		{
			$error[] = 'Password and Confirm Password not Match!';
		}
		else if($sthandler->rowCount() > 0)
		{
			$error[] = 'Username already exist.';
		}
		else
		{
			//Insert Guardian
			$insert = dbConnect()->prepare("INSERT INTO guardian (g_id, g_username, g_password, g_name, g_ic, g_address, g_phone_no, g_job, g_job_address, g_job_phone_no, g_monthly_income) 
											VALUES ('',?,?,?,?,?,?,?,?,?,?)");
				$insert->bindParam(1, $g_username);
				$insert->bindParam(2, $encrypted);
				$insert->bindParam(3, $g_name);
				$insert->bindParam(4, $g_ic);
				$insert->bindParam(5, $g_address);
				$insert->bindParam(6, $g_phone);
				$insert->bindParam(7, $g_job);
				$insert->bindParam(8, $g_job_add);
				$insert->bindParam(9, $g_job_phone);
				$insert->bindParam(10, $g_income);
				
				$insert->execute();
			
			$sthandler2 = dbConnect()->prepare("SELECT * FROM guardian WHERE g_username = ?");
				$sthandler2->bindParam(1, $g_username);
				$sthandler2->execute();
				$row = $sthandler2->fetch();
						
				$g_id = $row['g_id'];
			
			//Insert Occupant
			$insert2 = dbConnect()->prepare("INSERT INTO occupants (o_id, o_name, o_ic, o_address, o_phone_no, o_email, o_birthdate, o_birthplace, o_gender, o_age, o_edu_level, o_no_of_sibling, o_old_school, o_category, o_disease, o_allergy, g_id, s_id) 
											VALUES ('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert2->bindParam(1, $o_name);
				$insert2->bindParam(2, $o_ic);
				$insert2->bindParam(3, $o_address);
				$insert2->bindParam(4, $o_phone);
				$insert2->bindParam(5, $o_email);
				$insert2->bindParam(6, $o_birthdate);
				$insert2->bindParam(7, $o_birthplace);
				$insert2->bindParam(8, $o_gender);
				$insert2->bindParam(9, $o_age);
				$insert2->bindParam(10, $o_edu_level);
				$insert2->bindParam(11, $o_sibling);
				$insert2->bindParam(12, $o_old_school);
				$insert2->bindParam(13, $o_category);
				$insert2->bindParam(14, $o_disease);
				$insert2->bindParam(15, $o_allergy);
				$insert2->bindParam(16, $g_id);
				$insert2->bindParam(17, $s_id);
				
				$insert2->execute();
			
			$query = dbConnect()->prepare("SELECT o_id FROM occupants 
											WHERE g_id = ? 
											ORDER BY o_id desc 
											LIMIT 1");
				$query->bindParam(1,$g_id);
				$query->execute();
				$row2 = $query->fetch();
						
			$o_id = $row2['o_id'];
				
			//Insert Dependents
			foreach($d_name as $a => $b)
			{			 
				$insert3 = dbConnect()->prepare("INSERT INTO dependents (d_id, d_name, d_age, d_notes, g_id)
													VALUES ('',?,?,?,?)");
					$insert3->bindParam(1, $d_name[$a]);
					$insert3->bindParam(2, $d_age[$a]);
					$insert3->bindParam(3, $d_notes[$a]);
					$insert3->bindParam(4, $g_id);
					
					$insert3->execute();
			}
			
			//Insert Heir
			foreach($h_name as $a => $b)
			{
				$insert4 = dbConnect()->prepare("INSERT INTO heir (h_id, h_name, h_phoneNo, h_address) 
											VALUES ('',?,?,?)");
					$insert4->bindParam(1, $h_name[$a]);
					$insert4->bindParam(2, $h_phone[$a]);
					$insert4->bindParam(3, $h_address[$a]);
				
				$insert4->execute();
				
				$query = dbConnect()->prepare("SELECT h_id FROM heir 
											ORDER BY h_id desc 
											LIMIT 1");
					$query->execute();
					$row3 = $query->fetch();
						
				$h_id[] = $row3['h_id'];	
			}
			 
			//Insert Relationships
			foreach($h_id as $a => $b)
			{
				$insert5 = dbConnect()->prepare("INSERT INTO relationships (r_id, o_id, h_id) 
												VALUES ('',?,?)");
					$insert5->bindParam(1, $o_id);
					$insert5->bindParam(2, $h_id[$a]);
					
					$insert5->execute();
			}
			
			$success[] = "Successfull create account for occupant named $o_name";
			$_SESSION['success'] = $success;
			header("Location: successcreate.php");
		}
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Create Occupant</title>
    <link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
	
	<script src="js/validate.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	
	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script> 
	<script>
		$(document).ready(function(){
    	$('[data-toggle="popover"]').popover();
		});
	</script>
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
						<h2>Create Occupant Account</h2><br/>
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
							<span class="input-group-addon">Occupant details</span>
							<div class="form-group input-group">
								<span class="input-group-addon">Occupant Name</span>
								<input type="text" name="o_name" class="form-control" placeholder="Full Name" value="<?php if(isset($_POST['o_name'])){ echo $_POST['o_name'];}?>" data-toggle="popover" data-placement="right" data-content="Please enter occupant full name" required pattern="[a-zA-Z][a-zA-Z\s]*" oninvalid="setCustomValidity('Please enter occupant name(without numberic)')" oninput="setCustomValidity('')">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">I/C Number</span>
								<input type="text" name="o_ic" id="ic" value="<?php if(isset($_POST['o_ic'])){ echo $_POST['o_ic'];}?>" onkeypress="countAge()" class="form-control" data-toggle="popover" data-placement="right" data-content="Please enter I/C number of occupant" pattern="[0-9]{12,12}" placeholder="(YYMMDDBP###G) example:020304123456" required oninvalid="setCustomValidity('Please enter occupant IC')" oninput="setCustomValidity('')">
								<span class="input-group-addon">Date of Birth</span>
								<input type="text" name="o_birthdate" size="2%" value="<?php if(isset($_POST['o_birthdate'])){ echo $_POST['o_birthdate'];}?>" class="form-control" id="birthdate" value="" readonly>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Birth Place</span>
								<input type="text" name="o_birthplace" value="<?php if(isset($_POST['o_birthplace'])){ echo $_POST['o_birthplace'];}?>" class="form-control" placeholder="Birth Place" data-toggle="popover" data-placement="right" data-content="Please enter occupant birth place" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Address</span>
								<input type="text" name="o_address" value="<?php if(isset($_POST['o_address'])){ echo $_POST['o_address'];}?>" class="form-control" placeholder="Address" data-toggle="popover" data-placement="right" data-content="Please enter occupant current address" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">No Phone</span>
								<input type="text" name="o_phone" value="<?php if(isset($_POST['o_phone'])){ echo $_POST['o_phone'];}?>" class="form-control" placeholder="No Phone" data-toggle="popover" data-placement="right" data-content="Please enter occupant phone number to contact" required oninvalid="setCustomValidity('Please enter student contact number')" oninput="setCustomValidity('')">
								<span class="input-group-addon">Email</span>
								<input type="email" name="o_email" value="<?php if(isset($_POST['o_email'])){ echo $_POST['o_email'];}?>" class="form-control" data-toggle="popover" data-placement="right" data-content="Please enter email such as example provided" placeholder="example@email.com" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Gender</span>
								<input type="text" name="o_gender" class="form-control" value="Female" readonly>
								<span class="input-group-addon">Age</span>
								<input type="text" name="o_age" id="age" value="<?php if(isset($_POST['o_age'])){ echo $_POST['o_age'];}?>" class="form-control" value="" readonly>
								<span class="input-group-addon">Total of Siblings</span>
								<input type="number" name="o_sibling" min="0" value="<?php if(isset($_POST['o_sibling'])){ echo $_POST['o_sibling'];}?>" class="form-control" placeholder="Number" data-toggle="popover" data-placement="right" data-content="Please enter total number of occupant's siblings " required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Former School</span>
								<input type="text" name="o_old_school" value="<?php if(isset($_POST['o_old_school'])){ echo $_POST['o_old_school'];}?>" class="form-control" placeholder="Former School" data-toggle="popover" data-placement="right" data-content="Please enter occupant former school name" required="required">
							</div>
							<div class="form-group input-group">
                                <span class="input-group-addon">Category</span>
                                <select name="o_category" class="form-control" value="<?php if(isset($_POST['o_category'])){ echo $_POST['o_category'];}?>" data-toggle="popover" data-placement="right" data-content="Please choose category of the occupant" required oninvalid="setCustomValidity('Please choose one of category')" oninput="setCustomValidity('')">
									<option>-- choose --</option>
									<option value="Orphan">Orphan</option>
									<option value="Poor">Poor</option>
									<option value="Abandon">Abandon</option>
								</select>
								<span class="input-group-addon">Education</span>
                                <select name="o_edu" class="form-control" value="<?php if(isset($_POST['o_edu'])){ echo $_POST['o_edu'];}?>" data-toggle="popover" data-placement="right" data-content="Please choose current education whether standard or form or university" required oninvalid="setCustomValidity('Please choose one of education')" oninput="setCustomValidity('')">
									<option value>-- choose --</option>
									<option value="Standard">Standard</option>
									<option value="Form">Form</option>
									<option value="University">University</option>
								</select>
								<span class="input-group-addon"></span>
								<input type="text" size="1%" name="o_level" value="<?php if(isset($_POST['o_level'])){ echo $_POST['o_level'];}?>" class="form-control" data-toggle="popover" data-placement="right" data-content="Number of education level for form or standard/For university enter current semester" required="required">
							</div>
							<div class="btn-group form-group input-group" data-toggle=" "> 
								<span class="input-group-addon">Disease</span>
									<label class="btn btn-default">
										<input type="radio" name="o_disease" value="Yes" data-toggle="popover" data-placement="right" data-content="Please choose yes or no for having disease"> Yes
									</label>
									<label class="btn btn-default">
										<input type="radio" name="o_disease" value="No" data-toggle="popover" data-placement="right" data-content="Please choose yes or no for having disease" required> No
									</label>   
								<div class="btn-group input-group" data-toggle=" "> 
								<span class="input-group-addon">Allergy</span>
									<label class="btn btn-default">
										<input type="radio" name="o_allergy" value="Yes" data-toggle="popover" data-placement="right" data-content="Please choose yes or no for having allergy"> Yes
									</label>
									<label class="btn btn-default">
										<input type="radio" name="o_allergy" value="No" data-toggle="popover" data-placement="right" data-content="Please choose yes or no for having allergy" required> No
									</label> 
								</div>
							</div>
							<br><br>
							<span class="input-group-addon">Guardian details</span>
							<div class="form-group input-group">
								<span class="input-group-addon">Name</span>
								<input type="text" name="g_name" class="form-control" value="<?php if(isset($_POST['g_name'])){ echo $_POST['g_name'];}?>" placeholder="Father/Mother/Guardian name" data-toggle="popover" data-placement="right" data-content="Please enter guardian full name" required pattern="[a-zA-Z][a-zA-Z\s]*" oninvalid="setCustomValidity('Please enter guardian name(without numberic)')" oninput="setCustomValidity('')">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Username</span>
								<input type="text" name="g_username" class="form-control" placeholder="Username" data-toggle="popover" data-placement="right" data-content="Please enter username to use for login" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Password</span>
								<input type="password" name="g_password" id="password1" size="30" class="form-control" minlength="6" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Confirm Password</span>
								<input type="password" name="password2" id="password2" size="30" onkeyup="return passwordmatch();" class="form-control" minlength="6" required="required">
							</div>
							<p id="validate-status"></p>
							<div class="form-group input-group">
								<span class="input-group-addon">I/C Number</span>
								<input type="text" name="g_ic" id="ic2" onkeypress="countAge2()" value="<?php if(isset($_POST['g_ic'])){ echo $_POST['g_ic'];}?>" class="form-control" data-toggle="popover" data-placement="right" data-content="Please enter I/C number of guardian" required="required" pattern="[0-9]{12,12}" placeholder="(YYMMDDBP###G) example:020304123456" required oninvalid="setCustomValidity('Please enter occupant IC')" oninput="setCustomValidity('')">
								<span class="input-group-addon">Age</span>
								<input type="text" name="g_age" id="age2" size="2%" class="form-control" value="<?php if(isset($_POST['g_age'])){ echo $_POST['g_age'];}?>" readonly>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Address</span>
								<input type="text" name="g_address" class="form-control" value="<?php if(isset($_POST['g_address'])){ echo $_POST['g_address'];}?>" placeholder="Address" data-toggle="popover" data-placement="right" data-content="Please enter guardian current address" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">No Phone</span>
								<input type="text" name="g_phone" class="form-control" value="<?php if(isset($_POST['g_phone'])){ echo $_POST['g_phone'];}?>" placeholder="No Phone" data-toggle="popover" data-placement="right" data-content="Please enter guardian no phone to contact" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Occupation</span>
								<input type="text" name="g_job" class="form-control" value="<?php if(isset($_POST['g_job'])){ echo $_POST['g_job'];}?>" placeholder="Job" data-toggle="popover" data-placement="right" data-content="Please enter guardian occuppation" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Occupation's Address</span>
								<input type="text" name="g_job_add" class="form-control" value="<?php if(isset($_POST['g_job_add'])){ echo $_POST['g_job_add'];}?>" placeholder="Address" data-toggle="popover" data-placement="right" data-content="Please enter occuppation's address" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Occupation's No Phone</span>
								<input type="text" name="g_job_phone" class="form-control" value="<?php if(isset($_POST['g_job_phone'])){ echo $_POST['g_job_phone'];}?>" placeholder="No Phone" data-toggle="popover" data-placement="right" data-content="Please enter occuppation's number phone to contact" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">Monthly Income (RM)</span>
								<input type="number" step="0.01" name="g_income" class="form-control" min="0" value="<?php if(isset($_POST['g_income'])){ echo $_POST['g_income'];}?>" placeholder="Monthly Income" data-toggle="popover" data-placement="right" data-content="Please enter monthly income such as 1400" required="required">
							</div>
							<br><br>
							<span class="input-group-addon">Dependents details</span> 
							<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped" id="myTable">
									<thead>
									<tr>
										<th><center>Bil</center></th>
										<th><center>Name</center></th>
										<th><center>Age</center></th>
										<th><center>Notes</center></th>
									</tr>
									<thead>
									<tbody>
									<tr>
										<td><center>1</center></td>
										<td><input type="text" class="form-control" name="d_name[]" data-toggle="popover" data-placement="right" data-content="Please enter dependent full name" required /></td>
										<td><input type="text" class="form-control" name="d_age[]" data-toggle="popover" data-placement="right" data-content="Please enter age of dependent" required /></td>
										<td><input type="text" class="form-control" name="d_notes[]" data-toggle="popover" data-placement="right" data-content="Please enter status of dependent whether studied or worked" required /></td>
									</tr>
									<tbody> 
								</table>  
								<input type="button" class="btn btn-default" onclick="addTable()" value="Add More"/>
								<input type="button" class="btn btn-default" onclick="deleteTable()" value="Delete" />
							</div> 
							</div>
							<br><br>
							<span class="input-group-addon">Heir to Contact if Emergency</span>
							<div class="form-group input-group">
								<span class="input-group-addon">1</span>
								<span class="input-group-addon">Name</span>
								<input type="text" name="h_name[]" value="<?php if(isset($_POST['h_name[1]'])){ echo $_POST['h_name[1]'];}?>" class="form-control" placeholder="First heir name" data-toggle="popover" data-placement="right" data-content="Please enter first heir full name" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">&nbsp;</span>
								<span class="input-group-addon">Address</span>
								<input type="text" name="h_address[]" value="<?php if(isset($_POST['h_address[1]'])){ echo $_POST['h_address[1]'];}?>" class="form-control" placeholder="Address" data-toggle="popover" data-placement="right" data-content="Please enter heir current address" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">&nbsp;</span>
								<span class="input-group-addon">No Phone</span>
								<input type="text" name="h_phone[]" value="<?php if(isset($_POST['h_phone[1]'])){ echo $_POST['h_phone[1]'];}?>" class="form-control" placeholder="No Phone" data-toggle="popover" data-placement="right" data-content="Please enter heir phone number to contact" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">2</span>
								<span class="input-group-addon">Name</span>
								<input type="text" name="h_name[]" value="<?php if(isset($_POST['h_name[2]'])){ echo $_POST['h_name[2]'];}?>" class="form-control" placeholder="Second heir name" data-toggle="popover" data-placement="right" data-content="Please enter second heir full name" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">&nbsp;</span>
								<span class="input-group-addon">Address</span>
								<input type="text" name="h_address[]" value="<?php if(isset($_POST['h_address[2]'])){ echo $_POST['h_address[2]'];}?>" class="form-control" placeholder="Address" data-toggle="popover" data-placement="right" data-content="Please enter heir phone number to contact" required="required">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon">&nbsp;</span>
								<span class="input-group-addon">No Phone</span>
								<input type="text" name="h_phone[]" value="<?php if(isset($_POST['h_phone[2]'])){ echo $_POST['h_phone[2]'];}?>" class="form-control" placeholder="No Phone" data-toggle="popover" data-placement="right" data-content="Please enter heir current address" required="required">
							</div>
							<br><br>
							  <button type="submit" name="submit" class="btn btn-default" onclick="return confirm(&quot;Are sure to create this occupant account?&quot;);">Create</button> 
							  <button type="reset" name="reset" class="btn btn-default">Clear</button>
						 </form> 
					</div>
					<div class="col-lg-2">
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<div id="pwd_strength_wrap" style="text-align:left">
						<div id="passwordDescription">Password not entered</div>
						<div id="passwordStrength" class="strength0"></div>
						<div id="pswd_info">
							<strong>Strong Password Tips:</strong>
							<ul>
								<li style="text-align:left" class="invalid" id="length"><i class="fa fa-check-square-o"></i>At least 6 characters</li>
								<li style="text-align:left" class="invalid" id="pnum"><i class="fa fa-check-square-o"></i>At least one number</li>
								<li style="text-align:left" class="invalid" id="capital"><i class="fa fa-check-square-o"></i>At least one lowercase &amp; one uppercase letter</li>
								<li style="text-align:left" class="invalid" id="spchar"><i class="fa fa-check-square-o"></i>At least one special character</li>
							</ul>
						</div><!-- END pswd_info -->
					</div><!-- END pwd_strength_wrap -->
					</br></br>
					<div id="pwd_match_wrap">
						<div id="match_info">
							<ul>
								<li style="text-align:left" class="invalid" id="match" ><div id="passwordDescriptionMatch"></div></li>
							</ul>
						</div>
					</div><!-- END pwd_strength_wrap -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/passwordstrength.js"></script>
	<script src="js/passwordmatch.js"></script> 
	<script src="js/addtablecountage.js"></script> 
</center>
</body>
</html>