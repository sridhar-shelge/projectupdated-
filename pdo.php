<?php

$username='root';
$password='root';
$host="localhost";
$dbname="mentormind";

$pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", 
   $username, $password);
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>