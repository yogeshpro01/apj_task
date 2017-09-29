<?php
  include("db.php");
  session_start();
  session_destroy();
?>

<html>
  <head>
    <title>Logout</title>
  </head>
  <body bgcolor="skyblue">
    <h1>LOGGED OUT</h1>
    <a href = "index.php">Home page</a>
  </body>
</html>
