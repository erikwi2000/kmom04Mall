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

// Restore the database to its original settings
$sql      = 'movie.sql';
$host     = 'localhost';
$output = null;


$mysql    = 'C:\xampp\mysql\bin\mysql.exe';
$login    = '';
$password = '';

//echo "Tvaan <br>";
if(isset($_POST['restore']) || isset($_GET['restore'])) {		
	$cmd = "$mysql -h {$host} -u {$login} -p{$password} < $sql 2>&1";
	$cmd = "$mysql -h {$host} -u {$login}  -p{$password} < $sql";
        $res = exec($cmd);
	$output = "<p>Databasen är återställd via kommandot<br/><code>{$cmd}</code></p><p>{$res}</p>";
	}
// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Återställ (databasen till ursprungligt skick)";

//$bwix['main'] 
$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<form method=post>
<input type=submit name=restore value='Återställ databasen'/>
<output>{$output}</output>
</form>
EOD;

//echo "<br>Tillbaka <br>";
$bwix['main'] = <<<EOD
{$trxx}
{$bwix['byline']}
</article>
EOD;
// Finally, leave it all to the rendering phase of Anax.
include(BWI_THEME_PATH);