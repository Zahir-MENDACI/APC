<?php
        if(isset($_POST['valider']))
        {
            

            

            require_once 'Connexion_BDD.php'; 
            extract($_POST);

            if ((!preg_match("/[a-zA-Z]+/", $Nom)) || (!preg_match("/[a-zA-Z]+/", $Prenom)))
            {
                echo "<script>alert('Nom ou Prenom invalide')</script>";
            }

            if (!preg_match("/[0-9]+/", $ID))
            {
                echo "<script>alert('ID invalide')</script>";
            }

            if (!preg_match("/[a-zA-Z]{1,20}[0-9]{0,3}/", $Username))
            {
                echo "<script>alert('Pseudo invalide')</script>";
            }

                if(!empty($ID) && !empty($Nom) && !empty($Prenom) && !empty($Username) && !empty($Mdp) && !empty($email))
                {
                    $reqID = $bdd -> query("SELECT ID FROM users WHERE ID = '$ID'");
                    $reqID = $reqID -> rowCount();
                    
                    $reqNU = $bdd -> query("SELECT Login_User FROM users WHERE Login_User = '$Username'");
                    $reqNU = $reqNU -> rowCount();

                    $reqEm = $bdd -> query("SELECT Email FROM users WHERE Email = '$email'");
                    $reqEm = $reqEm -> rowCount();

                    if(($reqID == 0) && ($reqNU == 0) && ($reqEm == 0))
                    {
                        if(($Mdp == $CMdp) && (!empty($Mdp)) && (!empty($CMdp)))
                        {
                            $req = $bdd -> query("SELECT * FROM citoyens WHERE ID = '$ID' AND Nom = '$Nom' AND Prenom = '$Prenom'");
                            $res = $req -> fetch();
                            if ( $res )
                            {
                                $longueurKey = 15;
                                $Cle = "";
                                for($i=1; $i<$longueurKey; $i++) {
                                $Cle .= mt_rand(0,9);
                                }
                                $Mdp = password_hash($Mdp, PASSWORD_DEFAULT);
                                $bdd -> exec("INSERT INTO users (ID, Email, Login_User, Mdp_User, CleConfirmation, Valide) VALUES ('$ID', '$email', '$Username', '$Mdp', '$Cle', '0')");
                                // $req2 = $bdd->prepare("INSERT INTO users(ID, Username, Mdp) VALUES(:ID, :Username, :Mdp)");
                                // $req2->execute(array(

                                //     'ID' => $ID,
                                //     'Username' => $Nom,
                                //     'Mdp' => $Prenom,
                                //     ));

                                header("Location:Connexion.php");

                                $header="MIME-Version: 1.0\r\n";
                                $header.='From:"APC.com"<support@apc.com>'."\n";
                                $header.='Content-Type:text/html; charset="uft-8"'."\n";
                                $header.='Content-Transfer-Encoding: 8bit';
                                $message='
                                <html>
                                    <body>
                                    <div align="center">
                                            <p>Vous venez de vous inscrire au site de l\'APC d\'Azazga </p> <br/>
                                            <p>Veuillez confirmer cotre compte pour finaliser votre inscription</p>
                                        <a href="http://localhost/Memoire/confirmation.php?ID='.$ID.'&Cle='.$Cle.'">Confirmez votre compte !</a>
                                    </div>
                                    </body>
                                </html>
                                ';
                                mail($email, "Confirmation de compte", $message, $header);
                                // $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                            }
                            
                        }
                        else
                            {
                                echo"<script>alert('Votre mot de passe ne correspond pas!')</script>";
                            }
                    }
                    else
                    {
                        if($reqID == 1)
                        {
                            $Alert1 = 'Il existe deja un compte avec cet ID';
                        }
                        if($reqNU == 1)
                        {
                            $Alert2 = 'Il existe deja un compte avec ce Nom d\'utilisateur';
                        }
                        if($reqEm == 1)
                        {
                            $Alert3 = 'Il existe deja un compte avec cet Email';
                        }
                    }


                    
                }
                else
                {
                    echo"<script>alert('Veuillez remplir tous les champs!')</script>";
                }
            
        }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/Inscription.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>
   
    <form method="post">
        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group">
                <label for="ID">ID:</label>
                <input type="Text" class="form-control" name="ID" id="ID" placeholder="Num CNI" onblur="verifPseudo(this)">
            </div>
            <div class="col-md-4 form-group">
                <label for="Nom">Nom:</label>
                <input type="Text" class="form-control" name="Nom" id="Nom" placeholder="Nom" onblur="verifPseudo(this)">
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php
            if(isset($Alert1))
            {?>
                <div class="a">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 form-group">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $Alert1; ?>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        
                    </div>
                    <div class="col-md-2"></div>
                </div><?php
            }?>
            

        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group">
                <label for="Prenom">Prenom:</label>
                <input type="Text" class="form-control" name="Prenom" id="Prenom" placeholder="Prenom" onblur="verifPseudo(this)">
            </div>
            <div class="col-md-4 form-group">
                <label for="DN">Date De Naissance:</label>
                <input type="Date" class="form-control" name="DN" id="DN" onblur="verifPseudo(this)">
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group">
                <label for="Username">Nom d'utilisateur:</label>
                <input type="Text" class="form-control" name="Username" id="Username" placeholder="Nom d'utilisateur" onblur="verifPseudo(this)">
            </div>
            <div class="col-md-4 form-group">
                <label for="Mdp">Mot de passe</label>
                <input type="password" class="form-control" name="Mdp" id="Mdp" placeholder="************" onblur="verifPseudo(this)">
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php
            if(isset($Alert2))
            {?>
                <div class="a">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 form-group">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $Alert2; ?>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        
                    </div>
                    <div class="col-md-2"></div>
                </div><?php
            }?>

        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group">
                <label for="CMdp">Confirmez votre Mot de passe</label>
                <input type="password" class="form-control" name="CMdp" id="CMdp" placeholder="************" onblur="verifMdp()">
            </div>
            <div class="col-md-4 form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="col-md-2"></div>
        </div>

        <?php
            if(isset($Alert3))
            {?>
                <div class="a">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 form-group">
                        
                    </div>
                    <div class="col-md-4 form-group">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $Alert3; ?>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div><?php
            }  ?>

        <div class="a">
            <div class="col-md-2"></div>
            <div class="col-md-4 form-group" id="diverr">
                
            </div>
            <div class="col-md-4 form-group">
                <button type="submit" class="btn btn-primary" id="btn" name="valider">Valider</button>
                <button type="reset" class="btn btn-secondary" id="btn" onclick="defaultcolor()">Effacer</button>
            </div>
            <div class="col-md-2"></div>
        </div>
       
    </form>


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
            }

        
            
           
            
            function verifMdp()
                {
               var mdp = document.getElementById("Mdp").value;
               var mdp2 = document.getElementById("CMdp").value;

                if(mdp != mdp2)
                    {
                        document.getElementById("Mdp").style.borderColor= "red";
                        document.getElementById("CMdp").style.borderColor="red";
                        document.getElementById('diverr').innerHTML = '<p style="color: red">Les mots de passe ne correspondent pas. </p> ';
                                                                                  
                                                                               
                    }
                else if (mdp.length == 0 && mdp2.length == 0 )
                    {
                        document.getElementById("Mdp").style.borderColor= "red";
                        document.getElementById("CMdp").style.borderColor="red";
                        
                    }
                    
                else
                
                {
                        document.getElementById("Mdp").style.borderColor= "#2fef59";
                        document.getElementById("CMdp").style.borderColor="#2fef59";
                        document.getElementById('diverr').innerHTML ="";
                    }
                }
</script>  
   

</body>
</html>