<html>
<head>
	<title>LEGO</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="script.js"></script>
	
	<?php
	mysql_connect("mysql.itn.liu.se", "lego", "");
	mysql_select_db("lego");
	// Från formuläret, om man trycker på "submit"-knappen, kommer
	// variablen $POST["setnr"] som innehåller texten i fältet "setnr".
	if(!$_GET == "")
	{
	$setnr = $_GET["setnr"];
	}
	require("Fetch_image.php");
	?>
</head>
<body>
	<div class="menu" id="menu" onmouseover="menuFold();">
		<table border="0">
		<tr>
		<td class="menu">READY</td>
		</tr>
		<tr>
		<td class="menu">SET</td>
		</tr>
		<tr>
		<td class="menu">GO!</td>
		</tr>
		</table>
	</div>

	<div class="search" id="search">
		<form action="layout.php" method=GET name="form">
			Common Set ID:<input type="text" size="40" name="setnr" />
			<input type=submit value="Submit" />
			</br>
			Specific Set ID:<input type="text" size="40" name="setnr_specific" />
			<input type=submit value="Submit" />
		</form>
	</div>

	<div class="list" id="list">
		<p>
	<?php
	//common
	//Hämtar och skriver ut common-sets sökningen
	if(!$_GET == "")
	{
		$setnr = $_GET["setnr"];
		$setnr_specific = $_GET["setnr_specific"];
		
		$contents = mysql_query("SELECT SetID, Setname FROM sets WHERE SetID LIKE '$setnr-%'");
	   if(mysql_num_rows($contents) == 0 && $setnr_specific == "")									//fixa så tabellen försvinner!!!!!!!!!!!!!!!!!!!
	   {
	      print("Inga satser funna!");
	   }
	   else
	   {
	      print("<table border=1>\n<tr>");
	      for($i=0; $i<mysql_num_fields($contents); $i++)
	      {
	         $fieldname = mysql_field_name($contents, $i);
	         print("<th>$fieldname </th>");
			 
	      }
	      print "</tr>\n";

	      while($row = mysql_fetch_row($contents))
	      {
	         print("<tr>");
			 
	         for($i=0; $i<mysql_num_fields($contents); $i++)
	         {
			 
					print("<td><a href='./layout.php?setnr=&setnr_specific=$row[$i]'> $row[$i]</a></td>");
					
	         }
	         print("</tr>\n");
	      } 
	      print("</table>\n");
	   }
	  }
	?>
	<?php
	//specific
	//Hämtar och skriver ut specifiksökningsresultatet ex 1695-1
		if(!$_GET == "")
	{
		$setnr_specific = $_GET["setnr_specific"];
		
		$contents = mysql_query("SELECT * FROM sets WHERE 1 AND SetID ='" . $setnr_specific ."'");
	   if(mysql_num_rows($contents) == 0 && $setnr == "")													//fixa så tabellen försvinner!!!!!!!!!!
	   {
	      print("Inga satser funna!");
	   }
	   else
	   {
	      print("<table border=1>\n<tr>");
	      for($i=0; $i<mysql_num_fields($contents); $i++)
	      {
	         $fieldname = mysql_field_name($contents, $i);
	         print("<th>$fieldname</th>");
	      }
	      print "</tr>\n";

	      while($row = mysql_fetch_row($contents))
	      {
	         print("<tr>");
	         for($i=0; $i<mysql_num_fields($contents); $i++)
	         {
	            print("<td><a href='./layout.php?setnr_specific=$row[$i]'> $row[$i]</a></td>");
	         }
	         print("</tr>\n");
	      } 
	      print("</table>\n");
	   }
	  }
		
	?>
