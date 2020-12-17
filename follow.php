<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "socialnetwork");
$getFollowedId = $_GET['followedid'];

?>