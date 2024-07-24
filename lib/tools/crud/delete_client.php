<?php
session_start();
require "../db/mysqlConnection.php";
if (!isset($_SESSION['access']) && !isset($_SESSION['nom'])) {
    header("Location:auth/login.php");
}
if(isset($_GET["id"])) {
    $id = $_GET['id'];
    $sqlQuery1 = "DELETE FROM commande WHERE id_commande = :id";
    $query1 = $db->prepare($sqlQuery1);
    $query1->execute([
        ":id" => $id
    ]);
    header("Location:../../../commande.php");
}else{
    echo "tsy mety";
}