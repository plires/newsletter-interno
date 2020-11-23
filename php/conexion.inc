<?php 

	try {
	   $db = new PDO(DSN, DB_USER, DB_PASS);
	   $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
	    echo $sql . "<br>" . $e->getMessage();
	}

?>