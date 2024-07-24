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
    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            isset($_POST['nom']) && isset($_POST['produit']) && isset($_POST['quantiter'])
            && !empty($_POST['nom']) && !empty($_POST['produit']) && !empty($_POST['quantiter'])
        ) {
            $nom = $_POST['nom'];
            $quantiter = $_POST['quantiter'];
            $id_produit = $_POST['produit'];

            $nbr_query = "SELECT quantiter FROM produit WHERE id_produit= :id_produit";
            $request = $db->prepare($nbr_query);
            $request->execute([":id_produit" => $id_produit]);
            $stock = $request->fetch();
            if ($stock['quantiter'] >= $quantiter ) {
                $add_sql_query = "INSERT INTO commande(nom_client, quantites,id_produit) VALUES (:nom_client,:quantites,:id_produit);";
                $request = $db->prepare($add_sql_query);
                $request->execute([
                    ":nom_client" => $nom,
                    ":quantites" => $quantiter,
                    ":id_produit" => $id_produit
                ]);
                // Mettre à jour le nombre du produit
                $update_sql_query = "UPDATE produit SET quantiter =:quantiter WHERE id_produit = :id_produit";
                $request = $db->prepare($update_sql_query);
                $request->execute([
                    ":quantiter" => $stock['quantiter'] - $quantiter,
                    ":id_produit" => $id_produit,
                ]);
                header("Location:../../../commande.php");
            }else{
                $error = "Le nombre de produit que vous avez commander sont grande que le nombre de produit en stock";
            }
        }else{
            $error = "Veuillez remplir les champs vides";
        }
    }
    ?>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom Client</label>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="" aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <!-- nom produits -->
                <label for="categorie" class="form-label">Produit</label>
                <select class="form-control" id="categorie" name="produit">
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
                <!-- quantiter -->
                <label for="quantiter" class="form-label">Quantité</label>
                <input type="number" name="quantiter" id="quantiter" class="form-control" placeholder=""
                    aria-describedby="helpId" />
            </div>
            <?php 
            if(!empty($error)){
            ?>
            <div class="mb-3">
               <small class="text-danger"> <?=$error?></small> 
            </div>
            <?php  }?>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>

    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
</body>

</html>