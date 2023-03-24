<?php
$db = new PDO('mysql:host=localhost; dbname=studentsdb; charset=utf8', 'root', 'password');
$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 ?>
