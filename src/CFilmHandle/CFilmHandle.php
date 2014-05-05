<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class CFilmHandle {

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
  public function GetSeventen() {
      $iii= 17;
      
      return $iii;
      
  }
  
  public function StartSessions() {
// Sanity Check, unnecessary??
      
if(isset($_SESSION['dumpp'])) {
  $dumpp = $_SESSION['dumpp'];
}
else {
	$dumpp = new CDump(1);
  $_SESSION['dumpp'] = $dumpp;
}

if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}
$putte = "PUTTE";

//$this->count =0;
return $putte;
//$temp2 = StartSessions();


}

public function GetDBaseFilmPage($hej){


$bwix['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';
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
";


			/**
			 * Use the current querystring as base, modify it according to $options and return the modified query string.
			 *
			 * @param array $options to set/change.
			 * @param string $prepend this to the resulting query string
			 * @return string with an updated query string.
			 */
			function getQueryString($options, $prepend='?') {
				// parse query string into array
				$query = array();
				parse_str($_SERVER['QUERY_STRING'], $query);

				// Modify the existing query string with new options
				$query = array_merge($query, $options);

				// Return the modified querystring
				return $prepend . http_build_query($query);
			}



			/**
			 * Create links for hits per page.
			 *
			 * @param array $hits a list of hits-options to display.
			 * @return string as a link to this page.
			 */
			function getHitsPerPage($hits) {
				$nav = "Träffar per sida: ";
				foreach($hits AS $val) {
					$nav .= "<a href='" . getQueryString(array('hits' => $val)) . "'>$val</a> ";
				}  
				return $nav;
			}



			/**
			 * Create navigation among pages.
			 *
			 * @param integer $hits per page.
			 * @param integer $page current page.
			 * @param integer $max number of pages. 
			 * @param integer $min is the first page number, usually 0 or 1. 
			 * @return string as a link to this page.
			 */
			function getPageNavigation($hits, $page, $max, $min=1) {
				$nav  = "<a href='" . getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
				$nav .= "<a href='" . getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

				for($i=$min; $i<=$max; $i++) {
					$nav .= "<a href='" . getQueryString(array('page' => $i)) . "'>$i</a> ";
				}

				$nav .= "<a href='" . getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
				$nav .= "<a href='" . getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
				return $nav;
			}



// Connect to a MySQL database using PHP PDO
//$dsn      = 'mysql:host=localhost;dbname=Movie;';
//$login    = 'bjvi13';
//$password = '';
//$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");


try {
//  $pdo = new PDO($dsn, $login, $password, $options);
 	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	

}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}


$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//Nytt 5_02

//$db = new CDatabase($bwix['database']);
//$db = new CDatabase($hej);




// Get parameters for sorting
$hits  = isset($_GET['hits']) ? $_GET['hits'] : 8;
$page  = isset($_GET['page']) ? $_GET['page'] : 1;


// Check that incoming is valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');

if(isset($_SESSION['CDatabase'])) {
  $db = $_SESSION['CDatabase'];
}
else {

//echo "ZZZZNoDB<br>";
	$db = new CDatabase($hej);
  $_SESSION['CDatabase'] = $db;
}
//==========================================


//===========================================
// Get max pages from table, for navigation
$sql = "SELECT COUNT(id) AS rows FROM VMovie";

//$sth = $pdo->prepare($sql);
//$sth->execute();
//$res = $sth->fetchAll();


//-------------------------

// nytt17_01
//$db = '';
$res = $db->ExecuteSelectQueryAndFetchAll($sql);
// Get maximal pages
$max = ceil($res[0]->rows / $hits);


// Do SELECT from a table
$sql = "SELECT * FROM VMovie LIMIT $hits OFFSET " . (($page - 1) * $hits);

//$sth = $pdo->prepare($sql);
//$sth->execute();
//$res = $sth->fetchAll();


$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}


// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Visa resultatet i flera sidor";

$hitsPerPage = getHitsPerPage(array(2, 4, 8));
$navigatePage = getPageNavigation($hits, $page, $max);

