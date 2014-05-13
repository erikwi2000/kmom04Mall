<?php 
/**
 * This is a Bwix pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 

session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
session_start();

// Do it and store it all in variables in the BWi container.
$bwix['title'] = "Flimmer";

// Do it and store it all in variables in the BWi container.
//$bwix['title'] = "Pflimmer";
//echo getCurrentUrl();
/*
if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

*/
//session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
//session_start();
//dumpa($bwix['database']);


//$fromdb = $handle->GetDBaseMovieViewDelete($bwix['database']);
//SOF-----------------------------------
$bwix['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';

$bwix['inlinestyle'] = "
.orderby a {
  text-decoration: none;
  color: black;
}

.dbtable {

}

.dbtable table {
  width: 100%;
}

.dbtable .rows {
  text-align: right;
}

.dbtable .pages {
  text-align: center;
}

td.menu {
  padding-left: 1em;
  padding-right: 1em;
}

td.menu a {
  text-decoration: none;
  color: #666;
}

td.menu a:hover {
  color: #333;
}

.debug {
  color: #666;
}

label {
  font-size: smaller;
}

input[type=text] {
  width: 300px;
}

select {
  height: 10em;
}
";




/*
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'bjvi13';
$password = '';
$options = '';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
*/
$db = new CDatabase($bwix['database']);
  $_SESSION['CDatabase'] = $db;
/*
try {
  $pdo = new PDO($dsn, $login, $password, $options);
 //	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	

}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
 
 */
  
  /*
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
 
 */

// Do SELECT from a table
 
 
$sql = "SELECT * FROM Movie;";
/*
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();
*/

//$res = $sth->fetch(PDO::FETCH_OBJ);
$res = $db->ExecuteSelectQueryAndFetchAll($sql);
//--------------------------------------------------------
// Connect to a MySQL database using PHP PDO
//--------------------

//--------------

//$db = new CDatabase($bwix['database']);
//dumpa($bwix['stylesheets']);

// Do SELECT from a table
// Connect to a MySQL database using PHP PDO
//$db = new CDatabase($bwix['database']);


// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);


// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th></th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td><td class='menu'><a href='movie_delete.php?id={$val->id}'><i class='icon-remove-sign'></i></a></td></tr>";
}


// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Välj film att radera";

$sqlDebug = $db->Dump();

//$anax['main'] 

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<table>
{$tr}
</table>

<div class=debug>{$sqlDebug}</div>

EOD;



		//	return $trxx;
// EOF GetDBaseMovieViewDelete

//EOF--------------------------------


//dumpa($fromdb);
//-----------------------

//{$fromdb}
//-----------------------------------


$bwix['main'] = <<<EOD
{$trxx}
{$bwix['byline']}
</article>
EOD;


// Finally, leave it all to the rendering phase of BWi.
//echo BWI_THEME_PATH;
include(BWI_THEME_PATH);