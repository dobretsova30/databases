<?php
require "constants.php";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$transaction = $db->select_one("SELECT * FROM transaction WHERE id = " . $id);
$status = "returned";

//echo "<pre>";
//var_dump($transaction);
//var_dump($status);
//die;

if ($status)
{
	$data = ["status"=>$status, "date_return"=>date("Y-m-d")];
	$db->update("transaction", $data, "id = ".$id);
	header("Location:".$_SERVER['HTTP_REFERER']);
}
?>