//$anax['main'] 

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<div class='dbtable'>
  <div class='rows'>{$hitsPerPage}</div>
  <table>
  {$tr}
  </table>
  <div class='pages'>{$navigatePage}</div>
</div>
EOD;



//dumpa($trxx);
return $trxx;


}


public function GetDBaseReset(){


// Restore the database to its original settings
$sql      = 'movie.sql';
//$mysql    = '/usr/local/bin/mysql';
$host     = 'localhost';
//$login    = 'acronym';
//$password = 'password';
$output = null;

// Use these settings on windows and WAMPServer, 
// but you must check - and change - your path to the executable mysql.exe
//$mysql    = 'C:\wamp\bin\mysql\mysql5.5.24\bin\mysql.exe';
$mysql    = 'C:\wamp\bin\mysql.exe';
$login    = 'root';
$password = '';


if(isset($_POST['restore']) || isset($_GET['restore'])) {

  // Use on Unix/Unix/Mac
//  $cmd = "$mysql -h{$host} -u{$login} -p{$password} < $sql 2>&1";

  // Use on Windows, remove password if its empty
    dumpa($host);
	
	$cmd = "$mysql -h{$host} -u{$login} -p{$password} < $sql 2>&1";
  dumpa($cmd);
	$cmd = "$mysql -h{$host} -u{$login} < $sql";
  dumpa($cmd);
  $res = exec($cmd);
  $output = "<p>Databasen är återställd via kommandot<br/><code>{$cmd}</code></p><p>{$res}</p>";
}


// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Återställ databasen till ursprungligt skick";

//$bwix['main'] 

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<form method=post>
<input type=submit name=restore value='Återställ databasen'/>
<output>{$output}</output>
</form>
EOD;
//dumpa($trxx);
return $trxx;


}

public function GetDBaseByGenre($hej) {
// Connect to a MySQL database using PHP PDO
//$dsn      = 'mysql:host=localhost;dbname=Movie;';
//$login    = 'bjvi13';
//$password = '';
//$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

//dumpa($hej);
try {
//  $pdo = new PDO($dsn, $login, $password, $options);
 	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	

}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


//=======================


//========================

// Get parameters for sorting
$genre = isset($_GET['genre']) ? $_GET['genre'] : null;

// Get all genres that are active
$sql = '
  SELECT DISTINCT G.name
  FROM Genre AS G
    INNER JOIN Movie2Genre AS M2G
      ON G.id = M2G.idGenre
';

$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();
//dumpa($res);


$genres = null;
foreach($res as $val) {
  $genres .= "<a href=?genre={$val->name}>{$val->name}</a> ";
}
//dumpa($genres);

// Do SELECT from a table
if($genre) {
  $sql = '
    SELECT 
      M.*,
      G.name AS genre
    FROM Movie AS M
      LEFT OUTER JOIN Movie2Genre AS M2G
        ON M.id = M2G.idMovie
      INNER JOIN Genre AS G
        ON M2G.idGenre = G.id
    WHERE G.name = ?
    ;
  ';

  $params = array(
    $genre,
  );  
} 
else {
  $sql = 'SELECT * FROM VMovie;';
  $params = null;
}
$sth = $pdo->prepare($sql);
$sth->execute($params);
//$sth->execute();
$res = $sth->fetchAll();

//dumpa($res);


// Put results into a HTML-table
$tr = '<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>';
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}


// Do it and store it all in variables in the Anax container.
$bwix['genre'] = "Sök film per genre";

$paramsPrint = htmlentities(print_r($params, 1));

//$anax['main'] 

$trxx = <<<EOD
<h1>{$bwix['genre']}</h1>
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Välj genre:</label><br/>{$genres}</p>
<p><a href='?'>Visa alla</a></p>
</fieldset>
</form>
<p>Resultatet från SQL-frågan:</p>
<pre>{$sql}</pre>
<pre>{$paramsPrint}</pre>
<table>
{$tr}
</table>
EOD;

return $trxx;
// EOF GetDBaseByGenre

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

