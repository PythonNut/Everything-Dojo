<?php
class theme_unvalidated {
  public $id;

  function __construct($item_id) {
    $this->id = $item_id;
  }

  function get_data() {
    $data = array(
      'subject'  => 'Sorry, your theme was not validated.',
      'color'    => 'D553CB',
      'location' => 'Database'
    );
    return $data;
  }

  function get_url() {
    $url = SITE_ROOT . URL_DATABASE . "?mode=view&view=style&id=" . $this->id;
    return $url;
  }
}
?>
