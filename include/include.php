<?php
//error_reporting("off"); //uncomment for unnecessary "warnings" that PHP is smart enough to ignore
// database connection
include("db.php");
// recaptcha
include("recaptcha.php");
// trello
include("trello.php");
// functions
include("functions.php");
// constants
include("constants.php");
// notification class
include("notification.php");
date_default_timezone_set("America/Los_Angeles");
?>