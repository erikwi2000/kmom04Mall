<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class CFilmHandle {

  /**
   * Properties
   *
   */
   	private $aNumber;					// Sidor på tärningen
  	

  public function __construct($aNumber=7) {
         /*
      for($i=0; $i < $aNumber; $i++) {
     echo "Number:  " . $i;
    }
    return $i;
    */
  }
  public function GetSeventen() {
      $iii= 17;
      
      return $iii;
      
  }
  
  public function StartSessions() {
// Sanity Check, unnecessary??
      
if(isset($_SESSION['dumpp'])) {
  $dumpp = $_SESSION['dumpp'];
}
else {
	$dumpp = new CDump(1);
  $_SESSION['dumpp'] = $dumpp;
}

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}
$putte = "PUTTE";

//$this->count =0;
return $putte;
//$temp2 = StartSessions();


}
public function GetDBaseContent(){
        
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'bjvi13';
$password = '';
//$options = '';
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
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// Do SELECT from a table
// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();

//echo "GetDBaseContentdumpa_1_start<br>";
//dumpa($res);
//echo "GetDBaseContentdumpa_1_stop<br>";

//echo "wwwwwwwwwwwwwwwwwww";
//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//$res = PDO::FETCH_OBJ;
//dump($_SERVER);
// Put results into a HTML-table
$tr = "<p>Resultatet från SQL-frågan:</p>";
$tr .= "<p><code>{$sql}</code></p>";

$tr .= "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";

foreach($res AS $key => $val) {
$tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";


}
$tr .= "</table>";

			return $tr;
			
			
      //  return $res;
}        


}