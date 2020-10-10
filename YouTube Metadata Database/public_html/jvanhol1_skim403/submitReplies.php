<body>
	<html>
		<body>
			<h2>Query Results</h2>
			<form action='replies.html' method='post'>
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
		$REPLY_COMMENT_ID = $_POST['REPLY_COMMENT_ID'];
		$ORIGINAL_COMMENT_ID = $_POST['ORIGINAL_COMMENT_ID'];
		$SORT = $_POST['SORT'];
		$SORT_DIR = $_POST['SORT_DIR'];
		$GET_COUNT = $_POST['GET_COUNT'];
		$GET_COUNT_BOOL = 0;
		$GET_PER = $_POST['GET_PER'];
		$GET_PER_BOOL = 1;
		$GET_REPLY_COMMENT_ID = $_POST['GET_REPLY_COMMENT_ID'];
		$GET_REPLY_COMMENT_ID_BOOL = 0;
		$GET_ORIGINAL_COMMENT_ID = $_POST['GET_ORIGINAL_COMMENT_ID'];
		$GET_ORIGINAL_COMMENT_ID_BOOL = 0;

		if (strcmp($ORDER_DIR, '') != 0 && strcmp($ORDER, '') == 0) {
		   echo "<h2>Error: must select what to order by if selected ascending or descending order";
		   exit();
		}
		echo "<h3>Query Parameters Submitted</h3>";

		if (strcmp($MAX_RESULTS, '') != 0 || strcmp($REPLY_COMMENT_ID, '') != 0 || strcmp($ORIGINAL_COMMENT_ID, '') != 0) {
		   echo "<h3>&emsp;Filtered By:</h3>";
		} else {
		   echo "<h3>&emsp;No Filters Chosen</h3>";
		}
		if (strcmp($MAX_RESULTS, '') != 0) {
		   echo "&emsp;&emsp;Maximum results to be displayed: ".$MAX_RESULTS."<br>";
                   $MAX_RESULTS_INT = (int)$MAX_RESULTS;
		}
		if (strcmp($REPLY_COMMENT_ID, '') != 0) {
		   echo "&emsp;&emsp;Only reply comments with ID: ".$REPLY_COMMENT_ID."<br>";
		}
		if (strcmp($ORIGINAL_COMMENT_ID, '') != 0) {
		   echo "&emsp;&emsp;Only original comments with ID: ".$ORIGINAL_COMMENT_ID."<br>";
		}

		if (strcmp($SORT, '') == 0) {
		   echo "<h3>&emsp;No Sorting Chosen</h3>";
		} else {
		   echo "<h3>&emsp;Sorted by:</h3>";
		   echo "&emsp;&emsp;".$SORT;
		   if (strcmp($SORT_DIR, '') != 0) {
		      echo ", ".$SORT_DIR;
		   }
		}

		if (strcmp($GET_COUNT, '') != 0) {
		   $GET_COUNT_BOOL = 1;
		}
		if (strcmp($GET_PER, '') != 0) {
		   $GET_PER_BOOL = 1;
		}

		if (strcmp($GET_REPLY_COMMENT_ID, '') != 0) {
		   $GET_REPLY_COMMENT_ID_BOOL = 1;
		}
		if (strcmp($GET_ORIGINAL_COMMENT_ID, '') != 0) {
		   $GET_ORIGINAL_COMMENT_ID_BOOL = 1;
		}

		if ($mysqli->multi_query("CALL getRepliesStatistics($MAX_RESULTS_INT, '".$REPLY_COMMENT_ID."', '".$ORIGINAL_COMMENT_ID."', '".$SORT."', '".$SORT_DIR."', $GET_COUNT_BOOL, $GET_PER_BOOL);")) {
		   if ($result = $mysqli->store_result()) {
		      $row = $result->fetch_row();
		      if (strcmp($row[0], 'ERROR: ') == 0) {
		      	 do {
			    for ($i = 0; $i < sizeof($row); $i++) {
			    	echo "<h3>".$row[$i]."</h3>";
			    }
			 } while ($row = $result->fetch_row());
		      } else if (strcmp($row[0], '') ==0) {
		      	echo "<h3>No Such Replies Exist in the Database</h3>";
		      } else {
		      	if ($GET_COUNT_BOOL == 1 || $GET_PER_BOOL == 1) {
			   echo "<h3>Summary Statistics</h3>";
			   echo "<table border =\"1px solid black\">";
			   if ($GET_COUNT_BOOL == 1) {
			      echo "<tr><td>Result Count</td><td>".$row[2]."</td></tr>";
			   }
			   if ($GET_PER_BOOL == 1) {
			      echo "<tr><td>Result Count as a Percentage of Total</td><td>".$row[1]."%</td></tr>";
			   }
			   echo "</table>";
			} else {
			  echo "<h3>No Summary Statistics Chosen</h3>";
			}
			mysqli_close($mysqli);

			$result->free();
			include('open.php');

			if ($mysqli->multi_query("CALL getReplies($MAX_RESULTS_INT, '".$REPLY_COMMENT_ID."', '".$ORIGINAL_COMMENT_ID."', '".$SORT."', '".$SORT_DIR."', $GET_REPLY_COMMENT_ID_BOOL, $GET_ORIGINAL_COMMENT_ID_BOOL);")) {
			   if ($result = $mysqli->store_result()) {
			      $row = $result->fetch_row();
			      if ($GET_REPLY_COMMENT_ID_BOOL == 1 || $GET_ORIGINAL_COMMENT_ID_BOOL == 1) {
			      	 if (strcmp($row[0], 'ERROR: ') == 0) {
				    do {
				       for ($i = 0; $i < sizeof($row); $i++) {
				       	   echo "<h3>".$row[$i]."</h3>";
				       }
				    } while ($row = $result->fetch_row());
				 } else if (strcmp($row[0], '') == 0) {
				   echo "<h3>No Such Replies Exist in the Database</h3>";
				 } else {
				   echo "<h3>Results</h3>";
				   echo "<table border =\"1px solid black\">";
				   echo "<tr>";
				   echo "<th> # </th>";
				   if ($GET_REPLY_COMMENT_ID_BOOL == 1) {
				      echo "<th> Reply Comment ID </th>";
				   }
				   if ($GET_ORIGINAL_COMMENT_ID_BOOL == 1) {
				      echo "<th> Original Comment ID </th>";
				   }
				   echo "</tr>";
				   do {
				      echo "<tr>";
				      echo "<td>".$row[0]."</td>";
				      if ($GET_REPLY_COMMENT_ID_BOOL == 1) {
				      	 echo "<td>".$row[1]."</td>";
				      }
				      if ($GET_ORIGINAL_COMMENT_ID_BOOL == 1) {
				      	 echo "<td>".$row[2]."</td>";
				      }
				      echo "</tr>";
				   } while ($row = $result->fetch_row());
				   echo "</table>";
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