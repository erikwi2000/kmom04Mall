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
       * */
       
    
  }
  public function __sleep()
{
    return array();
}
  public function __wakeup()
{
    return array();
}
  public function GetSeventen() {
      $iii= 17;  
      return $iii;  
  }

}