<?php 

	function is_logged_in()
	{
		if(isset($_SESSION['loggedin']))
			if($_SESSION['loggedin'] == true)
				return true;
	}
	
?>