
	<?php 
	  function calendar($file) {
	  	if( !empty($_SESSION) && $_SESSION['user']){  
		   	$is_looged = true;
		   	$user = $_SESSION['user'];
		} else {
			$is_looged = false;
		}

	    if ((isset($_GET['d'])) ? $day = $_GET['d'] : $day = date("d"));
	    if ((isset($_GET['m'])) ? $month = $_GET['m'] : $month = date("m"));
	    if ((isset($_GET['y'])) ? $year = $_GET['y'] : $year = date("Y"));
	    
	    $months_days = array("31","28","31","30","31","30","31","31", "30","31","30","31");
	    $months_name = array("January","February","March","April","May","June","July", "August","September","October","November","December");
	    $days_array = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
	    
	    if (strlen($month) == 1) {
	      $month = str_replace("0","",$month);
	    } else {
	      $month = $month;
	    }
	    
	    $month = $month - 1;
	    $days_in_month = $months_days[$month];
	    $month_name = $months_name[$month];
	    $m = $month + 1;
	    
	    $time = date("M D Y H:i:s", mktime(0, 0, 0, $m, 1, $year));
	    $first_day = explode(" ",$time);
	    $time = $first_day[1];
	    $next = $month + 2;
	    $x = $year;
	    
	    if ($next == 13) {
	      $next = 1;
	      $x = $x + 1;
	    }

	    $prev = $month;
	    $y = $year;
	    
	    if ($prev == 0) {
	      $prev = 12;
	      $y = $y-1;
	    }

	    $calendar = "";
	    $calendar .= '<div class="calendar">' . "\n";
	    $calendar .= '  <div class="monheader">' . "\n";
	    $calendar .= '    <span class="navi_prev"><a class="prev" href="' . $file . '?m=' . $prev . '&amp;y=' . $y . '&amp;d=' . $day . '"><img src="../assets/arrow_left.png" width="50px"></a></span>' . "\n";
	    $calendar .= '    <span class="navi_title">' . $month_name . '/' . $year . '</span>' . "\n";
	    $calendar .= '    <span class="navi_next"><a class="next" href="' . $file . '?m=' . $next . '&amp;y=' . $x . '&amp;d=' . $day . '"><img src="../assets/arrow_right.png" width="50px"></a></span>' . "\n";
	    $calendar .= '  </div>' . "\n";
	    $calendar .= '  <div class="dayheader">Mon</div>' . "\n";
	    $calendar .= '  <div class="dayheader">Tue</div>' . "\n";
	    $calendar .= '  <div class="dayheader">Wed</div>' . "\n";
	    $calendar .= '  <div class="dayheader">Thu</div>' . "\n";
	    $calendar .= '  <div class="dayheader">Fri</div>' . "\n";
	    $calendar .= '  <div class="dayheader">Sat</div>' . "\n";
	    $calendar .= '  <div class="dayheader">Sun</div>' . "\n";

	    # Checks for leap years and add 1 to February
	    if (!($year % 4) && $month === 1) {
	    	$days_in_month++;
	    }
	    $new_time = "";

	    # Find how many blank spaces at beginning of the month
	    foreach ($days_array as $key => $value) {
	    	if ($value == $time) {
	        	$new_time .= $key+1;
		      }
		}
		
	    # Loop through the days in the month
	    for ($k = 1; $k < ($days_in_month+$new_time) || (($k-1) % 7); $k++) {
	    	if ($k < $new_time || $k >= ($days_in_month+$new_time)) {
		      	$calendar .= '  <div class="inactive"></div>' . "\n";
		        continue;
		    }
	      
	    $n = $k - $new_time + 1;
	    $day_url = "day.php?month={$month}&day={$n}";
	    $stay_on_page = "calendar.php?month={$month}&day={$n}";
	    $date = $year . "-" . $m . "-" . $n;
	    #$a = "MONTH($date)";

	    $db = 'first_db';
	    mysql_connect("localhost", "root", "") or die(mysql_error());
	    mysql_select_db("first_db") or die("Cannot connect to database");

	    $option = mysql_real_escape_string(@$_GET['calendar_options']);
	    #$event_month = mysql_real_escape_string(@$_GET['month']);

	    $event = mysql_query("SELECT * FROM events WHERE event_date ='$date' AND type = '$option'") OR (die(mysql_error()));
	    #$event_months = mysql_query("SELECT $a FROM events WHERE $a = $m") OR (die(mysql_error()));
		#$exists_month = mysql_num_rows($event_months);
		
		$exists = mysql_num_rows($event);
		$images = array("../assets/red.png","../assets/yellow.gif", "../assets/light_blue.png", "../assets/green.png", "../assets/purple.png", "../assets/orange.png", "./assets/dark_blue.png", "../assets/pink.png", "../assets/black.png");
		
		if ($exists > 0){
			switch ($option) {
			    case "exam":
			        $image = "<img style='width: 20px; position:right' src='$images[0]'/>";
			        break;
			    case "exercise":
			        $image = "<img style='width: 20px; position:right' src='$images[1]'/>";;
			        break;
			    case "guest lecture":
			        $image = "<img style='width: 20px; position:right' src='$images[2]'/>";
			        break;
			    case "homework":
			        $image = "<img style='width: 20px; position:right' src='$images[3]'/>";
			        break;
			    case "lecture":
			        $image = "<img style='width: 20px; position:right' src='$images[4]'/>";
			        break;
			    case "presentation":
			        $image = "<img style='width: 20px; position:right' src='$images[5]'/>";
			        break;
			    case "referat":
			        $image = "<img style='width: 20px; position:right' src='$images[6]'/>";
			        break;
			    case "other":
			        $image = "<img style='width: 20px; position:right' src='$images[7]'/>";
			        break;
			}
		} else {
			$image = "";
		}

	    if ($n == $day) {
	      	if ($is_looged == true){
	        	$calendar .= '  <div class="today" onclick="window.location.href = \'' . $day_url . '\'">' . $n. "\n". $image.'</div>' . "\n";

	      	} else {
	      		$calendar .= '  <div class="today" onclick="window.location.href = \'' . $stay_on_page . '\'">'. $n . "\n". $image . '</div>' . "\n";
	      	}
	    } else {
	      	if ($is_looged == false){
	        	$calendar .= '  <div class="day" onclick="window.location.href = \'' . $stay_on_page . '\'">'. $n . "\n". $image . '</div>' . "\n";
	      	} else {
	      		$calendar .= '  <div class="day" onclick="window.location.href = \'' . $day_url . '\'">' . $n . "\n". $image . '</div>' . "\n";
	      	}
	      }
	    }
	    $calendar .= '</div>' . "\n";
	    
	    $d = date("d");
	    $m = date("m");
	    $y = date("Y");
	    return $calendar;
	  }
	  $file = basename($_SERVER['PHP_SELF']);
	  echo calendar($file);
	?>