<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*


    CUser::Login($user, $password) loggar in användaren om användare och lösenord stämmer.
    CUser::Logout() loggar ut användaren.
    CUser::IsAuthenticated() returnerar true om användaren är inloggad, annars false.
    CUser::GetAcronym() returnera användarens akronym.
    CUser::GetName() returnera användarens namn.



*/
class CUser {

  /**
   * Properties
   *
   */
   	private $aNumber;					// Sidor på tärningen
  	

  public function __construct($aNumber=7) {
         /*
      for($i=0; $i < $aNumber; $i++) {
     echo "Number:  " . $i;
    }
    return $i;
    */
  
  }
   public function GetUserAcronym(){
  
 

// Get incoming parameters
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
    $way = TRUE;
}
else {
  $output = "Du är INTE inloggad.";
  $way = FALSE;
}
//return $way;
return $output;
 }
 
 
 
  public function GetLoginStatus($hej){
      
    
if(isset($_SESSION['logge'])) {
  $log = $_SESSION['logge'];
}
else {
	$log = new CUser();
  $_SESSION['logge'] = $log;
}
try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//=========================================
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
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
	$sth = $pdo->prepare($sql);
  $sth->execute(array($_POST['acronym'], $_POST['password']));
  $res = $sth->fetchAll();
//	dumpa($res);
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
    echo "su 100 " . $_SESSION['user'];
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



return $trxx;
      
  }
 public function IsUserAuthenticated(){
  
    
if(isset($_SESSION['logge'])) {
  $log = $_SESSION['logge'];
}
else {
	$log = new CUser();
  $_SESSION['logge'] = $log;
}

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}

// Get incoming parameters
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
//$acronym = isset($_SESSION['logge']) ? $_SESSION['user']->acronym : null;

if($acronym) {
  $output = "Du är inloggad somAutt: $acronym ({$_SESSION['user']->name})";
    $way = FALSE;
}
else {
  $output = "Du är INTE inloggad.Autt";
  $way = FALSE;
}
return $way;
//return $output;
 }
  
  
public function GetDBaseLogout($hej) {

    try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
// Get incoming parameters
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}
// Logout the user
if(isset($_POST['logout'])) {
 //  $_SESSION['user']->LoggedIn = FALSE; 
  unset($_SESSION['user']);
  header('Location: movie_logout.php');
}

// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Logout";

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Login</legend>
  <p><input type='submit' name='logout' value='Logout'/></p>
  <p><a href='movie_login.php'>Login</a></p>
  <output><b>{$output}</b></output>
  </fieldset>
</form>

EOD;
//---------------
return $trxx;

}
  
  public function CheckLoggedIn ($hej) {
      
      
//$hej = $bwix['database'];
//----------------------------------------
try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//--------------------------------------
//=========================================

   

    $pluppas = isset($_SESSION['user']) ? "Du är inloggad!" : "Du är INTE inloggad!";
//echo "pluppa2" . $pluppas;

return $pluppas;
  }
  
   public function CheckLoggedInBool ($hej) {
      
      
//$hej = $bwix['database'];
//----------------------------------------
try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//--------------------------------------
//=========================================

   

    $pluppas = isset($_SESSION['user']) ? "Du är inloggad!" : "Du är INTE inloggad!";
//echo "pluppa2" . $pluppas;

return $pluppas;
  }
  
  
public function GetDBaseLogin($hej) {

    
try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//=========================================

    
    $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
//echo "pluppa" . $acronym;


//Info strings

$trinfo = "<p><em>Du kan logga in med doe:doe eller admin:admin.</em></p>";
$trinfonotlogggedin = <<<EOD
  <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p>
  <p><label>Lösenord:<br/><input type='text' name='password' value=''/></label></p>
  <p><input type='submit' name='login' value='Login'/></p>
EOD;

$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

//dumpa($acronym);
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
  $trinfo1 = $output;

 // $trinfo2 = $trinfo; 
    $trinfo2 = "*************************************";
}
else {
  $output = "Du är INTE inloggad.";
  $trinfo1 = $output;
    $trinfo1 .= $trinfonotlogggedin;
  $trinfo2 = $trinfo;

}
//$acronym = isset($_SESSION['user']) ? dumpa($_SESSION['user']->acronym) : null;

// Check if user and password is okey
if(isset($_POST['login'])) {
  $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
  $sth = $pdo->prepare($sql);
  $sth->execute(array($_POST['acronym'], $_POST['password']));
  $res = $sth->fetchAll();
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
  {$trinfo1}
  <p><a href='movie_logout.php'>Logout</a></p>
  <output><b>{$trinfo2}</b></output>
  </fieldset>
</form>

EOD;

return $trxx;
}





public function GetDBaseLogin2($hej) {


    
    
try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//=========================================
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
//dumpa($acronym);
if($acronym) {
  $output = "STATUS: Du är inloggad somdbl2: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "STATUS: Du är INTE inloggaddbl2.";
}

    
    $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
echo "pluppa" . $acronym . $output;

/*
// Check if user and password is okey
if(isset($_POST['login'])) {
echo "Inside Logon";
  $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
  //	dumpa($sql);
	$sth = $pdo->prepare($sql);
  $sth->execute(array($_POST['acronym'], $_POST['password']));
  $res = $sth->fetchAll();
//	dumpa($res);
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
  }
  header('Location: movie_login.php');
}

*/
    echo "su 329 "; 
       //     dumpa($_SESSION['user']);

// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Login2";
$bwix['Status'] = "Status.";

$trxx = <<<EOD
  <output><b>{$output}</b></output>
EOD;
//echo "<br> " . $trxx;
return $trxx;
}


public function GetDBaseLoginLogoutStats($hej) {
try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


// Get incoming parameters
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}

// Logout the user
if(isset($_POST['logout'])) {
  unset($_SESSION['user']);
  header('Location: movie_logout.php');
}

//-----------------

// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Logout";

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Login</legend>
  <p><input type='submit' name='logout' value='Logout'/></p>
  <p><a href='movie_login.php'>Login</a></p>
  <output><b>{$output}</b></output>
  </fieldset>
</form>

EOD;
//---------------

//dumpa($trxx);
return $trxx;

}
  


}