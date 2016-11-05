	function validateForm() {
		return passwordMatch();
	}
	
	function passwordMatch() {
    
		var password1 = document.forms["myForm"]["password1"].value;
		var password2 = document.forms["myForm"]["password2"].value;
		
		if (password1 == password2) {
			document.getElementById("password2").className = 'form-control match';
			return true;
		} 
		else{
			document.getElementById("password2").className = 'form-control error';
			return false;
		}
	}