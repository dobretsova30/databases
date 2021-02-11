<?php
class db
{
	protected $dbh;
	public function __construct()
	{
		$dsn = 'mysql:host=localhost;dbname=library';
		$username = 'root';
		$password = '';
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		); 

		$this->dbh = new PDO($dsn, $username, $password, $options);
		if (!$this->dbh){
			throw new exception($this->dbh->errorInfo());
		}	
	}
	public function select($sql)
	{
		$res = $this->dbh->query($sql);
		if (!$res)
		{
			throw new exception($this->dbh->errorInfo()[2]." (".$sql.")");
		}
		return $res;
	}
	
	public function insert($table, $data)
	{
		$fields = array_keys($data);
		$vals = [];
		foreach ($data as $v)
		{
			$vals[] = $this->dbh->quote($v); 
		}			
		$sql = "insert into `".$table."` (".implode(",", $fields).") values(".implode(",", $vals).")";
		//print($sql);
		return $this->dbh->exec($sql);
	}
	
	public function last_id()
	{
		return $this->dbh->lastInsertId();	
	}
	
	public function select_one($sql)
	{
		$rows = $this->select($sql);
		//echo "<pre>";
		//var_dump($rows);
		//die;
		return $rows?$rows->fetch():[]();
	}
	
	public function update($table, $data, $where)
	{
		$pairs = [];
		foreach ($data as $f=>$v)
		{
			$pairs[] = "`".$f."`= '".$v."'";
			
		}
		$sql = "update ".$table." set " . implode(",", $pairs). " where ". $where;
		/*echo("<pre>");
		var_dump($sql);
		die;*/
		$this->dbh->exec($sql);

	}
}

$db = new db();