<?php
/*
* Discuss Version 1.0
* Methods
*/
class discuss {

  function __construct($dbc){
    $this->dbc = $dbc;
  }

}
$discuss = new discuss($dbc);
?>
