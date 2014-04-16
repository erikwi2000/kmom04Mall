<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This is a BWi pagecontroller.
 *
 */
// Include the essential config-file which also creates the $bwix variable with its defaults.


include(__DIR__.'/config.php'); 

  session_start(); 
if(isset($_SESSION['filmhandle'])) {
  $handle = $_SESSION['filmhandle'];
}
else {
    $handle = new CFilmHandle(1);
    $_SESSION['filmhandle'] = $handle;

}
$dump = $handle->StartSessions();
echo "PUTTe" . $dump;

$iin = $handle->GetSeventen();
echo "seventen " . $iin;



