<?php 
/**
 * This is a BWi pagecontroller.
 *
 */
// Include the essential config-file which also creates the $bwix 
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the BWi container.
$bwix['title'] = "Flimmer";
//echo getCurrentUrl();

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

$db = new CDatabase($bwix['database']);

// Do SELECT from a table
$sql = "SELECT * FROM VMovie;";

$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Put results into a HTML-table
$tr = "<p>Resultatet från SQL-frågan:</p>";
$tr .= "<p><code>{$sql}</code></p>";

$tr .= "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>";

foreach($res AS $key => $val) {
$tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td><td>{$val->genre}</td></tr>";
}

$tr .= "</table>";

$bwix['main'] = <<<EOD
{$tr}
{$bwix['byline']}
</article>
EOD;
// Finally, leave it all to the rendering phase of BWi.
include(BWI_THEME_PATH);