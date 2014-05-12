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

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

if(isset($_SESSION['CDatabase'])) {
  $db = $_SESSION['CDatabase'];
		dumpa($db);
}
else {
	$db = new CDatabase($bwix['database']);
//	dumpa($db);
  $_SESSION['CDatabase'] = $db;
}
//session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
//session_start();
//dumpa($bwix['database']);




$fromdb = $handle->GetDBaseMovieCreate($bwix['database']);



//dumpa($fromdb);
//-----------------------

//{$fromdb}
//-----------------------------------


$bwix['main'] = <<<EOD
{$fromdb}
{$bwix['byline']}
</article>
EOD;


// Finally, leave it all to the rendering phase of BWi.
//echo BWI_THEME_PATH;
include(BWI_THEME_PATH);