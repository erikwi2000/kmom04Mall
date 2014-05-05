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

//echo getCurrentUrl();

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

$fromdb = $handle->GetDBasePflimmerStart();

//dumpa($fromdb);
//-----------------------

//-----------------------------------
$bwix['main'] = <<<EOD
{$fromdb}
{$bwix['byline']}
</article>
EOD;

// Finally, leave it all to the rendering phase of BWi.
include(BWI_THEME_PATH);