<?php
  session_start();
  require_once 'Connexion_BDD.php'; 
  if ($_POST) 
  {
    
    extract($_POST);
    $req=$bdd->prepare('SELECT * FROM users WHERE Login_User = :Username');
    $req->execute(array('Username' => $Username));
    $data=$req->fetch();
    if ($data) // Acces OK !
    {
      if ($Verif_Mdp = password_verify($Mdp, $data['Mdp_User']))
      {
        $_SESSION['Valide']=$data['Valide'];
        $_SESSION['ID_User']=$data['ID'];
        $_SESSION['Login_User']=$data['Login_User'];
        $_SESSION['Email']=$data['Email'];
        header('Location:Extrait_De_Naissance.php');
      }
      else
      {
          echo"<script>alert('Cooredonnées incorrectes!')</script>";
      }
      
    }
    else
    {
      echo 'Erreur';
    }  
      $req->closeCursor();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/Connexion.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">  
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>

    <form action="Connexion.php" method="post">
      <div class="container" id="form">
          <?php
            if (isset($_GET['Section']))
            { ?>
              <div class="alert alert-light" role="alert">
                Veuillez valider votre compte
              </div> 
              <?php session_destroy(); ?>
              <a href="Connexion.php"><button type="button" class="btn btn-primary" name="valider" id="btn"> Reessayer  </button> </a><?php
            }
            else
            {?>
            <div class="form-group">
              <label for="Username">Nom d'utilisateur:</label>
              <input type="Text" class="form-control" name="Username" placeholder="Nom d'utilisateur">
            </div>
            <div class="form-group">
              <label for="Mdp">Mot de passe</label>
              <input type="password" class="form-control" name="Mdp" placeholder="Mot de passe">
            </div>
            <div class="a">  
              <?php
                if (isset($_SESSION['Login_Admin']))
                { ?>
                  <div class="alert alert-danger" role="alert">
                    "Veuillez d'abord vous déconnecter du compte Admin"
                  </div> <?php
                }
                else
                { ?>
                  <div class="col-md-7">
                    <a href="Recuperation.php"> Mot de passe oublié? </a>
                  </div>
                  <div class="col-md-5">
                    <button type="submit" class="btn btn-primary" name="valider" id="btn">Se Connecter</button>
                  </div> <?php
                } ?>
            </div>
            <?php
            } ?>
        </div>
    </form>


  </div>
</body>
</html>