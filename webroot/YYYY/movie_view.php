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

/////////////////////////////////////
//echo "Iväg <br>";



$fromdb = $handle->GetDBaseMovieView($bwix['database']);


//SOF

//EOF



//echo "<br>Tillbaka <br>";
$bwix['main'] = <<<EOD
{$fromdb}
{$bwix['byline']}
</article>
EOD;


// Finally, leave it all to the rendering phase of Anax.
include(BWI_THEME_PATH);