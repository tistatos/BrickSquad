/**
 * 		Grupp 18 - 2012-12-06
 * 	Name:	Erik Larsson
 *	file: 	menu.js
 *	Desc:	javascript for menu animation
 *
 */
var inMenu = false;

function menuMouseEnter()
{
	if(!inMenu)
	{
		inMenu = true;
		$('div.menu').animate({width:'10%'},complete=function()
			{
				$('div.menu').css('min-width', '100px');
			});

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
		$('div.menu').css('min-width', 0);
		console.log("exit!");
		inMenu = false;
	}
}