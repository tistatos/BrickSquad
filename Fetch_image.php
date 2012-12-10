
<?php

			function validate_image($Part, $Color){
			$site = "http://www.bricklink.com/";
			$gif_url = $site . "P/" . $Color .  "/" . $Part . ".gif";
			$jpg_url = $site . "P/" . $Color .  "/" . $Part . ".jpg";
						
						
						
				if (@fclose(fopen($gif_url, "r")))
				{
				print("<td><img src='$gif_url' alt='gif-image' /></td>");
						  //error_reporting(0);
				}
				else if (@fclose(fopen($jpg_url, "r")))
				{
					print("<td><img src='$jpg_url' alt='jpg-image' /></td>");
					//error_reporting(0);
				}
				else
				{
					print("<td> .PNG fil </td>"); 
				}
			}
?>
