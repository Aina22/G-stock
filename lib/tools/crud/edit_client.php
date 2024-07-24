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
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (
                isset($_POST["nom"]) && isset($_POST['produit']) && isset($_POST['quantiter']) &&
                !empty($_POST["nom"]) && !empty($_POST['produit']) && !empty($_POST["quantiter"])
            ) 
            {
                $name = $_POST["nom"];
                $produit = $_POST['produit'];
                $quantiter = $_POST['$quantiter'];
                // Traitez les données ici, par exemple en mettant à jour la base de données
                $mysql_request = "UPDATE commande SET nom_client = :nom_client, id_produit = :produit, quantites = :quantite  WHERE id_commande = :id";
                $query = $db->prepare($mysql_request);
                $query->execute([
                    ':nom_client' => $name,
                    ':produit' => $produit,
                    ':quantite' =>  $quantiter,
                    ':id' => $_GET['id']
                ]);

                header('Location:../../../commande.php');
            }else{
                $error ="Veuillez remplir les champs vides";
            }
        }

        // Affichage du formulaire initialement
        if (isset($_GET["id"])) {
            $id = $_GET['id'];
            $sqlQuery = "SELECT nom_client,quantites FROM commande WHERE id_commande = :id";
            $query = $db->prepare($sqlQuery);
            $query->execute([
                ":id" => $id
            ]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $nom = $result['nom_client'];
            $quantiter = $result['quantites'];
        ?>
            <form method="post">
                <?php if(!empty($error)){
                ?>
                <div class='alert alert-danger my-2'><?= $error?>.</div> 
                <?php }?>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom client</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?= htmlspecialchars($nom) ?>" />
                </div>
                <div class="mb-3">
                    <label for="produit" class="form-label">Produit</label>
                    <select class="form-control" id="produit" name="produit">
                    <?php
                    $requestSql = "SELECT id_produit ,nom FROM produit";
                    $request2 = $db->prepare($requestSql);
                    $request2->execute();

                    while ($resultat = $request2->fetch()) {
                        $id_produit = $resultat["id_produit"];
                        $nom_produit = $resultat["nom"];
                        ?>
                        <option value="<?= $id_produit ?>"><?= $nom_produit ?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="mb-3">
                    <label for="quantiter" class="form-label">Quantité</label>
                    <input type="text" name="quantiter" id="quantiter" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?= htmlspecialchars($quantiter) ?>" />
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
