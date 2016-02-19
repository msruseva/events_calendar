<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="../css/main_page.css" >
	</head>
	<body class="page">
	
		<form method="post" action="checklogin.php" class="login">
			<div class='title'>LOG IN</div>

			<p>
		      <label for="login">Name:</label>
		      <input type="text" name="username" id="login" >
		    </p>
		    
		    <p>
		      <label for="password">Password:</label>
		      <input type="password" name="password" id="password">
		    </p>

		    <p class="login_submit">
		      <button type="submit" class="login_button">Login</button>
		    </p>
	  	</form>

	  	<form action="../index.php">
       		<input type="submit" value="Home page" style="margin-right: 25%">
      	</form>

	</body>
</html>