public function GetDBaseViewEdit($hej) {


$bwix['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';

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

td.menu {
  padding-left: 1em;
  padding-right: 1em;
}

td.menu a {
  text-decoration: none;
  color: #666;
}

td.menu a:hover {
  color: #333;
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
//----------------
//----------------------------------------


try {
//  $pdo = new PDO($dsn, $login, $password, $options);
 	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	

}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();
//$res = $sth->fetch(PDO::FETCH_OBJ);


//--------------------------------------------------------
// Connect to a MySQL database using PHP PDO
$db = new CDatabase($bwix['database']);


// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);


// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th></th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td><td class='menu'><a href='movie_edit.php?id={$val->id}'><i class='icon-edit'></i></a></td></tr>";
}


// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Välj och uppdatera info om film";

$sqlDebug = $db->Dump();


$bwix['title'] = "Loging";


$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<table>
{$tr}
</table>

<div class=debug>{$sqlDebug}</div>

EOD;
 return $trxx;
 
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
//dumpa($pdo);
//dumpa($handle);
// Check if user is authenticated.
//dumpa($pdo);

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
  	dumpa($sql);
	$sth = $pdo->prepare($sql);
  $sth->execute(array($_POST['acronym'], $_POST['password']));
  $res = $sth->fetchAll();
	dumpa($res);
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
  }
  header('Location: movie_login.php');
}



// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Loging";


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



