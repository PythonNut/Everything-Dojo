<?php
  /**
   * Generates dynamic headers for pages
   */
  function generateHeader($title, $titleAdd="", $html="") {
    $convert = array(
      'Index'    => 'index',     // index page
      'Database' => 'database',  // Database
      'Themizer' => 'themizer',  // Themizer
      'Try-It'   => 'tryit',     // Try-It
      'Discuss'  => 'discuss'    // Forum; can edit later
    );

    echo '<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">

      <title>Everything Dojo - ' . $title . $titleAdd . '</title>

      <link href="css/normalize.css" rel="stylesheet">
      <link href="css/general.css" rel="stylesheet">
      <link href="css/' . $convert[$title] . '.css" rel="stylesheet">
      ' . $html . '
    </head>

    <body>';
  }
?>

