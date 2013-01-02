<?php

  /**
   *    Grupp 18 - 2012-12-28
   *  Name: Daniel Rönnkvist
   *  file:   form.php
   *  Desc: contains logic and layout of the contact form
   */

if(isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_text']))
{
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_text = $_POST['contact_text'];

	if(!empty($contact_name) && !empty($contact_email) && !empty($contact_text))
	{
		if (filter_var($contact_email, FILTER_VALIDATE_EMAIL))
		{
			$to = 'danro716@student.liu.se';
			$subject = 'Kontaktformulär Bricksquad';
			$body = 'Namn: ' . $contact_name . "\n" . "\n" . $contact_text;
			$headers = 'From: ' . $contact_email;

			if(mail($to, $subject, $body, $headers))
			{
				echo "Thanks for contacting us!";
			}
			else
			{
				echo "Something went wrong";
			}
		}
		else
		{
			echo "Something went wrong";
		}
	}
	else
	{
		echo "Something went wrong";
	}
}
else
{
	echo '<form id="form" action="contact.php" onsubmit="javascript:return contactValidate();" method="POST">';
	echo 'Name:<br><input type="text" name="contact_name" maxlength="30"><br><br>';
	echo 'Email:<br><input type="text" name="contact_email" maxlength="50"><br><br>';
	echo 'Message:<br>';
	echo '<textarea name="contact_text" rows="6" cols="30" maxlength="750"></textarea><br><br>';
	echo '<input class="button" type="submit" value="Send">';
	echo '</form>';
}

?>