
I read somewhere that someone was having trouble setting up a database with the periodic elements in it.
Hopefully this will be helpful to soomeone out there.
I ran this on my local server. 
Simply change these parameters below as you need for it to work on your server/database.
Change them in the "periodic table creator.php" or "periodic table reader.php" files.
The creator.php will create a table and fill it with the Elements from the "Periodic Elements.json" file.
The reader.php will display them in a simply formatted way to make sure the database was filled correctly.
If anyone is curious I was using AMPPS to test this on. 
AMPPS is wonderful...


//where the database is hosted
	$host = "localhost";
//the name of the database
	$database = "periodic table test";

//the user with INSERT, DROP and CREATE permissions
	$databaseWriteUser = "periodicWriter";
//the user's password
	$databasePassword = "password";

//the user with SELECT permissions
	$databaseReadUser = "periodicReader";
//the user's password
	$databasePassword = "password";