<?php
require "constants.php";
$author_surname = filter_input(INPUT_POST, "author_surname", FILTER_SANITIZE_STRING);
$author_name = filter_input(INPUT_POST, "author_name", FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$cost = filter_input(INPUT_POST, "cost", FILTER_SANITIZE_NUMBER_INT);
if ($author_surname && $author_name && $title && $cost)
{
	$data = [
		"author_surname" => $author_surname,
		"author_name" => $author_name,
		"title" => $title,
		"cost" => $cost,
		];
	
	$db->insert("book", $data);
	header("Location: /booklist.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Book Addition
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1>
	Book Addition
	</h1>
	<a href = "booklist.php"> List of books </a>
	<form method = post>
		<label>
			Author's surname
		</label>
		<br>
		<input type = text name = author_surname>
		<br> <br>
		<label>
			Author's name
		</label>
		<br>
		<input type = text name = author_name>
		<br><br>
		<label>
			Title
		</label>
		<br>
		<input type = text name = "title">
		
		<br><br>
		<label>
			Cost
		</label>
		<br>
		<input type = number name = cost>
		
		<br> <br>
		<button type = submit>
			Add
		</button>
	</form>
	</body>
</html>