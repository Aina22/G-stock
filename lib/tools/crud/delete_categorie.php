<?php 
session_start();
require "../db/mysqlConnection.php";
if (!isset($_SESSION['access']) && !isset($_SESSION['nom'])) {
  header("Location:auth/login.php");
}
if(isset($_GET["id"])){
    $id = $_GET['id'];
    $sqlQuery = "DELETE FROM categorie  WHERE id_categorie = :id";
    $query = $db->prepare($sqlQuery);
    $query->execute([
        ":id"=>$id
    ]);
    header("Location:../../../categorie.php");
}