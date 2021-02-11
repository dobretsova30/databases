<?php
require "constants.php";
$surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
if ($surname && $name)
{
	$data = ["surname" => $surname, "name" => $name, "date_in" => date("Y-m-d")];
	$db->insert("reader", $data);
	header("Location: /readerlist.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Reader Addition
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1>
	Reader Addition
	</h1>
	<a href = "readerlist.php"> List of readers </a>
	<form method = post>
		<label>
			Surname
		</label>
		<br>
		<input type = text name = surname>
		<br> <br>
		<label>
			Name
		</label>
		<br>
		<input type = text name = name>
		
		<br> <br>
		<button type = submit>
			Add
		</button>
	</form>
	</body>
</html>