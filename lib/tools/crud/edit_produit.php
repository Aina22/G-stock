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
            $add_sql_query = "UPDATE produit SET nom = :nom, prix_unitaire = :prix, id_categorie = :id_cat, quantiter = :quantiter WHERE id_produit = :id";

            $request = $db->prepare($add_sql_query);
            $request->execute([
                ":nom" => $nom,
                ":prix" => $prix,
                ":id_cat" => $categorie,
                ":quantiter" => $quantiter,
                ":id" => $_GET['id']
            ]);
            header("Location:../../../produit.php");
        }
    }
    ?>
    <?php
      if (isset($_GET["id"])) {
            $id = $_GET['id'];
            $sqlQuery = "SELECT * FROM produit WHERE id_produit = :id";
            $query = $db->prepare($sqlQuery);
            $query->execute([
                ":id" => $id
            ]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $nom = $result['nom'];
            $quantiter = $result['quantiter'];
            $prix = $result['prix_unitaire'];
        ?>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="" aria-describedby="helpId" value="<?=$nom?>"/>
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
                    aria-describedby="helpId" value="<?=$quantiter?>"/>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix unitaire</label>
                <input type="number" name="prix" id="prix" class="form-control" placeholder="" aria-describedby="helpId" value="<?=$prix?>"/>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
</body>
<?php }?>
</html>
