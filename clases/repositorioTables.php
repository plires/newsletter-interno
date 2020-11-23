<?php

abstract class repositorioTables {
	public abstract function getAllTables();
	public abstract function getTableCurrentMonth();
	public abstract function getTableByNewsletterId($newsletterId);
}

?>