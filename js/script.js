	/**
 *	Grupp 18 - 2012-12-06
 * 	Name:	Daniel Rönnkvist
 * 	file: 	script.js
 * 	Desc:	Generic javascripts for bricksquad website
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
 * Validate contact form
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

	//Validate that user has written a proper email adress
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
	var searchType = form.searchType.value;
	if(searchString == "")
	{
		//No input from user
		alert("Please specify what you're searching for!");
		return false;
	}
	else if(searchString.length < 2)
	{
		//user has written a string that is two characters or less
		//to avoid the database to handle too much data, user must
		//be more specific
		alert("Please make your search more specific!");
		return false;
	}
	return true;
}
/**
 * paging and scrolling system for search result
 */
function scrollResult(pageNumber)
{
	var pixelmove = 0;
	var resultHeight = 85;
	var resultsPerPage = 11;
	//Calculate how much the div must move to show the next 11 results
	pixelmove = pageNumber * resultsPerPage * resultHeight * -1;

	//Write it to the div
	document.getElementById("searchResult").style.top = pixelmove+'px';
}