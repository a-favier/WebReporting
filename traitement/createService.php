<?php
include('../frame/launcher.php');

// Creation du string pour le nom dans la base sql (no characters speciaux + espace + CAMEL CASE)
$_POST['serviceAdr'] = cleanStr($_POST['serviceName']);

// Verification de base

// On verifie que la service a bien un nom et une adresse
if(empty($_POST['serviceName']) || empty($_POST['serviceAdr'])){
    $_SESSION['alert']['message'] = "Impossible de crée un service sans nom";
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



//Ajout d'une entré dans la table service
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
    // Creation du string pour le champs dans la base sql (no characters speciaux + espace + CAMEL CASE)
    $_POST['chpName'.$i] = cleanStr($_POST['chpLibel'.$i]);
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


function cleanStr($string){
    //	Remplace les accents
    $ch0 = array("œ"=>"oe","Œ"=>"OE","æ"=>"ae","Æ"=>"AE","À" => "A","Á" => "A","Â" => "A","Ã" => "A","Ä" => "A","Å" => "A","&#256;" => "A","&#258;" => "A","&#461;" => "A","&#7840;" => "A","&#7842;" => "A","&#7844;" => "A","&#7846;" => "A","&#7848;" => "A","&#7850;" => "A","&#7852;" => "A","&#7854;" => "A","&#7856;" => "A","&#7858;" => "A","&#7860;" => "A","&#7862;" => "A","&#506;" => "A","&#260;" => "A","à" => "a","á" => "a","â" => "a","ã" => "a","ä" => "a","å" => "a","&#257;" => "a","&#259;" => "a","&#462;" => "a","&#7841;" => "a","&#7843;" => "a","&#7845;" => "a","&#7847;" => "a","&#7849;" => "a","&#7851;" => "a","&#7853;" => "a","&#7855;" => "a","&#7857;" => "a","&#7859;" => "a","&#7861;" => "a","&#7863;" => "a","&#507;" => "a","&#261;" => "a","Ç" => "C","&#262;" => "C","&#264;" => "C","&#266;" => "C","&#268;" => "C","ç" => "c","&#263;" => "c","&#265;" => "c","&#267;" => "c","&#269;" => "c","Ð" => "D","&#270;" => "D","&#272;" => "D","&#271;" => "d","&#273;" => "d","È" => "E","É" => "E","Ê" => "E","Ë" => "E","&#274;" => "E","&#276;" => "E","&#278;" => "E","&#280;" => "E","&#282;" => "E","&#7864;" => "E","&#7866;" => "E","&#7868;" => "E","&#7870;" => "E","&#7872;" => "E","&#7874;" => "E","&#7876;" => "E","&#7878;" => "E","è" => "e","é" => "e","ê" => "e","ë" => "e","&#275;" => "e","&#277;" => "e","&#279;" => "e","&#281;" => "e","&#283;" => "e","&#7865;" => "e","&#7867;" => "e","&#7869;" => "e","&#7871;" => "e","&#7873;" => "e","&#7875;" => "e","&#7877;" => "e","&#7879;" => "e","&#284;" => "G","&#286;" => "G","&#288;" => "G","&#290;" => "G","&#285;" => "g","&#287;" => "g","&#289;" => "g","&#291;" => "g","&#292;" => "H","&#294;" => "H","&#293;" => "h","&#295;" => "h","Ì" => "I","Í" => "I","Î" => "I","Ï" => "I","&#296;" => "I","&#298;" => "I","&#300;" => "I","&#302;" => "I","&#304;" => "I","&#463;" => "I","&#7880;" => "I","&#7882;" => "I","&#308;" => "J","&#309;" => "j","&#310;" => "K","&#311;" => "k","&#313;" => "L","&#315;" => "L","&#317;" => "L","&#319;" => "L","&#321;" => "L","&#314;" => "l","&#316;" => "l","&#318;" => "l","&#320;" => "l","&#322;" => "l","Ñ" => "N","&#323;" => "N","&#325;" => "N","&#327;" => "N","ñ" => "n","&#324;" => "n","&#326;" => "n","&#328;" => "n","&#329;" => "n","Ò" => "O","Ó" => "O","Ô" => "O","Õ" => "O","Ö" => "O","Ø" => "O","&#332;" => "O","&#334;" => "O","&#336;" => "O","&#416;" => "O","&#465;" => "O","&#510;" => "O","&#7884;" => "O","&#7886;" => "O","&#7888;" => "O","&#7890;" => "O","&#7892;" => "O","&#7894;" => "O","&#7896;" => "O","&#7898;" => "O","&#7900;" => "O","&#7902;" => "O","&#7904;" => "O","&#7906;" => "O","ò" => "o","ó" => "o","ô" => "o","õ" => "o","ö" => "o","ø" => "o","&#333;" => "o","&#335;" => "o","&#337;" => "o","&#417;" => "o","&#466;" => "o","&#511;" => "o","&#7885;" => "o","&#7887;" => "o","&#7889;" => "o","&#7891;" => "o","&#7893;" => "o","&#7895;" => "o","&#7897;" => "o","&#7899;" => "o","&#7901;" => "o","&#7903;" => "o","&#7905;" => "o","&#7907;" => "o","ð" => "o","&#340;" => "R","&#342;" => "R","&#344;" => "R","&#341;" => "r","&#343;" => "r","&#345;" => "r","&#346;" => "S","&#348;" => "S","&#350;" => "S","Š" => "S","&#347;" => "s","&#349;" => "s","&#351;" => "s","š" => "s","&#354;" => "T","&#356;" => "T","&#358;" => "T","&#355;" => "t","&#357;" => "t","&#359;" => "t","Ù" => "U","Ú" => "U","Û" => "U","Ü" => "U","&#360;" => "U","&#362;" => "U","&#364;" => "U","&#366;" => "U","&#368;" => "U","&#370;" => "U","&#431;" => "U","&#467;" => "U","&#469;" => "U","&#471;" => "U","&#473;" => "U","&#475;" => "U","&#7908;" => "U","&#7910;" => "U","&#7912;" => "U","&#7914;" => "U","&#7916;" => "U","&#7918;" => "U","&#7920;" => "U","ù" => "u","ú" => "u","û" => "u","ü" => "u","&#361;" => "u","&#363;" => "u","&#365;" => "u","&#367;" => "u","&#369;" => "u","&#371;" => "u","&#432;" => "u","&#468;" => "u","&#470;" => "u","&#472;" => "u","&#474;" => "u","&#476;" => "u","&#7909;" => "u","&#7911;" => "u","&#7913;" => "u","&#7915;" => "u","&#7917;" => "u","&#7919;" => "u","&#7921;" => "u","&#372;" => "W","&#7808;" => "W","&#7810;" => "W","&#7812;" => "W","&#373;" => "w","&#7809;" => "w","&#7811;" => "w","&#7813;" => "w","Ý" => "Y","&#374;" => "Y","Ÿ" => "Y","&#7922;" => "Y","&#7928;" => "Y","&#7926;" => "Y","&#7924;" => "Y","ý" => "y","ÿ" => "y","&#375;" => "y","&#7929;" => "y","&#7925;" => "y","&#7927;" => "y","&#7923;" => "y","&#377;" => "Z","&#379;" => "Z","Ž" => "Z","&#378;" => "z","&#380;" => "z","ž" => "z");
    $string = strtr($string,$ch0);

    //	Suprrime les caracètres spéciaux (autres que lettres et chiffres en fait)
    $string = preg_replace('/([^.a-z0-9 ]+)/i', '', $string);

    // Applique le CAMEL CASE
    $string = ucwords($string);

    // Supprime les espace blanc
    $string = str_replace(' ', '', $string);
    return $string;
};