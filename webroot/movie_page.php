<?php 
/**
 * This is a BWi pagecontroller.
 *
 */

include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the BWi container.
$bwix['title'] = "PFlimmer";


if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
	$handle = new CFilmHandle();
  $_SESSION['filmhandle'] = $handle;
}



$bwix['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';

$db = new CDatabase($bwix['database']);

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


// Get parameters for sorting
$hits  = isset($_GET['hits']) ? $_GET['hits'] : 8;
$page  = isset($_GET['page']) ? $_GET['page'] : 1;
// Check that incoming is valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');

//===========================================
// Get max pages from table, for navigation
$sql = "SELECT COUNT(id) AS rows FROM VMovie";

$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Get maximal pages
$max = ceil($res[0]->rows / $hits);


// Do SELECT from a table
$sql = "SELECT * FROM VMovie LIMIT $hits OFFSET " . (($page - 1) * $hits);

$res = $db->ExecuteSelectQueryAndFetchAll($sql);
//$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td><td>{$val->genre}</td></tr>";
}


// Do it and store it all in variables in the Anax container.
$bwix['title'] = "PAGINERING";

$hitsPerPage = getHitsPerPage(array(2, 4, 8));
$navigatePage = getPageNavigation($hits, $page, $max);

//$anax['main'] 

//$trxx 
        
$bwix['main'] = <<<EOD
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
  {$bwix['byline']}
</article>
EOD;

// Finally, leave it all to the rendering phase of BWi.
//echo BWI_THEME_PATH;
include(BWI_THEME_PATH);
