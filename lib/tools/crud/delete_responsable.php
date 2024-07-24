<?php 
session_start();
require "../db/mysqlConnection.php";
if (!isset($_SESSION['access']) && !isset($_SESSION['nom'])) {
  header("Location:auth/login.php");
}
if(isset($_GET["id"])){
    $id = $_GET['id'];
    $sqlQuery = "DELETE FROM responsable  WHERE id_responsable = :id";
    $query = $db->prepare($sqlQuery);
    $query->execute([
        ":id"=>$id
    ]);
    header("Location:../../../responsable.php");
}