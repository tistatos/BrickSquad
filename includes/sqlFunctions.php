<?php
	/**
	 * 		Grupp 18 - 2012-12-10
	 * 	Name:	Erik Larsson
	 *	file: 	sqlFunctions.php
	 *	Desc:	functions for handling SQL replies
	 */


function CreateTable($sqlQuery)
{
	if(mysql_num_rows($sqlQuery) == 0)
	{
		//Query is empty
		echo("Inga satser funna!");
	}
	else
	{
		echo("<table border=1>\n");
		echo("<tr>");
		for($i=0; $i<mysql_num_fields($sqlQuery); $i++)
		{
			$fieldname = mysql_field_name($sqlQuery, $i);
			echo("<th>$fieldname</th>");
		}
		echo "</tr>\n";

		while($row = mysql_fetch_row($sqlQuery))
		{
			echo('<tr onclick="location.href=\'./search.php?setnr=&setnr_specific='.$row[0].'\'">');
			for($i=0; $i<mysql_num_fields($sqlQuery); $i++)
			{
				echo("<td>$row[$i]</td>");
			}
			echo("</tr>\n");
		}
			echo("</table>\n");
}
}