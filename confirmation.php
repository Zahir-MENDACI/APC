<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=pfe', 'root', '');

if(isset($_GET['ID'], $_GET['Cle']) AND !empty($_GET['ID']) AND !empty($_GET['Cle'])) {
   $ID = htmlspecialchars($_GET['ID']);
   $Cle = htmlspecialchars($_GET['Cle']);
   $requser = $bdd->prepare("SELECT * FROM users WHERE ID = ? AND CleConfirmation = ?");
   $requser->execute(array($ID, $Cle));
   $userexist = $requser->rowCount();
   if($userexist == 1) {
      $user = $requser->fetch();
      if($user['Valide'] == 0) {
         $updateuser = $bdd->prepare("UPDATE users SET Valide = 1 WHERE ID = ? AND CleConfirmation = ?");
         $updateuser->execute(array($ID,$Cle));
         echo "Votre compte a bien été confirmé !";
      } else {
         echo "Votre compte a déjà été confirmé !";
      }
   } else {
      echo "L'utilisateur n'existe pas !";
   }
}
?>