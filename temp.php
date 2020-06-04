<?php
$salt = 'XyZzy12*_';
$check = hash('md5', $salt.'hanuman');
echo $check;
?>