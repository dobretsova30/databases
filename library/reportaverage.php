<?php 
	require "constants.php";
	$sql = "SELECT r.surname, r.name, count(t.id) cnt FROM transaction t
		LEFT JOIN reader r on r.id = t.reader_id WHERE datediff(curdate(), t.date_rent) <= 365 GROUP BY 1, 2 
		ORDER BY cnt DESC";
	$readerlist = $db->select($sql);
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Reports
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1> Books read per year </h1>
	<a href = "index.html"> Main page </a>
	<br>
	<br>
	<?php if ($readerlist):?>
		<table border = "1">
		<tr> 
			<th> Surname </th> 
			<th> Name </th>
			<th> How many books has he read </th>
		</tr>
		<?php foreach ($readerlist as $reader): ?>
		<tr>
			<td> <?=$reader["surname"]?> </td>
			<td> <?=$reader["name"]?> </td>
			<td> <?=$reader["cnt"]?> </td>
		</tr>
		<?php endforeach; ?>
		</table>

	 
	<?php endif; ?>

	</body>
</html>