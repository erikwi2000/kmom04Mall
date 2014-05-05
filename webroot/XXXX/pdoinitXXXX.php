<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Connect to a MySQL database using PHP PDO
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'bjvi13';
$password = '';
$options = '';

$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
//$pdo = new PDO($dsn, $login, $password, $options);
//$pdo = new PDO($dsn, $login, $password, $options);
try {
  $pdo = new PDO($dsn, $login, $password, $options);
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();
dumpa($res);