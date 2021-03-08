<?php
    session_start();
    require_once 'Connexion_BDD.php'; 

    if (isset($_GET['Section']))
    {
        $Section = htmlspecialchars($_GET['Section']);
    }
    else
    {
        $Section = "";
    }

    if(isset($_POST['SubmitRecup'],$_POST['EmailRecup'])) 
    {
        if(!empty($_POST['EmailRecup'])) 
        {
            $recup_mail = htmlspecialchars($_POST['EmailRecup']);
            if(filter_var($recup_mail,FILTER_VALIDATE_EMAIL)) 
            {
                $mailexist = $bdd->prepare('SELECT ID, Login_User FROM users WHERE Email = ?');
                $mailexist->execute(array($recup_mail));
                $mailexist_count = $mailexist->rowCount();
                if($mailexist_count == 1) 
                {
                    $Data = $mailexist->fetch();
                    $Login = $Data['Login'];
                    
                    $_SESSION['EmailRecup'] = $recup_mail;
                    $recup_code = "";
                    for($i=0; $i < 8; $i++) 
                    { 
                        $recup_code .= mt_rand(0,9);
                    }
                    $mail_recup_exist = $bdd->prepare('SELECT ID FROM recuperation WHERE Email = ?');
                    $mail_recup_exist->execute(array($recup_mail));
                    $mail_recup_exist = $mail_recup_exist->rowCount();
                    if($mail_recup_exist == 1) 
                    {
                        $recup_insert = $bdd->prepare('UPDATE recuperation SET Code = ? WHERE Email = ?');
                        $recup_insert->execute(array($recup_code,$recup_mail));
                    } 
                    else 
                    {
                        $recup_insert = $bdd->prepare('INSERT INTO recuperation(ID, Email, Code, Confirm) VALUES (?, ?, ?, ?)');
                        $recup_insert->execute(array($Data['ID'], $recup_mail,$recup_code, '0'));
                    }
                    $header="MIME-Version: 1.0\r\n";
                    $header.='From:"APC.com"<support@apc.com>'."\n";
                    $header.='Content-Type:text/html; charset="utf-8"'."\n";
                    $header.='Content-Transfer-Encoding: 8bit';
                    $message = '
                    <html>
                    <head>
                        <title>Récupération de mot de passe - APC.com</title>
                        <meta charset="utf-8" />
                    </head>
                    <body>
                        <font color="#303030";>
                            <div align="center">
                                <table width="600px">
                                    <tr>
                                        <td>
                                            
                                            <div align="center">Bonjour <b>'.$Login.'</b>,</div>
                                            Voici votre code de récupération: <b>'.$recup_code.'</b>
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </font>
                    </body>
                    </html>
                    ';

                    mail($recup_mail, "Récupération de mot de passe - APC.com", $message, $header);
                    header("Location:http://localhost/Memoire/Recuperation.php?Section=Code");
                } 
                else 
                {
                    $error = "Cette adresse mail n'est pas enregistrée";
                }
            } 
            else 
            {
                $error = "Adresse mail invalide";
            }
        } 
        else 
        {
            $error = "Veuillez entrer votre adresse mail";
        }
    }

    if(isset($_POST['SubmitVerif'],$_POST['CodeVerif'])) 
    {
        if(!empty($_POST['CodeVerif'])) 
        {
            $verif_code = htmlspecialchars($_POST['CodeVerif']);
            $verif_req = $bdd->prepare('SELECT ID FROM recuperation WHERE Email = ? AND Code = ?');
            $verif_req->execute(array($_SESSION['EmailRecup'],$verif_code));
            $verif_req = $verif_req->rowCount();
            if($verif_req == 1) 
            {
                $up_req = $bdd->prepare('UPDATE recuperation SET Confirm = 1 WHERE Email = ?');
                $up_req->execute(array($_SESSION['EmailRecup']));
                header('Location:http://localhost/Memoire/Recuperation.php?Section=ChangeMdp');
            } 
            else 
            {
                $error = "Code invalide";
            }
        } 
        else 
        {
            $error = "Veuillez entrer votre code de confirmation";
        }
    }
    if(isset($_POST['SubmitChange'])) 
    {
        if(isset($_POST['Mdp'],$_POST['CMdp'])) 
        {
            $verif_confirme = $bdd->prepare('SELECT Confirm FROM recuperation WHERE Email = ?');
            $verif_confirme->execute(array($_SESSION['EmailRecup']));
            $verif_confirme = $verif_confirme->fetch();
            $verif_confirme = $verif_confirme['Confirm'];
            if($verif_confirme == 1) 
            {
                $mdp = htmlspecialchars($_POST['Mdp']);
                $mdpc = htmlspecialchars($_POST['CMdp']);
                if(!empty($mdp) AND !empty($mdpc)) 
                {
                    if($mdp == $mdpc) 
                    {
                        //    $mdp = sha1($mdp);
                        $ins_mdp = $bdd->prepare('UPDATE users SET Mdp_User = ? WHERE Email = ?');
                        $ins_mdp->execute(array($mdp,$_SESSION['EmailRecup']));
                        $del_req = $bdd->prepare('DELETE FROM recuperation WHERE Email = ?');
                        $del_req->execute(array($_SESSION['EmailRecup']));
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
    <?php
        if($Section == 'Code') 
        { ?>
            
            <br/>
            <form method="post">
                <div class="container" id="form">
                    <div>
                        Un code de vérification vous a été envoyé par mail: <?= $_SESSION['EmailRecup'] ?>
                    </div>
                    <div class="form-group" id="champ"></div>
                        <label for="CodeVerif">Code de verification</label>
                        <input type="Text" class="form-control" name="CodeVerif" placeholder="Code de verification">
                        <button type="submit" class="btn btn-primary" name="SubmitVerif">Valider</button>
                    </div>
                </div>
            </form>
            <?php 
        } 
        elseif($Section == "ChangeMdp") 
        { ?>
            
            <form method="post">
                <div class="container" id="form">
                    <div>
                        Nouveau mot de passe pour <?= $_SESSION['EmailRecup'] ?>
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
                        <label for="EmailRecup">Adresse Email</label>
                        <input type="Text" class="form-control" name="EmailRecup" placeholder="Adresse Email">
                        <button type="submit" class="btn btn-primary" name="SubmitRecup">Valider</button>
                    </div>
                </div>
            </form>
            <?php 
        } ?>
    <?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } else { echo ""; } ?>
    </div>
</body>
</html>