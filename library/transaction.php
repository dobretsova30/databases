<?php
require "constants.php";
$book_id = filter_input(INPUT_GET, "book_id", FILTER_SANITIZE_NUMBER_INT);
$reader_id = filter_input(INPUT_POST, "reader_id", FILTER_SANITIZE_NUMBER_INT);
if ($book_id && $reader_id)
{
	$data = 
	[
		"book_id" => $book_id, 
		"reader_id" => $reader_id, 
		"date_rent" => date("Y-m-d")
	];
	$db->insert("transaction", $data);
	header("Location: /booklist.php");
	exit;
}
$sql = "select r.*, ifnull((SELECT count(*) FROM transaction WHERE reader_id = r.id AND status IN('rented', 'prolonged1',
	'prolonged2', 'prolonged3')), 0) ct from reader r where 
	r.date_out is NULL
	AND r.id NOT IN (SELECT reader_id 
    
FROM
    `transaction` t
WHERE
	datediff(curdate(), t.date_rent) >
    (CASE WHEN t.status = \"prolonged3\" THEN 65
    	WHEN t.status = \"prolonged2\" THEN 58
        WHEN t.status = \"prolonged1\" THEN 51
        WHEN t.status = \"rented\" THEN 44
        else 9999
    END)
	)
	order by r.surname, r.name";
$readerlist = $db->select($sql);
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>

	<head>
		<title>
			Rent a book
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1>
	Rent a book
	</h1>
	<a href = "booklist.php"> List of books </a>
	<form method = post>
		<label>
			Reader
		</label>
		<br>
		<select name = reader_id>
		<option value = ""> =Choose a reader=- </option>
		<?php foreach ($readerlist as $reader): ?>
		<?php if ($reader["ct"] <= 2): ?>
		<option value = "<?=$reader["id"]?>"> <?=$reader["surname"]?> <?=$reader["name"]?> (<?=$reader["ct"]?>)  </option>
		<?php endif ?>
		<?php endforeach; ?>
		</select>
		
		<br> <br>
		<button type = submit>
			Add
		</button>
	</form>
	</body>
</html>