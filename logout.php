<?php

include 'config.php';

session_start();
session_unset();
session_destroy();

// Remove token from local storage
echo '<script>';
echo 'localStorage.removeItem("token");';
echo '</script>';

header('location:login.php');

?>
