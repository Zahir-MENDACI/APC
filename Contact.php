<?php
	//tous d'abord il faut démarrer le système de sessions
	session_start();
    include ('Connexion_BDD.php');
	if(!isset($_SESSION['ID_User'])){
		header('location:Connexion.php');
  }
  $ID_User=$_SESSION['ID_User'];
  
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/Inscription.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>
   
    <form method="post">
        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-8 form-group">
                <label for="Msg">Message:</label>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-8 form-group">
                <textarea name="Msg" id="Msg" cols="30" rows="10"></textarea>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-8 form-group">
            <button type="submit" class="btn btn-primary" name="envoyer" id="envoyer">Envoyer</button>
            </div>
            <div class="col-md-2"></div>
        </div>
       
    </form>
    <?php
        if (isset($_POST['envoyer']))
        {
            if (!empty($_POST['Msg']))
            {
                extract($_POST);
                $req=$bdd->prepare('INSERT INTO Messages (ID_Exp, Email, Msg, Dat) VALUES(:ID, :Email, :Msg, :dat)');
                $req->execute(array('ID' => $_SESSION['ID_User'], 'Email' => $_SESSION['Email'], 'Msg' => $Msg, 'dat' => date("y/m/d") ));
            }
            else
            {
                echo"<script>alert('Veuillez ecrire votre message!')</script>";
            }
        }
        
    ?>

  </div>
   

</body>
</html>