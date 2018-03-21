<?php
include('../frame/launcher.php');
//Les variables global de la page
$serviceId = strtolower($_GET['id']);
$serviceName = dataDispenser::getServiceName($_GET['id']);
if($serviceName != false){
    $listeAtelier = service::listeAtelier($_GET['id']);

//On fixe les valeur pour la recherche /!\ dateType = user
//Si la page vient de insert
    if($_SESSION['service_atelier'] != null && $_SESSION['service_date'] != null){
        $date = dataDispenser::translateDate($_SESSION['service_date']);
        $atelierId = $_SESSION['service_atelier'];

        $_SESSION['service_atelier'] = null;
        $_SESSION['service_date'] = null;
    }//Si la page vient d'un fromulaire de recherche
    elseif(isset($_POST['date']) && isset($_POST['atelier'])){
        $date = $_POST['date'];
        $atelierId = $_POST['atelier'];
    }//Sinon
    else{

        $date = dataDispenser::getDayDateUser();
        $atelierId = current(array_keys($listeAtelier)); // Le premier service trouvé
    }

    $donnee = dataDispenser::recherche($serviceName, $serviceId, $date, $atelierId);


    include('../frame/header.php');

    include('service_modules/top.php');
    include('service_modules/saisie.php');
    include('service_modules/result.php');

    include('../frame/footer.php');
}else{
    $_SESSION['alert']['message'] = "PAGE NOT FOUND";
    $_SESSION['alert']['type'] = "danger";
    header("Location: ../pages/accueil.php");
}
?>
