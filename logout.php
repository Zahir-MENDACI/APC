<?php
	// tous d'abord il faut démarrer le système de sessions
	session_start();
	if(isset($_SESSION['Login_Admin']))
	{
		session_destroy();
		header('location:Connexion_Admin.php');
	  }
	elseif(isset($_SESSION['ID_User']))
	{
		session_destroy();
		header('location:Connexion.php');
  	}
	

?>