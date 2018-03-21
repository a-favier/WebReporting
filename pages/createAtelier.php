<?php
include('../frame/launcher.php');
include('../frame/header.php');

$listeVariable = array($_POST['id']);
$infoService = Requete::getResult('infoService', $listeVariable);
$listeAtelier = Requete::getResult('listeAtelierForService', $listeVariable);
?>
    <section class="row">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h1 class="text-center">Création d'objectif pour l'atelier "<?php echo ucfirst($infoService[0]['nom'])?>"</h1>
        </div>
    </section>

    <section class="row text-center">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
            <h4>Liste des Atelier</h4>
            <ul class="list-group">
                <?php foreach ($listeAtelier as $key => $value) {
                    echo "<li class='list-group-item'>".$value['nom']."</li>";
                }?>
                <li class="list-group-item">
                    <form method="post" action="../traitement/addAtelier.php">
                        <div class="col-lg-9 col-md-8 col-xs-7">
                            <input id="name" name="name" type="text" placeholder="Nom Atelier" class="form-control">
                            <input type="hidden" name="idService" value="<?php echo $_POST['id']?>"/>
                        </div>
                        <div class="col-lg-3 col-md-4 col-xs-5">
                            <button class="col-xs-2 btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span> Atelier</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </section>


<?php
include('../frame/footer.php');
?>