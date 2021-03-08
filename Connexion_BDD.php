<?php
	// define("serveur","localhost");
	// define("utilisateur","root");
	// define("mot_de_passe",'');
	// define("base","tp_ihm");

	// $bdd=mysqli_connect(serveur,utilisateur,mot_de_passe,base) or die(mysqli_connect_error());


	// $bdd=mmysqli_connect(serveur,utilisateur,mot_de_passe,base) or die(mysqli_connect_error());

	$Host = 'mysql:host=localhost;dbname=pfe;charset=utf8';
	$User = 'root';
	$Mdp = '';

	try
	{
		$bdd = new PDO($Host, $User, $Mdp);
	}

	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
?>