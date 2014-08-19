<?php
class account_urgent {
  public $id;

  function __construct ($item_id) {
    $this->id = $item_id;
  }

  function get_data () {
    $data = array(
      'subject'  => 'Your account may have been hacked. Click here to change your password.',
      'color'    => 'B00',
      'location' => 'My Account'
    );
    return $data;
  }

  function get_url () {
    $url = SITE_ROOT . "mysettings.php";
    return $url;
  }
}
?>
