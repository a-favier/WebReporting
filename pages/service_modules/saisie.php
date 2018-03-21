<section class="row">
    <div class="col-sm-offset-0 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 well">

        <div class="row">
            <legend class="text-center">Atelier <?php echo ucfirst($donnee['atelierName']) ?> le <?php echo dataDispenser::translateDate($donnee['date']); ?></legend>
        </div>

        <div class="row">
            <table class="table table-bordered table-condensed well">
                <th class="text-center col-sm-4">Date de création : <br/><?php echo $donnee['dateCreation'] ?></th>
                <th class="text-center col-sm-4">Date de modification :<br/><?php echo $donnee['dateModification'] ?></th>
                <th class="text-center col-sm-4">Utilisateur :<br/><?php echo $donnee['userName'] ?></th>
            </table>
        </div>

        <div class="row">
            <form  id="saisieForm" method="post" action="../traitement/insert.php" onsubmit="return aform_submit('saisieForm')">
                <fieldset>
                    <table class="table table-bordered table-striped table-condensed">
                        <?php
                        foreach ($donnee['data'] as $name => $obj){
                            //Affichage
                            echo '<tr>';
                            echo '<td class="text-center col-sm-4">'.$obj->getLibel().'</td>';
                            echo '<td><input id="' . $name . '" type="text" name="' . $name . '" class="form-control input-md aform_number input_center" value="' . $obj->getValue() . '"></td>';
                            echo '<td  class="text-center col-sm-4">'.$obj->getValue().'</td>';
                            echo '<tr>';
                        }
                        ?>
                    </table>


                    <input type="hidden" name="id" value="<?php echo $donnee['id'] ?>"/>
                    <input type="hidden" name="idAtelier" value="<?php echo $donnee['atelierId'] ?>"/>
                    <input type="hidden" name="dateCreation" value="<?php echo $donnee['dateCreation'] ?>"/>
                    <input type="hidden" name="date" value="<?php echo $donnee['date'] ?>"/>
                    <input type="hidden" name="idUser" value="<?php echo $_SESSION['id'] ?>"/>
                    <input type="hidden" name="url" value="<?php echo $serviceId ?>"/>
                    <input type="hidden" name="serviceName" value="<?php echo $serviceName ?>"/>
                    <input type="hidden" name="nbChamps" value="<?php echo $donnee['nbChamps'] ?>"/>
                </fieldset>
                <button class="btn btn-primary btn-default pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
            </form>
        </div>

    </div>
</section>