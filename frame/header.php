<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Reporting</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/logo/favicon.png" />
    <!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="../img/logo/favicon.png" /><![endif]-->
    <!-- Bootstrap Date-Picker Plugin -->
    <link rel="stylesheet" href="../bootstrap/bootstrap-datetimepicker/css/bootstrap-datepicker.css"/>

    <?php
    if(empty($_SESSION) || $_SESSION['valide'] != "OK"){
        header("Location: ../index.php");
    }

    $page = explode('/' , $_SERVER['PHP_SELF']);
    $page = explode('.', $page[count($page)-1])[0];

    if(($page == 'gestionServices' || $page == 'gestionUsers' || $page == 'creationServices' || $page == 'creationUsers') && $_SESSION['admin'] != 1){
        $_SESSION['alert']['message'] = 'Vous avez tentez d\'accéder a une page protéger';
        $_SESSION['alert']['type'] = "danger";
        header("Location: ../pages/accueil.php");

    }elseif($page == 'service'){
        $page =  explode("=", $_SERVER['QUERY_STRING'])[1];
        $acces = false;

        foreach ($_SESSION['listeService'] as $key => $value){
            if($value->getId() == $page){
                $acces = true;
            }
        }
        if(!$acces){
            $_SESSION['alert']['message'] = 'Vous avez tentez d\'accéder a une page protéger';
            $_SESSION['alert']['type'] = "danger";
            header("Location: ../pages/accueil.php");
        }
    }


    ?>

    <!--Intégration des scripts -->
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../bootstrap/bootstrap-datetimepicker/js/bootstrap-datepicker.js"></script>
</head>
<body class="container-fluid">
<?php include('../frame/menu.php') ?>