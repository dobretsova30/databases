<?php
require "constants.php";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$data = ["date_out" => date("Y-m-d")];
$db->update("reader", $data, "id=".$id);
header("Location:".$_SERVER['HTTP_REFERER']);
?>