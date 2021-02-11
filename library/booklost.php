<?php
require "constants.php";
$transaction_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
if ($transaction_id)
{
	
	$sql = "SELECT t.*, b.cost FROM transaction t 
		LEFT JOIN book b ON b.id=t.book_id
		WHERE t.id=" . $transaction_id;
		
	$transaction = $db->select_one($sql);
	$data = [
		"status" => "lost",
		];
	
	$db->update("transaction", $data, "id = ".$transaction_id);
	$data2 = [
		"book_id" => $transaction["book_id"],
		"amount" => (-1),
		"dt" => date("Y-m-d")
		];
	
	$db->insert("book_transaction", $data2);
	$data = ["book_id"=>$transaction["book_id"], "reader_id"=>$transaction["reader_id"],
	 "cost"=>$transaction["cost"], "date"=>date("Y-m-d")];
	  
	$db->insert("payments", $data);
	$payment_id = $db->last_id();
	$data2 = ["payment_id"=>$payment_id];
	$db->update("transaction", $data2, "id=".$transaction_id);

}
header("Location:".$_SERVER['HTTP_REFERER']);


?>