<?php
require "constants.php";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$transaction = $db->select_one("SELECT * FROM transaction WHERE id = " . $id);
$status = "";
if ($transaction["status"] == "rented")
{
	$status = "prolonged1";
}
elseif ($transaction["status"] == "prolonged1")
{
	$status = "prolonged2";
}
elseif ($transaction["status"] == "prolonged2")
{
	$status = "prolonged3";
}

//echo "<pre>";
//var_dump($transaction);
//var_dump($status);
//die;

if ($status)
{
	$data = ["status"=>$status];
	$db->update("transaction", $data, "id = ".$id);
	header("Location:".$_SERVER['HTTP_REFERER']);
}
?>