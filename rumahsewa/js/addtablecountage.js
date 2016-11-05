
	function addTable() {
		var table = document.getElementById("myTable");

		var rowCount = table.rows.length; 
		var row = table.insertRow(rowCount);
		var rowCount = rowCount - 1;

		var cell1 = row.insertCell(0);
		cell1.innerHTML = rowCount + 1;
			
		var cell2 = row.insertCell(1);
		var element1 = document.createElement("input");
		element1.type = "text";
		element1.name = "d_name[]";
		element1.className = "form-control";
		cell2.appendChild(element1);
 
		var cell3 = row.insertCell(2);
		var element2 = document.createElement("input");
		element2.type = "text";
		element2.name = "d_age[]";
		element2.className = "form-control";
		cell3.appendChild(element2);
			
		var cell4 = row.insertCell(3);
		var element3 = document.createElement("input");
		element3.type = "text";
		element3.name = "d_notes[]";
		element3.className = "form-control";
		cell4.appendChild(element3);
	}
	 
	function deleteTable() {
			var table = document.getElementById("myTable");
			var rowCount = table.rows.length;
			
			if(rowCount == 1)
				alert("Cannot delete all the table")
			else
			{
				var delRow = rowCount - 1;
				table.deleteRow(delRow);
			}
	}
	
	function countAge(){ 
		var IC = document.getElementById("ic").value; //940703115331
		var age = IC.substr(0,2);
		var month = IC.substr(2,2);
		var day = IC.substr(4,2);
		var age = parseInt(age);
		var d = new Date();
		var year = d.getFullYear();
		if(age>50)
		{
			var yearAge = age + 1900;
			var age = year - yearAge;
			
		}
		else if(age<50)
		{
			var yearAge = age + 2000;
			var age = year - yearAge;
		}
		document.getElementById('age').value = age;
		var dob = day+"/"+month+"/"+yearAge;
		document.getElementById('birthdate').value = dob;
	} 
	
	function countAge2(){ 
		var IC = document.getElementById("ic2").value;
		var age = IC.substr(0,2);
		var age = parseInt(age);
		var d = new Date();
		var year = d.getFullYear();
		if(age>30)
		{
			var age = age + 1900;
			var age = year - age;
		}
		else if(age<=30)
		{
			var age = age + 2000;
			var age = year - age;
		}
		document.getElementById('age2').value = age;
	} 