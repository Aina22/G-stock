<?php
require "../db/mysqlConnection.php";
session_start();
if (!isset($_SESSION['access']) && !isset($_SESSION['nom'])) {
    header("Location:auth/login.php");
}
$acces = $_SESSION['access'];
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
    <?php
    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            isset($_POST['nom']) && !empty($_POST['nom']) &&
            isset($_POST['categorie']) && !empty($_POST['categorie']) &&
            isset($_POST['quantiter']) && !empty($_POST['quantiter']) &&
            isset($_POST['prix']) && !empty($_POST['prix'])
        ) {
            $nom = $_POST['nom'];
            $categorie = $_POST['categorie'];
            $quantiter = $_POST['quantiter'];
            $prix = $_POST['prix'];
            $add_sql_query = "INSERT INTO produit (nom, prix_unitaire, id_categorie, quantiter) VALUES (:nom,:prix,:id,:quantiter)";

            $request = $db->prepare($add_sql_query);
            $request->execute([
                ":nom" => $nom,
                ":prix" => $prix,
                ":id" => $categorie,
                ":quantiter" => $quantiter
            ]);
            header("Location:../../../produit.php");
        } else {
            $error = "Veuillez remplir les formulaires";
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
                <label for="categorie" class="form-label">Categorie</label>
                <select class="form-control" id="categorie" name="categorie">
                    <?php
                    $requestSql = "SELECT id_categorie ,nom FROM categorie";
                    $request2 = $db->prepare($requestSql);
                    $request2->execute();

                    while ($resultat = $request2->fetch()) {
                        $id_produit = $resultat["id_categorie"];
                        $nom_produit = $resultat["nom"];
                        ?>
                        <option value="<?= $id_produit ?>"><?= $nom_produit ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantiter" class="form-label">Quantiter</label>
                <input type="number" name="quantiter" id="quantiter" class="form-control" placeholder=""
                    aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix unitaire</label>
                <input type="number" name="prix" id="prix" class="form-control" placeholder="" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <?php if (!empty($error)) { ?>
            <div id='error' class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?= $error ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="../utilities/toast.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
</body>

</html>
