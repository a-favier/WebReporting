<?php
include('../frame/launcher.php');
include('../frame/header.php');
?>

    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Création d'un service</h1>
        </div>
    </section>

    <section class="row">
        <div class="col-md-offset-3 col-md-3">
            <button onclick="addAtelier()" class="btn btn-block btn-primary btn-success"><span class="glyphicon glyphicon-plus"></span> Atelier</button>
        </div>
        <div class="col-md-3">
            <button onclick="addChamps()" class="btn btn-block btn-primary btn-success"><span class="glyphicon glyphicon-plus"></span> Champs</button>
        </div>
        <div class="col-md-3"></div>
    </section>

    <section class="row well">
        <form class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4" method="post" action="../traitement/createService.php">
            <fieldset>
                <div class="form-group has-feedback">
                    <label class="control-label" for="idError">Nom du service</label>
                    <input type="text" name="serviceName" id="serviceName" class="form-control" required>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Les Atelier</h3>
                    </div>
                    <input type="hidden" name="nbAtelier" id="endOfAtelier" value="1"/>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Les Champs</h3>
                    </div>
                    <input type="hidden" name="nbChamps" id="endOfChamps" value="1"/>
                </div>

                <input type="hidden" name="nbObj" id="endOfChamps" value="1"/>

                <div>
                    <button type="submit" class="btn btn-lg btn-primary col-md-offset-4 col-md-4 col-xs-offset-1 col-xs-10"><i class="fa fa-pencil"></i> Crée</button>
                </div>
            </fieldset
        </form>
    </section>
<?php
include('../frame/footer.php');
?>