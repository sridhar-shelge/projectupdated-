<?php

$pdo = new PDO('mysql:host=sridhar7.heliohost.org;port=3306;dbname=sridhar7_mentormind', 
   'sridhar7_sridhar', 'mysql@122410');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
