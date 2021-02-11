<?php
require "constants.php";
$sql1 = "SELECT b.id, b.title, b.author_surname, b.author_name, SUM(bt.amount) s, SUM(bt.amount)*b.cost p 
	FROM `book_transaction` bt 
	LEFT JOIN book b on b.id = bt.book_id WHERE datediff(curdate(), bt.dt) <= 365
	AND	bt.amount > 0 GROUP BY 1, 2, 3, 4
	union 
	SELECT b.id, b.title, b.author_surname, b.author_name, SUM(bt.amount) s, SUM(bt.amount)*b.cost p 
	FROM `book_transaction` bt 
	LEFT JOIN book b on b.id = bt.book_id WHERE datediff(curdate(), bt.dt) <= 365
	AND bt.amount < 0 GROUP BY 1, 2, 3, 4";
$reportbooksrows = $db->select($sql1);
$reportbooksdata = [];
foreach ($reportbooksrows as $row)
{
	if (empty($row["id"]))
	{
		continue;
	}
	if (empty($reportbooksdata[$row["id"]]))
	{
		$reportbooksdata[$row["id"]][0] = $row["author_surname"]." ".$row["author_name"]." - ". $row["title"];	
	}
	if ($row["s"] > 0)
	{
		$reportbooksdata[$row["id"]][1] = $row["s"];
		$reportbooksdata[$row["id"]][2] = $row["p"];
	}
	else if ($row["s"] < 0)
	{
		$reportbooksdata[$row["id"]][3] = $row["s"];
		$reportbooksdata[$row["id"]][4] = $row["p"];		
	}
}

$sql2 = "SELECT p.date, p.cost, r.surname reader_surname, r.name reader_name, b.title, b.author_surname, b.author_name
	FROM payments p 
	LEFT JOIN reader r ON r.id = p.reader_id
	LEFT JOIN book b ON b.id = p.book_id
	WHERE datediff(curdate(), p.date) <= 365";
$paymentlist = $db->select($sql2);
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<head>
		<title>
			Financial reports
		</title>
		<meta charset - utf-8>
	</head>
	<body>
	<h1> Financial report </h1>
	<a href = "index.html"> Main page </a>
	<br>
	<br>
	<h2> Fixed assets </h2>
	<?php if ($reportbooksdata):?>
		<table border = "1">
		<tr> 
			<th> Book </th>
			<th> Income amount </th>
			<th> Income cost </th>
			<th> Outcome amount </th>
			<th> Outcome cost </th>
		</tr>
		<?php foreach ($reportbooksdata as $row): ?>
		<tr>
			<td> <?=$row[0]?> </td>
			<td> <?=$row[1]??0?> </td>
			<td> <?=$row[2]??0?> </td>
			<td> <?=$row[3]??0?> </td>
			<td> <?=$row[4]??0?> </td>
		</tr>
		<?php endforeach; ?>
		</table>

	 
	<?php endif; ?>
	
	
	<br> <br>
	<h2> Fines </h2>
	<table border = "1">
		<tr>
			<th> Book </th>
			<th> Reader </th>
			<th> Cost </th>
			<th> Date </th>
		</tr>
		<?php foreach ($paymentlist as $payment): ?>
		<tr>
			<td> <?=$payment["author_surname"].' '.$payment["author_name"].' - '.$payment["title"]?> </td>
			<td> <?=$payment["reader_surname"].' '.$payment["reader_name"]?>
			<td> <?=$payment["cost"]?> </td>
			<td> <?=$payment["date"]?> </td>
		</tr>
		<?php endforeach ?>
	</table>
	</body>
</html>