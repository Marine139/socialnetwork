<?php
session_start();
session_destroy();
session_start();

//@see https://www.php.net/manual/fr/function.include.php
include "src/restricted.php";