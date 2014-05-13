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

session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
session_start();
$db = new CDatabase($bwix['database']);

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

// Connect to a MySQL database using PHP PDO
      
//$db = new CDatabase($bwix['database']);
    
 
 
 

// Get parameters 
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$create = isset($_POST['create'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to edit.');



// Check if form was submitted
if($create) {
  $sql = 'INSERT INTO Movie (title) VALUES (?)';
	echo "<br>create<br>";
  $db->ExecuteQuery($sql, array($title));
  $db->SaveDebug();
  header('Location: movie_edit.php?id=' . $db->LastInsertId());
  exit;
}



// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Skapa ny film";

$sqlDebug = $db->Dump();

//$anax['main'] 

$bwix['main']  = <<<EOD
<h1>{$bwix['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Skapa ny film</legend>
  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><input type='submit' name='create' value='Skapa'/></p>
  </fieldset>
</form>

EOD;




// Finally, leave it all to the rendering phase of Anax.
include(BWI_THEME_PATH);
