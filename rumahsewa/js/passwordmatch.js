function passwordmatch() {
$("input#password2").on("focus keyup", function () {
        var score = 0;
        var a = $(this).val();
        var desc = new Array();
		var password1 = document.forms["myForm"]["password1"].value;
		var password2 = document.forms["myForm"]["password2"].value;
 
        $("#pwd_match_wrap").fadeIn(400);
		
        if(password2 == password1) {
                //show strength text
                $("#passwordDescriptionMatch").text("Password match");
                $("#match").removeClass("invalid").addClass("valid");
				return true;
        } else {
                $("#passwordDescriptionMatch").text("Password not match");
                $("#match").removeClass("valid").addClass("invalid");
				return false;
        }
});
 
$("input#password2").blur(function () {
        $("#pwd_match_wrap").fadeOut(1);
});
}