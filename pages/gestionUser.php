<?php
include('../frame/launcher.php');
include('../frame/header.php');

$listeVariable = array();
$actif = Requete::getResult('listeUser', $listeVariable);

$inactif = Requete::getResult('listeUserInactif', $listeVariable);

?>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Gestion des services</h1>
        </div>
    </section>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <table class="table table-striped table-condensed">
                <legend>Utilisateurs Activer</legend>
                <thead>
                <tr>
                    <th class="text-center">Pseudo</th>
                    <th class="text-center">Mot de passe</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($actif as $key => $value){?>
                    <tr>
                        <td class="text-center"><?php echo $value["pseudo"] ?></td>
                        <td class="text-center"><?php echo $value["mdp"] ?></td>
                        <td>
                            <ul class="list-group">
                                <form method="post" action="createUser.php"><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><li class="list-group-item"><button class="btn btn-block btn-primary btn-warning"><i class="fa fa-pencil"></i> Modifier</button></li></form>
                                <form method="post" action="../traitement/users.php"><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><input type="hidden" name="action" value="desactivate"/><li class="list-group-item"><button class="btn btn-block btn-primary btn-danger" ><i class="fa fa-pause"></i> Désactiver</button></li></form>
                            </ul>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="row">
        <a href="createUser.php" class="btn btn-lg btn-success col-md-offset-4 col-md-4 col-xs-offset-1 col-xs-10"><i class="fa fa-plus-circle"></i> Crée un nouvel utilisateur</a>
    </section>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <table class="table table-striped table-condensed">
                <legend>Utilisateurs Desactiver</legend>
                <thead>
                <tr>
                    <th class="text-center">Pseudo</th>
                    <th class="text-center">Mot de passe</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($inactif as $key => $value){?>
                    <tr>
                        <td class="text-center"><?php echo $value["pseudo"] ?></td>
                        <td class="text-center"><?php echo $value["mdp"] ?></td>
                        <td>
                            <ul class="list-group">
                                <form method="post" action="createUser.php"><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><li class="list-group-item"><button class="btn btn-block btn-primary btn-warning"><i class="fa fa-pencil"></i> Modifier</button></li></form>
                                <form method="post" action="../traitement/users.php"><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><input type="hidden" name="action" value="activate"/><li class="list-group-item"><button class="btn btn-block btn-primary btn-success"><i class="fa fa-play"></i> Activer</button></li></form>
                            </ul>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </section>


<?php
include('../frame/footer.php');
?>