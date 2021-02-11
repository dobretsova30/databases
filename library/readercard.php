<?php
require "constants.php";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$transactionlist_sql = "SELECT
    t.*,
    b.author_surname author_surname,
    b.author_name author_name,
    b.title title,
    datediff(curdate(), t.date_rent) rented_days,
    (CASE WHEN t.status = \"prolonged3\" THEN 65
    	WHEN t.status = \"prolonged2\" THEN 58
        WHEN t.status = \"prolonged1\" THEN 51
        WHEN t.status = \"rented\" THEN 44
        else 9999
    END) rented_days_max
    
FROM
    `transaction` t
LEFT JOIN book b ON
    b.id = t.book_id
WHERE
    t.reader_id = ".$id;
$transactionlist = $db->select($transactionlist_sql);

$transaction_curt_sql = "SELECT * FROM transaction WHERE reader_id = ".$id." AND (status IN ('rented', 'prolonged1',
	'prolonged2', 'prolonged3') OR datediff(curdate(), date_rent) > 365)";
$transaction_curt = $db->select($transaction_curt_sql);

$reader = $db->select_one("SELECT * FROM reader WHERE id = ".$id);
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Reader Card
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1> ReaderCard </h1>
	<a href = "index.html"> Main page  </a> <br>
	<a href = "readerlist.php"> Readerlist  </a>
	<p style = "color: #228b22"><big> <?=$reader["surname"]." ". $reader["name"]?> </big></p>
	<br>
	<p> <?=$reader["date_in"]." - ".$reader["date_out"]?> </p>
	<h2> Transactions </h2>
	<table border = "1">
		<?php
				foreach($transactionlist as $t): 
			?>
			<tr>
				<td> <?= $t['date_rent'] ?> </td>
				<td> <?= $t['title'] ?> </td>
				<td> <?= $t['author_surname'] ?> <?= $t['author_name'] ?> </td>
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
					<a href = "booklost.php?id=<?=$t["id"]?>"> If the book is lost tap here </a>

					<?php
						endif;
					?>
				</td>
				
				
				<td>
					<?php
						if ($t['rented_days'] > $t['rented_days_max']):
					?>
					
					<span style = "background-color: #cc9999; padding: 3px;"> The book is overdue!!! </span>
					
					<?php
						endif;
					?>
				
					<?php
						if (($t['rented_days'] - $t['rented_days_max']) > 365 && empty($t['payment_id'])):
					?>
					<a href = "paymentsoverdue.php?transaction_id=<?=$t["id"]?>"> Pay a fee </a>
					<?php
						endif;
					?>
				</td>
				
			</tr>
			<?php
				endforeach;
			?>
	</table>
	<br>
	<?php
		if ($transaction_curt->rowCount() == 0 && empty($reader["date_out"])):
	?>
	<a href = "readerout.php?id=<?= $id?>"> Write-off the reader </a>
	<?php
		endif;
	?>
	</body>
</html>