<?php
require_once ("dbconnect.php");
session_start();
session_destroy();
header("Location: index.php");
return;
?>
