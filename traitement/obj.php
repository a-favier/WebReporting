<?php
include('../frame/launcher.php');

if(isset($_POST['idObjDel'])){
    $listeVariable = array($_POST['idObjDel']);
    $result = Requete::getResult('delObj', $listeVariable);
    if(empty($_SESSION['alert'])) {
        $_SESSION['alert']['message'] = "Objectif supprimer";
        $_SESSION['alert']['type'] = "warning";
    }
}else {
    $listeVariable = array($_POST['objName'], $_POST['atelierId'], $_POST['calculObj'], $_POST['objMin'], $_POST['objMax']);
    $result = Requete::getResult('insertObj', $listeVariable);
    if (empty($_SESSION['alert'])){
        $_SESSION['alert']['message'] = "Objectif crée";
        $_SESSION['alert']['type'] = "success";
    }
}


header("Location: ../pages/gestionService.php");