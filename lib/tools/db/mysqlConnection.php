<?php

$msql_connection ='mysql:host=localhost;dbname=gest_stock';
$username = 'root';
$password = '';

$db = new PDO($msql_connection, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);