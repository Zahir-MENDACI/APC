<?php
	//tous d'abord il faut démarrer le système de sessions
	session_start();

	if(!isset($_SESSION['ID_User'])){
		header('location:Connexion.php');
  }
  $ID_User=$_SESSION['ID_User'];
  if($_SESSION['Valide'] == "0")
  {
    header('location:Connexion.php?Section=Confirm');
  }
  include ('Connexion_BDD.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/Extrait_De_Naissance.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>
    <form method="post">
      <div id="form">
          <div class="a">
              <div class="col-md-2"></div>
              <div class="col-md-4 form-group">
                  <label>Nombre d'exemplaire:</label>
                  <select class="custom-select" name="Nbre">
                      <option value="1"selected>1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                  </select>
              </div>
              <div class="col-md-4 form-group">
                  <label>Jour:</label>
                  <!-- <input type="date"  class="form-control" id="DR" name="DR">  -->
                  <input type="text" class="form-control" name="DR" id="datepicker" placeholder="AAAA-MM-JJ">
              </div>
              <div class="col-md-2"></div>
          </div>
          <div class="a">
              <div class="col-md-2" ></div>
              <div class="col-md-4 form-group">
                  <label>Heure:</label>
                  <div style="display: flex">
                      <select class="custom-select" name="HR">
                          <option value="08" selected>8</option>
                          <option value="09">9</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                      </select>
                      <h3>h</h3>
                      <select class="custom-select" name="Min">
                          <option value="00m" selected>00</option>
                          <option value="15m">15</option>
                          <option value="30m">30</option>
                          <option value="45m">45</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-4 form-group">
                <label></label>
                  <div id="btn">
                      <button type="reset" class="btn btn-light">Effacer</button>
                      <button type="submit" class="btn btn-primary" name="Valider">Valider</button>
                  </div>
              </div>
              <div class="col-md-2"></div>
          </div>        
      </div>
    </form>

   
    <?php
      include ('Connexion_BDD.php');
      if(isset($_POST['Valider']))
      {
        if(!empty($_POST['DR']))
        {
            extract($_POST); 
            $Heure=$HR.'h'.$Min;
            echo $Nbre;
            $ID = $_SESSION['ID_User'];
            $bdd->exec("INSERT INTO demande (ID_User, Nbre, Date_Recup, Heure) VALUES ('$ID', '$Nbre', '$DR', '$Heure')");

            echo"<script>alert('valider!')</script>";
        }
        else
        {
          echo"<script>alert('remplirez tous les champs!')</script>";
        }
      }
    ?>

  </div>
    

    
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