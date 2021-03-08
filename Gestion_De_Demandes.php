<?php
  include ('Connexion_BDD.php');  
  session_start();

	if(!isset($_SESSION['Login_Admin'])){
		header('location:Connexion_Admin.php');
  }
// $path = $_SERVER['PHP_SELF']; // $path = /home/httpd/html/index.php
// $file = basename ($path);
// echo"$file"; // index.php
      if(isset($_POST['sup']))
      {
        if(isset($_POST['check']))
        {
          foreach($_POST['check'] as $check)
          {
            
            $bdd->query("DELETE FROM demande WHERE NumDemande = $check"); 
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
    <link rel="stylesheet" href="./styles/Gestion_De_Demandes.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">


</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>
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
                    <th scope="col">Numéro</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre d'exemplaire</th>
                    <th scope="col">Date de récupération</th>
                    <th scope="col">Heure de récupération</th> 
                    <th scope="col">PDF</th> 
                  </tr>
                </thead>

            <!-- Importation de la table des demandes -->
                <?php
                  $req=$bdd->query('SELECT * FROM demande ORDER BY NumDemande');
                
                  while($data=$req->fetch())
                  {
                    extract($data);
                    
                    // $req2 = $bdd -> query ("SELECT * FROM citoyens WHERE ID = '$ID'")
                    // $res = $req2 -> fetch();

                    // $req2=$bdd->prepare('SELECT * FROM citoyens WHERE ID = :ID');
                    // $req2->execute(array('ID' => $ID));
                    // $res=$req->fetch();


                ?>
                <tbody>
                  <tr>
                    <th scope="row"><input type="checkbox" value="<?php echo $data['NumDemande'] ?>" name="check[]" id="sup" /></th>
                    <th><?php echo $NumDemande ; ?> </th>
                    <td><?php echo $ID_User; ?></td>
                    <td><?php echo $Nbre; ?></td>
                    <td><?php echo $Date_Recup; ?></td>
                    <td><?php echo $Heure; ?></td>
                    <td><a href="Pdf.php?ID=<?php echo $ID_User ?>">Afficher</a> </td>
                  </tr>
                </tbody>
                <?php } ?> <!-- Fermeture de la boucle While -->
              </table>
            </div>

            <button type="submit" class="btn btn-info btn-lg" id="btn" name="sup" onclick="return confirm('voulez vous supprimer') ">Supprimer</button>
          </form>

          

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