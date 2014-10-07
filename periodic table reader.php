<?php
	//where the database is hosted
	$host = "localhost";
	//the name of the database
	$database = "periodic table test";
	//the user with SELECT permissions
	$databaseReadUser = "periodicReader";
	//the user's password
	$databasePassword = "password";

	//open a connection to the database
	@ $db = new mysqli($host, $databaseReadUser, $databasePassword, $database);
	if(mysqli_connect_errno()){
		echo "Error: Could not connect to database. Try again later.";
		exit;
	}

	$query = "SELECT * FROM Element;";
	$result = $db->query($query);

	$numResults = $result->num_rows;

	for($i = 0; $i < $numResults; $i++){
		$row = $result->fetch_object();

		echo "<div>";
		echo "<p>";
		echo "Name: " . $row->name . "<br>";
		echo "Symbol: " . $row->symbol . "<br>";
		echo "Atomic Number: " . $row->atomic_number . "<br>";
		echo "Group: " . $row->periodic_group . "<br>";
		echo "Period: " . $row->period . "<br>";
		echo "Molar Mass: " . $row->molar_mass . "<br>";
		echo "</p>";
		echo "</div>";
	}
?>