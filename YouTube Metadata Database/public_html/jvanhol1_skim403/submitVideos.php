<body>
	<html>
		<body>
			<h2>Query Results</h2>
			<form action='videos.html' method='post'>
			<input type='submit' value='Submit New Query'>
			</form>
			<form action='home.html' method='post'>
			<input type='submit' value='Return to Home'>
			</form>
		</body>
	</html>
	<?php
		header('Content-Type: text/html; charset=utf-8');
		include('open.php');

		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', false);
		ini_set('error_log', '/tmp/php.log');
		error_log('hi');

		$MAX_RESULTS = $_POST['MAX_RESULTS'];
		$MAX_RESULTS_INT = 2147483647;
		$VIDEO_ID = $_POST['VIDEO_ID'];
		$AUTH_ID = $_POST['AUTH_ID'];
		$TITLE_CONTAIN = $_POST['TITLE_CONTAIN'];
                $TITLE_NOT_CONTAIN = $_POST['TITLE_NOT_CONTAIN'];
		$TITLE_EXCEED = $_POST['TITLE_EXCEED'];
                $TITLE_EXCEED_INT = -1;
                $TITLE_LESS = $_POST['TITLE_LESS'];
                $TITLE_LESS_INT = -1;
		$TITLE_ALL_CAPS = $_POST['TITLE_ALL_CAPS'];
		$TITLE_ALL_CAPS_BOOL = 0;
                $DESC_CONTAIN = $_POST['DESC_CONTAIN'];
                $DESC_NOT_CONTAIN = $_POST['DESC_NOT_CONTAIN'];
                $DESC_EXCEED = $_POST['DESC_EXCEED'];
                $DESC_EXCEED_INT = -1;
                $DESC_LESS = $_POST['DESC_LESS'];
                $DESC_LESS_INT = -1;
		$DESC_ALL_CAPS = $_POST['DESC_ALL_CAPS'];
		$DESC_ALL_CAPS_BOOL = 0;
                $BEFORE = $_POST['BEFORE'];
                $BEFORE_DATE = '2500-01-01 00:00:00';
                $AFTER = $_POST['AFTER'];
                $AFTER_DATE = '1900-01-01 00:00:00';
		$VIEW_EXCEED = $_POST['VIEW_EXCEED'];
                $VIEW_EXCEED_INT = -1;
                $VIEW_LESS = $_POST['VIEW_LESS'];
                $VIEW_LESS_INT = -1;
		$LIKE_EXCEED = $_POST['LIKE_EXCEED'];
		$LIKE_EXCEED_INT = -1;
		$LIKE_LESS = $_POST['LIKE_LESS'];
		$LIKE_LESS_INT = -1;
		$DISLIKE_EXCEED = $_POST['DISLIKE_EXCEED'];
		$DISLIKE_EXCEED_INT = -1;
		$DISLIKE_LESS = $_POST['DISLIKE_LESS'];
		$DISLIKE_LESS_INT = -1;
		$COM_EXCEED = $_POST['COM_EXCEED'];
                $COM_EXCEED_INT = -1;
                $COM_LESS = $_POST['COM_LESS'];
                $COM_LESS_INT = -1;
		$DURATION_EXCEED = $_POST['DURATION_EXCEED'];
		$DURATION_EXCEED_INT = -1;
		$DURATION_LESS = $_POST['DURATION_LESS'];
		$DURATION_LESS_INT = -1;
		$CATEGORY = $_POST['CATEGORY'];
		$SORT = $_POST['SORT'];
                $SORT_DIR = $_POST['SORT_DIR'];
		$GET_COUNT = $_POST['GET_COUNT'];
                $GET_COUNT_BOOL = 0;
                $GET_PER = $_POST['GET_PER'];
                $GET_PER_BOOL = 0;
		$AVE_VIEW = $_POST['AVE_VIEW'];
                $AVE_VIEW_BOOL = 0;
                $MAX_VIEW = $_POST['MAX_VIEW'];
                $MAX_VIEW_BOOL = 0;
                $MIN_VIEW = $_POST['MIN_VIEW'];
                $MIN_VIEW_BOOL = 0;
                $STD_VIEW = $_POST['STD_VIEW'];
                $STD_VIEW_BOOL = 0;
		$AVE_LIKE = $_POST['AVE_LIKE'];
		$AVE_LIKE_BOOL = 0;
		$MAX_LIKE = $_POST['MAX_LIKE'];
		$MAX_LIKE_BOOL = 0;
		$MIN_LIKE = $_POST['MIN_LIKE'];
		$MIN_LIKE_BOOL = 0;
		$STD_LIKE = $_POST['STD_LIKE'];
		$STD_LIKE_BOOL = 0;
		$AVE_DISLIKE = $_POST['AVE_DISLIKE'];
		$AVE_DISLIKE_BOOL = 0;
		$MAX_DISLIKE = $_POST['MAX_DISLIKE'];
		$MAX_DISLIKE_BOOL = 0;
		$MIN_DISLIKE = $_POST['MIN_DISLIKE'];
		$MIN_DISLIKE_BOOL = 0;
		$STD_DISLIKE = $_POST['STD_DISLIKE'];
		$STD_DISLIKE_BOOL = 0;
		$AVE_COM = $_POST['AVE_COM'];
                $AVE_COM_BOOL = 0;
                $MAX_COM = $_POST['MAX_COM'];
                $MAX_COM_BOOL = 0;
                $MIN_COM = $_POST['MIN_COM'];
                $MIN_COM_BOOL = 0;
                $STD_COM = $_POST['STD_COM'];
                $STD_COM_BOOL = 0;
		$AVE_DATE = $_POST['AVE_DATE'];
                $AVE_DATE_BOOL = 0;
                $MAX_DATE = $_POST['MAX_DATE'];
                $MAX_DATE_BOOL = 0;
                $MIN_DATE = $_POST['MIN_DATE'];
                $MIN_DATE_BOOL = 0;
                $STD_DATE = $_POST['STD_DATE'];
                $STD_DATE_BOOL = 0;
		$AVE_TITLE = $_POST['AVE_TITLE'];
                $AVE_TITLE_BOOL = 0;
                $MAX_TITLE = $_POST['MAX_TITLE'];
                $MAX_TITLE_BOOL = 0;
                $MIN_TITLE = $_POST['MIN_TITLE'];
                $MIN_TITLE_BOOL = 0;
                $STD_TITLE = $_POST['STD_TITLE'];
                $STD_TITLE_BOOL = 0;
                $AVE_DESC = $_POST['AVE_DESC'];
                $AVE_DESC_BOOL = 0;
                $MAX_DESC = $_POST['MAX_DESC'];
                $MAX_DESC_BOOL = 0;
                $MIN_DESC = $_POST['MIN_DESC'];
                $MIN_DESC_BOOL = 0;
                $STD_DESC = $_POST['STD_DESC'];
                $STD_DESC_BOOL = 0;
		$AVE_DURATION = $_POST['AVE_DURATION'];
		$AVE_DURATION_BOOL = 0;
		$MAX_DURATION = $_POST['MAX_DURATION'];
		$MAX_DURATION_BOOL = 0;
		$MIN_DURATION = $_POST['MIN_DURATION'];
		$MIN_DURATION_BOOL = 0;
		$STD_DURATION = $_POST['STD_DURATION'];
		$STD_DURATION_BOOL = 0;
		$CORRELATION_FIRST = $_POST['CORRELATION_FIRST'];
                $CORRELATION_SECOND = $_POST['CORRELATION_SECOND'];
                $RATIO_FIRST = $_POST['RATIO_FIRST'];
                $RATIO_SECOND = $_POST['RATIO_SECOND'];
		$GET_VIDEO_ID = $_POST['GET_VIDEO_ID'];
		$GET_VIDEO_ID_BOOL = 0;
		$GET_CHANNEL_ID = $_POST['GET_CHANNEL_ID'];
                $GET_CHANNEL_ID_BOOL = 0;
		$GET_TITLE = $_POST['GET_TITLE'];
                $GET_TITLE_BOOL = 0;
		$GET_DESC = $_POST['GET_DESC'];
                $GET_DESC_BOOL = 0;
		$GET_DATE = $_POST['GET_DATE'];
                $GET_DATE_BOOL = 0;
                $GET_VIEWS = $_POST['GET_VIEWS'];
                $GET_VIEWS_BOOL = 0;
		$GET_LIKES = $_POST['GET_LIKES'];
		$GET_LIKES_BOOL = 0;
		$GET_DISLIKES = $_POST['GET_DISLIKES'];
		$GET_DISLIKES_BOOL = 0;
		$GET_COM = $_POST['GET_COM'];
                $GET_COM_BOOL = 0;
		$GET_DURATION = $_POST['GET_DURATION'];
		$GET_DURATION_BOOL = 0;
		$GET_CATEGORY = $_POST['GET_CATEGORY'];
		$GET_CATEGORY_BOOL = 0;

		if((strcmp($CORRELATION_FIRST, '') == 0) xor (strcmp($CORRELATION_SECOND, '') == 0)) {
                echo "<h2>Error: must include both or neither correlation selections</h2>";
                exit();
                }
                if((strcmp($RATIO_FIRST, '') == 0) xor (strcmp($RATIO_SECOND, '') == 0)) {
                echo "<h2>Error: must include both or neither ratio selections</h2>";
                exit();
                }
		if(strcmp($ORDER_DIR, '') != 0 && strcmp($ORDER, '') == 0) {
                echo "<h2>Error: must select what to order by if selected ascending or descending order";
                exit();
                }
                echo "<h3>Query Parameters Submitted</h3>";

		if (strcmp($MAX_RESULTS, '') != 0 || strcmp($VIDEO_ID, '') != 0 || strcmp($AUTH_ID, '') != 0 || strcmp($TITLE_CONTAIN, '') != 0 || strcmp($TITLE_NOT_CONTAIN, '') != 0 || strcmp($TITLE_EXCEED, '') != 0 || strcmp($TITLE_LESS, '') != 0 || strcmp($TITLE_ALL_CAPS, '') != 0 || strcmp($DESC_CONTAIN, '') != 0 || strcmp($DESC_NOT_CONTAIN, '') != 0 || strcmp($DESC_EXCEED, '') != 0 || strcmp($DESC_LESS, '') != 0 || strcmp($DESC_ALL_CAPS, '') != 0 || strcmp($BEFORE, '') != 0 || strcmp($AFTER, '') != 0 || strcmp($VIEW_EXCEED, '') != 0 || strcmp($VIEW_LESS, '') != 0 || strcmp($LIKE_EXCEED, '') != 0 || strcmp($LIKE_LESS, '') != 0 || strcmp($DISLIKE_EXCEED, '') != 0 || strcmp($DISLIKE_LESS, '') != 0 || strcmp($COM_LESS, '') != 0 || strcmp($COM_EXCEED, '') != 0 || strcmp($DURATION_EXCEED, '') != 0 || strcmp($DURATION_LESS, '') != 0) {
		   echo "<h3>&emsp;Filtered By:</h3>";
		} else {
		   echo "<h3>&emsp;No Filters Chosen</h3>";
		}
		if (strcmp($MAX_RESULTS, '') != 0) {
                   echo "&emsp;&emsp;Maximum results to be displayed: ".$MAX_RESULTS."<br>";
                   $MAX_RESULTS_INT = (int)$MAX_RESULTS;
                }
		if (strcmp($VIDEO_ID, '') != 0) {
		   echo "&emsp;&emsp;Only videos with ID: ".$VIDEO_ID."<br>";
		}
		if (strcmp($AUTH_ID, '') != 0) {
		   echo "&emsp;&emsp;Only videos posted by channel ID: ".$AUTH_ID."<br>";
		}
		if (strcmp($TITLE_CONTAIN, '') != 0) {
                   echo "&emsp;&emsp;Title must contain: ".$TITLE_CONTAIN."<br>";
                }
                if (strcmp($TITLE_NOT_CONTAIN, '') != 0) {
                   echo "&emsp;&emsp;Title must not contain: ".$TITLE_NOT_CONTAIN."<br>";
                }
                if (strcmp($TITLE_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Title must exceed length: ".$TITLE_EXCEED."<br>";
                   $TITLE_EXCEED_INT = (int)$TITLE_EXCEED;
                }
                if (strcmp($TITLE_LESS, '') != 0) {
                   echo "&emsp;&emsp;Title must be less than length: ".$TITLE_LESS."<br>";
                   $TITLE_LESS_INT = (int)$TITLE_LESS;
                }
		if (strcmp($TITLE_ALL_CAPS, '') != 0) {
		   echo "&emsp;&emsp;Title must be All-Caps<br>";
		   $TITLE_ALL_CAPS_BOOL = 1;
		}
		if (strcmp($DESC_CONTAIN, '') != 0) {
                   echo "&emsp;&emsp;Description must contain: ".$DESC_CONTAIN."<br>";
                }
                if (strcmp($DESC_NOT_CONTAIN, '') != 0) {
                   echo "&emsp;&emsp;Description must not contain: ".$DESC_NOT_CONTAIN."<br>";
                }
                if (strcmp($DESC_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Description must exceed length: ".$DESC_EXCEED."<br>";
                   $DESC_EXCEED_INT = (int)$DESC_EXCEED;
                }
                if (strcmp($DESC_LESS, '') != 0) {
                   echo "&emsp;&emsp;Description must be less than length: ".$DESC_LESS."<br>";
                   $DESC_LESS_INT = (int)$DESC_LESS;
                }
		if (strcmp($DESC_ALL_CAPS, '') != 0) {
                   echo	"&emsp;&emsp;Description must be All-Caps<br>";
                   $DESC_ALL_CAPS_BOOL	= 1;
		}
		if (strcmp($BEFORE, '') != 0) {
                   echo "&emsp;&emsp;Channel must have been created before: ".$BEFORE."t"."<br>";
                   $BEFORE_DATE = str_replace("T", " " , $BEFORE);
                   $BEFORE_DATE = str_replace("t", "", $BEFORE_DATE);
                }
                if (strcmp($AFTER, '') != 0) {
                   echo "&emsp;&emsp;Channel must have been created after: ".$AFTER."<br>";
                   $AFTER_DATE = str_replace("T", " " , $AFTER);
                   $AFTER_DATE = str_replace("t", "", $AFTER_DATE);
                }
		if (strcmp($VIEW_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;View count must exceed: ".$VIEW_EXCEED."<br>";
                   $VIEW_EXCEED_INT = (int)$VIEW_EXCEED;
                }
                if (strcmp($VIEW_LESS, '') != 0) {
                   echo "&emsp;&emsp;View count less than: ".$VIEW_LESS."<br>";
                   $VIEW_LESS_INT = (int)$VIEW_LESS;
                }
		if (strcmp($LIKE_EXCEED, '') != 0) {
		   echo "&emsp;&emsp;Like count must exceed: ".$LIKE_EXCEED."<br>";
		   $LIKE_EXCEED_INT = (int)$LIKE_EXCEED;
		}
		if (strcmp($LIKE_LESS, '') != 0) {
		   echo "&emsp;&emsp;Like count less than: ".$LIKE_LESS."<br>";
		   $LIKE_LESS_INT = (int)$LIKE_LESS;
		}
		if (strcmp($DISLIKE_EXCEED, '') != 0) {
		   echo "&emsp;&emsp;Dislike count must exceed: ".$DISLIKE_EXCEED."<br>";
		   $DISLIKE_EXCEED_INT = (int)$DISLIKE_EXCEED;
		}
		if (strcmp($DISLIKE_LESS, '') != 0) {
		   echo "&emsp;&emsp;Dislike discount less than: ".$DISLIKE_LESS."<br>";
		   $DISLIKE_LESS_INT = (int)$DISLIKE_LESS;
		}
		if (strcmp($COM_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Comment count must exceed: ".$COM_EXCEED."<br>";
                   $COM_EXCEED_INT = (int)$COM_EXCEED;
                }
                if (strcmp($COM_LESS, '') != 0) {
                   echo "&emsp;&emsp;Comment discount less than: ".$COM_LESS."<br>";
                   $COM_LESS_INT = (int)$COM_LESS;
                }
		if (strcmp($DURATION_EXCEED, '') != 0) {
		   echo "&emsp;&emsp;Duration must exceed: ".$DURATION_EXCEED."<br>";
		   $DURATION_EXCEED_INT = (int)$DURATION_EXCEED;
		}
		if (strcmp($DURATION_LESS, '') != 0) {
		   echo "&emsp;&emsp;Duration less than: ".$DURATION_LESS."<br>";
		   $DURATION_LESS_INT = (int)$DURATION_LESS;
		}
		if (strcmp($CATEGORY, '') != 0) {
		   echo "<h3>&emsp;&emsp;Must be of category: ".$CATEGORY."<br>";
		}
		if (strcmp($SORT, '') == 0) {
		   echo "<h3>&emsp;No Sorting Chosen</h3>";
		} else {
		   echo "<h3>&emsp;Sorted by:</h3>";
                   echo "&emsp;&emsp;".$SORT;
                   if (strcmp($SORT_DIR, '') != 0) {
                      echo ", ".$SORT_DIR;
                   }
                   echo "<br>";
		}
		if (strcmp($GET_COUNT, '') != 0) {
                   $GET_COUNT_BOOL = 1;
                }
                if (strcmp($GET_PER, '') != 0) {
                   $GET_PER_BOOL = 1;
                }
		if (strcmp($AVE_VIEW, '') != 0) {
                   $AVE_VIEW_BOOL = 1;
                }
                if (strcmp($MAX_VIEW, '') != 0) {
                   $MAX_VIEW_BOOL = 1;
                }
                if (strcmp($MIN_VIEW, '') != 0) {
                   $MIN_VIEW_BOOL = 1;
                }
                if (strcmp($STD_VIEW, '') != 0) {
                   $STD_VIEW_BOOL = 1;
                }
		if (strcmp($AVE_LIKE, '') != 0) {
		   $AVE_LIKE_BOOL = 1;
		}
		if (strcmp($MAX_LIKE, '') != 0) {
		   $MAX_LIKE_BOOL = 1;
		}
		if (strcmp($MIN_LIKE, '') != 0) {
		   $MIN_LIKE_BOOL = 1;
		}
		if (strcmp($STD_LIKE, '') != 0) {
		   $STD_LIKE_BOOL = 1;
		}
		if (strcmp($AVE_DISLIKE, '') != 0) {
		   $AVE_DISLIKE_BOOL = 1;
		}
		if (strcmp($MAX_DISLIKE, '') != 0) {
		   $MAX_DISLIKE_BOOL = 1;
		}
		if (strcmp($MIN_DISLIKE, '') != 0) {
		   $MIN_DISLIKE_BOOL = 1;
		}
		if (strcmp($STD_DISLIKE, '') != 0) {
		   $STD_DISLIKE_BOOL = 1;
		}
		if (strcmp($AVE_COM, '') != 0) {
                   $AVE_COM_BOOL = 1;
                }
                if (strcmp($MAX_COM, '') != 0) {
                   $MAX_COM_BOOL = 1;
                }
                if (strcmp($MIN_COM, '') != 0) {
                   $MIN_COM_BOOL = 1;
                }
                if (strcmp($STD_COM, '') != 0) {
                   $STD_COM_BOOL = 1;
                }
		if (strcmp($AVE_DATE, '') != 0) {
                   $AVE_DATE_BOOL = 1;
                }
                if (strcmp($MAX_DATE, '') != 0) {
                   $MAX_DATE_BOOL = 1;
                }
                if (strcmp($MIN_DATE, '') != 0) {
                   $MIN_DATE_BOOL = 1;
                }
                if (strcmp($STD_DATE, '') != 0) {
                   $STD_DATE_BOOL = 1;
                }
		if (strcmp($AVE_TITLE, '') != 0) {
                   $AVE_TITLE_BOOL = 1;
                }
                if (strcmp($MAX_TITLE, '') != 0) {
                   $MAX_TITLE_BOOL = 1;
                }
                if (strcmp($MIN_TITLE, '') != 0) {
                   $MIN_TITLE_BOOL = 1;
                }
                if (strcmp($STD_TITLE, '') != 0) {
                   $STD_TITLE_BOOL = 1;
                }
		if (strcmp($AVE_DESC, '') != 0) {
                   $AVE_DESC_BOOL = 1;
                }
                if (strcmp($MAX_DESC, '') != 0) {
                   $MAX_DESC_BOOL = 1;
                }
                if (strcmp($MIN_DESC, '') != 0) {
                   $MIN_DESC_BOOL = 1;
                }
                if (strcmp($STD_DESC, '') != 0) {
                   $STD_DESC_BOOL = 1;
                }
		if (strcmp($AVE_DURATION, '') != 0) {
		   $AVE_DURATION_BOOL = 1;
		}
		if (strcmp($MAX_DURATION, '') != 0) {
		   $MAX_DURATION_BOOL = 1;
		}
		if (strcmp($MIN_DURATION, '') != 0) {
		   $MIN_DURATION_BOOL = 1;
		}
		if (strcmp($STD_DURATION, '') != 0) {
		   $STD_DURATION_BOOL = 1;
		}
		if (strcmp($GET_VIDEO_ID, '') != 0) {
		   $GET_VIDEO_ID_BOOL = 1;
		}
		if (strcmp($GET_CHANNEL_ID, '') != 0) {
		   $GET_CHANNEL_ID_BOOL = 1;
		}
		if (strcmp($GET_TITLE, '') != 0) {
		   $GET_TITLE_BOOL = 1;
		}
		if (strcmp($GET_DESC, '') != 0) {
		   $GET_DESC_BOOL = 1;
		}
		if (strcmp($GET_DATE, '') != 0) {
		   $GET_DATE_BOOL = 1;
		}
		if (strcmp($GET_VIEWS, '') != 0) {
		   $GET_VIEWS_BOOL = 1;
		}
		if (strcmp($GET_LIKES, '') != 0) {
		   $GET_LIKES_BOOL = 1;
		}
		if (strcmp($GET_DISLIKES, '') != 0) {
		   $GET_DISLIKES_BOOL = 1;
		}
		if (strcmp($GET_COM, '') != 0) {
                   $GET_COM_BOOL = 1;
                }
		if (strcmp($GET_DURATION, '') != 0) {
		   $GET_DURATION_BOOL = 1;
		}
		if (strcmp($GET_CATEGORY, '') != 0) {
		   $GET_CATEGORY_BOOL = 1;
		}

		if ($mysqli->multi_query("CALL getVideosStatistics($MAX_RESULTS_INT, '".$VIDEO_ID."', '".$AUTH_ID."', '".$TITLE_CONTAIN."', '".$TITLE_NOT_CONTAIN."', $TITLE_EXCEED_INT, $TITLE_LESS_INT, $TITLE_ALL_CAPS_BOOL, '".$DESC_CONTAIN."', '".$DESC_NOT_CONTAIN."', $DESC_EXCEED_INT, $DESC_LESS_INT, $DESC_ALL_CAPS_BOOL, '".$BEFORE_DATE."', '".$AFTER_DATE."', $VIEW_EXCEED_INT, $VIEW_LESS_INT, $LIKE_EXCEED_INT, $LIKE_LESS_INT, $DISLIKE_EXCEED_INT, $DISLIKE_LESS_INT, $COM_EXCEED_INT, $COM_LESS_INT, $DURATION_EXCEED_INT, $DURATION_LESS_INT, '".$CATEGORY."', '".$SORT."', '".$SORT_DIR."', $GET_COUNT_BOOL, $GET_PER_BOOL, $AVE_VIEW_BOOL, $MAX_VIEW_BOOL, $MIN_VIEW_BOOL, $STD_VIEW_BOOL, $AVE_LIKE_BOOL, $MAX_LIKE_BOOL, $MIN_LIKE_BOOL, $STD_LIKE_BOOL, $AVE_DISLIKE_BOOL, $MAX_DISLIKE_BOOL, $MIN_DISLIKE_BOOL, $STD_DISLIKE_BOOL, $AVE_COM_BOOL, $MAX_COM_BOOL, $MIN_COM_BOOL, $STD_COM_BOOL, $AVE_DATE_BOOL, $MAX_DATE_BOOL, $MIN_DATE_BOOL, $STD_DATE_BOOL, $AVE_TITLE_BOOL, $MAX_TITLE_BOOL, $MIN_TITLE_BOOL, $STD_TITLE_BOOL, $AVE_DESC_BOOL, $MAX_DESC_BOOL, $MIN_DESC_BOOL, $STD_DESC_BOOL, $AVE_DURATION_BOOL, $MAX_DURATION_BOOL, $MIN_DURATION_BOOL, $STD_DURATION_BOOL, '".$CORRELATION_FIRST."', '".$CORRELATION_SECOND."', '".$RATIO_FIRST."', '".$RATIO_SECOND."');")) {
		   if ($result = $mysqli->store_result()) {
		      $row = $result->fetch_row();

		      if (strcmp($row[0], 'ERROR: ') == 0) {
		      	 do {
			    for ($i = 0; $i < sizeof($row); $i++) {
			    	echo "<h3>".$row[$i]."</h3>";
			    }
			 } while ($row = $result->fetch_row());
		      } else if (strcmp($row[0], '') == 0) {
		      	 echo "<h3>No Such Videos Exist in the Database</h3>";
		      } else {
		      	 if ($GET_COUNT_BOOL == 1 || $GET_PER_BOOL == 1 || $AVE_VIEW_BOOL == 1 || $MAX_VIEW_BOOL == 1 || $MIN_VIEW_BOOL == 1 || $STD_VIEW_BOOL == 1 || $AVE_LIKE_BOOL == 1 || $MAX_LIKE_BOOL == 1 || $MIN_LIKE_BOOL == 1 || $STD_LIKE_BOOL == 1 || $AVE_DISLIKE_BOOL == 1 || $MAX_DISLIKE_BOOL == 1 || $MIN_DISLIKE_BOOL == 1 || $AVE_COM_BOOL == 1|| $MAX_COM_BOOL == 1 || $MIN_COM_BOOL == 1 || $STD_COM_BOOL == 1 || $AVE_DATE_BOOL == 1 || $MAX_DATE_BOOL == 1 || $MIN_DATE_BOOL == 1 || $STD_DATE_BOOL == 1 || $AVE_TITLE_BOOL == 1 || $MAX_TITLE_BOOL == 1 || $MIN_TITLE_BOOL == 1 || $STD_TITLE_BOOL == 1 || $AVE_DESC_BOOL == 1 || $MAX_DESC_BOOL == 1 || $MIN_DESC_BOOL == 1 || $STD_DESC_BOOL == 1 || $AVE_DURATION_BOOL == 1 || $MAX_DURATION_BOOL == 1 || $MIN_DURATION_BOOL == 1 || $STD_DURATION_BOOL == 1 || strcmp($RATIO_FIRST, '' ) != 0 || strcmp($CORRELATION_FIRST, '') != 0) {
			    echo "<h3>Summary Statistics</h3>";
			    echo "<table border =\"1px solid black\">";

			    if ($GET_COUNT_BOOL == 1) {
			       echo "<tr><td>Result Count</td><td>".$row[2]."</td></tr>";
			    }
			    if ($GET_PER_BOOL == 1) {
			       echo "<tr><td>Result Count as a Percentage of Total</td><td>".$row[1]."%</td></tr>";
			    }
			    if ($AVE_VIEW_BOOL == 1) {
			       echo "<tr><td>Average View Count</td><td>".$row[3]."</td></tr>";
			    }
			    if ($MAX_VIEW_BOOL == 1) {
			       echo "<tr><td>Maximum View Count</td><td>".$row[4]."</td></tr>";
			    }
			    if ($MIN_VIEW_BOOL == 1) {
			       echo "<tr><td>Minimum of View Count</td><td>".$row[5]."</td></tr>";
			    }
			    if ($STD_VIEW_BOOL == 1) {
			       echo "<tr><td>Standard Deviation of View Count</td><td>".$row[6]."</td></tr>";
			    }
			    if ($AVE_LIKE_BOOL == 1) {
			       echo "<tr><td>Average Like Count</td><td>".$row[7]."</td></tr>";
			    }
			    if ($MAX_LIKE_BOOL == 1) {
			       echo "<tr><td>Maximum Like Count</td><td>".$row[8]."</td></tr>";
			    }
			    if ($MIN_LIKE_BOOL == 1) {
			       echo "<tr><td>Minimum Like Count</td><td>".$row[9]."</td></tr>";
			    }
			    if ($STD_LIKE_BOOL == 1) {
			       echo "<tr><td>Standard Deviation of Like Count</td><td>".$row[10]."</td></tr>";
			    }
			    if ($AVE_DISLIKE_BOOL == 1) {
			       echo "<tr><td>Average Dislike Count</td><td>".$row[11]."</td></tr>";
			    }
			    if ($MAX_DISLIKE_BOOL == 1) {
			       echo "<tr><td>Maximum Dislike Count</td><td>".$row[12]."</td></tr>";
			    }
			    if ($MIN_DISLIKE_BOOL == 1) {
			       echo "<tr><td>Minimum Dislike Count</td><td>".$row[13]."</td></tr>";
			    }
			    if ($STD_DISLIKE_BOOL == 1) {
			       echo "<tr><td>Standard Deviation of Dislike Count</td><td>".$row[14]."</td></tr>";
			    }
			    if ($AVE_COM_BOOL == 1) {
                               echo "<tr><td>Average Comment Count</td><td>".$row[15]."</td></tr>";
                            }
                            if ($MAX_COM_BOOL == 1) {
                               echo "<tr><td>Maximum Comment Count</td><td>".$row[16]."</td></tr>";
                            }
                            if ($MIN_COM_BOOL == 1) {
                               echo "<tr><td>Minimum Comment Count</td><td>".$row[17]."</td></tr>";
                            }
			    if ($STD_COM_BOOL == 1) {
                               echo "<tr><td>Standard Deviation of Comment Count</td><td>".$row[18]."</td></tr>";
                            }
			    if ($AVE_DATE_BOOL == 1) {
                               echo "<tr><td>Average Datetime Created</td><td>".$row[19]."</td></tr>";
                            }
                            if ($MAX_DATE_BOOL == 1) {
                               echo "<tr><td>Most Recent Datetime Created</td><td>".$row[20]."</td></tr>";
                            }
                            if ($MIN_DATE_BOOL == 1) {
                               echo "<tr><td>Earliest Datetime Created</td><td>".$row[21]."</td></tr>";
                            }
                            if ($STD_DATE_BOOL == 1) {
                               echo "<tr><td>Standard Deviation of Datetime (in days)</td><td>".$row[22]."</td></tr>";
                            }
			    if ($AVE_TITLE_BOOL == 1) {
                       	       echo "<tr><td>Average Title Length</td><td>".$row[23]."</td></tr>";
                            }
                            if ($MAX_TITLE_BOOL == 1) {
                               echo "<tr><td>Maximum Title Length</td><td>".$row[24]."</td></tr>";
                            }
                            if ($MIN_TITLE_BOOL == 1) {
                               echo "<tr><td>Minimum of Title Length</td><td>".$row[25]."</td></tr>";
                            }
                            if ($STD_TITLE_BOOL == 1) {
                               echo "<tr><td>Standard Deviation of Title Length</td><td>".$row[26]."</td></tr>";
                            }
			    if ($AVE_DESC_BOOL == 1) {
                       	       echo "<tr><td>Average Description Length</td><td>".$row[27]."</td></tr>";
                            }
                            if ($MAX_DESC_BOOL == 1) {
                               echo "<tr><td>Maximum Description Length</td><td>".$row[28]."</td></tr>";
                            }
                            if ($MIN_DESC_BOOL == 1) {
                               echo "<tr><td>Minimum of Description Length</td><td>".$row[29]."</td></tr>";
                            }
                            if ($STD_DESC_BOOL == 1) {
                               echo "<tr><td>Standard Deviation of Description Length</td><td>".$row[30]."</td></tr>";
                            }
			    if ($AVE_DURATION_BOOL == 1) {
			       echo "<tr><td>Average Duration</td><td>".$row[31]."</td></tr>";
			    }
			    if ($MAX_DURATION_BOOL == 1) {
			       echo "<tr><td>Maximum Duration</td><td>".$row[32]."</td></tr>";
			    }
			    if ($MIN_DURATION_BOOL == 1) {
			       echo "<tr><td>Minimum Duration</td><td>".$row[33]."</td></tr>";
			    }
			    if ($STD_DURATION_BOOL == 1) {
			       echo "<tr><td>Standard Deviation of Duration</td><td>".$row[34]."</td></tr>";
			    }
			    if (strcmp($CORRELATION_FIRST, '') != 0) {
                               echo "<tr><td>Pearson Correlation Coefficient Between ".$CORRELATION_FIRST." and ".$CORRELATION_SECOND."</td><td>".$row[36]."</td></tr>";
                            }
                            if (strcmp($RATIO_FIRST, '') != 0) {
                               echo "<tr><td>Average Ratio of ".$RATIO_FIRST." to ".$RATIO_SECOND."</td><td>".$row[35]."</td></tr>";
                            }
			    echo "</table>";
			 } else {
			    echo "<h3>No Summary Statistics Chosen</h3>";
			 }
			 mysqli_close($mysqli);

			 $result->free();
			 include('open.php');
			 if ($mysqli->multi_query("CALL getVideos($MAX_RESULTS_INT, '".$VIDEO_ID."', '".$AUTH_ID."', '".$TITLE_CONTAIN."', '".$TITLE_NOT_CONTAIN."', $TITLE_EXCEED_INT, $TITLE_LESS_INT, $TITLE_ALL_CAPS_BOOL, '".$DESC_CONTAIN."', '".$DESC_NOT_CONTAIN."', $DESC_EXCEED_INT, $DESC_LESS_INT, $DESC_ALL_CAPS_BOOL, '".$BEFORE_DATE."', '".$AFTER_DATE."', $VIEW_EXCEED_INT, $VIEW_LESS_INT, $LIKE_EXCEED_INT, $LIKE_LESS_INT, $DISLIKE_EXCEED_INT, $DISLIKE_LESS_INT, $COM_EXCEED_INT, $COM_LESS_INT, $DURATION_EXCEED_INT, $DURATION_LESS_INT, '".$CATEGORY."', '".$SORT."', '".$SORT_DIR."', $GET_VIDEO_ID_BOOL, $GET_CHANNEL_ID_BOOL, $GET_TITLE_BOOL, $GET_DESC_BOOL, $GET_DATE_BOOL, $GET_VIEWS_BOOL, $GET_LIKES_BOOL, $GET_DISLIKES_BOOL, $GET_COM_BOOL, $GET_DURATION_BOOL, $GET_CATEGORY_BOOL);")) {
			    if ($result = $mysqli->store_result()) {
			       $row = $result->fetch_row();
			       if ($GET_VIDEO_ID_BOOL == 1 || $GET_CHANNEL_ID_BOOL == 1 || $GET_TITLE_BOOL == 1 || $GET_DESC_BOOL == 1 || $GET_DATE_BOOL == 1 || $GET_VIEWS_BOOL == 1 || $GET_LIKES_BOOL == 1 || $GET_DISLIKES_BOOL == 1 || $GET_COM_BOOL == 1 || $GET_DURATION_BOOL == 1 || $GET_CATEGORY_BOOL == 1) {
			       	  if (strcmp($row[0], 'ERROR: ') == 0) {
			       	     do {
				     	for ($i = 0; $i < sizeof($row); $i++) {
				     	   echo "<h3>".$row[$i]."</h3>";
				     	}
				     } while ($row = $result->fetch_row());
			       	  } else if (strcmp($row[0], '') == 0) {
			       	     echo "<h3>No Such Videos Exist in the Database</h3>";
			          } else {
			       	     echo "<h3>Results</h3>";
				     echo "<table border =\1px solid black\">";
				     echo "<tr>";
				     echo "<th> # </th>";
				     if ($GET_VIDEO_ID_BOOL == 1) {
				     	echo "<th> Video ID </th>";
				     }
				     if ($GET_CHANNEL_ID_BOOL == 1) {
				     	echo "<th> Channel ID </th>";
				     }
				     if ($GET_TITLE_BOOL == 1) {
				     	echo "<th> Title </th>";
                           	     }
				     if ($GET_DESC_BOOL == 1) {
				     	echo "<th> Description </th>";
				     }
				     if ($GET_DATE_BOOL == 1) {
				     	echo "<th> Date Posted </th>";
				     }
				     if ($GET_VIEWS_BOOL == 1) {
				     	echo "<th> View Count </th>";
				     }
				     if ($GET_LIKES_BOOL == 1) {
				     	echo "<th> Like Count </th>";
				     }
				     if ($GET_DISLIKES_BOOL == 1) {
				     	echo "<th> Dislike Count </th>";
				     }
				     if ($GET_COM_BOOL == 1) {
                                        echo "<th> Comment Count </th>";
                                     }
				     if ($GET_DURATION_BOOL == 1) {
				     	echo "<th> Duration </th>";
				     }
				     if ($GET_CATEGORY_BOOL == 1) {
				     	echo "<th> Category </th>";
			 	     }
				     echo "</tr>";
				     do {
				     	 echo "<tr>";
					 echo "<td>".$row[0]."</td>";
					 if ($GET_VIDEO_ID_BOOL == 1) {
					    echo "<td>".$row[1]."</td>";
					 }
					 if ($GET_CHANNEL_ID_BOOL == 1) {
					    echo "<td>".$row[2]."</td>";
					 }
					 if ($GET_TITLE_BOOL == 1) {
					    echo "<td>".$row[3]."</td>";
					 }
					 if ($GET_DESC_BOOL == 1) {
					    echo "<td>".$row[4]."</td>";
					 }
					 if ($GET_DATE_BOOL == 1) {
					    echo "<td>".$row[5]."</td>";
					 }
					 if ($GET_VIEWS_BOOL == 1) {
					    echo "<td>".$row[6]."</td>";
					 }
					 if ($GET_LIKES_BOOL == 1) {
					    echo "<td>".$row[7]."</td>";
					 }
					 if ($GET_DISLIKES_BOOL == 1) {
					    echo "<td>".$row[8]."</td>";
					 }
					 if ($GET_COM_BOOL == 1) {
                                            echo "<td>".$row[9]."</td>";
                                         }
					 if ($GET_DURATION_BOOL == 1) {
					    echo "<td>".$row[9]."</td>";
					 }
					 if ($GET_CATEGORY_BOOL == 1) {
					    echo "<td>".$row[10]."</td>";
					 }
					 echo "</tr>";
				     } while ($row = $result->fetch_row());
				     echo "</tr>";
				 }
			     } else {
			       echo "<h3>No Columns Chosen</h3>";
			     }
			     $result->close();
			 }
		     } else {
		       printf("Error: %s\n", $mysqli->error);
		     }
		 }
	     }
	 } else {
	   printf("Error: %s\n", $mysqli->error);
	 }
	 mysqli_close($mysqli);
	 ?>
</body>