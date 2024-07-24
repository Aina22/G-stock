<?php
session_start();
if (isset($_SESSION['access']) && isset($_SESSION['nom'])) {
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../lib/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Connexion</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Login</h2>
                        <div class="card-body">
                            <form method="post">
                                <?php
                                require "../lib/tools/db/mysqlConnection.php";
                                $isempty = "";

                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                    if (isset($_POST['nom']) && isset($_POST['mdp'])) {
                                        $username = $_POST['nom'];
                                        $password = $_POST['mdp'];
                                        if (!empty($username)) {
                                            // Verifier si le username est un admin ou non
                                
                                            $admin_sql_query = 'SELECT * FROM responsable 
                                            WHERE nom_utilisateur =:username AND 
                                            mdp = :password 
                                            AND admin_access = :access;';

                                            $Prepare_query = $db->prepare($admin_sql_query);
                                            $Prepare_query->execute([
                                                ":username" => $username,
                                                ":password" => $password,
                                                ":access" => "oui"
                                            ]);

                                            $resultat = $Prepare_query->rowCount();
                                            if ($resultat === 1) {
                                                $admin = $Prepare_query->fetch(PDO::FETCH_ASSOC);
                                                session_start();
                                                $_SESSION['access'] = $admin['admin_access'];
                                                $_SESSION['nom'] = $admin["nom_responsable"];
                                                $_SESSION['id'] = $admin['id_responsable'];
                                                $_SESSION['mdp'] = $admin["mdp"];

                                                header("Location:../index.php");
                                            } else {
                                                $admin_sql_query = 'SELECT * FROM responsable 
                                                WHERE nom_utilisateur =:username AND 
                                                mdp = :password 
                                                AND admin_access = :access;';

                                                $noAdmin_query = $db->prepare($admin_sql_query);
                                                $noAdmin_query->execute([
                                                    ":username" => $username,
                                                    ":password" => $password,
                                                    ":access" => "non"
                                                ]);
                                                $resultat = $noAdmin_query->rowCount();
                                                if ($resultat === 1) {
                                                    $noAdmin = $noAdmin_query->fetch(PDO::FETCH_ASSOC);
                                                    session_start();
                                                    $_SESSION['access'] = $noAdmin['admin_access'];
                                                    $_SESSION['nom'] = $noAdmin["nom_responsable"];
                                                    header("Location:../index.php");
                                                } else {
                                                    $isempty = "Les information que vous avez entrée son invalide";
                                                }
                                            }

                                        } else {
                                            $isempty = 'S\'il vous plait remplit les champs ';
                                        }
                                    }

                                }
                                ?>
                                <div class="mb-3">
                                    <label for="user" class="form-label">Nom utilisateur</label>
                                    <input type="text" class="form-control" name="nom" id="user"
                                        aria-describedby="helpId" placeholder="" />
                                    <small class="text-danger"><?= $isempty ?></small>
                                </div>
                                <div class="mb-3">
                                    <label for="mdp" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" name="mdp" id="mdp"
                                        aria-describedby="helpId" placeholder="" />
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Se connecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    </div>
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>