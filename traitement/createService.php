<?php
include('../frame/launcher.php');
$_POST['serviceAdr'] = strtolower($_POST['serviceAdr']);

// Verification de base

// On verifie que la service a bien un nom et une adresse
if(empty($_POST['serviceName']) || empty($_POST['serviceAdr'])){
    $_SESSION['alert']['message'] = "Impossible de crée un service sans nom ou adresse";
    $_SESSION['alert']['type'] = "danger";
    header("Location: ../pages/gestionService.php");
    exit();
}

// On verifie qu'il existe des champs sur le service
if($_POST['nbChamps'] == 1){
    $_SESSION['alert']['message'] = "Impossible de crée un service sans champs";
    $_SESSION['alert']['type'] = "danger";

    header("Location: ../pages/gestionService.php");
    exit();
}

// On verifie qu'il n'existe pas de service eponyme
$listeVariable = array();
$result = Requete::getResult('listeService', $listeVariable);
foreach($result as $key => $value){
    if($value['adresse'] == $_POST['serviceAdr']){
        $_SESSION['alert']['message'] = "Il existe déjà un service avec cette adresse (".$value['adresse'].")";
        $_SESSION['alert']['type'] = "danger";

        header("Location: ../pages/gestionService.php");
        exit();
    }
}



//Ajout d'une entré dans le table service
$listeVariable = array($_POST['serviceName'], $_POST['serviceAdr']);
$result = Requete::getResult('createService', $listeVariable);

//Si le service n'a aucun atelier on crée par defaut un atelier du nom de se service
if($_POST['nbAtelier'] == 1 || ($_POST['nbAtelier'] == 2 && empty($_POST['atelierName1']))){
    $_POST['nbAtelier'] = 2;
    $_POST['atelierName1'] = $_POST['serviceAdr'];
}

//On récupère l'adresse du service
$listeVariable = array($_POST['serviceAdr']);
$result = Requete::getResult('idOfService', $listeVariable);
$_POST['id'] = $result[0]['id'];



//Ajouts des entrée dans atelier
for ($i=1; $i<$_POST['nbAtelier']; $i++){
    if(!empty($_POST['atelierName'.$i])){
        $listeVariable = array($_POST['atelierName'.$i], $_POST['id']);
        $result = Requete::getResult('createAtelier', $listeVariable);
    }
}

//Ajouts des libel des champs
for ($i=1; $i<$_POST['nbChamps']; $i++){
    // Si le champs n'est qu'un nombre on rajoute un x_ pour éviter des erreurs sql
    if(preg_match('#^[0-9]*$#', $_POST['chpName'.$i])){
        $_POST['chpName'.$i] = 'x_' . $_POST['chpName'.$i];
    }
    $listeVariable = array($_POST['id'], $_POST['chpName'.$i], $_POST['chpLibel'.$i]);
    $result = Requete::getResult('addLibel', $listeVariable);
}

//Creation Table SQL

$debutReq = 'CREATE TABLE webReporting.'.$_POST['serviceAdr'].' ( `id` INT PRIMARY KEY AUTO_INCREMENT, `idAtelier` INT, `date` DATE, `dateCreation` DATETIME, `dateModification` DATETIME, `idUser` INT, ';
$mileuReq = '';
$finReq = ' FOREIGN KEY(idAtelier) REFERENCES webReporting.atelier(id) ON DELETE SET NULL, FOREIGN KEY(idUser) REFERENCES webReporting.user(id) ON DELETE SET NULL )ENGINE = InnoDB;';

for ($i=1; $i<$_POST['nbChamps']; $i++){
    $mileuReq = $mileuReq . $_POST['chpName'.$i] .' INT, ';
}

$req = $debutReq . $mileuReq . $finReq;
$bdd = PDOFactory::getMysqlConnexion();
$bdd->query($req);

//Création des requète SQL
$service = $_POST['serviceAdr'];
$nbChamps = $_POST['nbChamps'];

$get = 'SELECT '.$_POST['serviceAdr'].'.`id`, `idAtelier`, `date`, `dateCreation`, `dateModification`, `idUser`';
$insert = 'INSERT INTO '.$_POST['serviceAdr'].' (`idAtelier`, `date`, `dateCreation`, `idUser`';
$update = 'UPDATE '.$_POST['serviceAdr'].' SET `dateModification` = ?, `idUser` = ?';
for ($i=1; $i<$_POST['nbChamps']; $i++){
//Get
    $get = $get . ', ' . $_POST['chpName'.$i];
//Insert
    $insert = $insert . ', ' . $_POST['chpName'.$i];

//Update
    $update = $update . ', ' . $_POST['chpName'.$i] .'=? ';
}

$get = $get . ', `nom` AS "atelierName", `pseudo` AS "userName" FROM '.$_POST['serviceAdr'].' LEFT JOIN `atelier` ON `idAtelier` = `atelier`.`id` LEFT JOIN `user` ON `idUser` = `user`.`id` WHERE `idAtelier` = ? AND `date` = ?';
$insert = $insert . ') VALUES(?,?,?,?';
$update = $update . 'WHERE `idAtelier` = ? AND `date` = ?';

for ($i=1; $i<$_POST['nbChamps']; $i++){
//Insert
    $insert = $insert . ',?';
}
$insert = $insert . ');';



$listeVariable = array($service.'Get', $get, 2, 1, 'Error : ' . $service.'Get', $_POST['id']);
$result = Requete::getResult('createReq', $listeVariable);

$nbChamps =$nbChamps + 3;
$listeVariable = array($service.'Insert', $insert, $nbChamps, 0, 'Error : ' . $service.'Insert', $_POST['id']);
$result = Requete::getResult('createReq', $listeVariable);
$nbChamps =$nbChamps - 3;

$nbChamps =$nbChamps + 3;
$listeVariable = array($service.'Update', $update, $nbChamps, 0, 'Error : ' . $service.'Update', $_POST['id']);
$result = Requete::getResult('createReq', $listeVariable);
$nbChamps =$nbChamps - 3;



header("Location: ../pages/gestionService.php");