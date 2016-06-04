<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SignUp Page</title>

	

</head>
<body>

<div id="container">
	<h1>SignUp</h1>

<?php
	echo form_open("main/signup_validation");
	echo validation_errors();
	
	echo "<p>";
	echo form_label("E-Mail");
	echo form_input("email",$this->input->post('email'));
	echo "</p>";
	echo "<p>";
	echo form_label("Password");
	echo form_password("password","test");
	echo "</p>";
	echo "<p>";
	echo form_label("Confirm Password");
	echo form_password("cpassword","test");
	echo "<p>";
	echo "<p>";
	echo form_submit("login_submit","Login");
	echo "</p>";
	echo form_close();
	?>


	</div>

</body>
</html>