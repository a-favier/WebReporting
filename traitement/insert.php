<?php
include('../frame/launcher.php');

if(empty($_POST['id'])){
    $row = new Row($_POST, 'INSERT');
    $_SESSION['alert']['message'] = "Saisie éffectuée";
    $_SESSION['alert']['type'] = "success";
}else{
    $row = new Row($_POST, 'UPDATE');
    $_SESSION['alert']['message'] = "Modification éffectuée";
    $_SESSION['alert']['type'] = "warning";
}


if($row->isValide()){
    if($row->getMethode() == 'INSERT'){
        $listeVariable = array($row->getIdAtelier(), $row->getDate(), $row->getCurrentDate(), $row->getIdUser());
        foreach ($row->getData() as $key => $values){
            array_push($listeVariable, $values);
        }
        $result = Requete::getResult($row->getReqName(), $listeVariable);

    }else{
        $listeVariable = array($row->getCurrentDate(), $row->getIdUser());
        foreach ($row->getData() as $key => $values){
            array_push($listeVariable, $values);
        }
        array_push($listeVariable,  $row->getIdAtelier() ,$row->getDate());
        $result = Requete::getResult($row->getReqName(), $listeVariable);
    }
}else{
    $_SESSION['alert']['message'] = "Vous ne pouvez pas faire de saisie vide";
    $_SESSION['alert']['type'] = "danger";
}

$_SESSION['service_atelier'] = $_POST['idAtelier'];
$_SESSION['service_date'] = $_POST['date'];


header("Location: ../pages/service.php?id=".$_POST['url']);