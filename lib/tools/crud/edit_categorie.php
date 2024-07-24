<?php
require "../db/mysqlConnection.php";
session_start();
if (!isset($_SESSION['nom'])) {
    header("Location:auth/login.php");
}
$nom = $_SESSION['nom'];
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
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (
                isset($_POST["nom"]) && !empty($_POST["nom"]))
            {
                $name = $_POST["nom"];
                // Traitez les données ici, par exemple en mettant à jour la base de données
                $mysql_request = "UPDATE categorie SET nom = :nom WHERE id_categorie = :id";
                $query = $db->prepare($mysql_request);
                $query->execute([
                    ':nom' => $name,
                    ':id' => $_GET['id']
                ]);

                header('Location:../../../categorie.php');
            }
        }

        // Affichage du formulaire initialement
        if (isset($_GET["id"])) {
            $id = $_GET['id'];
            $sqlQuery = "SELECT nom FROM categorie WHERE id_categorie = :id";
            $query = $db->prepare($sqlQuery);
            $query->execute([
                ":id" => $id
            ]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $nom = $result['nom'];
        ?>
            <form method="post">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?= htmlspecialchars($nom) ?>" />
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        <?php
        } else {
            echo "<div class='alert alert-danger'>Aucun ID fourni pour éditer les informations.</div>";
        }
        ?>
    </div>

    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
</body>

</html>
