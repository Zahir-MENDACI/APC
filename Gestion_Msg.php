<?php
  include ('Connexion_BDD.php');  
  session_start();

    if(!isset($_SESSION['Login_Admin']))
    {
        header('location:Connexion_Admin.php');
    }

    if (isset($_GET['Section']))
    {
        $req=$bdd->query('SELECT * FROM messages WHERE NumMsg = ' .$_GET['Num']);
                
                  while($data=$req->fetch())
                  {
                    extract($data);
                    
                }
    }

    if (isset($_POST['envoyer']))
    {
        $header="MIME-Version: 1.0\r\n";
        $header.='From:"APC.com"<support@apc.com>'."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';
        $message='
        <html>
            <body>
            <div align="center">
                    <p> ' .$_POST['Msg']. '</p>
            </div>
            </body>
        </html>
        ';
        mail($Email, "ne-pas-repondre", $message, $header);
    }

      if(isset($_POST['sup']))
      {
        if(isset($_POST['check']))
        {
          foreach($_POST['check'] as $check)
          {
            
            $bdd->query("DELETE FROM demande WHERE ID_User = $check"); 
          }
          header('Location:Gestion_De_Demandes.php');
        }
      }

                  


                
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/Gestion_Msg.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">


</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); 

    if (isset($_GET['Section']))
    {
        $req=$bdd->query('SELECT * FROM messages WHERE NumMsg = ' .$_GET['Num']);
                
                  while($data=$req->fetch())
                  {
                    extract($data);

        ?>
    
        <form method="post">
            <div class="formmsg">
                <div class="a">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <label for="Msg">Message de: <b><?php echo $Email ?></b></label>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="msgr">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <p><?php echo $Msg ?></p>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            

                <div class="a">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <label for="Msg">Reponse:</label>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="msg">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                        <textarea name="Msg" id="Msg" cols="65" rows="10"></textarea>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="a">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 form-group">
                    <button type="submit" class="btn btn-primary" name="envoyer" id="btn">Envoyer</button>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </form>
        <?php
    }}

    else
    { ?>


        <div id="aa">
        <div class="row">
            <div class="col-md-2">
            <nav class="nav flex-column" id="navs">
                <a class="nav-link" href="Gestion_De_Demandes.php">Gestion de demandes</a>
                <a class="nav-link" href="Gestion_Msg.php">Messagerie</a>
            </nav>
            </div>
            <div class="col-md-9">
            <form method="post">
                <div class="form">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><input type="checkbox"  onclick="Cocher(this.checked);"></th>
                        <th scope="col">Num</th>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Msg</th>
                        <th scope="col">Date</th>
                        <th scope="col"></th> 
                    </tr>
                    </thead>

                <!-- Importation de la table des demandes -->
                <?php
                $req=$bdd->query('SELECT * FROM messages ORDER BY Dat');
                
                while($data=$req->fetch())
                {
                  extract($data); ?>
                    <tbody>
                    <tr>
                        <th scope="row"><input type="checkbox" value="<?php echo $data['NumMsg'] ?>" name="check[]" id="sup" /></th>
                        <th><?php echo $NumMsg ; ?> </th>
                        <td><?php echo $ID_Exp; ?></td>
                        <td><?php echo $Email; ?></td>
                        <td><?php 
                            if (strlen($Msg) > 15)
                            {
                                echo substr($Msg, 0, 15) ."..." ; 
                            }
                            else
                            {
                                echo $Msg;
                            }?>
                        </td>
                        <td><?php echo $Dat; ?></td>
                        <td><a href="Gestion_Msg.php?Section=Aff&Num=<?php echo $NumMsg ?>">Afficher</a> </td>
                    </tr>
                    </tbody>
                    <?php } ?> <!-- Fermeture de la boucle While -->
                </table>
                </div>

                <!-- <button type="submit" class="btn btn-info btn-lg" id="btn" name="sup" onclick="return confirm('voulez vous supprimer') ">Supprimer</button> -->
            </form>
            <?php
    }?>
            

            </div>
        </div>
        </div>
    <!-- Suppression de demandes -->
    

    <!-- Fonction pour tous cocher/decocher -->
    <script >
      function Cocher(Etat_Case)
      {
        var cases = document.getElementsByTagName('input');   // on recupere tous les INPUT
        for(var i=1; i<cases.length; i++)    // on les parcourt
          if(cases[i].type == 'checkbox')    // voir si l'input est une checkbox
            cases[i].checked = Etat_Case;    // On coche/decoche           
      }
    </script>

  </div>
</body>
</html>