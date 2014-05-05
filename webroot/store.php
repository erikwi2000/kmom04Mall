<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 

$anax['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';

$anax['inlinestyle'] = "
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


// Connect to a MySQL database using PHP PDO
$db = new CDatabase($anax['database']);


// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);


// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th></th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td><td class='menu'><a href='movie_edit.php?id={$val->id}'><i class='icon-edit'></i></a></td></tr>";
}


// Do it and store it all in variables in the Anax container.
$anax['title'] = "Välj och uppdatera info om film";

$sqlDebug = $db->Dump();

$anax['main'] = <<<EOD
<h1>{$anax['title']}</h1>
<table>
{$tr}
</table>

<div class=debug>{$sqlDebug}</div>

EOD;




// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);