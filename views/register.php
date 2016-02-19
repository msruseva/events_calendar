<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysql_real_escape_string($_POST["username"]);
    $password = mysql_real_escape_string($_POST["password"]);
    $password = hash("sha256", $password);
    $successful = true;

    mysql_connect("localhost:8080", "root", "") or die (mysql_error());
    mysql_select_db("first_db") or die ("Cannot connect to database");

    $query = mysql_query("SELECT * FROM users");

    while($row = mysql_fetch_array($query))
    {
      $table_users = $row["username"];
      if ($username == $table_users){
        $successful = false;
        print '<script>alert("Username has been taken!"); </script>';
        print '<script>window.location.assign("register.php"); </script>';
      }
    }

    if ($successful){
      mysql_query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
      print '<script>alert("Successfully registered.");</script>';
      print '<script>window.location.assign("login.php");</script>';
    }
  }

?>

<html>
    <head>
        <title>My first PHP Website</title>
        <link rel="stylesheet" href="../css/main_page.css" >
    </head>
    <body class="page">

        <form method="post" action="register.php" class="login">
          <div class='title'>REGISTER PAGE</div>
          <p>
            <label for="login">Name:</label>
            <input type="text" name="username" required="required" >
          </p>

          <p>
            <label for="password">Password:</label>
            <input type="password" name="password" required="required">
          </p>

          <p class="login_submit">
            <button type="submit" class="login_button">Register</button>
          </p>
        </form>

        <form action="login.php">
          <input type="submit" value="Go to log in" style='margin-right: 25%'>
        </form>
    </body> 
</html>