</p>
	</div>

	<div class="selected" id="selected">
		<center>
		<?php
		//bild för satser
		if(!$_GET == "")
		{
		
		if(!$setnr == "")
		{
		$site = "http://www.bricklink.com/SL/" . $setnr ."-1.jpg" ; // visar alltid första i setordningen
		print("<img class='select' src=$site>");
		print("</br> <p>Satsnummer: $setnr-1</p> ");
		}
		
		else{
		$site = "http://www.bricklink.com/SL/" . $setnr_specific .".jpg OR .png OR .gif" ; // bild för setnumber specifik
		print("<img class='select' src=$site>");
		}
		}
		?>
		</br>
		<table border="0">
		<tr>
		<td>Lite info</td>
		<td>lite mer info</td>
		</tr>
		<tr>
		<td>INFORMATION</td>
		<td>LEGO IS FUN</td>
		</tr>
		</table></center>
	</div>

	<div class="is" id="is">
		
		
		
	<?php
		if(!$_GET == "")
		{
		  		  
	//klossar som ingår i satsen
	$contents = mysql_query("SELECT inventory.SetID, inventory.Quantity, colors.Colorname, parts.Partname
      FROM inventory
      JOIN parts ON inventory.ItemID = parts.PartID
      JOIN colors ON inventory.ColorID = colors.ColorID
      WHERE inventory.SetID LIKE '$setnr-%' OR SetID ='" . $setnr_specific ."'
      ORDER BY SetID, Partname ");  
		  
   
   if(mysql_num_rows($contents) == 0)
   {
      print("Ingen detaljerad information funnen!");
   }
   else
   {
      print("<table border=1>\n<tr>");
      print("<th>SetID</th> <th>Qty</th>  <th>Color</th>  <th>Name</th>  <th>Image</th> ");
      print "</tr>\n";
	 
      while($row = mysql_fetch_row($contents))
      {
         print("<tr>");
		
         for($i=0; $i<mysql_num_fields($contents); $i++)
         {
           if($i == 2){
			  $COLOR_NAME = $row[$i];
			  }
				
					if($i == 3)
					{
					$PART_NAME = $row[$i];
					 
					$PART_ID = mysql_query("SELECT PartID From parts WHERE Partname ='" . $PART_NAME ."'");
					$minifig_ID = mysql_query("SELECT MinifigID FROM minifigs where Minifigname = '". $PART_NAME ."'");
					
					$part_row = mysql_fetch_row($PART_ID);
						
					
					$COLOR_ID = mysql_query("SELECT colors.ColorID, colors.Colorname FROM inventory 
								JOIN colors ON inventory.ColorID = colors.ColorID 
								JOIN parts ON inventory.ItemID = parts.PartID
								WHERE PartID = '". $part_row[0] ."' AND Colorname = '". $COLOR_NAME ."'");
					print("<td><a href='./layout.php?setnr_specific=$row[$i]'> $row[$i]</a></td>");
					$color_row = mysql_fetch_row($COLOR_ID);
					
					
					$image_Query = mysql_query("SELECT filepath FROM `images` WHERE filepath= 'P/". $color_row[0]. "/".$part_row[0].".gif' AND isthere=TRUE");
					$imageRow = mysql_fetch_row($image_Query);
					
					
					
					$minifigRow = mysql_fetch_row($minifig_ID);
					
					if($imageRow != null)
					{
						$imglink = "http://img.bricklink.com/" . $imageRow[0];
						print("<td><img src='$imglink' alt='gif-image' /></td>");
						//error_reporting(0);
					}
						
					
					else
					{
					validate_image($part_row[0], $color_row[0]);
						
					}
				
					
					if($minifigRow != null)
					{
					
						print($PART_NAME);
						$imglink_minifig = "http://img.bricklink.com/M/ ". $minifigRow[0].".gif";
						print("<td><img src='$imglink_minifig' alt='gif-image' /></td>");
					}
					
					
					/*
					
					else if
					{
						validate_image($part_row[0], $color_row[0]);
					}
					
					else 
					{
					 return 0;
					}
					*/
					
					
					/*
					validate_image($part_row[0], $color_row[0]);
					
					Debugg
					print($part_row[0].'<br />');
					
					print($part_row[0]);
					
					print($COLOR_NAME);
					
					for($j = 0; $j < mysql_num_fields($COLOR_ID); $j++)
					{
						print(($color_row[0]). '<br />' ); 
					}
					*/
					 
					 
					   
					print("<td>$color_row[0]</td>");
					
					
				
				else
				{
				print("<td>$row[$i]</td>");
				}
			
				SELECT inventory.SetID, inventory.Quantity, minifigs.MinifigID, minifigs.minifigname
				FROM inventory
				JOIN minifigs ON inventory.ItemID= minifigs.MinifigID
				WHERE inventory.SetID= '1712-1'
	
			
         }
         print("</tr>\n");
      }
      print("</table>\n");
   }
}
?>
	</div>
</body>
</html>