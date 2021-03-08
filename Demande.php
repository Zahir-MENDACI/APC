<?php
	// tous d'abord il faut démarrer le système de sessions
	session_start();

	if(!isset($_SESSION['ID_User'])){
		header('location:Connexion.php');
  }
  $ID_User=$_SESSION['ID_User'];
  include ('Connexion_BDD.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/Demande.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="7d10e7b8-0f14-4710-a53c-7ac53c6429d4.png" width="60px" height="60px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <h5>
              <li class="nav-item active">
                <a class="nav-link" href="#">Acceuil <span class="sr-only">(current)</span></a>
              </li>
            </h5>
            <h5>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Etat Civil
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Acte De Naissance</a>
                  <a class="dropdown-item" href="#">Acte De Mariage</a>
                  <a class="dropdown-item" href="#">Acte De Décès</a>
                </div>
              </li>
            </h5>
            <h5>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
              </li>
            </h5>

            
              <li class="nav-item" id="NU">
                <?php echo $_SESSION['Login_User'];?> (<a href="logout.php">Deconnexion</a>)
              </li>
            

          </ul>
        </div>
      </nav>
   
    
        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group">
                <a href="Extrait_De_Naissance.php"><input type="button" value="Extrait De Naissance"></a>
                
            </div>
            <div class="col-md-4 form-group">
                
            </div>
            <div class="col-md-2"></div>
        </div>
        

   
    <?php
      include ('Connexion_BDD.php');
      if(isset($_POST['Valider']))
      {
        if(!empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['DN']) && !empty($_POST['LN']) && !empty($_POST['ID'])&& !empty($_POST['DR'] ))
        {
            //extract($_POST); 
            $Nom=htmlspecialchars($_POST['Nom']);
            $Prenom=htmlspecialchars($_POST['Prenom']);
            $DN=htmlspecialchars($_POST['DN']);
            $LN=htmlspecialchars($_POST['LN']);
            $ID=htmlspecialchars($_POST['ID']);
            $DR=htmlspecialchars($_POST['DR']);
            $HR=htmlspecialchars($_POST['HR']);
            $Min=htmlspecialchars($_POST['Min']);
            $Nbre=htmlspecialchars($_POST['Nbre']);
            $Sexe=htmlspecialchars($_POST['Sexe']);
            $Heure=$HR.'h'.$Min;
            mysql_query("INSERT INTO demande (Nbre, ID, Nom, Prenom, DN, LN, Sexe, Date_Recup, Heure_Recup, ID_User) VALUES ('$Nbre', '$ID', '$Nom', '$Prenom','$DN','$LN','$Sexe','$DR','$Heure', $ID_User)") or die(mysql_error());
            echo"<script>alert('valider!')</script>";
        }
        else
        {
          echo"<script>alert('remplirez touts les champs!')</script>";
        }
      }
?>

    

?>
    
  <script>
    function surligne(champ, erreur)
            {
               if(erreur)
               {
                    champ.style.borderColor = "red";
                   
                }
               else
               {
                    champ.style.borderColor = "#2fef59";
                    
                }
            }
            function verifPseudo(champ)
            {
                if(champ.value.length > 0 )
                    {
                    surligne (champ, false);
                    return true;
                    }
                
                else
                    {
                    surligne (champ, true);
                    return false;
                    }
            }</script>  
   

</body>
</html>