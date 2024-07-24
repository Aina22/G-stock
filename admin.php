<?php
require "lib/tools/db/mysqlConnection.php";
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion de stock</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="lib/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="lib/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="lib/dist/css/adminlte.min.css">
  <style>
    .selected {
      position: relative;
      background-color: #354e58;
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .giga-big {
      font-size: 3rem;
    }

    .bottum {
      float: right;
      padding-top: 15px;
    }

    .selected::before {
      content: "";
      position: absolute;
      width: 7px;
      height: 100%;
      top: 0;
      left: -10px;
      background-color: skyblue;

    }
  </style>
</head>

<body>
  <?php
  $error = "";
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['mdp']) && !empty($_POST['mdp'])) {
      $username = $_POST['username'];
      $mdp = $_POST['mdp'];
      $admin = $nom ;
      $count_admin_sql = 'SELECT nom_utilisateur FROM responsable WHERE nom_utilisateur = :username ';
      $count_admin = $db->prepare($count_admin_sql);
      $count_admin->execute([":username" => $nom]);
      $resultat = $count_admin->rowCount();
      if ($resultat > 0) {
        $update_sql = "UPDATE responsable SET nom_utilisateur = :username, mdp = :mdp WHERE nom_responsable = :admin";
        $update = $db->prepare($update_sql);
        $update->execute([
          ":username" => $username,
          ":mdp" => $mdp,
          ":admin" => $nom
        ]);
      } else {
        $error = "Cette utilisateur existe déja";
      }
    }
  }else{
    $error = "Veuillez remplir les champs";
  }
  ?>
  <div class="container">
    <form method="POST">
      <div class="mb-3 mt-3">
        <?php
        if (!empty($error)) {
          ?>
          <div class="alert alert-danger">
            <?= $error ?>
          </div>
        <?php
        }
        ?>
      </div>
      <div class="mb-3">
        <label for="user" class="form-label">Nom utilisateur</label>
        <input type="text" name="username" id="user" class="form-control" placeholder="" aria-describedby="helpId" />
      </div>
      <div class="mb-3">
        <label for="pass" class="form-label">Mot de passe</label>
        <input type="text" name="mdp" id="pass" class="form-control" placeholder="" aria-describedby="helpId" />
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-primary">Valider</button>
      </div>
    </form>
  </div>

  <!-- jQuery -->
  <script src="lib/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="lib/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="lib/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="lib/dist/js/adminlte.min.js"></script>
</body>

</html>