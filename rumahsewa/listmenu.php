<?php

function home()
{
	if(empty($_SESSION['role']))
	{
		echo '<a class="navbar-brand" href="index.php">RumahKu SyurgaKu</a>';
	}
	else
	{
		echo '<a class="navbar-brand" href="home.php">RumahKu SyurgaKu</a>';
	}
}

function listmenu()
{
	if(empty($_SESSION['role']))
	{
		echo'<li class="hidden">
				<a href="#page-top"></a>
			</li>
			<li>
				<a class="page-scroll" href="apply.php"><strong> Apply account </strong></a>
			</li> 
			<li>
				<a class="page-scroll" href="login.php"><i class="glyphicon glyphicon-log-in"></i><strong> Log In </strong></a>
			</li>';
	}
	else
	{
		$role = $_SESSION['role'];
		if($role == 'Admin')
		{
			echo'<li class="hidden">
					<a href="#page-top"></a>
				</li>
				<li>
					<li class="dropdown">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown"> </i><strong>Resident</strong>
					<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><a class="page-scroll" href="handleresident.php"><strong> Handle Resident Account </strong></a></li>
							<li class="divider"></li>
							<li><a class="page-scroll" href="register.php"><strong> Register new Resident </strong></a></li>
							<li class="divider"></li>
							<li><a class="page-scroll" href="viewallresident.php"><strong> View Resident </strong></a></li> 
							<li></li>
						</ul>
					</li>
				</li> 
				<li>
					<li class="dropdown">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown"> </i><strong>Charge</strong>
					<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><a class="page-scroll" href=" "><strong> Create Charge </strong></a></a></li>
							<li class="divider"></li>
							<li><a class="page-scroll" href=" "></i><strong> View Charge </strong></a></li> 
							<li></li>
						</ul>
					</li>
				</li>  
				<li>
					<li class="dropdown">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-user fa-fw"></i><strong>'.$_SESSION['name'].'</strong>
					<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><i class="fa fa-align-right"></i><strong> Role Type</strong></li>
							<ul>
								<li style="text-align:left;">'.$_SESSION['role'].'</li>
							</ul>
							<li class="divider"></li>
							<li><a class="page-scroll" href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
						</ul>
					</li>
				</li>'; 
		}
		else if($role == 'Crew')
		{
			echo'<li class="hidden">
					<a href="#page-top"></a>
				</li>
				<li>
					<li class="dropdown">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown"> </i><strong>Resident</strong>
					<i class="caret"></i></a>
						<ul class="dropdown-menu">  
							<li><a class="page-scroll" href="viewallresident.php"><strong> View Resident </strong></a></li> 
							<li></li>
						</ul>
					</li>
				</li> 
				<li>
					<li class="dropdown">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown"> </i><strong>Charge</strong>
					<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><a class="page-scroll" href=" "><strong> Create Charge </strong></a></a></li>
							<li class="divider"></li>
							<li><a class="page-scroll" href=" "></i><strong> View Charge </strong></a></li> 
							<li></li>
						</ul>
					</li>
				</li>   
				<li>
					<li class="dropdown">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-user fa-fw"></i><strong>'.$_SESSION['name'].'</strong>
					<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><i class="fa fa-align-right"></i><strong> Role Type</strong></li>
							<ul>
								<li style="text-align:left;">'.$_SESSION['role'].'</li>
							</ul>
							<li class="divider"></li>
							<li><a class="page-scroll" href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
						</ul>
					</li>
				</li>'; 
		}
	}
}
?>