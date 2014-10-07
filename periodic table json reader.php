<?php
	//get the raw file from the elements file
	$periodicraw = file_get_contents("Periodic Elements.json");
	if(!$periodicraw){
		echo "Could not read in elements";
		exit();
	}

	//decode the raw elements file as a json file
	$periodicjson = json_decode($periodicraw);

	//echo out each element
	foreach($periodicjson->{"elements"} as $element){
		$group = $element->{'group'};
		//if the group is null in the json file then set its value to "none" before echoing
		if($group == null){
			$group = "none";
		}

		//format element for echoing
		echo "<div>";
		echo "<p>";
		echo "Name: " . $element->{'name'} . "<br>";
		echo "Symbol: " . $element->{'symbol'} . "<br>";
		echo "Atomic Number: " . $element->{'atomic-number'} . "<br>";
		echo "Group: " . $group . "<br>";
		echo "Period: " . $element->{'period'} . "<br>";
		echo "Molar Mass: " . $element->{'molar-mass'} . "<br>";
		echo "</p>";
		echo "</div>";
	}
?>