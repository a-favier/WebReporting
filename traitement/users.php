<?php
include('../frame/launcher.php');

//supression de l'user
if($_POST['action'] == 'desactivate')
{
    $listeVariable = array($_POST['id']);
    $result = Requete::getResult('desactiverUser', $listeVariable);
    $_SESSION['alert']['type'] = "success";
    $_SESSION['alert']['message'] = "Utilisateur descativé";
}
elseif ($_POST['action'] == 'activate'){
    $listeVariable = array($_POST['id']);
    $result = Requete::getResult('activerUser', $listeVariable);
    $_SESSION['alert']['type'] = "success";
    $_SESSION['alert']['message'] = "Utilisateur activer";
}
else
{
    if(isset($_POST['admin'])){
        $_POST['admin'] = 1;
    }else{
        $_POST['admin'] = 0;
    }

//Modification de l'user
    if($_POST['action'] == 'modif'){
        $listeVariable = array($_POST['pseudo'], $_POST['mdp'], $_POST['admin'], $_POST['id']);
        $result = Requete::getResult('updateUser', $listeVariable);

        $listeVariable = array($_POST['id']);
        $result = Requete::getResult('delAccesServiceUser', $listeVariable);

        $listeVariable = array($_POST['id']);
        $result = Requete::getResult('delAccesAtelierUser', $listeVariable);

        $_SESSION['alert']['type'] = "warning";
        $_SESSION['alert']['message'] = 'Modification effectuée /!\ l\'utilisateur doit se déconnecter pour que les modifs prennent effets';
    }
//Creation de l'user'
    elseif ($_POST['action'] == 'cree'){
        $listeVariable = array($_POST['pseudo'], $_POST['mdp'], $_POST['admin']);
        $result = Requete::getResult('insertUser', $listeVariable);

        $listeVariable = array($_POST['pseudo']);
        $result = Requete::getResult('infoConnexion', $listeVariable);
        $_POST['id'] = $result[0]['id'];

        $_SESSION['alert']['type'] = "success";
        $_SESSION['alert']['message'] = 'Création effectuée';
    }

//Attribution des droits
    foreach ($_POST as $key => $value){
        $decompose = explode("_", $key);
        if($decompose[0] == 'service'){
            $listeVariable = array($_POST['id'], $decompose[1]);
            $result = Requete::getResult('insertAccesServiceUser', $listeVariable);
        }
        elseif($decompose[0] == 'atelier'){
            $listeVariable = array($_POST['id'], $decompose[1]);
            $result = Requete::getResult('insertAccesAtelierUser', $listeVariable);
        }
    }
}


header("Location: ../pages/gestionUser.php");
?>
