<?php

include('../frame/launcher.php');



if(empty($_POST['name'])){
    $_SESSION['alert']['message'] = "Impossible de crée un atelier sans nom";
    $_SESSION['alert']['type'] = "danger";

    header("Location: ../pages/gestionService.php");
}else{
    $listeVariable = array($_POST['name'], $_POST['idService']);
    $result = Requete::getResult('createAtelier', $listeVariable);

    $_SESSION['alert']['message'] = "Atelier crée";
    $_SESSION['alert']['type'] = "success";

    header("Location: ../pages/gestionService.php");
}