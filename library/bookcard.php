<?php
require "constants.php";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$book = $db->select_one("select *, (SELECT ifnull(sum(amount), 0) FROM book_transaction WHERE book_id = book.id)
	amount from book where id = ".$id." limit 1");

$transactionlist_sql = "SELECT t.*, r.surname reader_surname, r.name reader_name  FROM `transaction` t
LEFT JOIN reader r on r.id = t.reader_id WHERE t.book_id = ".$id;
$transactionlist = $db->select($transactionlist_sql);

$rented_val_amount_sql = "SELECT ifnull(count(*), 0) FROM transaction WHERE book_id = ".$id." AND status not in('returned', 'lost')";
$rented_val_amount_rows = $db->select_one($rented_val_amount_sql);
$rented_val_amount = $rented_val_amount_rows[0];
/*
if ($rented_val_amount_rows)
{
	$rented_val_amount = count($rented_val_amount_rows);
}

echo("<pre>");
var_dump($rented_val_amount_rows);
die;
*/
?>


<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Book Card
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1> BookCard </h1>
	<a href = "index.html"> Main page  </a> <br>
	<a href = "booklist.php"> Booklist  </a>
	<table border = "1">
		<tr>
			<th> Author </th>
			<td> <?=!empty($book["author_surname"]) ? $book["author_surname"] : ""?> <?=!empty($book["author_name"]) ? $book["author_name"] : ""?> </td>
		</tr>
		<tr>
			<th> Title </th>
			<td> <?=!empty($book["title"]) ? $book["title"] : ""?> </td>
		</tr>	
		<tr>
			<th> Amount </th>
			<td> <?=!empty($book["amount"]) ? $book["amount"] : "0"?> </td>
		</tr>
		<tr>
			<th> Amount available </th>
			<td> <?=$book["amount"] - $rented_val_amount ?> </td>
		</tr>
		<tr>
			<th> Cost </th>
			<td> <?=!empty($book["cost"]) ? $book["cost"] : ""?> </td>
		</tr>
	</table>
	<a href = "bookin.php?book_id=<?=$book["id"]?>"> Write-on the book </a>
	<br>
	<a href = "bookout.php?book_id=<?=$book["id"]?>"> Write-off the book </a>

	<h2> Transactions </h2>
	<table border = "1">
		<?php
				foreach($transactionlist as $t): 
			?>
			<tr>
				<td> <?= $t['date_rent'] ?> </td>
				<td> <a href = "readercard.php?id=<?= $t['reader_id'] ?>"> <?= $t['reader_surname'] ?> <?= $t['reader_name'] ?></a> </td>
				<td> <?= $t['status'] ?> </td>
				<td> <?= $t['date_return'] ?> </td>
				
				<td> 
					<?php
						if (in_array($t['status'],["rented", "prolonged1", "prolonged2"])):
					?>
					<a href = "bookprolong.php?id=<?= $t["id"] ?>"> Prolong the book </a>
					<?php
						endif;
					?>
				</td>
				<td> 
					<?php
						if (in_array($t['status'],["rented", "prolonged1", "prolonged2", "prolonged3"])):
					?>
					<a href = "bookreturn.php?id=<?= $t["id"] ?>"> Return the book </a>
					<?php
						endif;
					?>
				</td>
				<td> 
					<?php
						if (in_array($t['status'],["rented", "prolonged1", "prolonged2", "prolonged3"])):
					?>
					<a href = "booklost.php?id=<?= $t["id"] ?>"> If the book is lost tap here </a>
					<?php
						endif;
					?>
				</td>
			</tr>
			<?php
				endforeach;
			?>
	</table>
	</body>
</html>