/**
 * 		Grupp 18 - 2012-12-06
 * 	Name:	Erik Larsson
 *	file: 	menu.js
 *	Desc:	javascript controlling menu expanding
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

		//switch menubutton to larger model with text
		var menu = document.getElementsByName('menuItem');
		for(var i = 0; i < menu.length;i++)
		{
			var imgvalue = menu[i].getAttributeNode('src').value;
			imgvalue = imgvalue.substr(0, imgvalue.lastIndexOf('.jpg')) +"_large.jpg";
			menu[i].getAttributeNode('src').value = imgvalue;
		}

		//Animate the menu, minimum width of menu is 100px
		$('div.menu').animate({width:'10%'}, complete=function(){
			$(this).css('min-width', '100px');
		});
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
	console.log(windowWidth/10);
	console.log(mousepos);

	//mouse is outside menu
	if(mousepos > windowWidth/10)
	{

		$('div.menu').css('min-width', '40px');
		$('div.menu').animate({width:'3%'}, complete=function(){

			//Change to smaller menu items
			var menu = document.getElementsByName('menuItem');

			for(var i = 0; i < menu.length;i++)
			{
				var imgvalue = menu[i].getAttributeNode('src').value;
				imgvalue = imgvalue.substr(0, imgvalue.lastIndexOf('_large.jpg')) +".jpg";
				menu[i].getAttributeNode('src').value = imgvalue;
			}
		});
		inMenu = false;
	}
}