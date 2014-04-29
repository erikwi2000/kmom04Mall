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
//echo $mepath . "------";


//dump(BWI_THEME_PATH);
// Do it and store it all in variables in the BWi container.
$bwix['title'] = "Pflimmer";
//echo getCurrentUrl();

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}
//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$fromdb = $handle->GetDBaseContent();
//$fromdb2 = var_dump($fromdb);
//echo "Nuu<br>";
//dumpa($fromdb);
//-----------------------


//-----------------------------------


//$test = "<h1>Testing</h1>";
//$bwix['main'] = $fromdb;
$bwix['main'] = <<<EOD



{$fromdb}

{$bwix['byline']}


</article>

EOD;


// Finally, leave it all to the rendering phase of BWi.
//echo BWI_THEME_PATH;
include(BWI_THEME_PATH);