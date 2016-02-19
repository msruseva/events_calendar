<?php
	session_start();
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$password = hash("sha256", $password);

	mysql_connect("localhost", "root","") or die(mysql_error());
	mysql_select_db("first_db") or die("Cannot connect to database");
	$query = mysql_query("SELECT * from users WHERE username='$username'");
	$exists = mysql_num_rows($query);
	$table_users = "";
	$table_password = "";

	if($exists > 0)
	{
		$row = mysql_fetch_assoc($query);
		
		if(($username == $row['username']) && ($password == $row['password']))
		{	
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user'] = $username;
			header("location: calendar.php");
		}
		else
		{
			echo '<script>alert("Incorrect Password!");</script>';
			echo '<script>window.location.assign("login.php");</script>';
		}
	}
	else
	{
		echo '<script>alert("Incorrect Username!");</script>';
		echo '<script>window.location.assign("login.php");</script>';
	}
?>