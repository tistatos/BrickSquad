	/**
 *	Grupp 18 - 2012-12-06
 * 	Name:	Daniel Rönnkvist
 * 	file: 	script.js
 * 	Desc:	Generic javascripts for bricksquad
 */

/**
 * making "year" available in searches
 */
function dropDownChange()
{
	var form = document.getElementById("searchForm");
	var menu = form.searchType;
	var year = form.searchYear;
	var selection = menu.options[menu.selectedIndex].value;

	if(selection == "partID" || selection == "partName")
	{
		//Year is not interesting when we look at parts
		year.disabled = true;
	}
	else
	{
		year.disabled = false;
	}

}
/**
 * 	Validate contact form
 */
function contactValidate()
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
		alert("Enter a real name!");
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

/**
 * Validate search strings
 */
function searchValidate()
{
	var form = document.getElementById("searchForm");
	var searchString = form.searchString.value;

	if(searchString == "")
	{
		alert("Please specify what you're searching for!");
		return false;
	}
	else if(searchString.length < 2)
	{
		alert("Please make your search more specific!");
		return false;
	}
	return true;
}
