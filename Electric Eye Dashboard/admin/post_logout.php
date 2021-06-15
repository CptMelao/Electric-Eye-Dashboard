<?php
    session_start();
    header('location:../index.php');
    unset($_SESSION['user']);
    session_destroy();
?>