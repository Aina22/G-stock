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
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (
                isset($_POST["nom"]) && isset($_POST['mdp']) && isset($_POST['admin']) &&
                !empty($_POST["nom"]) && !empty($_POST['mdp']) && !empty($_POST['admin'])
            ) 
            {
                $name = $_POST["nom"];
                $mdp = $_POST['mdp'];
                $admin = $_POST['admin'];

                // Traitez les données ici, par exemple en mettant à jour la base de données
                $mysql_request = "UPDATE responsable SET nom_responsable = :nom, mdp = :mdp, admin_access = :admin WHERE id_responsable = :id";
                $query = $db->prepare($mysql_request);
                $query->execute([
                    ':nom' => $name,
                    ':mdp' => $mdp,
                    ':admin' => $admin,
                    ':id' => $_GET['id']
                ]);

                header('Location:../../../responsable.php');
            }
        }

        // Affichage du formulaire initialement
        if (isset($_GET["id"])) {
            $id = $_GET['id'];
            $sqlQuery = "SELECT nom_responsable, mdp FROM responsable WHERE id_responsable = :id";
            $query = $db->prepare($sqlQuery);
            $query->execute([
                ":id" => $id
            ]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $nom = $result['nom_responsable'];
            $mdp = $result['mdp'];
        ?>
            <form method="post">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?= htmlspecialchars($nom) ?>" />
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" id="mdp" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?= htmlspecialchars($mdp) ?>" />
                </div>
                <div class="mb-3">
                    <label for="admin" class="form-label">Accès admin</label>
                    <select name="admin" id="admin" class="form-control">
                        <?php
                        $sql = "SELECT admin_access FROM responsable";
                        $request = $db->prepare($sql);
                        $request->execute();
                        while ($access = $request->fetch(PDO::FETCH_ASSOC)) {
                            $access_value = htmlspecialchars($access['admin_access']);
                        ?>
                            <option value="<?= $access_value ?>"><?= $access_value ?></option>
                        <?php } ?>
                    </select>
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
