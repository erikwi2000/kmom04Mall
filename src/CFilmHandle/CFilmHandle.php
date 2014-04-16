<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
$putte = "PUTTe";

//$this->count =0;
return $putte;
//$temp2 = StartSessions();


}

  
  }