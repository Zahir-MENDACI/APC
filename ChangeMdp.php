<?php
    session_start();
    require_once 'Connexion_BDD.php'; 
    $error="";
    if (isset($_GET['Section']))
    {
        $Section = htmlspecialchars($_GET['Section']);
    }
    else
    {
        $Section = "";
    }

    if(isset($_POST['SubmitID'],$_POST['ID'])) 
    {
        if(!empty($_POST['ID'])) 
        {
            $ID = htmlspecialchars($_POST['ID']);
            $IDexist = $bdd->prepare('SELECT Login_User FROM users WHERE ID = ?');
            $IDexist->execute(array($ID));
            $IDexist_count = $IDexist->rowCount();
            if($IDexist_count == 1) 
            {
                $Data = $IDexist->fetch();
                $_SESSION['Login'] = $Data['Login_User'];
                $_SESSION['ID'] = $ID;
                    header("Location:http://localhost/Memoire/ChangeMDP.php?Section=Mdp");
            } 
            else 
            {
                $error = "ID invalide";
            }
        } 
        else 
        {
            $error = "Veuillez entrer votre adresse mail";
        }
    }

    if(isset($_POST['SubmitChange'])) 
    {
        if(isset($_POST['Mdp'],$_POST['CMdp'])) 
        {
                $mdp = htmlspecialchars($_POST['Mdp']);
                $mdpc = htmlspecialchars($_POST['CMdp']);
                if(!empty($mdp) AND !empty($mdpc)) 
                {
                    if($mdp == $mdpc) 
                    {
                        //    $mdp = sha1($mdp);
                        $ins_mdp = $bdd->prepare('UPDATE users SET Mdp_User = ? WHERE ID = ?');
                        $ins_mdp->execute(array($mdp,$_SESSION['ID']));
                        header('Location:http://localhost/Memoire/Connexion.php');
                    } 
                    else 
                    {
                        $error = "Vos mots de passes ne correspondent pas";
                    }
                } 
                else 
                {
                    $error = "Veuillez remplir tous les champs";
                }
            } 
            else 
            {
                $error = "Veuillez valider votre mail grâce au code de vérification qui vous a été envoyé par mail";
            }
        } 
        else 
        {
            $error = "Veuillez remplir tous les champs";
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/Recuperation.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"> 
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>
    <h4 id="Titre">Récupération de mot de passe</h4>
    <?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } else { echo ""; } ?>

    <?php
        if($Section == "Mdp") 
        { ?>

            <form method="post">
                <div class="container" id="form">
                    <div>
                        Nouveau mot de passe pour <?= $_SESSION['Login'] ?>
                    </div>
                    <div class="form-group" id="champ"></div>
                        <label for="Mdp">Nouveau Mot de passe</label>
                        <input type="password" class="form-control" name="Mdp" placeholder="Nouveau Mot de passe">
                        <label for="CMdp">Confirmation du nouveau mot de passe</label>
                        <input type="password" class="form-control" name="CMdp" placeholder="Confirmation du nouveau mot de passe">
                        <button type="submit" class="btn btn-primary" name="SubmitChange">Valider</button>
                    </div>
                </div>
            </form>
            <?php 
        } 
        else 
        { ?>
            <form method="post">
                <div class="container" id="form">
                    <div class="form-group">
                        <label for="ID">ID du citoyen</label>
                        <input type="Text" class="form-control" name="ID" placeholder="ID">
                        <button type="submit" class="btn btn-primary" name="SubmitID">Valider</button>
                    </div>
                </div>
            </form>
            <?php 
        } ?>
    </div>
</body>
</html>