<html>
<head>
	<title>LEGO</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<script type="text/javascript" src="./js/script.js"></script>
	<?php
	//Change this to false to use School database
	$DEBUG = true;
	//Start connection to SQL-Servers
	require("./config/sqlconfig.php");

	// Från formuläret, om man trycker på "submit"-knappen, kommer
	// variablen $POST["setnr"] som innehåller texten i fältet "setnr".
	if(!$_POST == "")
	{
		$setnr = $_POST["setnr"];
	}
	?>
</head>
<body>
	<?php
		require("./templates/menu.php");
	?>

	<div class="search" id="search">
		<form action="layout.php" method=POST name="form">
			Set ID:<input type="text" size="40" name="setnr" />
			<input type=submit value="Submit" />
		</form>
	</div>

	<div class="list" id="list">
		<p>
	<?php
	if(!$_POST == "")
	{
		$contents = mysql_query("SELECT SetID, Setname FROM sets WHERE SetID LIKE '$setnr-%'");
	   if(mysql_num_rows($contents) == 0)
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
	            print("<td>$row[$i]</td>");
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
		if(!$_POST == "")
		{
		$site = "http://www.bricklink.com/SL/" . $setnr . "-1.jpg";
		print("<img class='select' src=$site>");
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
		if(!$_POST == "")
		{
   $contents = mysql_query("SELECT inventory.SetID, inventory.Quantity, colors.Colorname, parts.Partname
      FROM inventory
      JOIN parts ON inventory.ItemID = parts.PartID
      JOIN colors ON inventory.ColorID = colors.ColorID
      WHERE inventory.SetID LIKE '$setnr-%'
      ORDER BY SetID, Partname");

   if(mysql_num_rows($contents) == 0)
   {
      print("Ingen detaljerad information funnen!");
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
            print("<td> <a href='$row[$i].html'> $row[$i]</a></td>");
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