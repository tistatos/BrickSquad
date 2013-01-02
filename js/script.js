/**
 *	Grupp 18 - 2012-12-06
 * 	Name:	Daniel Rönnkvist
 * 	file: 	script.js
 * 	Desc:	Generic javascripts for bricksquad
 */

/**
 * Validation for searches
 */

function Validation()
{
	//variables for validating the input
	var form = document.getElementById("form");
	var numeric = /[0-9]-/;
	var falsechars = /\W/; // allow letters, numbers, and underscores

	var year = form.year_set.value;
	var color = form.part_color.value;

	var search = form.searchstring.value;
	var searchtype = form.searchtype.value;

	if(search !== "" || search !== null)
	{
		switch(searchtype)
		{
			case "SetID":
			case "part_id":
				//if the search is not made up by any of the given chars in numeric it will return false
				if(search.value.match(numeric))
				{
					return true;
				}
				else
				{
					alert("Enter valid search!");
					return false;
				}
				break;
			case "set_name":
			case "part_name":
			case "category_name":
				if(search.value.match(falsechars))
				{
					return true;
				}
				else
				{
					alert("Enter valid search!");
					return false;
				}
				break;
			default:
				alert("OOOPS!");
				return false;
				break;
		}	
	}
	else
	{
		alert("Enter something!");
		return false;
	}

	return true;
}


/**
 * Validation for contactform
 */

 function contactvalidate()
{
	//retrieving variables from the form
	var form = document.getElementById("form");
	var email = form.contact_email.value;
	var name = form.contact_name.value;
	var text = form.contact_text.value;

	if(email === "" || name === "" || text === "") 
	{
		alert("Fill in every field!");
		return false;
	}
	//checks if theres any numbers in the name
	if(!isNaN(name))
	{
		alert("Enter a real name!")
		return false;
	}

	//makes sure that the e-mail contains a '@' and a '.' with letters inbetween
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  	{
  		alert("Enter a valid email!");
  		return false;
  	}

  	return true;
}