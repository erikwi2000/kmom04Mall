<?php 
/**
 * This is a BWi pagecontroller.
 *
 */
// Include the essential config-file which also creates the $bwix 
//variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the BWi container.
$bwix['title'] = "Flimmer";

// Do it and store it all in variables in the BWi container.
//$bwix['title'] = "Pflimmer";
//echo getCurrentUrl();

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}
/*
//$fromdb = $handle->GetDBaseTitles($bwix['database']);
// Connect to a MySQL database using PHP PDO
 $dsn      = 'mysql:host=localhost;dbname=Movie;';
 $login    = 'bjvi13';
 $password = '';
 $options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
*/
$db = new CDatabase($bwix['database']);

/*
try {
  $pdo = new PDO($dsn, $login, $password, $options);
 //	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
 	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

*/
//=======================

//$db = new CDatabase($bwix['database']);
//dumpa($db);
//========================

// Get parameters for sorting
$title = isset($_GET['title']) ? $_GET['title'] : null;
//dumpa($title);

// Do SELECT from a table
if($title) {
  $sql = "SELECT * FROM Movie WHERE title LIKE ?;";
  $params = array(
    $title,
  );  
} 
else {
  $sql = "SELECT * FROM Movie;";
  $params = null;
}


//$sth = $pdo->prepare($sql);
//$sth->execute($params);
//---------------------------$res = $sth->fetchAll();

$res = $db->ExecuteSelectQueryAndFetchAll($sql);
//dumpa($res);
// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td></tr>";
}
//dumpa($tr);

// Do it and store it all in variables in the Bwix container.
$bwix['title'] = "Sök titel i filmdatabasen";

$title = htmlentities($title);
$paramsPrint = htmlentities(print_r($params, 1));
//dumpa($paramsPrint);


//$bwix['main'] 

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Titel (delsträng, använd % som *): <input type='search' name='title' value='{$title}'/></label></p>
<p><a href='?'>Visa alla</a></p>
</fieldset>
</form>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<p><pre>{$paramsPrint}</pre></p>
<table>
{$tr}
</table>
EOD;


			//return $tr;

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