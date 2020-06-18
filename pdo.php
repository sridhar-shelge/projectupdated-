<?php

$pdo = new PDO('mysql:host=152.56.242.165;port=3306;dbname=sridhar7_mentormind', 
   'sridhar7_sridhar', 'mysql@122410');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
