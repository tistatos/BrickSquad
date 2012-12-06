var inMenu = false;

function menuMouseEnter()
{
	if(!inMenu)
	{
		inMenu = true;
		$('div.menu').animate({width:'10%'});
	}
}

function menuMouseExit()
{
	var mousepos = window.event.clientX;
	var windowWidth = document.body.clientWidth;
	console.log(windowWidth/10);
	console.log(mousepos);
	if(mousepos > windowWidth/10)
	{
		$('div.menu').animate({width:'3%'});
		console.log("exit!");
		inMenu = false;
	}
}