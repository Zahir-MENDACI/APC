<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/EnTete.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">  
    <title>Document</title>
</head>

<body>
        <div id="Header">
            <div class="row">
                <div class="col-md-3">
                    <img src="./images/Logo.png" id="img">
                </div>
                <div class="col-md-6"  id="Texte">
                    <h4>République Algérienne Démocratique et Populaire</h4><br/>
                    <h4>Wilaya de Tizi Ouzou</h4>

                </div>
                <div class="col-md-3">
                    <img src="./images/images.jpg">
                </div>
            </div>
        </div>
        <div class="navig">
            <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" id="a" href="Acceuil.php"><h5>Acceuil</h5></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a" href="Extrait_De_Naissance.php"><h5>Demande</h5></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a" href="Inscription.php"><h5>Inscription</h5> </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="a" href="Contact.php"><h5>Contact</h5> </a>
                    </li>
                    <li class="nav-item" >
                        
                        <?php
                            if (isset($_SESSION['Login_User']))
                            {?>
                                <div id="c"><?php
                                echo $_SESSION['Login_User'];?> (<a id="dec" href="logout.php">Deconnexion</a>) </div><?php  
                                
                            }
                            elseif (isset($_SESSION['Login_Admin']))
                            {?>
                                <div id="c"><?php
                                echo $_SESSION['Login_Admin'];?> (<a id="dec" href="logout.php">Deconnexion</a>) </div> <?php

                            } 
                        ?>
                    </li>
                </ul>
                </div>
            </nav>
        </div>

</body>
</html>