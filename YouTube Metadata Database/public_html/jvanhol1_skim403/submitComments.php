<body>
	<html>
		<body>
			<h2>Query Results</h2>
			<form action='comments.html' method='post'>
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
		ini_set('display_error', true);

		$MAX_RESULTS = $_POST['MAX_RESULTS'];
		$MAX_RESULTS_INT = 2147483647;
		$COM_ID = $_POST['COM_ID'];
		$AUTH_ID = $_POST['AUTH_ID'];
		$VIDEO_ID = $_POST['VIDEO_ID'];
		$COM_CONTAIN = $_POST['COM_CONTAIN'];
		$COM_NOT_CONTAIN = $_POST['COM_NOT_CONTAIN'];
		//$COM_START = $_POST['COM_START'];
		//$COM_END = $_POST['COM_END'];
		$COM_EXCEED = $_POST['COM_EXCEED'];
		$COM_EXCEED_INT = -1;
		$COM_LESS = $_POST['COM_LESS'];
		$COM_LESS_INT = -1;
		$CONTAIN_SUB = $_POST['CONTAIN_SUB'];
		$CONTAIN_SUB_BOOL = 0;
		$ALL_CAPS = $_POST['ALL_CAPS'];
		$ALL_CAPS_BOOL = 0;
		$BEFORE = $_POST['BEFORE'];
		$BEFORE_DATE = '2500-01-01 00:00:00';
		$AFTER = $_POST['AFTER'];
		$AFTER_DATE = '1900-01-01 00:00:00';
		$CREATED_BEFORE_VIDEO = 0;
		$CREATED_BEFORE_VIDEO_SEC = $_POST['BEFORE_CREATED_VIDEO_SEC'];
		$CREATED_BEFORE_VIDEO_SEC_INT = -1;
		$CREATED_BEFORE_VIDEO_MIN = $_POST['BEFORE_CREATED_VIDEO_MIN'];
		$CREATED_BEFORE_VIDEO_MIN_INT = -1;
		$CREATED_BEFORE_VIDEO_HR = $_POST['BEFORE_CREATED_VIDEO_HR'];
		$CREATED_BEFORE_VIDEO_HR_INT = -1;
		$CREATED_BEFORE_VIDEO_DAY = $_POST['BEFORE_CREATED_VIDEO_DAY'];
		$CREATED_BEFORE_VIDEO_DAY_INT = -1;

		$CREATED_AFTER_VIDEO =	0;
                $CREATED_AFTER_VIDEO_SEC = $_POST['AFTER_CREATED_VIDEO_SEC'];
		$CREATED_AFTER_VIDEO_SEC_INT = -1;
		$CREATED_AFTER_VIDEO_MIN = $_POST['AFTER_CREATED_VIDEO_MIN'];
                $CREATED_AFTER_VIDEO_MIN_INT = -1;
		$CREATED_AFTER_VIDEO_HR = $_POST['AFTER_CREATED_VIDEO_HR'];
                $CREATED_AFTER_VIDEO_HR_INT = -1;
                $CREATED_AFTER_VIDEO_DAY = $_POST['AFTER_CREATED_VIDEO_DAY'];
                $CREATED_AFTER_VIDEO_DAY_INT = -1;
		
		$LIKE_EXCEED = $_POST['LIKE_EXCEED'];
		$LIKE_EXCEED_INT = -1;
		$LIKE_LESS = $_POST['LIKE_LESS'];
		$LIKE_LESS_INT = -1;
		$SORT = $_POST['SORT'];
		$SORT_DIR = $_POST['SORT_DIR'];
		$GET_COUNT = $_POST['GET_COUNT'];
		$GET_COUNT_BOOL = 0;
		$GET_PER = $_POST['GET_PER'];
		$GET_PER_BOOL = 0;
		$AVE_LIKE = $_POST['AVE_LIKE'];
		$AVE_LIKE_BOOL = 0;
		$MAX_LIKE = $_POST['MAX_LIKE'];
		$MAX_LIKE_BOOL = 0;
		$MIN_LIKE = $_POST['MIN_LIKE'];
		$MIN_LIKE_BOOL = 0;
		$STD_LIKE = $_POST['STD_LIKE'];
		$STD_LIKE_BOOL = 0;
		$AVE_DATE = $_POST['AVE_DATE'];
		$AVE_DATE_BOOL = 0;
		$MAX_DATE = $_POST['MAX_DATE'];
		$MAX_DATE_BOOL = 0;
		$MIN_DATE = $_POST['MIN_DATE'];
		$MIN_DATE_BOOL = 0;
		$STD_DATE = $_POST['STD_DATE'];
		$STD_DATE_BOOL = 0;
		$AVE_COM = $_POST['AVE_COM'];
		$AVE_COM_BOOL = 0;
		$MAX_COM = $_POST['MAX_COM'];
		$MAX_COM_BOOL = 0;
		$MIN_COM = $_POST['MIN_COM'];
		$MIN_COM_BOOL = 0; 
		$STD_COM = $_POST['STD_COM'];
		$STD_COM_BOOL = 0;
		$CORRELATION_FIRST = $_POST['CORRELATION_FIRST'];
		$CORRELATION_SECOND = $_POST['CORRELATION_SECOND'];
		$RATIO_FIRST = $_POST['RATIO_FIRST'];
		$RATIO_SECOND = $_POST['RATIO_SECOND'];
		$GET_COM_ID = $_POST['GET_COM_ID'];
		$GET_COM_ID_BOOL = 0;
		$GET_COM = $_POST['GET_COM'];
		$GET_AUTH_ID = $_POST['GET_AUTH_ID'];
		$GET_AUTH_ID_BOOL = 0;
		$GET_VIDEO_ID = $_POST['GET_VIDEO_ID'];
		$GET_VIDEO_ID_BOOL = 0;
		$GET_COM_BOOL = 0;
		$GET_DATE = $_POST['GET_DATE'];
		$GET_DATE_BOOL = 0;
		$GET_LIKE = $_POST['GET_LIKE'];
		$GET_LIKE_BOOL = 0;
		$GET_VIDEO = $_POST['GET_DATE'];
		$GET_VIDEO_BOOL = 0;
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
		if(strcmp($MAX_RESULTS, '') != 0 || strcmp($COM_ID, '') != 0 || strcmp($AUTH_ID, '') != 0 || strcmp($VIDEO_ID, '') != 0 || strcmp($COM_CONTAIN, '') != 0 || strcmp($COM_NOT_CONTAIN, '') != 0 || strcmp($COM_EXCEED, '') != 0 || strcmp($COM_LESS, '') != 0 || strcmp($BEFORE, '') != 0 || strcmp($AFTER, '') != 0 || strcmp($LIKE_EXCEED, '') != 0 || strcmp($LIKE_LESS, '') != 0) {
		echo "<h3>&emsp;Filtered By:</h3>";			
		} else {
		echo "<h3>&emsp;No Filters Chosen</h3>";
		}		
		if (strcmp($MAX_RESULTS, '') != 0) {
		   echo "&emsp;&emsp;Maximum results to be displayed: ".$MAX_RESULTS."<br>";
		   $MAX_RESULTS_INT = (int)$MAX_RESULTS;
		}
                if (strcmp($COM_ID, '') != 0) {
                   echo "&emsp;&emsp;Only comments with ID: ".$COM_ID."<br>";
                }
		if (strcmp($AUTH_ID, '') != 0) {
                   echo "&emsp;&emsp;Only comments from authors with channel ID: ".$CHANNEL_ID."<br>";
                }
		if (strcmp($VIDEO_ID, '') != 0) {
                   echo "&emsp;&emsp;Only comment posted on video with ID: ".$CHANNEL_ID."<br>";
                }
		if (strcmp($COM_CONTAIN, '') != 0) {
			echo "&emsp;&emsp;Comment must contain: ".$COM_CONTAIN."<br>";
		}
                if (strcmp($COM_NOT_CONTAIN, '') != 0) {
                   echo "&emsp;&emsp;Comment must not contain: ".$COM_NOT_CONTAIN."<br>";
                }
                if (strcmp($COM_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Comment must exceed length: ".$COM_EXCEED."<br>";
		   $COM_EXCEED_INT = (int)$COM_EXCEED;
                }
                if (strcmp($COM_LESS, '') != 0) {
                   echo "&emsp;&emsp;Comment must be less than length: ".$COM_LESS."<br>";
		   $COM_LESS_INT = (int)$COM_LESS;
                }
		if (strcmp($CONTAIN_SUB, '') != 0) {
                   echo "&emsp;&emsp;Comment must contain a substring of its video's title<br>";
                   $CONTAIN_SUB_BOOL = 1;
                }
		if (strcmp($ALL_CAPS, '') != 0) {
                   echo "&emsp;&emsp;Comment must be All-Caps<br>";
                   $ALL_CAPS_BOOL = 1;
                }
                if (strcmp($BEFORE, '') != 0) {
                   echo "&emsp;&emsp;Comment must have been posted before: ".$BEFORE."t"."<br>";
		   $BEFORE_DATE = str_replace("T", " " , $BEFORE);
                   $BEFORE_DATE = str_replace("t", "", $BEFORE_DATE);
                }
                if (strcmp($AFTER, '') != 0) {
                   echo "&emsp;&emsp;Comment must have been posted after: ".$AFTER."<br>";
		   $AFTER_DATE = str_replace("T", " " , $AFTER);
                   $AFTER_DATE = str_replace("t", "", $AFTER_DATE);
                }
		if (strcmp($CREATED_BEFORE_VIDEO_SEC, '') != 0) {
                   $CREATED_BEFORE_VIDEO_SEC_INT = (int)$CREATED_BEFORE_VIDEO_SEC;
                }
		if (strcmp($CREATED_BEFORE_VIDEO_MIN, '') != 0) {
                   $CREATED_BEFORE_VIDEO_MIN_INT = (int)$CREATED_BEFORE_VIDEO_MIN;
		}
		if (strcmp($CREATED_BEFORE_VIDEO_HR, '') != 0) {
                   $CREATED_BEFORE_VIDEO_HR_INT = (int)$CREATED_BEFORE_VIDEO_HR;
		}
		if (strcmp($CREATED_BEFORE_VIDEO_DAY, '') != 0) {
                   $CREATED_BEFORE_VIDEO_DAY_INT = (int)$CREATED_BEFORE_VIDEO_DAY;
		}
		if($CREATED_BEFORE_VIDEO_SEC_INT != -1 || $CREATED_BEFORE_VIDEO_MIN_INT != -1 || $CREATED_BEFORE_VIDEO_HR_INT != -1 || $CREATED_BEFORE_VIDEO_DAY_INT != -1) {
		$CREATED_BEFORE_VIDEO = 1;
		if($CREATED_BEFORE_VIDEO_SEC_INT == -1) {
		$CREATED_BEFORE_VIDEO_SEC_INT = 0;
		$CREATED_BEFORE_VIDEO_SEC = "0";
		}
		if($CREATED_BEFORE_VIDEO_MIN_INT == -1) {
		$CREATED_BEFORE_VIDEO_MIN_INT = 0;
		$CREATED_BEFORE_VIDEO_MIN = "0";
		}
		if($CREATED_BEFORE_VIDEO_HR_INT == -1) {
		$CREATED_BEFORE_VIDEO_HR_INT = 0;
		$CREATED_BEFORE_VIDEO_HR = "0";
		}
		if($CREATED_BEFORE_VIDEO_DAY_INT == -1) {
		$CREATED_BEFORE_VIDEO_DAY_INT = 0;
		$CREATED_BEFORE_VIDEO_DAY = "0";
		}
		echo "&emsp;&emsp;Comment must have been posted within ".$CREATED_BEFORE_VIDEO_SEC." seconds, ".$CREATED_BEFORE_VIDEO_MIN." minutes, ".$CREATED_BEFORE_VIDEO_HR." hours, and ".$CREATED_BEFORE_VIDEO_DAY." days of the video post date<br>";
		}
		if (strcmp($CREATED_AFTER_VIDEO_SEC, '') != 0) {
                   $CREATED_AFTER_VIDEO_SEC_INT = (int)$CREATED_AFTER_VIDEO_SEC;
                }
		if (strcmp($CREATED_AFTER_VIDEO_MIN, '') != 0) {
                   $CREATED_AFTER_VIDEO_MIN_INT = (int)$CREATED_AFTER_VIDEO_MIN;
		}
		if (strcmp($CREATED_AFTER_VIDEO_HR, '') != 0) {
                   $CREATED_AFTER_VIDEO_HR_INT = (int)$CREATED_AFTER_VIDEO_HR;
		}
		if (strcmp($CREATED_AFTER_VIDEO_DAY, '') != 0) {
                   $CREATED_AFTER_VIDEO_SEC_DAY = (int)$CREATED_AFTER_VIDEO_DAY;
		}
		if($CREATED_AFTER_VIDEO_SEC_INT != -1 || $CREATED_AFTER_VIDEO_MIN_INT != -1 || $CREATED_AFTER_VIDEO_HR_INT != -1 || $CREATED_AFTER_VIDEO_DAY_INT != -1) {
		$CREATED_AFTER_VIDEO = 1;
		if($CREATED_AFTER_VIDEO_SEC_INT == -1) {
		$CREATED_AFTER_VIDEO_SEC_INT = 0;
		$CREATED_AFTER_VIDEO_SEC = "0";
		}
		if($CREATED_AFTER_VIDEO_MIN_INT == -1) {
		$CREATED_AFTER_VIDEO_MIN = "0";
		$CREATED_AFTER_VIDEO_MIN_INT = 0;
                }
		if($CREATED_AFTER_VIDEO_HR_INT == -1) {
		$CREATED_AFTER_VIDEO_HR_INT = 0;
		$CREATED_AFTER_VIDEO_HR = "0";
		}
		if($CREATED_AFTER_VIDEO_DAY_INT == -1) {
		$CREATED_AFTER_VIDEO_DAY_INT = 0;
		$CREATED_AFTER_VIDEO_DAY = "0";
		}
		echo "&emsp;&emsp;Comment must have been posted after ".$CREATED_AFTER_VIDEO_SEC." seconds, ".$CREATED_AFTER_VIDEO_MIN." minutes, ".$CREATED_AFTER_VIDEO_HR." hours, and ".$CREATED_AFTER_VIDEO_DAY." days from the video post date<br>";
		}
                if (strcmp($LIKE_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Like count must exceed: ".$LIKE_EXCEED."<br>";
		   $LIKE_EXCEED_INT = (int)$LIKE_EXCEED;
                }
                if (strcmp($LIKE_LESS, '') != 0) {
                   echo "&emsp;&emsp;Like count must be less than: ".$LIKE_LESS."<br>";
		   $LIKE_LESS_INT = (int)$LIKE_LESS;
                }
   		if(strcmp($SORT, '') == 0) {
			echo "<h3>&emsp;No Sorting Chosen</h3>";	
		} else {
		  echo "<h3>&emsp;Sorted by:</h3>";
		  echo "&emsp;&emsp;".$SORT;
		  if (strcmp($SORT_DIR, '') != 0) {
		     echo ", ".$SORT_DIR;
		  }
		}
		if(strcmp($GET_COUNT, '') != 0) {
		$GET_COUNT_BOOL = 1;
		}
		if(strcmp($GET_PER, '') != 0) {
		$GET_PER_BOOL = 1;
		}
		if(strcmp($AVE_LIKE, '') != 0) {
		$AVE_LIKE_BOOL = 1;
		}
		if(strcmp($MAX_LIKE, '') != 0) {
		$MAX_LIKE_BOOL = 1;
		}
		if(strcmp($MIN_LIKE, '') != 0) {
		$MIN_LIKE_BOOL = 1;
		}
		if(strcmp($STD_LIKE, '') != 0) {
		$STD_LIKE_BOOL = 1;
		}
		if(strcmp($AVE_DATE, '') != 0) {
		$AVE_DATE_BOOL = 1;
		}
                if(strcmp($MAX_DATE, '') != 0) {
		$MAX_DATE_BOOL = 1;
		}
                if(strcmp($MIN_DATE, '') != 0) {
		$MIN_DATE_BOOL = 1;
		}
                if(strcmp($STD_DATE, '') != 0) {
		$STD_DATE_BOOL = 1;
		}
		if(strcmp($AVE_COM, '') != 0) {
		$AVE_COM_BOOL = 1;
		}
                if(strcmp($MAX_COM, '') != 0) {
		$MAX_COM_BOOL = 1;
		}
                if(strcmp($MIN_COM, '') != 0) {
		$MIN_COM_BOOL = 1;
		}
                if(strcmp($STD_COM, '') != 0) {
		$STD_COM_BOOL = 1;
		}
		if(strcmp($GET_COM_ID, '') != 0) {
      		$GET_COM_ID_BOOL = 1;
                }
		if(strcmp($GET_AUTH_ID, '') != 0) {
      		$GET_AUTH_ID_BOOL = 1;
                }
		if(strcmp($GET_VIDEO_ID, '') != 0) {
      		$GET_VIDEO_ID_BOOL = 1;
                }
		if(strcmp($GET_COM, '') != 0) {
		$GET_COM_BOOL = 1;
                }
		if(strcmp($GET_DATE, '') != 0) {
		$GET_DATE_BOOL = 1;
                }
		if(strcmp($GET_LIKE, '') != 0) {
		$GET_LIKE_BOOL = 1;
                }
		if(strcmp($GET_VIDEO, '') != 0) {
                $GET_VIDEO_BOOL = 1;
                }
		if ($mysqli->multi_query("CALL getCommentsStatistics($MAX_RESULTS_INT, '".$COM_ID."', '".$AUTH_ID."', '".$VIDEO_ID."', '".$COM_CONTAIN."', '".$COM_NOT_CONTAIN."', $COM_EXCEED_INT, $COM_LESS_INT, $CONTAIN_SUB_BOOL, $ALL_CAPS_BOOL, '".$BEFORE_DATE."', '".$AFTER_DATE."', $CREATED_BEFORE_VIDEO, $CREATED_BEFORE_VIDEO_SEC_INT, $CREATED_BEFORE_VIDEO_MIN_INT, $CREATED_BEFORE_VIDEO_HR_INT, $CREATED_BEFORE_VIDEO_DAY_INT, $CREATED_AFTER_VIDEO, $CREATED_AFTER_VIDEO_SEC_INT, $CREATED_AFTER_VIDEO_MIN_INT, $CREATED_AFTER_VIDEO_HR_INT, $CREATED_AFTER_VIDEO_DAY_INT, $LIKE_EXCEED_INT, $LIKE_LESS_INT, '".$SORT."', '".$SORT_DIR."', $GET_COUNT_BOOL, $GET_PER_BOOL, $AVE_LIKE_BOOL, $MAX_LIKE_BOOL, $MIN_LIKE_BOOL, $STD_LIKE_BOOL, $AVE_DATE_BOOL, $MAX_DATE_BOOL, $MIN_DATE_BOOL, $STD_DATE_BOOL, $AVE_COM_BOOL, $MAX_COM_BOOL, $MIN_COM_BOOL, $STD_COM_BOOL, '".$CORRELATION_FIRST."', '".$CORRELATION_SECOND."', '".$RATIO_FIRST."', '".$RATIO_SECOND."');")) {
		   if($result = $mysqli->store_result()) {
		   $row = $result->fetch_row();
		   	if(strcmp($row[0], 'ERROR: ') == 0) {
			      do {
				 for($i = 0; $i < sizeof($row); $i++) {
				 	echo "<h3>".$row[$i]."</h3>";
				 }
		   	      } while($row = $result->fetch_row());
			 } else if (strcmp($row[0], '') == 0) {
			   	echo "<h3>No Such Comments Exist in the Database</h3>"; 	  
			 } else {
			   if($GET_COUNT_BOOL == 1 || $GET_PER_BOOL == 1 || $AVE_LIKE_BOOL == 1 || $MAX_LIKE_BOOL == 1 || $MIN_LIKE_BOOL == 1 || $STD_LIKE_BOOL == 1 || $AVE_DATE_BOOL == 1 || $MAX_DATE_BOOL == 1 || $MIN_DATE_BOOL == 1 || $STD_DATE_BOOL == 1 || $AVE_COM_BOOL == 1 || $MAX_COM_BOOL == 1 || $MIN_COM_BOOL == 1 || $STD_COM_BOOL == 1 || strcmp($RATIO_FIRST, '' ) != 0 || strcmp($CORRELATION_FIRST, '') != 0) {
			   echo "<h3>Summary Statistics</h3>";
			   echo "<table border =\"1px solid black\">";
			   if ($GET_COUNT_BOOL == 1) {
			   echo "<tr><td>Result Count</td><td>".$row[2]."</td></tr>";
			   }
			   if ($GET_PER_BOOL == 1) {
			   echo "<tr><td>Result Count as a Percentage of Total</td><td>".$row[1]."%</td></tr>";
			   }
			   if($AVE_LIKE_BOOL == 1) {
			   echo "<tr><td>Average Like Count</td><td>".$row[3]."</td></tr>";
			   }
	      		if($MAX_LIKE_BOOL == 1) {
               		echo "<tr><td>Maximum Like Count</td><td>".$row[4]."</td></tr>";
			}
			if($MIN_LIKE_BOOL == 1) {
			echo "<tr><td>Minimum of Like Count</td><td>".$row[5]."</td></tr>";
			}
			if($STD_LIKE_BOOL == 1) {
	                echo "<tr><td>Standard Deviation of Like Count</td><td>".$row[6]."</td></tr>";
			}
			if($AVE_DATE_BOOL == 1) {
        	        echo "<tr><td>Average Datetime Posted</td><td>".$row[7]."</td></tr>";
			}
	                if($MAX_DATE_BOOL == 1) {
        	        echo "<tr><td>Most Recent Datetime Posted</td><td>".$row[8]."</td></tr>";
			}
	                if($MIN_DATE_BOOL == 1) {
        	        echo "<tr><td>Earliest Datetime Posted</td><td>".$row[9]."</td></tr>";
			}
                	if($STD_DATE_BOOL == 1) {
                	echo "<tr><td>Standard Deviation of Datetime Posted (in days)</td><td>".$row[10]."</td></tr>";
			}
			if($AVE_COM_BOOL == 1) {
               		echo "<tr><td>Average Comment Length</td><td>".$row[11]."</td></tr>";
			}
                	if($MAX_COM_BOOL == 1) {
                	echo "<tr><td>Maximum Comment Length</td><td>".$row[12]."</td></tr>";
			}
	                if($MIN_COM_BOOL == 1) {
        	        echo "<tr><td>Minimum of Comment Length</td><td>".$row[13]."</td></tr>";
			}
                	if($STD_COM_BOOL == 1) {
                	echo "<tr><td>Standard Deviation of Comment Length</td><td>".$row[14]."</td></tr>";
			}
			if(strcmp($CORRELATION_FIRST, '') != 0) {
			echo "<tr><td>Pearson Correlation Coefficient Between ".$CORRELATION_FIRST." and ".$CORRELATION_SECOND."</td><td>".$row[16]."</td></tr>";
			}
			if(strcmp($RATIO_FIRST, '') != 0) {
                	echo "<tr><td>Average Ratio of ".$RATIO_FIRST." to ".$RATIO_SECOND."</td><td>".$row[15]."</td></tr>";
			}
			echo "</table>";
			} else {
			   echo "<h3>No Summary Statistics Chosen</h3>";
		        }
			mysqli_close($mysqli);
			 
			$result->free();
			include('open.php');
			if($mysqli->multi_query("CALL getComments($MAX_RESULTS_INT, '".$COM_ID."', '".$AUTH_ID."', '".$VIDEO_ID."', '".$COM_CONTAIN."', '".$COM_NOT_CONTAIN."', $COM_EXCEED_INT, $COM_LESS_INT, $CONTAIN_SUB_BOOL, $ALL_CAPS_BOOL, '".$BEFORE_DATE."', '".$AFTER_DATE."', $CREATED_BEFORE_VIDEO, $CREATED_BEFORE_VIDEO_SEC_INT, $CREATED_BEFORE_VIDEO_MIN_INT, $CREATED_BEFORE_VIDEO_HR_INT, $CREATED_BEFORE_VIDEO_DAY_INT, $CREATED_AFTER_VIDEO, $CREATED_AFTER_VIDEO_SEC_INT, $CREATED_AFTER_VIDEO_MIN_INT, $CREATED_AFTER_VIDEO_HR_INT, $CREATED_AFTER_VIDEO_DAY_INT, $LIKE_EXCEED_INT, $LIKE_LESS_INT, '".$SORT."', '".$SORT_DIR."', $GET_COM_ID_BOOL, $GET_COM_BOOL, $GET_AUTH_ID_BOOL, $GET_VIDEO_ID_BOOL, $GET_DATE_BOOL, $GET_LIKE_BOOL, $GET_VIDEO_BOOL);")) {
			 if($result = $mysqli->store_result()) {
                             $row = $result->fetch_row();
			   if ($GET_COM_ID_BOOL == 1 || $GET_AUTH_ID_BOOL == 1 || $GET_VIDEO_ID_BOOL == 1 || $GET_COM_BOOL == 1 || $GET_DATE_BOOL == 1 || $GET_LIKE_BOOL == 1) {
			   if(strcmp($row[0], 'ERROR: ') == 0) {
                              do {
                                 for($i = 0; $i < sizeof($row); $i++) {
                                        echo "<h3>".$row[$i]."</h3>";
                                 }
                              } while($row = $result->fetch_row());
                         } else if (strcmp($row[0], '') == 0) {
                                echo "<h3>No Such Comments Exist in the Database</h3>";
                         } else {
			   echo "<h3>Results</h3>";
			   echo "<table border =\"1px solid black\">";
			   echo "<tr>";
			   echo "<th> # </th>";
			   if ($GET_COM_ID_BOOL == 1) {
			      echo "<th> Comment ID </th>";
			   }
			   if ($GET_AUTH_ID_BOOL == 1) {
			      echo "<th> Author Channel ID </th>";
			   }
			   if ($GET_VIDEO_ID_BOOL == 1) {
			      echo "<th> Video ID Posted On </th>";
			   }
			   if ($GET_DATE_BOOL == 1) {
			      echo "<th> Date Posted </th>";
			   }
			   if ($GET_LIKE_BOOL == 1) {
			       echo "<th> Like Count </th>";
			   }
			   if ($GET_COM_BOOL == 1) {
                              echo "<th> Comment </th>";
                           }
			   if ($GET_COM_BOOL == 1) {
                              echo "<th> Video Title </th>";
                           }
			   echo "</tr>";
			   do {
                           echo "<tr>";
                           echo "<td>".$row[0]."</td>";
			   if ($GET_COM_ID_BOOL == 1) {
	                   echo "<td>".$row[1]."</td>";
                           }
			   if ($GET_AUTH_ID_BOOL == 1) {
	                   echo "<td>".$row[2]."</td>";
                           }
			   if ($GET_VIDEO_ID_BOOL == 1) {
	                   echo "<td>".$row[3]."</td>";
                           }
                           if ($GET_DATE_BOOL == 1) {
                           echo "<td>".$row[4]."</td>";
                           }
                           if ($GET_LIKE_BOOL == 1) {
                           echo "<td>".$row[5]."</td>";
                           }
			   if ($GET_COM_BOOL == 1) {
                           echo "<td>".$row[6]."</td>";
                           }
			   if ($GET_VIDEO_BOOL == 1) {
                           echo "<td>".$row[7]."</td>";
                           }
                           echo "</tr>";
                           } while($row = $result->fetch_row());
			  
    			  echo "</table>";
			  }} else {
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