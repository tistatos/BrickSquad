<?php

  /**
   *    Grupp 18 - 2012-12-28
   *  Name: Daniel Rönnkvist
   *  file:   form.php
   *  Desc: contains logic and layout of the contact form
   *  		uses POST-REDIRECT-GET design to avoid double posting
   */

if(isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_text']))
{
	//POST Data from user
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_text = $_POST['contact_text'];

	if(!empty($contact_name) && !empty($contact_email) && !empty($contact_text))
	{
		//any of the form data is not empty
		if (filter_var($contact_email, FILTER_VALIDATE_EMAIL))
		{
			//Send email to daniel
			$to = 'danro71i@student.liu.se';
			$subject = 'Kontaktformulär Bricksquad';
			$body = 'Namn: ' . $contact_name . "\n" . "\n" . $contact_text;
			$headers = 'From: ' . $contact_email;

			if(mail($to, $subject, $body, $headers))
			{
				//Mail was sent
				header( "location:./contact.php?status=success" );

			}
			else
			{
				//Mail error
				header( "location:./contact.php?status=error" );

			}
		}
		else
		{
			//Error in data in form
			header( "location:./contact.php?status=error" );
		}
	}
	else
	{
		//somehow the client side validation failed
		echo "Something went wrong";
	}
}
else if(isset($_GET['status']))
{
	$status = $_GET['status'];
	if($status == "success")
	{
			echo "<p>Thanks for contacting us! <br />";
			echo "You will be directed in 3 seconds...</p>";
	}
	else
	{
			echo "<p>Something went wrong <br />";
			echo "You will be directed in 3 seconds...</p>";
	}
	header( "refresh:3;url=./contact.php?lalos" );
}
else
{
	//There is no POST-data, so user the form to fill in
	echo '<form id="form" action="contact.php" onsubmit="javascript:return contactValidate();" method="POST">';
	echo 'Name:<br><input type="text" name="contact_name" maxlength="30"><br><br>';
	echo 'Email:<br><input type="text" name="contact_email" maxlength="50"><br><br>';
	echo 'Message:<br>';
	echo '<textarea name="contact_text" rows="6" cols="30" maxlength="750"></textarea><br><br>';
	echo '<input class="button" type="submit" value="Send">';
	echo '</form>';
}

?>