<?php
require "../db/mysqlConnection.php";
session_start();
if (!isset($_SESSION['access']) && !isset($_SESSION['nom']) && !isset($_SESSION['mdp'])) {
    header("Location:auth/login.php");
}
$acces = $_SESSION['access'];
$nom = $_SESSION['nom'];
$mdp = $_SESSION['mdp'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <title>G-stock</title>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nom']) && !empty($_POST['nom'])) {
            $nom = $_POST['nom'];
            $add_sql_query = "INSERT INTO categorie (nom) VALUES (:nom);";

            $request = $db->prepare($add_sql_query);
            $request->execute([
                ":nom" => $nom,
            ]);
            header("Location:../../../categorie.php");
        }
    }
    ?>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>

    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
</body>

</html>