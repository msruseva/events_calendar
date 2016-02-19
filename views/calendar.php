<!DOCTYPE html>
<html>
	<head>
		<title>Calender</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="../css/calendar_page.css">
		<link rel="stylesheet" href="../css/months_page.css" type="text/css">
	</head>
		<?php
		   session_start();
		   if( !empty($_SESSION) && $_SESSION['user']){  
			   	$is_looged = true;
			   	$user = $_SESSION['user'];
		   } else {
		   		$is_looged = false;
		   }
	   ?>
		<body>
			<?php if ($is_looged): ?>
        		<button onclick="window.location.href = 'logout.php'">Log out</button>
        		<center><div class="hello">Hello, <?=$user?></div>
        		<?php else: ?>
        			<button onclick="window.location.href = '../index.php'">Home page</button>
        	<?php endif ?>

			<fieldset class="month_picker_fieldset">
				<?php foreach( range(1, 12) as $month ) { ?>
			      <label class="month_picker_label <?= $month == $_GET['month'] ? 'active' : '' ?>" >
			      	<input type="radio" name="month" value="<?= $month ?>" id="month" onclick="window.location.href = 'calendar.php?month=<?= $month ?>'">
			      	<?= date('F', strtotime("2016-$month-01")) ?>
			      </label>
			  	<?php } ?>
		    </fieldset>

		    <?php include("calendar_months.php"); ?>

		    <form action="calendar.php">
				<select name="calendar_options" style="margin-left: 60px; margin-top: 100px">
						<option>Events</option>
			      		<?php
					        $options = array("exam", "exercise", "guest lecture", "homework", "lecture", "presentation", "referat", "other");
							foreach ($options as $option) {
								$selected = $option == $_GET['calendar_options'] ? 'selected' : '';
								echo "<option $selected value=\"" . $option . "\">" . $option . "</option>";
							}
			        	?>
				</select>
				<button type="submit">Show me</button>
			</form>

			<!--<form action="event_information.php">
				<button type="submit" style="margin-left: 100px">More information</button>
			</form>
			!-->

		</body>
</html>