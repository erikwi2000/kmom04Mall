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
//session_name(preg_replace('/[:\.\/-_]/', '', __DIR__));
//session_start();
//dumpa($bwix['database']);



$db = new CDatabase($bwix['database']);
/*
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'bjvi13';
$password = '';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

*/
/*
try {
    
    $pdo = new PDO($dsn, $login, $password, $options);  
  //$pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}




$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

 * 
 * //=========================================
 */
//dumpa($pdo);
//dumpa($handle);
// Check if user is authenticated.
//dumpa($pdo);


//$res = $db->ExecuteSelectQueryAndFetchAll($sql);

//	dumpa($db);

$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
//echo "<br> acronym<br";
//dumpa($acronym);
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
//  echo "<br>wwwwwwwwwwwwwwwwwwwwwwwwww<br>";
}
else {
  $output = "Du är INTE inloggad.";
}


// Check if user and password is okey
if(isset($_POST['login'])) {
echo "Inside Logon";
  $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
  //	dumpa($sql);
  
 // echo "Inside Logon";echo "Inside Logon";echo "Inside Logon";
  
  /*
	$sth = $pdo->prepare($sql);
  $sth->execute(array($_POST['acronym'], $_POST['password']));
  $res = $sth->fetchAll();
  */
   $res = $db->ExecuteSelectQueryAndFetchAll($sql,array($_POST['acronym'], $_POST['password']));
  
  
	dumpa($res);
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
  }
  header('Location: movie_login.php');
}



// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Login";


//$trxx 
        
$trxx = <<<EOD
<h1>{$bwix['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Login</legend>
  <p><em>Du kan logga in med doe:doe eller admin:admin.</em></p>
  <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p>
  <p><label>Lösenord:<br/><input type='text' name='password' value=''/></label></p>
  <p><input type='submit' name='login' value='Login'/></p>
  <p><a href='movie_logout.php'>Logout</a></p>
  <output><b>{$output}</b></output>
  </fieldset>
</form>

EOD;



//return $trxx;

//dumpa($fromdb);
//-----------------------

//{$fromdb}
//-----------------------------------


$bwix['main'] = <<<EOD
{$trxx}
{$bwix['byline']}
</article>
EOD;


// Finally, leave it all to the rendering phase of BWi.
//echo BWI_THEME_PATH;
include(BWI_THEME_PATH);