<?php
include('../frame/launcher.php');
include('../frame/header.php');

$listeVariable = array($_POST['serviceId']);
$result = Requete::getResult('infoService', $listeVariable);

$listeVariable = array($result[0]['adresse']);
$result = Requete::getResult('getNomChamps', $listeVariable);
?>
    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Création d'objectif pour l'atelier "<?php echo $_POST['atelierNom']?>"</h1>
        </div>
    </section>

    <section class="row">
        <form method="post" action="../traitement/obj.php" class="form-horizontal col-sm-offset-0 col-sm-12 col-md-offset-3 col-md-6 well">
            <input type="hidden" name="atelierId" id="atelierId" value="<?php echo $_POST['atelierId']?>"/>
            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Nom</label>
                    <div class="col-md-4">
                        <input id="objName" name="objName" type="text" placeholder="" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textInput">OBJ Minimun</label>
                    <div class="col-md-4">
                        <input id="objMin" name="objMin" type="text" placeholder="" class="form-control input-md">
                        <span class="help-block">Aucun si vide</span>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">OBJ Maximun</label>
                    <div class="col-md-4">
                        <input id="objMax" name="objMax" type="text" placeholder="" class="form-control input-md">
                        <span class="help-block">Aucun si vide</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Calcul</label>
                    <div class="col-md-4">
                        <textarea readonly="readonly" type="text" name="calculObj" id="calculObj" class="form-control"></textarea>
                        <span class="help-block">Crée avec section "CALCUL"</span>
                    </div>
                </div>

                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
                    <button type="submit" class="btn btn-success btn-lg center-block"><span class="glyphicon glyphicon-plus"></span> Valider</button>
                </div>
            </fieldset>
        </form>
    </section>
    <section class="row">
        <table class="table table-bordered table-striped table-condensed table-responsive well">
            <caption class="text-center">Calcul de l'objectif</caption
            <tbody>
            <tr>
                <td>Champs disponibles</td>
                <td>
                    <?php
                    foreach ($result as $key => $value){
                        $champName = $value['COLUMN_NAME'];
                        ?>
                        <button class="btn champs" onclick="addObjChamps('<?php echo $champName?>')"><?php echo $champName ?></button>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>Opérateurs</td>
                <td>
                    <button class="btn operateur" onclick="addObjOperateur('+')">+</button>
                    <button class="btn operateur" onclick="addObjOperateur('-')">-</button>
                    <button class="btn operateur" onclick="addObjOperateur('*')">*</button>
                    <button class="btn operateur" onclick="addObjOperateur('/')">/</button>
                </td>
            </tr>
            <tr>
                <td>Reset</td>
                <td>
                    <button class="btn btn-danger" onclick="resetObj()">Reset</button>
                </td>
            </tr>
            </tbody>
        </table>
    </section>


<?php
include('../frame/footer.php');
?>