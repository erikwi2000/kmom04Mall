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





//	dumpa($db);

$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
//echo "<br> acronym<br";
//dumpa($acronym);
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
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




$bwix['main'] = <<<EOD
{$trxx}
{$bwix['byline']}
</article>
EOD;


// Finally, leave it all to the rendering phase of BWi.
//echo BWI_THEME_PATH;
include(BWI_THEME_PATH);