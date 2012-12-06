var count = 2;
function menuFold()
{
	if(isEven(count))
	{
		count++;
		document.getElementById("menu").style.width="4%";
		document.getElementById("search").style.width="96%";
		document.getElementById("list").style.width="32%";
		document.getElementById("selected").style.width="32%";
		document.getElementById("is").style.width="32%";	
	}
	else
	{
		count++;
		document.getElementById("menu").style.width="13%";
		document.getElementById("search").style.width="87%";
		document.getElementById("list").style.width="29%";
		document.getElementById("selected").style.width="29%";
		document.getElementById("is").style.width="29%";	
	}
}
function searchFold()
{
	if(isEven(count))
	{
		count++;
		document.getElementById("search").style.height="5%";
		document.getElementById("list").style.height="95%";
		document.getElementById("selected").style.height="95%";
		document.getElementById("is").style.height="95%";	
	}
	else
	{
		count++;
		document.getElementById("search").style.height="25%";
		document.getElementById("list").style.height="75%";
		document.getElementById("selected").style.height="75%";
		document.getElementById("is").style.height="75%";	
	}
}
function isEven(value)
{
	if(value%2 == 0)
		return true;
	else
		return false;
}
function searchHold()
{
	if (document.getElementById("search").style.height == "25%") 
	{
		document.getElementById("search").style.height="25%";
		document.getElementById("list").style.height="75%";
		document.getElementById("selected").style.height="75%";
		document.getElementById("is").style.height="75%";
	}
	else
	{
		document.getElementById("search").style.height="5%";
		document.getElementById("list").style.height="95%";
		document.getElementById("selected").style.height="95%";
		document.getElementById("is").style.height="95%";
	}
}