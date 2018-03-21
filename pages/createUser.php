<?php
include('../frame/launcher.php');
include('../frame/header.php');

$listeVariable = array();
$listeService = Requete::getResult('listeService', $listeVariable);

$listeVariable = array();
$listeAtelier = Requete::getResult('listeAtelier', $listeVariable);

if(isset($_POST['id'])){
    $listeVariable = array($_POST['id']);
    $result = Requete::getResult('listeServiceForUser', $listeVariable);
    foreach ($result as $key => $value){
        $listeOwnService[$value['idService']] =  $value['nom'];
    }

    $listeVariable = array($_POST['id']);
    $result = Requete::getResult('listeAtelierForUser', $listeVariable);
    foreach ($result as $key => $value){
        $listeOwnAtelier[$value['idAtelier']] =  $value['nom'];
    }

    $listeVariable = array($_POST['id']);
    $user = Requete::getResult('infoUser', $listeVariable);
}else{
    $listeOwnService = array();
    $listeOwnAtelier = array();
    $user = array();
}
?>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Création d'un utilisateur</h1>
        </div>
    </section>

    <section class="row special_checkbox">
        <form method="post" action="../traitement/users.php" class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
            <?php
            if(isset($_POST['id'])){
                echo '<input type="hidden" name="action" value="modif"/>';
                echo '<input type="hidden" name="id" value="'.$_POST['id'].'"/>';
            }else{
                echo '<input type="hidden" name="action" value="cree"/>';
            }
            ?>
            <div class="form-group has-feedback col-sm-12">
                <label class="control-label" for="idError">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php if(isset($user[0]["pseudo"])){echo $user[0]["pseudo"];}?>">
            </div>

            <div class="form-group has-feedback col-sm-12">
                <label class="control-label" for="idError">Mot de passe</label>
                <input id="mdp" type="text" name="mdp" class="form-control" value="<?php if(isset($user[0]["mdp"])){echo $user[0]["mdp"];}?>">
            </div>

            <!-- Multiple Checkboxes -->
            <div class="form-group col-sm-12 well">
                <label class="col-md-4 control-label" for="">Droit Généraux</label>
                <div class="col-md-4">
                    <div class="checkbox">
                        <?php
                        if(isset($user[0]['admin'])){
                            if($user[0]['admin'] == 1){
                                echo '<p><input type="checkbox" name="admin" id="admin" checked/><label for="admin">Admin</label></p>';
                            }else{
                                echo '<p><input type="checkbox" name="admin" id="admin"/><label for="admin">Admin</label></p>';
                            }
                        }else{
                            echo '<p><input type="checkbox" name="admin" id="admin"/><label for="admin">Admin</label></p>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Multiple Checkboxes -->
            <div class="form-group col-sm-12 well">
                <label class="col-md-4 control-label" for="checkboxes">Accès Service</label>
                <div class="col-md-4">
                    <div class="checkbox">
                        <?php
                        foreach ($listeService as $key => $value){
                            if(isset($listeOwnService[$value['id']])){
                                echo '<p><input type="checkbox" name=service_'.$value['id'].' id=service_'.$value['id'].' checked/><label for=service_'.$value['id'].'>'.$value['nom'].'</label></p>';
                            }else{
                                echo '<p><input type="checkbox" name=service_'.$value['id'].' id=service_'.$value['id'].' /><label for=service_'.$value['id'].'>'.$value['nom'].'</label><br /></p>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Multiple Checkboxes -->
            <div class="form-group col-sm-12 well">
                <label class="col-md-4 control-label" for="checkboxes">Accès Atelier</label>
                <div class="col-md-8">
                    <div class="checkbox">
                        <?php
                        foreach ($listeAtelier as $key => $value){
                            if(isset($listeOwnAtelier[$value['id']])){
                                echo '<p><input type="checkbox" name=atelier_'.$value['id'].' id=atelier_'.$value['id'].' checked/><label for=atelier_'.$value['id'].'>'. $value['serviceName'] .' > '. $value['nom'].'</label></p>';
                            }else{
                                echo '<p><input type="checkbox" name=atelier_'.$value['id'].' id=atelier_'.$value['id'].' /><label for=atelier_'.$value['id'].'>'.$value['serviceName'] .' > '. $value['nom'].'</label></p>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            if(isset($_POST['id'])){
                echo "<button type='submit' class='btn btn-lg btn-primary col-md-offset-4 col-md-4 col-xs-offset-1 col-xs-10'><i class='fa fa-pencil'></i> Modifier</button>";
            }else{
                echo "<button type='submit' class='btn btn-lg btn-primary col-md-offset-4 col-md-4 col-xs-offset-1 col-xs-10'><i class='fa fa-pencil'></i> Crée</button>";
            }
            ?>
            </fieldset>
        </form>
    </section>





<?php
include('../frame/footer.php');
?>