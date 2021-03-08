<?php 
  include ('Connexion_BDD.php');  
  session_start();
  
  if ($_POST) 
  {
    extract($_POST);
    $req=$bdd->prepare('SELECT * FROM admins WHERE Login_Admin = :Username AND Mdp_Admin = :Mdp');
    $req->execute(array('Username' => $Username, 'Mdp' => $Mdp));
    $data=$req->fetch();
    
    if ($data) // Acces OK !
    {
      $_SESSION['Login_Admin']=$data['Login_Admin'];
      $_SESSION['Mdp']=$data['Mdp_User'];
      header('location:Gestion_De_Demandes.php');       
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
    <form  method="post">
      <div class="container" id="form">
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
              if (isset($_SESSION['Login_User']))
              { ?>
                <div class="alert alert-danger" role="alert">
                  "Veuillez d'abord vous deconnecter du compte Citoyen"
                </div> <?php
              }
              else
              { ?>
          
                <div class="col-md-7">
                    
                </div>
                <div class="col-md-5">
                  <button type="submit" class="btn btn-primary" name="valider" id="btn">Se Connecter</button>
                </div> <?php
              } ?>
          </div>
      </div>
    </form>


  </div>
</body>
</html>