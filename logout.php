<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["login"]);
unset($_SESSION["order"]);
header('location: index.php');
?>