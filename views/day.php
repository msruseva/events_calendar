<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		session_start();
		$type = $_POST["options_calendar"];
		$comment = $_POST["comment"];
		$day = $_POST["day"];
		$month = $_POST["month"];
		$year = $_POST["year"];
		$date = $year . "-" . $month . "-" . $day;
		$author = $_SESSION['user_id'];
		$successful = true;

		print "<script> console.log('".$date."'); </script>";

		mysql_connect("localhost:8080", "root", "") or die (mysql_error());
	    mysql_select_db("first_db") or die ("Cannot connect to database");

	    if ($successful){
			mysql_query("INSERT INTO events (type, comment, event_date, author_id) VALUES ('$type', '$comment', '$date', '$author')");
	      	print '<script>alert("Successfully add event.");</script>';
	      	print '<script>window.location.assign("day.php");</script>';
	    }

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Event</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../css/day_page.css" >
</head>
	<body class="page">
	<form method="post" action="day.php">
		<div class="options">Event:
		    <input type="text" name="options_calendar" list="options" required>
		    <datalist id="options">
		      	<?php
			        $options = array("exam", "exercise", "guest lecture", "homework", "lecture", "presentation", "referat", "other");
					foreach ($options as $option) {
					echo "<option value=\"" . $option . "\">" . $option . "</option>";
					}
		        ?>
			</datalist>
		</div>

		<div class="comment">Type your comment:
			<div>
			<textarea name="comment" rows="4" cols="50" required></textarea>
			</div>
		</div>
		
		<div id="event_date" class="date"> Date:
			<select id="event_date" name="day" required>
				<option>Day</option>
	    		<?php
					for ($d=1; $d<=31; $d++) {
					    echo "<option value=\"" . $d . "\">" . $d. "</option>";
					}
	            ?>
			</select>

			<select id="event_date" name="month" required>
            	<option>Month</option>
	            <?php
		            $months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
					foreach ($months as $month) {
						$selected = $month == $_GET['months'] ? 'selected' : '';
					    echo "<option $selected value=\"" . $month . "\">" . $month . "</option>";
					}
	            ?>
            </select>

			<select id="event_date" name="year" required>
				<option>Year</option>
	    		<?php
					for ($y=2016; $y<=2017; $y++) {
					    echo "<option value=\"" . $y . "\">" . $y . "</option>";
					}
	            ?>
			</select>
		</div>
		
		<center><button type="submit">Submit</button></center>
		<input type="submit" value="Back" onclick="window.location.href = 'calendar.php'">
	</form>
	</body>
</html>