<?php
require "constants.php";
$author_surname = filter_input(INPUT_POST, "author_surname", FILTER_SANITIZE_STRING);
$author_name = filter_input(INPUT_POST, "author_name", FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$rows = [];
if ($author_surname || $author_name || $title)
{
	$where = [];
	if ($author_surname)
	{
		$where[] = "author_surname like '%".$author_surname."%'";
	}
	if ($author_name)
	{
		$where[] = "author_name like '%".$author_name."%'";
	}
	if ($title)
	{
		$where[] = "title like '%".$title."%'";
	}
	$sql = "select *, (SELECT ifnull(sum(amount), 0) FROM book_transaction WHERE book_id = book.id) amount,
			(SELECT ifnull(count(*), 0) FROM transaction WHERE book_id = book.id AND status not in('returned', 'lost'))
			amount_rented from book WHERE ".implode(" and ", $where);
	$rows = $db->select($sql);
}
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>

	<head>
		<title>
			Book Search
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1>
	Book Search
	</h1>
	<a href = "booklist.php"> List of books </a>
	<?php if ($author_surname || $author_name || $title): ?>
		<br>
		Found rows: <b> <?=$rows->rowCount(); ?> </b>
		<br>
		<?php if ($rows->rowCount() > 0): ?>
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
				foreach($rows as $book): 
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
					<a href = "bookcard.php?id=<?=$book['id']?>"> Card </a> 
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
		<?php else: ?>
			<br>
			Nothing found
		<?php endif; ?>
	<?php else: ?>
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
		
		<br> <br>
		<button type = submit>
			Search
		</button>
	</form>
	
	<?php endif; ?>
	</body>
</html>