<?php

include('../includes/config.inc');
include('con.php');
require '../vendor/autoload.php';

$sql = "SELECT * FROM sectors";
$stmt = $db->prepare($sql);
$stmt->execute();
$sectors = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($sectors);

?>