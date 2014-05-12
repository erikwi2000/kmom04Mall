<?php 
/**
 * This is a Bwix pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the BWi container.
$bwix['title'] = "PFlimmer";

// Do it and store it all in variables in the BWi container.

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

$bwix['stylesheets'][] = 'http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';

$db = new CDatabase($bwix['database']);      

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql); 
//dumpa($res);
// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>Årrrr</th><th>Val</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td><td class='menu'><a href='movie_edit.php?id={$val->id}'><i class='icon-edit'></i></a></td></tr>";
}
// Do it and store it all in variables in the Bwix container.
$bwix['title'] = "Välj och uppdatera info om film";

$sqlDebug = $db->Dump();

$bwix['title'] = "UPPDATERA";


$bwix['main'] = <<<EOD
<h1>{$bwix['title']}</h1>
<table>
{$tr}
</table>

<div class=debug>{$sqlDebug}</div>
{$bwix['byline']}
</article>
EOD;

// Finally, leave it all to the rendering phase of BWi.

include(BWI_THEME_PATH);