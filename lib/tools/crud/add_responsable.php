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
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['nom']) && isset($_POST['mdp']) && isset($_POST['admin'])
        && !empty($_POST['nom']) && !empty($_POST['mdp']) && !empty($_POST['admin'])  
        ){
            $nom = $_POST['nom'];
            $mdp = $_POST['mdp'];
            $admin = $_POST['admin']; 

            $add_sql_query = "INSERT INTO responsable (nom_responsable,mdp,nom_utilisateur,admin_access) VALUES (:nom,:mdp,:username,:admin);";
            
            $request = $db->prepare($add_sql_query);
            $request->execute([
                ":nom"=>$nom,
                ":username"=>$nom,
                ":mdp"=>$mdp,
                ":admin" =>$admin,
            ]);
            header("Location:../../../responsable.php");
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
                <label for="mdp" class="form-label">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="form-control" placeholder=""
                    aria-describedby="helpId" />
            </div>
            <div class="mb-3">
                <span class="mb-3">Accès au admin: </span>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="admin" id="flexRadioDefault1" value="oui">
                    <label class="form-check-label" for="flexRadioDefault1">
                        oui
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="admin" id="flexRadioDefault2" value="non" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        non
                    </label>
                </div>
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