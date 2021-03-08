<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/Connexion.css?t=<? echo time(); ?>">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">  
    <title>Document</title>
</head>
<body style="background-color: #d1d1d1;">
  <div class="body">
    <?php include('Entete.php'); ?>

    <form action="Connexion.php" method="post">
      <div class="container" id="form">
            <div class="alert alert-light" role="alert">
                Veuillez valider votre compte
            </div>
        </div>
    </form>


  </div>
</body>
</html>