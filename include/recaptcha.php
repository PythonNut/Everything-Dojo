<?php
  define('SALT_LENGTH', 9); // salt for password

  /* Specify user levels */
  define ("ADMIN_LEVEL", 5);
  define ("USER_LEVEL", 1);
  define ("GUEST_LEVEL", 0);

  date_default_timezone_set("America/New_York");

  /*************** reCAPTCHA KEYS****************/
  //https://www.google.com/recaptcha/admin#site/318046216
  $publickey = "6LcIAPUSAAAAAJeEkhZwNKNsM6RBNtN_iKcF80xi";
  $privatekey = "6LcIAPUSAAAAAOWFKdYaYgFudsAMkDQjjf_QiT7L";

  //you're done. below is other stuff that you only need to modify if you need to modify it. :P :D
?>