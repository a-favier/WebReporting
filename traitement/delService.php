<?php
include('../frame/launcher.php');


if($_POST['action'] == 'del')
{
    $listeVariable = array($_POST['id']);
    $result = Requete::getResult('delService', $listeVariable);

    // D'abord on crée un DUMP de la BDD
    PDOFactory::doADump($_POST['nom']);

     // Ensuite un crée une copie de la table qui serat supprimé avec pour format : OLD_NomDeLaTable
    $bdd = PDOFactory::getMysqlConnexion();

    $req = 'CREATE TABLE OLD'.date('dmY').'_' . $_POST['nom'] .' LIKE ' . $_POST['nom'];

    try{
        $bdd->query($req);
    }catch (PDOException $Exception){
        echo(1);
        exit();
        $_SESSION['alert']['message'] = "Service impossible a suprimer";
        $_SESSION['alert']['type'] = "danger";

        header("Location: ../pages/gestionService.php");
    }

    $req = 'INSERT INTO OLD'.date('dmY').'_' . $_POST['nom'] .' SELECT * FROM ' . $_POST['nom'];
    try{
        $bdd->query($req);
    }catch (PDOException $Exception){
        echo(2);
        exit();
        $_SESSION['alert']['message'] = "Service impossible a suprimer";
        $_SESSION['alert']['type'] = "danger";
        header("Location: ../pages/gestionService.php");
    }

    // Enfin on peut supprimer la table
    $req = 'DROP TABLE ' . $_POST['nom'];
    try{
        $bdd->query($req);
    }catch (PDOException $Exception){
        echo(3);
        exit();
        $_SESSION['alert']['message'] = "Service impossible a suprimer";
        $_SESSION['alert']['type'] = "danger";
        header("Location: ../pages/gestionService.php");
    }
    $_SESSION['alert']['message'] = "Service suprimé !";
    $_SESSION['alert']['type'] = "success";
    header("Location: ../pages/gestionService.php");
}else{
    $_SESSION['alert']['message'] = "Service impossible a suprimer";
    $_SESSION['alert']['type'] = "danger";
    header("Location: ../pages/gestionService.php");
}





