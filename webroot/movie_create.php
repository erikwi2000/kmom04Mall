<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

/*
if(isset($_SESSION['cdatabase'])) {
  $db = $_SESSION['cdatabase'];
}
else {

//echo "ZZZZNoDB<br>";
	$db = new CDatabase($bwix['database']);
  $_SESSION['cdatabase'] = $db;
}
*/




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



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($bwix['database']);


// Get parameters 
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$create = isset($_POST['create'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
//isset($acronym) or die('Check: You must login to edit.');



// Check if form was submitted
if($create) {
     echo "<br>Insert--------------<br>"; 
 $sql = "INSERT INTO Movie (title) VALUES (?);";
  echo "<br>Insert--------------<br>";
  $db->ExecuteQuery($sql, array($title));
  $db->SaveDebug();
  header('Location: movie_edit.php?id=' . $db->LastInsertId());
  exit;
}



// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Skapa ny film";

$sqlDebug = $db->Dump();
//$create = TRUE;
$bwix['main'] = <<<EOD
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