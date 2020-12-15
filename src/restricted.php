<?php

if (!isset($_SESSION['connected_id'])) {
    header('Status: 301 Not logged', false, 301);
    header('Location: login.php');
    //exit();
}
?>