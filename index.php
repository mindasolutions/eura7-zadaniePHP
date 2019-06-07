<?php

require_once "weekcounter.php";

// Above for manual use
// $counter = new WeekCounter(2019,3,4);

if($_POST) {
	$data = explode("-", $_POST['date']);
	$counter = new WeekCounter($data[0],$data[1],$data[2]);
	echo $counter->whichWeek();
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Week Counter</title>
</head>
<body>
	<form action="" method="POST">
		<input type="date" name="date">
		<input type="submit" value="Check weeks">
	</form>
</body>
</html>