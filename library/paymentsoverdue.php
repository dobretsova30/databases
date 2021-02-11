<?php
require "constants.php";
$transaction_id = filter_input(INPUT_GET, "transaction_id", FILTER_SANITIZE_NUMBER_INT);
$sql = "SELECT t.*, b.cost FROM transaction t 
	LEFT JOIN book b ON b.id=t.book_id
	WHERE t.id=" . $transaction_id;
$transaction = $db->select_one($sql);
$data = ["book_id"=>$transaction["book_id"], "reader_id"=>$transaction["reader_id"],
 "cost"=>3*$transaction["cost"], "date"=>date("Y-m-d")];
$db->insert("payments", $data);
$payment_id = $db->last_id();
$data2 = ["payment_id"=>$payment_id];
$db->update("transaction", $data2, "id=".$transaction_id);
header("Location:".$_SERVER['HTTP_REFERER']);
?>