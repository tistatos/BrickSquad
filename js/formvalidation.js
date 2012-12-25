function validate()
{
	var form = document.getElementById("form");
	var email = form.contact_email.value;
	var name = form.contact_name.value;
	var text = form.contact_text.value;

	if(email === "" || name === "" || text === "") 
	{
		alert("Fill in every field!");
		return false;
	}
	if(!isNaN(name))
	{
		alert("Enter a real name!")
		return false;
	}

	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  	{
  		alert("Enter a valid email!");
  		return false;
  	}

  	return true;
}