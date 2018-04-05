<?php
include('../frame/launcher.php');
include('../frame/header.php');

$listeVariable = array();
$listeService = Requete::getResult('listeService', $listeVariable);
?>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Gestion des services</h1>
        </div>
    </section>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th class="text-center">Service</th>
                    <th class="text-center">Atelier</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($listeService as $key => $value){
                    $listeVariable = array($value["id"]);
                    $listeAtelier = Requete::getResult('listeAtelierForService', $listeVariable); ?>
                    <tr>
                        <td class="text-center"><?php echo $value["nom"] ?></td>
                        <td>
                            <ul class="list-group">
                                <?php
                                $last_key = array_keys($listeAtelier)[count(array_keys($listeAtelier))-1]; //$last_key renvoie la dernière clé du tableau

                                foreach ($listeAtelier as $key2 => $value2){
                                    echo '<li class="list-group-item">'.$value2['nom'].'</li>';
                                }
                                ?>
                            </ul>
                        </td>
                        <td>
                            <ul class="list-group">
                                <form method="post" action="objService.php"><li class="list-group-item"><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><button class="btn btn-block btn-primary btn-success"><span class="glyphicon glyphicon-plus"></span> Objectif</button></li></form>
                                <form method="post" action="createAtelier.php"><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><li class="list-group-item"><button class="btn btn-block btn-primary btn-success"><span class="glyphicon glyphicon-plus"></span> Atelier</button></li></form>
                                <form method="post" action="../traitement/delService.php"><input type="hidden" name="nom" value="<?php echo $value["adresse"] ?>"/><input type="hidden" name="id" value="<?php echo $value["id"] ?>"/><input type="hidden" name="action" value="del"/><li class="list-group-item"><button class="btn btn-block btn-primary btn-danger" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette entrée?'));"><span class="glyphicon glyphicon-minus-sign"></span> Supprimer</button></li></form>
                            </ul>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="row">
        <a href="createService.php" class="btn btn-lg btn-success col-md-offset-4 col-md-4 col-xs-offset-1 col-xs-10"><i class="fa fa-pencil"></i> Créer un nouveau service</a>
    </section>


<?php
include('../frame/footer.php');
?>