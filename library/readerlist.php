<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			List of readers
		</title>
		<meta charset - utf-8>
	</head>
	<body>
		<?php
		require "constants.php";
		$sql = "select * from reader";
		$readerlist = $db->select($sql);
		?>
		<h1> List of readers </h1>
		<a href = "/"> Main page </a>
		<br>
		<a href = "ReaderAdd.php"> Add a reader </a>
		<table border = "1">
			<tr>
				<th> id </th>
				<th> surname </th>
				<th> name </th>
				<th> date_in </th>
				<th> date_out </th>
			</tr>
			<?php
				foreach($readerlist as $reader): 
			?>
			<tr>
				<td> <?= $reader['id'] ?> </td>
				<td> <a href = "readercard.php?id=<?= $reader['id'] ?>"> <?= $reader['surname'] ?> </a></td>
				<td> <?= $reader['name'] ?> </td>
				<td> <?= $reader['date_in'] ?> </td>
				<td> <?= $reader['date_out'] ?> </td>
			</tr>
			<?php
				endforeach;
			?>
		</table>
	</body>
</html>
