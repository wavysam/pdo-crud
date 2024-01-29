<?php

require_once "dbconfig.php";

$id = $_GET["id"];
$sql = "DELETE FROM users WHERE id = :id";
$query = $connection->prepare($sql);
$query->bindParam("id", $id, PDO::PARAM_INT);
$query->execute();
$count = $query->rowCount();

if ($count > 0)
{
    header("Location: dashboard.php");
}