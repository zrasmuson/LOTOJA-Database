<!-- 
Zach Rasmuson
CS2610
HW10 - LOTOJA Database 
Home URL: http://cs2610.cs.usu.edu/~zrasmuson/HW10/index.php
-->

<!DOCTYPE HTML>
<html lang="en">
<head>
	<?php 
	// Connecting up the database
	$mysqli = new mysqli("localhost", "lotoja_DB", "trololol", "lotoja_DB");
	if($mysqli->connect_errno)
    {
        echo "Failed to connect to mysql " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

	 ?>
	<meta charset="UTF-8"/>
	<title>Lotoja Database</title>
	<!-- Custom CSS -->
	<link href="./styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php
	// Distance between checkpoints stored as an array, minutes constant, and error bool
	$distance = array(44,43,41,37,42);
	const HOUR = 60;
	const totalDistance = 207;
	$error = false;

	// If 'results' has not yet been pressed
	if(!isset($_POST['submit']))
	{
		$interval = array_fill(0,5,"");
		$time = array_fill(0, 5, 0);
		$racerFirst = "";
		$racerLast = "";
		$racerFirstErr = "";
		$racerLastErr = "";
		$timeError = array_fill(0, 5, "");
	}

	// Once 'results has been pressed
	else
	{
		// If 'Clear' button has been pressed - not sure if this does anything
		if(isset($_POST['clear']))
		{
			$interval = array_fill(0,5,"");
			$time = array_fill(0, 5, 0);
			$racerFirst = "";
			$racerLast = "";
			$racerFirstErr = "";
			$racerLastErr = "";
			$timeError = array_fill(0, 5, "");
		}

		// All variables get copied from $_POST / clean up
		$interval = $_POST['interval'];
		$time = $_POST['interval'];
		$racerFirst = htmlentities($_POST['racerFirst']);
		$racerLast = htmlentities($_POST['racerLast']);
		
		// Checks if both racer names are filled in.
		if (empty($racerFirst)) {
			$racerFirstErr = "Cannot be empty";
			$error = true;
		}

		else {
			$racerFirstErr = "";
		}

		if (empty($racerLast)) {
			$racerLastErr = "Cannot be empty";
			$error = true;
		}

		else {
			$racerLastErr = "";
		}

		// Checks first interval separately to prevent out of bounds errors
		if (empty($interval[0]))
		{
			$timeError[0] = "Interval cannot be empty";
			$error = true;
		}

		else if ($interval[0] <= 0)
		{
			$timeError[0] = "Must be greater than 0";
			$error = true;
		}

		// Checks to see if there's any non-numeric characters
		else if (!is_numeric($interval[0]))
		{
			$timeError[0] = "Only numbers allowed";
			$error = true;
		}

		else
		{
			$timeError[0] = "";
		}

		// Loops through interval fields 2 to 5 to check if they're empty,
		// or have invalid input.
		for ($i = 1; $i < count($interval); $i++)
		{
			if (empty($interval[$i]))
			{
				$timeError[$i] = "Interval cannot be empty";
				$error = true;
			}

			else if ($interval[$i] == 0)
			{
				$timeError[$i] = "Interval cannot be zero";
				$error = true;
			}

			else if (!is_numeric($interval[$i]))
			{
				$timeError[$i] = "Only numbers allowed";
				$error = true;
			}

			else
			{
				$timeError[$i] = "";
			}

			if ($interval[$i] <= $interval[$i-1] && $interval[$i-1] >= 0 && $interval[$i] >= 0 && !empty($interval[$i]))
			{
				$timeError[$i] = "Must be greater than " . $interval[$i-1];
				$error = true;
			}

			else
			{
				//$timeError[$i] = "test1";
			}
		}
	}

	// If results has been pressed and there isn't an error then the
	// new submission will be placed into the database
	if(isset($_POST['submit']) && $error == false)
	{
		// Further clean before placing into database
		$racerFirst = $mysqli->real_escape_string($racerFirst);
		$racerLast = $mysqli->real_escape_string($racerLast);
		for ($i = 0; $i < count($interval); $i++)
		{
			$interval[$i] = $mysqli->real_escape_string($interval[$i]);
		}
		// Now placing into database
		$result = $mysqli->query("INSERT INTO racer(first, last, inter1, inter2, inter3, inter4, inter5) VALUES ('
			$racerFirst','$racerLast', $interval[0], $interval[1], $interval[2], $interval[3], $interval[4])");

		// Clears fields
		$interval = array_fill(0,5,"");
		$time = array_fill(0, 5, 0);
		$racerFirst = "";
		$racerLast = "";
		$racerFirstErr = "";
		$racerLastErr = "";
		$timeError = array_fill(0, 5, "");
		
	}
	
	?>

	<h1>Lotoja Interval Calculator</h1>
	
	<form action="index.php" method="post" class="fields">
		<div class="border">
			<div>
				<label for="racerFirst" class="racer">Racer First Name</label>
				<input id="racer" type="text" name="racerFirst" value="<?php echo $racerFirst ?>"/>
				<span class="errorMsg"><?php echo $racerFirstErr; ?></span>
			</div>
			<div>
				<label for="racerLast" class="racer">Racer Last Name</label>
				<input id="racer" type="text" name="racerLast" value="<?php echo $racerLast ?>"/>
				<span class="errorMsg"><?php echo $racerLastErr; ?></span>
			</div>
			<div>
				<label for="interval1" class="intervals">Interval 1</label>
				<input id="interval1" type="text" name="interval[]" value="<?php echo $interval[0]; ?>" />
				<span class="errorMsg"><?php echo $timeError[0]; ?></span>
			</div>
			<div>
				<label for="interval2" class="intervals">Interval 2</label>
				<input id="interval2" type="text" name="interval[]" value="<?php echo $interval[1]; ?>" />
				<span class="errorMsg"><?php echo $timeError[1];?></span>
			</div>
			<div>
				<label for="interval3" class="intervals">Interval 3</label>
				<input id="interval3" type="text" name="interval[]" value="<?php echo $interval[2]; ?>" />
				<span class="errorMsg"><?php echo $timeError[2];?></span>
			</div>
			<div>
				<label for="interval4" class="intervals">Interval 4</label>
				<input id="interval4" type="text" name="interval[]" value="<?php echo $interval[3]; ?>" />
				<span class="errorMsg"><?php echo $timeError[3];?></span>
			</div>
			<div>
				<label for="interval5" class="intervals">Interval 5</label>
				<input id="interval5" type="text" name="interval[]" value="<?php echo $interval[4]; ?>" />
				<span class="errorMsg"><?php echo $timeError[4];?></span>
			</div>
		</div>
		<span class="button"><input type="submit" value="Submit" name="submit" /></span>
		<span class="button"><input type="submit" value="Clear" name="clear" /></span>
		<h2>Results:</h2>
		<span class="button"><input type="submit" value="Sort by&#x00A;Last Name" name="sortLast" /></span>
		<span class="button"><input type="submit" value="Sort by&#x00A;First Name" name="sortFirst" /></span>
		<span class="button"><input type="submit" value="Sort by&#x00A;Speed" name="sortSpeed" /></span>
	</form>
	<?php



	// Checks for which sorting button has been pressed, if any.
	if(isset($_POST['sortLast']))
	{
		$sqlQuery = "SELECT * FROM racer ORDER BY last";
	}

	else if (isset($_POST['sortFirst']))
	{
		$sqlQuery = "SELECT * FROM racer ORDER BY first";
	}

	else if (isset($_POST['sortSpeed']))
	{
		$sqlQuery = "SELECT * FROM racer ORDER BY inter5";
	}

	else 
	{
		$sqlQuery = "SELECT * FROM racer ORDER BY id";
	}
		
	?>	
		<table>
		<thead>
			<tr>
			<?php echo "
				<th rowspan='2'>Racer</th>
				<th colspan='3'>
					Checkpoint 1<br>
					$distance[0] miles
				</th>
				<th colspan='3'>
					Checkpoint 2<br>
					$distance[1] miles
				</th>
				<th colspan='3'>
					Checkpoint 3<br>
					$distance[2] miles
				</th>
				<th colspan='3'>
					Checkpoint 4<br>
					$distance[3] miles
				</th>
				<th colspan='3'>
					Checkpoint 5<br>
					$distance[4] miles
				</th>"; ?>
				<th rowspan='2'>Overall Speed</th>
			</tr>
			<tr>
		<?php
			for ($i=0; $i<count($interval);$i++)
			{
				echo "
					<th>Interval Time</th>
					<th>Checkpoint Time</th>
					<th>Speed</th>";
			}

			echo "</tr></thead>
			<tbody>";
			$result = $mysqli->query($sqlQuery);
			while ($row = $result->fetch_assoc())
			{
				$intervalRow = array($row['inter1'], $row['inter2'], $row['inter3'], $row['inter4'], $row['inter5']);
				// Gets the total speed
				$overallSpeed = round((totalDistance / $row['inter5'] * HOUR),2);

				// Creates the time array and calculates time between check points
				$time[0] = $intervalRow[0];
				for ($i = 1; $i < count($interval); $i++)
				{
					$time[$i] = ($intervalRow[$i] - $intervalRow[$i-1]);
				}

				// Creates the speed array and calculates its values to two places
				$speed = array_fill(0, 5, 0);
				for ($i = 0; $i < count($interval); $i++)
				{
					$speed[$i] = $distance[$i] / ($time[$i]/HOUR);
					$speed[$i] = round($speed[$i],2);
				}
				echo "<tr>
				<td>$row[first] $row[last]</td>";
				for ($i=0; $i<count($interval);$i++)
				{
					echo"
					<td>$intervalRow[$i]</td>
					<td>$time[$i]</td>
					<td>$speed[$i] mph</td>";
				}
				echo "<td>$overallSpeed mph</td>";
			}
			echo "</tr></tbody></table>";
	?>
	<!-- Uncomment for testing -->
<!--   	<pre id="testing">
		<?php 
		// $_GET;
		// print_r($_POST);
		// print_r($timeError);
		?>
	</pre> -->

</body>
</html>

