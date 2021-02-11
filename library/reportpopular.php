<?php
require "constants.php";
$date_from = filter_input(INPUT_GET, "date_from", FILTER_SANITIZE_STRING);
$date_to = filter_input(INPUT_GET, "date_to", FILTER_SANITIZE_STRING);
$booklist = [];

if ($date_from && $date_to)
{
	$d1 = new DateTime($date_from);
	$d2 = new DateTime($date_to);
	if ($d1 > $d2)
	{
		$date_from = $d2->format("Y-m-d");
		$date_to = $d1->format("Y-m-d");
	}
	$sql = "SELECT t.book_id, b.author_surname, b.author_name,
		b.title,
		count(*) cnt from transaction t LEFT JOIN book b on b.id = t.book_id WHERE
		t.date_rent BETWEEN '".$date_from."' AND '".$date_to."' group by 1, 2, 3, 4 order by 5 desc
		limit 100";
	$booklist = $db->select($sql);
}
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Reports
		</title>
		<meta charset - utf-8>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	</head>
	<body>
	<h1> Most popular books </h1>
	<a href = "index.html"> Main page </a>
	<br>
	<br>
	<form action = "" method = "get">
		<label>
			From:
		</label>
		<input type = text name = date_from class = date_picker value = "<?=$date_from?>">
		<br><br>
		<label>
			To:
		</label>
		<input type = text name = date_to class = date_picker value = "<?=$date_to?>">
		<br><br>
		<button type = submit> Choose period </button>
	</form>
	<?php if ($booklist):?>
		<table border = "1">
		<tr> 
			<th> Author </th> 
			<th> Title </th>
			<th> How many times the book was rented </th>
		</tr>
		<?php foreach ($booklist as $book): ?>
		<tr>
			<td> <?=$book["author_surname"]?> <?=$book["author_name"]?> </td>
			<td> <?=$book["title"]?> </td>
			<td> <?=$book["cnt"]?> </td>
		</tr>
		<?php endforeach; ?>
		</table>

	 
	<?php endif; ?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script> 
		$(document).ready(function()
		{
			$(".date_picker").datepicker({dateFormat: "yy-mm-dd"});
		});
	</script>
	</body>
</html>