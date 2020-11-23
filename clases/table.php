<?php

class Table {

	private $name;
	private $ec;
	private $rp;
	private $cs;
	private $total;
	private $newsletter_id;

	protected $db;

  public function __construct($db) 
  {
    $this->db = $db;
  }


	public function getTable($newsletter) 
	{
		$sql = "SELECT * FROM tables where id = '$newsletter'";
		$stmt = $db->prepare($sql);
		$table = $stmt->execute();
		$table = $stmt->fetch(PDO::FETCH_ASSOC);

		return $table;
	}

}


?>