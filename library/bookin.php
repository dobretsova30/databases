<?php
require "constants.php";
$book_id = filter_input(INPUT_GET, "book_id", FILTER_SANITIZE_NUMBER_INT);
$amount = filter_input(INPUT_POST, "amount", FILTER_SANITIZE_NUMBER_INT);

if ($amount)
{
	$data = [
		"book_id" => $book_id,
		"amount" => $amount,
		"dt" => date("Y-m-d")
		];
	
	$db->insert("book_transaction", $data);
	header("Location: /bookcard.php?id=".$book_id);
	exit;
}
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>

	<head>
		<title>
			Book Write-on
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1>
		Book Write-on
	</h1>
	<a href = "bookcard.php?id = <?=$book_id?>"> Card of book </a>
	<form method = post action = "/bookin.php?book_id=<?=$book_id?>">
		<label>
			Amount
		</label>
		<br>
		<input type = number name = amount min = 1 value = 1>

		<br> <br>
		<button type = submit>
			Add
		</button>
	</form>
	</body>
</html>