<?php
session_start();
if (!isset($_SESSION['access']) && !isset($_SESSION['nom'])) {
  header("Location:login.php");
}
$acces = $_SESSION['access'];
$nom = $_SESSION['nom'];
require "lib/tools/db/mysqlConnection.php";
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

    .overflow {
      overflow-y: auto;
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
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link mb-2" data-toggle="dropdown" href="#">
            <img src="avatar.webp" class="rounded" height="40" width="40" alt="">
          </a>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <?php
            if ($acces === "oui") {
              ?>
              <a href="admin.php" class="dropdown-item">
                <i class="fas fa-user mr-2"></i> Administrateur
              </a>
              <div class="dropdown-divider"></div>
            <?php } ?>
            <a href="auth/logout.php" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-secondary elevation-4">
      <a href="index.php" class="brand-link pl-4">
        <h4>G-stock</h4>
      </a>
      <!-- Brand Logo -->

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="avatar.webp" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $nom ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="navbar-item pl-3">
              <p class="navbar-text pull-right mt-3">
                <a href="index.php" class="navbar-link">
                  <i class="fa fa-tachometer-alt"></i>
                  Dashboard
                </a>
              </p>
            </li>
            <li class="navbar-item pl-3">
              <p class="navbar-text pull-right  mt-3">
                <a href="produit.php" class="navbar-link">
                  <i class="fa fa-box"></i>
                  Produits
                </a>
              </p>
            </li>
            <li class="navbar-item pl-3  selected">
              <p class="navbar-text pull-right  mt-3">
                <a href="categorie.php" class="navbar-link">
                  <i class="fa fa-th-list"></i>
                  Catégorie
                </a>
              </p>
            </li>
            <li class="navbar-item pl-3">
              <p class="navbar-text pull-right  mt-3">
              <a href="commande.php" class="navbar-link">
                <i class="fa fa-shopping-cart"></i>
                  Commande
                </a>
              </p>
            </li>
            <?php if ($acces === "oui") { ?>
              <li class="navbar-item pl-3">
                <p class="navbar-text pull-right  mt-3">
                  <a href="responsable.php" class="navbar-link">
                    <i class="fa fa-user-tie"></i>
                    Responsable
                  </a>
                </p>
              </li>
            <?php } ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Categories</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end">
              <a href="lib/tools/crud/add_categorie.php">
                <button class="btn btn-primary">
                  <span class="text-light mr-2">Ajouter</span>
                  <i class="text-light fa fa-plus"></i>
                </button>
              </a>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="container-fluid">
          <div class="table-responsive">
            <table class="table table-secondary">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nom</th>
                  <th scope="col">action</th>
                </tr>
              </thead>
              <tbody class="overflow">
                <?php
                $sql_responsable = "SELECT * FROM categorie";
                $request = $db->prepare($sql_responsable);
                $request->execute();

                while ($resultat = $request->fetch(PDO::FETCH_ASSOC)) {

                  ?>
                  <tr>
                    <td><?= $resultat['id_categorie'] ?></td>
                    <td><?= $resultat['nom'] ?></td>
                    <td>
                      <a href="lib/tools/crud/edit_categorie?id=<?= $resultat['id_categorie'] ?>">
                        <button class="btn btn-success">
                          <i class="fa fa-edit text-light"></i>
                        </button>
                      </a>
                      <a href="lib/tools/crud/delete_categorie?id=<?= $resultat['id_categorie'] ?>">
                        <button class="btn btn-danger">
                          <i class="fa fa-trash text-light"></i>
                        </button>
                      </a>
                    </td>
                    <?php
                }
                ?>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </section>
      <!-- /.content -->
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