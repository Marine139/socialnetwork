<?php
session_start();

echo "<h2>REQUEST</h2>";
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
echo '<h2>$_GET</h2>';
echo "<pre>";
print_r($_GET);
echo "</pre>";
echo '<h2>$_POST</h2>';
echo "<pre>";
print_r($_POST);
echo "</pre>";
echo '<h2>$_COOKIE</h2>';
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
echo "</pre>";
echo '<h2>$_SESSION</h2>';
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

setcookie("bibi", "nono");