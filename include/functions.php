<?php function generateHeader($title, $html="") {
  echo '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <title>' . $title . '</title>

    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    ' . $html . '
  </head>

  <body>';
}
?>