<?php
include(__DIR__ . '/../motojen-admin/config/dbcon.php');
session_start();
session_unset();
session_destroy();

header('location: login.php');

?>