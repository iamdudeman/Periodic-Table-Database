<?php
	//format the data from the json file into what our database wants
	function getElementEntryLine($name, $symbol, $atomicNumber, $group, $period, $molarMass){ 
		return "(\"$name\", \"$symbol\", $atomicNumber, $group, $period, $molarMass)";
	}

	//where the database is hosted
	$host = "localhost";
	//the name of the database
	$database = "periodic table test";
	//the user with INSERT, DROP and CREATE permissions
	$databaseWriteUser = "periodicWriter";
	//the user's password
	$databasePassword = "password";


	//get the raw file from the elements file
	$periodicraw = file_get_contents("Periodic Elements.json");
	if(!$periodicraw){
		echo "Could not read in elements";
		exit();
	}

	//open a connection to the database
	@ $db = new mysqli($host, $databaseWriteUser, $databasePassword, $database);
	if(mysqli_connect_errno()){
		echo "Error: Could not connect to database. Try again later.";
		exit;
	}

	//drop the table that is already there so we can full it up with new stuff
	$elementTableDropQuery = "DROP TABLE IF EXISTS Element;";
	$success = mysqli_query($db, $elementTableDropQuery);
	if(!$success){
		echo "Element table could not be dropped";
		exit;
	}

	//create the Element table so we can fill up our database
	$elementTableCreateQuery = 
"CREATE TABLE Element(
	name VARCHAR(20) not null,
	symbol CHAR(3) not null,
	atomic_number INT not null,
	periodic_group INT,
	period INT not null,
	molar_mass DOUBLE not null,
	CONSTRAINT PRIMARY KEY(atomic_number)
);";
	$success = mysqli_query($db, $elementTableCreateQuery);
	if(!$success){
		echo "Element table could not be created";
		exit;
	}

	//decode the raw elements file as a json file
	$periodicjson = json_decode($periodicraw);

	//will contain all the entries for the mysql INSERT
	$elementEntries = "";
	//begin constructing the query
	foreach($periodicjson->{"elements"} as $element){
		$group = $element->{'group'};
		//if the group is null in the json file then set its value to "null" before inserting into database
		if($group == null){
			$group = "null";
		}

		//format the data how we want it
		$entryLine = getElementEntryLine($element->{'name'}, $element->{'symbol'}, $element->{'atomic-number'},
			$group, $element->{'period'}, $element->{'molar-mass'});
		//add a comma to separate entries
		$elementEntries .= $entryLine . ",";
	}

	//remove the extra comma
	$elementEntries = substr_replace($elementEntries, "", -1);

	//finish constructing query
	$query = "INSERT INTO Element(name, symbol, atomic_number, periodic_group, period, molar_mass) VALUES $elementEntries;";
	//run query and check for success
	$success = mysqli_query($db, $query);
	if(!$success){
		echo $query . "<br>";
		echo "Elements were not added. <br>";
	}
?>