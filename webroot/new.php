<?php 
/**
 * This is a Bwix pagecontroller.
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

// Connect to a MySQL database using PHP PDO
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'bjvi13';
$password = '';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
$pdo = new PDO($dsn, $login, $password, $options);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


echo "XX1";
dumpa($pdo);
// Check if user is authenticated.
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}
dumpa($output);
dumpa($bwix);

// Check if user and password is okey
if(isset($_POST['login'])) {
  $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
  $sth = $pdo->prepare($sql);
  $sth->execute(array($_POST['acronym'], $_POST['password']));
  $res = $sth->fetchAll();
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
  }
  header('Location: new.php');
}



// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Login";

$bwix['main'] = <<<EOD
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



// Finally, leave it all to the rendering phase of Anax.
include(BWI_THEME_PATH);