public function GetDBaseFilmByYear($hej) {
// Connect to a MySQL database using PHP PDO
//echo "Hej<br>";
//dumpa($hej);
//dumpa($hej['username']);
//echo "Hej Då<br>";
//$dsn      = 'mysql:host=localhost;dbname=Movie;';

//$login    = 'bjvi13';
//$password = '';
//$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

//$pdo = new PDO($dsn, $login, $password, $options);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//dumpa($pdo);
//$bwix['database'] = '';
//$db = new CDatabase($bwix['database']);

// Get parameters
$year1 = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2 = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;


// Do SELECT from a table
if($year1 && $year2) {
  $sql = "SELECT * FROM Movie WHERE year >= ? AND year <= ?;";
  $params = array(
    $year1,
    $year2,
  );  
} 
elseif($year1) {
  $sql = "SELECT * FROM Movie WHERE year >= ?;";
  $params = array(
    $year1,
  );  
} 
elseif($year2) {
  $sql = "SELECT * FROM Movie WHERE year <= ?;";
  $params = array(
    $year2,
  );  
} 
else {
  $sql = "SELECT * FROM Movie;";
  $params = null;
}
$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();

dumpa($pdo);
// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}
// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Sök film per år";

$year1 = htmlentities($year1);
$year2 = htmlentities($year2);
$paramsPrint = htmlentities(print_r($params, 1));
//$bwix['main'] 

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Skapad mellan åren: 
    <input type='text' name='year1' value='{$year1}'/>
    - 
    <input type='text' name='year2' value='{$year2}'/>
  </label>
</p>
<p><input type='submit' name='submit' value='Sök'/></p>
<p><a href='?'>Visa alla</a></p>
</fieldset>
</form>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<p><pre>{$paramsPrint}</pre></p>
<table>
{$tr}
</table>
EOD;

return $trxx;
// EOF GetDBaseFilmByYear()
}
public function GetDBaseFilmSort($hej) {


$bwix['inlinestyle'] = "
.orderby a {
  text-decoration: none;
  color: black;
}
";

//////
// Connect to a MySQL database using PHP PDO
//$dsn      = 'mysql:host=localhost;dbname=Movie;';
//$login    = 'bjvi13';
//$password = '';
//$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/*
try {
  $pdo = new PDO($dsn, $login, $password, $options);
 	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
*/
//$pdo = new PDO($dsn, $login, $password, $options);
//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//00000000000000000000

try {
  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}

//$pdo = new PDO($dsn, $login, $password, $options);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//0000000000000000000000000
// Get parameters for sorting
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';


// Check that incoming is valid
in_array($orderby, array('id', 'title', 'year')) or die('Check: Not valid column.');
in_array($order, array('asc', 'desc')) or die('Check: Not valid sort order.');



// Do SELECT from a table
$sql = "SELECT * FROM VMovie ORDER BY $orderby $order;";
$sth = $pdo->prepare($sql);
$sth->execute(array($orderby, $order));
$res = $sth->fetchAll();


/**
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
function orderby($column) {
  return "<span class='orderby'><a href='?orderby={$column}&order=asc'>&darr;</a><a href='?orderby={$column}&order=desc'>&uarr;</a></span>";
}


// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id " . orderby('id') . "</th><th>Bild</th><th>Titel " . orderby('title') . "</th><th>År " . orderby('year') . "</th><th>Genre</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}


// Do it and store it all in variables in the Anax container.
$bwix['title'] = "Sortera tabellens innehåll";

//$anax['main'] 

$trxx = <<<EOD
<h1>{$bwix['title']}</h1>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<table>
{$tr}
</table>
EOD;


return $trxx;
// EOF GetDBaseFilmSort
}


public function GetDBaseTitles($hej){
// Connect to a MySQL database using PHP PDO
// $dsn      = 'mysql:host=localhost;dbname=Movie;';
// $login    = 'bjvi13';
// $password = '';
// $options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");


try {
//  $pdo = new PDO($dsn, $login, $password, $options);
 	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	
 	
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


//=======================


//========================

// Get parameters for sorting
$title = isset($_GET['title']) ? $_GET['title'] : null;


// Do SELECT from a table
if($title) {
  $sql = "SELECT * FROM Movie WHERE title LIKE ?;";
  $params = array(
    $title,
  );  
} 
else {
  $sql = "SELECT * FROM Movie;";
  $params = null;
}


$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();



// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}


// Do it and store it all in variables in the Bwix container.
$bwix['title'] = "Sök titel i filmdatabasen";

$title = htmlentities($title);
$paramsPrint = htmlentities(print_r($params, 1));
//dumpa($paramsPrint);


//$bwix['main'] 

$tr = <<<EOD
<h1>{$bwix['title']}</h1>
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Titel (delsträng, använd % som *): <input type='search' name='title' value='{$title}'/></label></p>
<p><a href='?'>Visa alla</a></p>
</fieldset>
</form>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<p><pre>{$paramsPrint}</pre></p>
<table>
{$tr}
</table>
EOD;


			return $tr;

}


public function GetDBasePflimmerStart($hej){


try {
//  $pdo = new PDO($dsn, $login, $password, $options);
 	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	

}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();

//dumpa($res);


//dumpa($res);
//dump($_SERVER);
// Put results into a HTML-table
$tr = "<p>Resultatet från SQL-frågan:</p>";
$tr .= "<p><code>{$sql}</code></p>";
$tr .= "<p>Meny: Alla filmer i databasen</p>";

$tr .= "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";

foreach($res AS $key => $val) {
$tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}


$tr .= "</table>";
//$tr .= "lllllllllllllllllllllllllllllllllllllllllllllllllllllll";
//echo "llllllllllllllllllll";
			return $tr;
// EOF GetDBasePflimmerStart
}        
public function GetDBaseConnect($hej){
        
//$dsn      = 'mysql:host=localhost;dbname=Movie;';
//$login    = 'bjvi13';
//$password = '';
//$options = '';
//$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

try {
//  $pdo = new PDO($dsn, $login, $password, $options);
 	  $pdo = new PDO($hej['dsn'], $hej['username'], $hej['password'], $hej['driver_options']);	

}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
 $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();
//$res = $sth->fetch(PDO::FETCH_OBJ);

/*
print("PDO::FETCH_OBJ: ");
print("Return next row as an anonymous object with column names as properties\n");
$result = $sth->fetch(PDO::FETCH_OBJ);
print $result->NAME;
print("\n");
*/

//dumpa($res);
//dump($_SERVER);
// Put results into a HTML-table
$tr = "<p>Resultatet från SQL-frågan:</p>";
$tr .= "<p><code>{$sql}</code></p>";

$tr .= "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";

foreach($res AS $key => $val) {
$tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}


$tr .= "</table>";

			return $tr;
// EOF GetDBaseConnect
}        



}