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
    .card{
      transition: 0.3s;
      box-shadow: -4px 5px 8px rgba(0, 0, 0, 0.7);
    }
    .card:hover{
      transform: scale(1.1);
      transition: 0.3s;
      box-shadow: -6px 8px 8px rgba(0, 0, 0, 0.7);
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
            <li class="navbar-item pl-3 selected">
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
            <li class="navbar-item pl-3">
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
              <h1>Dashboard</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="container-fluid">
          <div class="row ">
            <div class="col-lg-4 pt-3 pl-4">
              <?php
              $nbr_query = "SELECT sum(quantiter) FROM produit";
              $request = $db->prepare($nbr_query);
              $request->execute();

              $nbr_produit = $request->fetch();
              $sum = $nbr_produit["sum(quantiter)"];
              ?>
              <div class="card bg-primary mb-3" style="max-width: 18rem;">
                <a href="produit.php">
                  <div class="card-body">
                    <h5 class="card-title">Quantité des produits</h5>
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <h1 class="giga-big"><?= $sum === null ? 0 : $sum ?></h1>
                      </div>
                      <div class="col-md-4">
                        <h1 class="bottum"><i class="fa fa-box "></i></h1>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="col-lg-4 pt-3 pl-4">
              <?php
              $nbr_query = "SELECT * FROM categorie";
              $request = $db->prepare($nbr_query);
              $request->execute();

              $nbr_cat = $request->rowCount();
              ?>
              <div class="card bg-secondary mb-3" style="max-width: 18rem;">
                <a href="categorie.php">
                  <div class="card-body">
                    <h5 class="card-title">Nombre des Categories</h5>
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <h1 class="giga-big"><?= $nbr_cat ?></h1>
                      </div>
                      <div class="col-md-4">
                        <h1 class="bottum"><i class="fa fa-th-list"></i></h1>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php if ($acces === "oui") {
              $nbr_query = "SELECT * FROM responsable";
              $request = $db->prepare($nbr_query);
              $request->execute();

              $nbr = $request->rowCount();

              ?>
              <div class="col-lg-4 pt-3 pl-4">
                <div class="card bg-danger mb-3" style="max-width: 18rem;">
                  <a href="responsable.php">
                    <div class="card-body">
                      <h5 class="card-title">Nombre des Responsables</h5>
                      <br>
                      <div class="row">
                        <div class="col-md-8">
                          <h1 class="giga-big"><?= $nbr ?></h1>
                        </div>
                        <div class="col-md-4">
                          <h1 class="bottum"><i class="fa fa-user-tie"></i></h1>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
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