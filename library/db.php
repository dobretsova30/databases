<?php
$dsn = 'mysql:host=localhost;dbname=MySQL';
$username = 'root';
$password = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 

$dbh = new PDO($dsn, $username, $password, $options);
if (!$dbh){
	echo $dbh->errorInfo();
}
$s = "Show Tables";
foreach($dbh->query($s) as $item){echo $item[0]. "<br></br>";}
	//echo $dbh->errorInfo();