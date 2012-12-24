/**
*	Grupp 18 - 2012-12-06
* 	Name:	Erik Larsson
*  	file: 	menu.js
*  Desc:	javascript controlling menu expanding
*
*  !!!NO Longer implemented with new layout!!!
*/

//are mouse pointer within menu borders
var inMenu = false;

/**
 * Mouse enter area of menu
 */
function menuMouseEnter()
{
	if(!inMenu)
	{
		inMenu = true;
		$('div.menu').animate({width:'140px'});
	}
}

/**
 * Mouse exits menu area
 */
function menuMouseExit()
{

	//If mouse hover over menu item, it has left the menu area
	//to avoid the menu closing we check if we're within the 10% that the window
	var mousepos = window.event.clientX;
	var windowWidth = document.body.clientWidth;

	//mouse is outside menu
	if(mousepos >= 120)
	{
		$('div.menu').animate({width:'40px'});
		inMenu = false;
	}
}

/**
 * Close menu after 500ms when a new page has been loaded
 */
function menuAutoClose()
{
	setTimeout(function(){
	if(!inMenu)
	{
		//$('div.menu').animate({width:'40px'});
	}
	},500);
}