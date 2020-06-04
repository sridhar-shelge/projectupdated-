<?php
$pdo = new PDO('mysql:host=sql12.freemysqlhosting.net;port=3306;dbname=sql12345260', 
   'sql12345260', 'DnyRULRXLK');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
