<?php
include('../frame/launcher.php');

$droit = 0;

if (isset($_POST['pseudo']) && isset($_POST['pass'])) {
    $listeVariable = array($_POST['pseudo']);
    $result = Requete::getResult('infoConnexion', $listeVariable);
    if($result === "no connection"){
        header("Location: ../index.html?error=2");
        exit();
    }else{

        if(!empty($result) && $result[0]['actif']){
            if ($result[0]['mdp'] == $_POST['pass']) {
                session_start();

                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['pseudo'] = $result[0]['pseudo'];
                $_SESSION['alert']['message'] = "Bienvenue " . $result[0]['pseudo'];
                $_SESSION['alert']['type'] = "success";
                $_SESSION['valide'] = 'OK';
                $_SESSION['admin'] = $result[0]['admin'];

                $_SESSION['service_result'] = null;
                $_SESSION['service_atelier'] = null;
                $_SESSION['service_date'] = null;



                $listeService = array();

                $listeVariable = array($_SESSION['id'] );
                $result = Requete::getResult('accesService', $listeVariable);

                if(!empty($result)){
                    $droit++;
                    foreach ($result as $key => $value){
                        $listeVariable = array($value['idService']);
                        $result = Requete::getResult('infoService', $listeVariable);

                        foreach ($result as $key => $value){
                            $service = new Service($value['id'], $value['nom'], $value['adresse']);
                            $listeService[$value['id']] = ($service);

                            $currentService = $value['id'];
                            $listeVariable = array($value['id']);
                            $result = Requete::getResult('AtelierInService', $listeVariable);

                            foreach ($result as $key => $value){
                                echo $listeService[$currentService]->addAtelier($value['id'], $value['nom']);
                            }
                        }
                    }
                }

                $listeVariable = array($_SESSION['id']);
                $result = Requete::getResult('accesAtelier', $listeVariable);

                if(!empty($result)){
                    $droit++;
                    foreach ($result as $key => $value){
                        $listeVariable = array($value['idAtelier']);
                        $result = Requete::getResult('ServiceDuAtelier', $listeVariable);


                        if(isset($listeService[$result[0]['id']])){
                            $listeService[$result[0]['id']]->addAtelier($result[0]['idAtelier'], $result[0]['idNom']);
                        }else{
                            $service = new Service($result[0]['id'], $result[0]['nom'],  $result[0]['adresse']);
                            $listeService[$result[0]['id']] = ($service);
                            $listeService[$result[0]['id']]->addAtelier($result[0]['idAtelier'], $result[0]['idNom']);
                        }
                    }

                }

                if($droit == 0){
                    $_SESSION['alert']['message'] = strtoupper($result[0]['pseudo']) . " : Votre compte n'a aucun droit, contactez votre administrateur";
                    $_SESSION['alert']['type'] = "danger";
                }

                $_SESSION['listeService'] = $listeService;

                header("Location: ../pages/accueil.php");
                exit();
            }
        }
    }
}
header("Location: ../index.html?error=1");
