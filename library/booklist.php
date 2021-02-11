<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			List of books
		</title>
		<meta charset - utf-8>
	</head>
	<body>
		<?php
		require "constants.php";
		$sql = "select *, (SELECT ifnull(sum(amount), 0) FROM book_transaction WHERE book_id = book.id) amount,
			(SELECT ifnull(count(*), 0) FROM transaction WHERE book_id = book.id AND status not in('returned', 'lost'))
			amount_rented from book";
			
		$booklist = $db->select($sql);
		?>
		<h1> List of books </h1>
		<a href = "/"> Main page </a>
		<br>
		<a href = "bookadd.php"> Add a book </a>
		<table border = "1">
			<tr>
				<th> id </th>
				<th> author_surname </th>
				<th> author_name </th>
				<th> title </th>
				<th> amount </th>
				<th> amount available </th>
				<th> cost </th>
				<th> Actions </th>
			</tr>
			<?php
				foreach($booklist as $book): 
			?>
			<tr>
				<td> <?= $book['id'] ?> </td>
				<td> <?= $book['author_surname'] ?> </td>
				<td> <?= $book['author_name'] ?> </td>
				<td> <?= $book['title'] ?> </td>
				<td> <?= $book['amount'] ?> </td>
				<td> <?= $book["amount"] - $book["amount_rented"] ?> </td>
				<td> <?= $book['cost'] ?> </td>
				<td> 
					<a href = "bookcard.php?id=<?=$book['id']?>"> View card </a> 
					<?php if ($book["amount"] - $book["amount_rented"] > 0): ?>
						<a href = "transaction.php?book_id=<?=$book['id']?>"> Rent </a> 
					<?php endif; ?>
				</td>
			</tr>
			<?php
				endforeach;
			?>
		</table>
		<br>
		<a href = "booksearch.php"> Search </a>
		
	</body>
</html>
