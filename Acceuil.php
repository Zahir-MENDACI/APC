<?php
  session_start();
  require_once 'Connexion_BDD.php'; 
  if ($_POST) 
  {
    
    extract($_POST);
    $req=$bdd->prepare('SELECT * FROM users WHERE Login_User = :Username AND Mdp_User = :Mdp');
    $req->execute(array('Username' => $Username, 'Mdp' => $Mdp));
    $data=$req->fetch();
    if ($data) // Acces OK !
    {
      $_SESSION['Valide']=$data['Valide'];
      $_SESSION['ID_User']=$data['ID'];
      $_SESSION['Login_User']=$data['Login_User'];
      $_SESSION['Email']=$data['Email'];
      header('Location:Extrait_De_Naissance.php');
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
    <link rel="stylesheet" href="./styles/Acceuil.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?> 
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-sd-6" >
          <div class="card border-dark mb-3" id="card" >
            <div class="card-header"><h5>Avis aux citoyens</h5></div>
              <div class="card-body text-dark">
                <p class="card-text">Mairie En Ligne permet aux citoyens de la commmune de demander guratuitement un acte de naisssance. Et prendre  Rendez-vous pour les récuperer.</p>
              </div>
            </div>
          </div>
        
        <div class="col-md-3 col-sd-6">
          <form action="Connexion.php" method="post">
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
                      if (isset($_SESSION['Login_Admin']))
                      { ?>
                        <div class="alert alert-danger" role="alert">
                          "Veuillez d'abord vous déconnecter du compte Admin"
                        </div> <?php
                      }
                      else
                      { ?>
                        <div class="col-md-12">
                          <a href="Recuperation.php"> Mot de passe oublié? </a>
                        </div>
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary" name="valider" id="btn">Se Connecter</button>
                        </div> <?php
                      } ?>
                  </div>
              </div>
          </form>  
        </div>  
      </div>
      </div>
    </div>    
   

    
</body>
</html>