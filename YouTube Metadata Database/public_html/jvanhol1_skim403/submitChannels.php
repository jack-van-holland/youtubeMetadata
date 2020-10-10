<body>
	<html>
		<body>
			<h2>Query Results</h2>
			<form action='channels.html' method='post'>
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
		ini_set(‘display_errors’, false);
		ini_set(‘error_log’, ‘/tmp/php.log’);
		error_log('hi');
		$MAX_RESULTS = $_POST['MAX_RESULTS'];
		$MAX_RESULTS_INT = 2147483647;
		$CHANNEL_ID = $_POST['CHANNEL_ID'];
		$TITLE_CONTAIN = $_POST['TITLE_CONTAIN'];
		$TITLE_NOT_CONTAIN = $_POST['TITLE_NOT_CONTAIN'];
		//$TITLE_START = $_POST['TITLE_START'];
		//$TITLE_END = $_POST['TITLE_END'];
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
		$DESC_ALL_CAPS	= $_POST['DESC_ALL_CAPS'];
                $DESC_ALL_CAPS_BOOL = 0;
		$BEFORE = $_POST['BEFORE'];
		$BEFORE_DATE = '2500-01-01 00:00:00';
		$AFTER = $_POST['AFTER'];
		$AFTER_DATE = '1900-01-01 00:00:00';
		$SUB_EXCEED = $_POST['SUB_EXCEED'];
		$SUB_EXCEED_INT = -1;
		$SUB_LESS = $_POST['SUB_LESS'];
		$SUB_LESS_INT = -1;
		$VIEW_EXCEED = $_POST['VIEW_EXCEED'];
		$VIEW_EXCEED_INT = -1;
		$VIEW_LESS = $_POST['VIEW_LESS'];
		$VIEW_LESS_INT = -1;
		$COUNTRY = $_POST['COUNTRY'];
		$SORT = $_POST['SORT'];
		$SORT_DIR = $_POST['SORT_DIR'];
		$GET_COUNT = $_POST['GET_COUNT'];
		$GET_COUNT_BOOL = 0;
		$GET_PER = $_POST['GET_PER'];
		$GET_PER_BOOL = 0;
		$AVE_SUB = $_POST['AVE_SUB'];
		$AVE_SUB_BOOL = 0;
		$MAX_SUB = $_POST['MAX_SUB'];
		$MAX_SUB_BOOL = 0;
		$MIN_SUB = $_POST['MIN_SUB'];
		$MIN_SUB_BOOL = 0;
		$STD_SUB = $_POST['STD_SUB'];
		$STD_SUB_BOOL = 0;
		$AVE_VIEW = $_POST['AVE_VIEW'];
		$AVE_VIEW_BOOL = 0;
		$MAX_VIEW = $_POST['MAX_VIEW'];
		$MAX_VIEW_BOOL = 0;
		$MIN_VIEW = $_POST['MIN_VIEW'];
		$MIN_VIEW_BOOL = 0;
		$STD_VIEW = $_POST['STD_VIEW'];
		$STD_VIEW_BOOL = 0;
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
		$FREQ_COUNTRY = $_POST['FREQ_COUNTRY'];
		$FREQ_COUNTRY_INT = -1;
		$CORRELATION_FIRST = $_POST['CORRELATION_FIRST'];
		$CORRELATION_SECOND = $_POST['CORRELATION_SECOND'];
		$RATIO_FIRST = $_POST['RATIO_FIRST'];
		$RATIO_SECOND = $_POST['RATIO_SECOND'];
		$GET_CHANNEL_ID = $_POST['GET_CHANNEL_ID'];
		$GET_CHANNEL_ID_BOOL = 0;
		$GET_TITLE = $_POST['GET_TITLE'];
		$GET_TITLE_BOOL = 0;
		$GET_DATE = $_POST['GET_DATE'];
		$GET_DATE_BOOL = 0;
		$GET_VIEWS = $_POST['GET_VIEWS'];
		$GET_VIEWS_BOOL = 0;
		$GET_SUB = $_POST['GET_SUB'];
		$GET_SUB_BOOL = 0;
		$GET_DESC = $_POST['GET_DESC'];
		$GET_DESC_BOOL = 0;
		$GET_COUNTRY = $_POST['GET_COUNTRY'];
		$GET_COUNTRY_BOOL = 0;
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
		if(strcmp($MAX_RESULTS, '') != 0 || strcmp($CHANNEL_ID, '') != 0 || strcmp($TITLE_CONTAIN, '') != 0 || strcmp($TITLE_NOT_CONTAIN, '') != 0 || strcmp($TITLE_EXCEED, '') != 0 || strcmp($TITLE_LESS, '') != 0 || strcmp($TITLE_ALL_CAPS, '') != 0 || strcmp($DESC_ALL_CAPS, '') != 0  || strcmp($DESC_CONTAIN, '') != 0 || strcmp($DESC_NOT_CONTAIN, '') != 0 || strcmp($DESC_EXCEED, '') != 0 || strcmp($DESC_LESS, '') != 0 || strcmp($BEFORE, '') != 0 || strcmp($AFTER, '') != 0 || strcmp($SUB_EXCEED, '') != 0 || strcmp($SUB_LESS, '') != 0 || strcmp($VIEW_EXCEED, '') != 0 || strcmp($VIEW_LESS, '') != 0 || strcmp($COUNTRY, '') != 0) {
		echo "<h3>&emsp;Filtered By:</h3>";			
		} else {
		echo "<h3>&emsp;No Filters Chosen</h3>";
		}		
		if (strcmp($MAX_RESULTS, '') != 0) {
		   echo "&emsp;&emsp;Maximum results to be displayed: ".$MAX_RESULTS."<br>";
		   $MAX_RESULTS_INT = (int)$MAX_RESULTS;
		}
                if (strcmp($CHANNEL_ID, '') != 0) {
                   echo "&emsp;&emsp;Only channels with ID: ".$CHANNEL_ID."<br>";
                }
		if (strcmp($TITLE_CONTAIN, '') != 0) {
			echo "&emsp;&emsp;Title must contain: ".$TITLE_CONTAIN."<br>";
		}
                if (strcmp($TITLE_NOT_CONTAIN, '') != 0) {
                   echo "&emsp;&emsp;Title must not contain: ".$TITLE_NOT_CONTAIN."<br>";
                }
                if (strcmp($TITLE_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Title must exceed length: ".$TITLEXCEED."<br>";
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
                   echo "&emsp;&emsp;Description must be All-Caps<br>";
                   $DESC_ALL_CAPS_BOOL = 1;
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
                if (strcmp($SUB_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;Subscriber count must exceed: ".$SUB_EXCEED."<br>";
		   $SUB_EXCEED_INT = (int)$SUB_EXCEED;
                }
                if (strcmp($SUB_LESS, '') != 0) {
                   echo "&emsp;&emsp;Subcriber count must be less than: ".$SUB_LESS."<br>";
		   $SUB_LESS_INT = (int)$SUB_LESS;
                }
                if (strcmp($VIEW_EXCEED, '') != 0) {
                   echo "&emsp;&emsp;View count must exceed: ".$VIEW_EXCEED."<br>";
		   $VIEW_EXCEED_INT = (int)$VIEW_EXCEED;
                }
                if (strcmp($VIEW_LESS, '') != 0) {
                   echo "&emsp;&emsp;View count less than: ".$VIEW_LESS."<br>";
		   $VIEW_LESS_INT = (int)$VIEW_LESS;   
		}
                if (strcmp($COUNTRY, '') != 0) {
                   echo "&emsp;&emsp;Must be from: ".$COUNTRY."<br>";
                }
		if(strcmp($SORT, '') == 0) {
			echo "<h3>&emsp;No Sorting Chosen</h3>";	
		} else {
		  echo "<h3>&emsp;Sorted by:</h3>";
		  echo "&emsp;&emsp;".$SORT;
		  if (strcmp($SORT_DIR, '') != 0) {
		     echo ", ".$SORT_DIR;
		  }
		  echo "<br>";
		}
		if(strcmp($GET_COUNT, '') != 0) {
		$GET_COUNT_BOOL = 1;
		}
		if(strcmp($GET_PER, '') != 0) {
		$GET_PER_BOOL = 1;
		}
		if(strcmp($AVE_SUB, '') != 0) {
		$AVE_SUB_BOOL = 1;
		}
		if(strcmp($MAX_SUB, '') != 0) {
		$MAX_SUB_BOOL = 1;
		}
		if(strcmp($MIN_SUB, '') != 0) {
		$MIN_SUB_BOOL = 1;
		}
		if(strcmp($STD_SUB, '') != 0) {
		$STD_SUB_BOOL = 1;
		}
		if(strcmp($AVE_VIEW, '') != 0) {
		$AVE_VIEW_BOOL = 1;
		}
                if(strcmp($MAX_VIEW, '') != 0) {
		$MAX_VIEW_BOOL = 1;
		}
                if(strcmp($MIN_VIEW, '') != 0) {
		$MIN_VIEW_BOOL = 1;
		}		
                if(strcmp($STD_VIEW, '') != 0) {
		$STD_VIEW_BOOL = 1;
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
		if(strcmp($AVE_TITLE, '') != 0) {
		$AVE_TITLE_BOOL = 1;
		}
                if(strcmp($MAX_TITLE, '') != 0) {
		$MAX_TITLE_BOOL = 1;
		}
                if(strcmp($MIN_TITLE, '') != 0) {
		$MIN_TITLE_BOOL = 1;
		}
                if(strcmp($STD_TITLE, '') != 0) {
		$STD_TITLE_BOOL = 1;
		}
		if(strcmp($AVE_DESC, '') != 0) {
		$AVE_DESC_BOOL = 1;
		}
                if(strcmp($MAX_DESC, '') != 0) {
		$MAX_DESC_BOOL = 1;
		}
                if(strcmp($MIN_DESC, '') != 0) {
		$MIN_DESC_BOOL = 1;
		}
                if(strcmp($STD_DESC, '') != 0) {
		$STD_DESC_BOOL = 1;
                }
		if(strcmp($FREQ_COUNTRY, '') != 0) {
		$FREQ_COUNTRY_INT = (int)$FREQ_COUNTRY;
		}
		if(strcmp($GET_CHANNEL_ID, '') != 0) {
      		$GET_CHANNEL_ID_BOOL = 1;
                }
		if(strcmp($GET_TITLE, '') != 0) {
		$GET_TITLE_BOOL = 1;
                }
		if(strcmp($GET_DATE, '') != 0) {
		$GET_DATE_BOOL = 1;
                }
		if(strcmp($GET_VIEWS, '') != 0) {
		$GET_VIEWS_BOOL = 1;
                }
		if(strcmp($GET_SUB, '') != 0) {
		$GET_SUB_BOOL = 1;
                }
		if(strcmp($GET_DESC, '') != 0) {
		$GET_DESC_BOOL = 1;
                }
		if(strcmp($GET_COUNTRY, '') != 0) {
		$GET_COUNTRY_BOOL = 1;
                }
		if ($mysqli->multi_query("CALL getChannelsStatistics($MAX_RESULTS_INT, '".$CHANNEL_ID."', '".$TITLE_CONTAIN."', '".$TITLE_NOT_CONTAIN."', $TITLE_EXCEED_INT, $TITLE_LESS_INT, $TITLE_ALL_CAPS_BOOL, '".$DESC_CONTAIN."', '".$DESC_NOT_CONTAIN."', $DESC_EXCEED_INT, $DESC_LESS_INT, $DESC_ALL_CAPS_BOOL, '".$BEFORE_DATE."', '".$AFTER_DATE."', $SUB_EXCEED_INT, $SUB_LESS_INT, $VIEW_EXCEED_INT, $VIEW_LESS_INT, '".$COUNTRY."', '".$SORT."', '".$SORT_DIR."', $GET_COUNT_BOOL, $GET_PER_BOOL, $AVE_SUB_BOOL, $MAX_SUB_BOOL, $MIN_SUB_BOOL, $STD_SUB_BOOL, $AVE_VIEW_BOOL, $MAX_VIEW_BOOL, $MIN_VIEW_BOOL, $STD_VIEW_BOOL, $AVE_DATE_BOOL, $MAX_DATE_BOOL, $MIN_DATE_BOOL, $STD_DATE_BOOL, $AVE_TITLE_BOOL, $MAX_TITLE_BOOL, $MIN_TITLE_BOOL, $STD_TITLE_BOOL, $AVE_DESC_BOOL, $MAX_DESC_BOOL, $MIN_DESC_BOOL, $STD_DESC_BOOL, '".$CORRELATION_FIRST."', '".$CORRELATION_SECOND."', '".$RATIO_FIRST."', '".$RATIO_SECOND."');")) {
		   if($result = $mysqli->store_result()) {
		   $row = $result->fetch_row();
		   	if(strcmp($row[0], 'ERROR: ') == 0) {
			      do {
				 for($i = 0; $i < sizeof($row); $i++) {
				 	echo "<h3>".$row[$i]."</h3>";
				 }
		   	      } while($row = $result->fetch_row());
			 } else if (strcmp($row[0], '') == 0) {
			   	echo "<h3>No Such Channels Exist in the Database</h3>"; 	  
			 } else {
			   if($GET_COUNT_BOOL == 1 || $GET_PER_BOOL == 1 || $AVE_SUB_BOOL == 1 || $MAX_SUB_BOOL == 1 || $MIN_SUB_BOOL == 1 || $STD_SUB_BOOL == 1 || $AVE_VIEW_BOOL == 1 || $MAX_VIEW_BOOL == 1 || $MIN_VIEW_BOOL == 1|| $STD_VIEW_BOOL == 1 || $AVE_DATE_BOOL == 1 || $MAX_DATE_BOOL == 1 || $MIN_DATE_BOOL == 1 || $STD_DATE_BOOL == 1 || $AVE_TITLE_BOOL == 1 || $MAX_TITLE_BOOL == 1 || $MIN_TITLE_BOOL == 1 || $STD_TITLE_BOOL == 1 || $AVE_DESC_BOOL == 1 || $MAX_DESC_BOOL == 1 || $MIN_DESC_BOOL == 1 || $STD_DESC_BOOL == 1 || $FREQ_COUNTRY_INT != -1 || strcmp($RATIO_FIRST, '' ) != 0 || strcmp($CORRELATION_FIRST, '') != 0) {
			   echo "<h3>Summary Statistics</h3>";
			   echo "<table border =\"1px solid black\">";
			   if ($GET_COUNT_BOOL == 1) {
			   echo "<tr><td>Result Count</td><td>".$row[2]."</td></tr>";
			   }
			   if ($GET_PER_BOOL == 1) {
			   echo "<tr><td>Result Count as a Percentage of Total</td><td>".$row[1]."%</td></tr>";
			   }
			   if($AVE_SUB_BOOL == 1) {
			   echo "<tr><td>Average Subscriber Count</td><td>".$row[3]."</td></tr>";
			   }
	      		if($MAX_SUB_BOOL == 1) {
               		echo "<tr><td>Maximum Subscriber Count</td><td>".$row[4]."</td></tr>";
			}
			if($MIN_SUB_BOOL == 1) {
			echo "<tr><td>Minimum of Subscriber Count</td><td>".$row[5]."</td></tr>";
			}
			if($STD_SUB_BOOL == 1) {
	                echo "<tr><td>Standard Deviation of Subscriber Count</td><td>".$row[6]."</td></tr>";
			}
			if($AVE_VIEW_BOOL == 1) {
                	echo "<tr><td>Average View Count</td><td>".$row[7]."</td></tr>";
			}
	                if($MAX_VIEW_BOOL == 1) {
                	echo "<tr><td>Maximum View Count</td><td>".$row[8]."</td></tr>";
			}
	                if($MIN_VIEW_BOOL == 1) {
        	        echo "<tr><td>Minimum of View Count</td><td>".$row[9]."</td></tr>";
			}		
	                if($STD_VIEW_BOOL == 1) {
        	        echo "<tr><td>Standard Deviation of View Count</td><td>".$row[10]."</td></tr>";
			}
			if($AVE_DATE_BOOL == 1) {
        	        echo "<tr><td>Average Datetime Created</td><td>".$row[11]."</td></tr>";
			}
	                if($MAX_DATE_BOOL == 1) {
        	        echo "<tr><td>Most Recent Datetime Created</td><td>".$row[12]."</td></tr>";
			}
	                if($MIN_DATE_BOOL == 1) {
        	        echo "<tr><td>Earliest Datetime Created</td><td>".$row[13]."</td></tr>";
			}
                	if($STD_DATE_BOOL == 1) {
                	echo "<tr><td>Standard Deviation of Datetime (in days)</td><td>".$row[14]."</td></tr>";
			}
			if($AVE_TITLE_BOOL == 1) {
               		echo "<tr><td>Average Title Length</td><td>".$row[15]."</td></tr>";
			}
                	if($MAX_TITLE_BOOL == 1) {
                	echo "<tr><td>Maximum Title Length</td><td>".$row[16]."</td></tr>";
			}
	                if($MIN_TITLE_BOOL == 1) {
        	        echo "<tr><td>Minimum of Title Length</td><td>".$row[17]."</td></tr>";
			}
                	if($STD_TITLE_BOOL == 1) {
                	echo "<tr><td>Standard Deviation of Title Length</td><td>".$row[18]."</td></tr>";
			}
			if($AVE_DESC_BOOL == 1) {
                	echo "<tr><td>Average Description Length</td><td>".$row[19]."</td></tr>";
			}
                	if($MAX_DESC_BOOL == 1) {
                	echo "<tr><td>Maximum Description Length</td><td>".$row[20]."</td></tr>";
			}
                	if($MIN_DESC_BOOL == 1) {
                	echo "<tr><td>Minimum of Description Length</td><td>".$row[21]."</td></tr>";
			}
                	if($STD_DESC_BOOL == 1) {
                	echo "<tr><td>Standard Deviation of Description Length</td><td>".$row[22]."</td></tr>";
                	}
			if(strcmp($CORRELATION_FIRST, '') != 0) {
			echo "<tr><td>Pearson Correlation Coefficient Between ".$CORRELATION_FIRST." and ".$CORRELATION_SECOND."</td><td>".$row[24]."</td></tr>";
			}
			if(strcmp($RATIO_FIRST, '') != 0) {
                	echo "<tr><td>Average Ratio of ".$RATIO_FIRST." to ".$RATIO_SECOND."</td><td>".$row[23]."</td></tr>";
			}
			echo "</table>";
			} else {
			   echo "<h3>No Summary Statistics Chosen</h3>";
		        }
			mysqli_close($mysqli);
			 
			$result->free();
			include('open.php');
			if($mysqli->multi_query("CALL getChannels($MAX_RESULTS_INT, '".$CHANNEL_ID."', '".$TITLE_CONTAIN."', '".$TITLE_NOT_CONTAIN."', $TITLE_EXCEED_INT, $TITLE_LESS_INT, $TITLE_ALL_CAPS_BOOL, '".$DESC_CONTAIN."', '".$DESC_NOT_CONTAIN."', $DESC_EXCEED_INT, $DESC_LESS_INT, $DESC_ALL_CAPS_BOOL, '".$BEFORE_DATE."', '".$AFTER_DATE."', $SUB_EXCEED_INT, $SUB_LESS_INT, $VIEW_EXCEED_INT, $VIEW_LESS_INT, '".$COUNTRY."', '".$SORT."', '".$SORT_DIR."', $GET_CHANNEL_ID_BOOL, $GET_TITLE_BOOL, $GET_DATE_BOOL, $GET_VIEWS_BOOL, $GET_SUB_BOOL, $GET_DESC_BOOL, $GET_COUNTRY_BOOL);")) {
			 if($result = $mysqli->store_result()) {
                             $row = $result->fetch_row();
			   if ($GET_CHANNEL_ID_BOOL == 1 || $GET_TITLE_BOOL == 1 || $GET_DATE_BOOL == 1 || $GET_VIEWS_BOOL == 1 || $GET_SUB_BOOL == 1 || $GET_DESC_BOOL == 1|| $GET_COUNTRY_BOOL == 1) {
			   if(strcmp($row[0], 'ERROR: ') == 0) {
                              do {
                                 for($i = 0; $i < sizeof($row); $i++) {
                                        echo "<h3>".$row[$i]."</h3>";
                                 }
                              } while($row = $result->fetch_row());
                         } else if (strcmp($row[0], '') == 0) {
                                echo "<h3>No Such Channels Exist in the Database</h3>";
                         } else {
			   echo "<h3>Results</h3>";
			   echo "<table border =\"1px solid black\">";
			   echo "<tr>";
			   echo "<th> # </th>";
			   if ($GET_CHANNEL_ID_BOOL == 1) {
			      echo "<th> Channel ID </th>";
			   }
			   if ($GET_TITLE_BOOL == 1) {
			      echo "<th> Title </th>";
			   }
			   if ($GET_DATE_BOOL == 1) {
			      echo "<th> Date Created </th>";
			   }
			   if ($GET_VIEWS_BOOL == 1) {
			      echo "<th> View Count </th>";
			   }
			   if ($GET_SUB_BOOL == 1) {
			       echo "<th> Subscriber Count </th>";
			   }
			   if ($GET_DESC_BOOL == 1) {
			      echo "<th> Description </th>";
			   }
			   if ($GET_COUNTRY_BOOL == 1) {
			      echo "<th> Country </th>";
			   }
			   echo "</tr>";
			   do {
                           echo "<tr>";
                           echo "<td>".$row[0]."</td>";
			   if ($GET_CHANNEL_ID_BOOL == 1) {
	                   echo "<td>".$row[1]."</td>";
                           }
                           if ($GET_TITLE_BOOL == 1) {
                           echo "<td>".$row[2]."</td>";
                           }
                           if ($GET_DATE_BOOL == 1) {
                           echo "<td>".$row[3]."</td>";
                           }
                           if ($GET_VIEWS_BOOL == 1) {
                           echo "<td>".$row[4]."</td>";
                           }
                           if ($GET_SUB_BOOL == 1) {
                           echo "<td>".$row[5]."</td>";
                           }
                           if ($GET_DESC_BOOL == 1) {
                           echo "<td>".$row[6]."</td>";
                           }
			   if ($GET_COUNTRY_BOOL == 1) {
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