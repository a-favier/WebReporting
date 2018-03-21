<?php
include('../frame/launcher.php');
include('../frame/header.php');

$listeVariable = array($_POST['id']);
$result = Requete::getResult('listeAtelierForService', $listeVariable);

$serviceNom= $result[0]['nom'];
?>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Liste des objectif du service : Amiotte Clavière</h1>
        </div>
    </section>
    <?php foreach ($result as $key => $atelier){
    $listeVariable = array($atelier['id']);
    $result = Requete::getResult('objParAtelier', $listeVariable);
    ?>
    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <table class="table table-bordered table-striped table-condensed">
                <caption>
                    <div class="col-lg-12">
                        <h4 class="col-lg-6"><?php echo $atelier['nom'] ?></h4>
                        <div class="col-lg-6">
                            <form method="post" action="objCreate.php">
                                <input type="hidden" name="atelierNom" id="atelierNom"
                                       value="<?php echo $atelier['nom'] ?>"/>
                                <input type="hidden" name="atelierId" id="atelierId"
                                       value="<?php echo $atelier['id'] ?>"/>
                                <input type="hidden" name="serviceId" value="<?php echo $_POST['id'] ?>"/>
                                <button class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span>
                                    Objectif
                                </button>
                            </form>
                        </div>
                    </div>
                </caption>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Calcul</th>
                    <th>Obj MIN</th>
                    <th>Obj MAX</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    if (empty($result)) {
                        echo '<tr><td colspan="5">Aucun objectif pour cet atelier</td></tr>';
                    } else {
                        foreach ($result as $key => $obj) {
                            echo '</tr>';
                            echo '<td>' . $obj['nom'] . '</td>';
                            echo '<td>' . $obj['calcul'] . '</td>';
                            echo '<td>' . $obj['objMin'] . '</td>';
                            echo '<td>' . $obj['objMax'] . '</td>';
                            echo '<td><form method="post" action="../traitement/obj.php"><input type="hidden" name="idObjDel" value="' . $obj['id'] . '"/><input class="btn center-block" type="submit" value="Supprimer"/></form></td>';
                            echo '<tr>';
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
    <?php
}
include('../frame/footer.php');
?>