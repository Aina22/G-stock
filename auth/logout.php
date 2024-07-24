<?php
session_start();
if(isset($_SESSION['access']) && isset($_SESSION['nom'])){
    session_unset();
    session_destroy();
    header("Location:login.php");
}