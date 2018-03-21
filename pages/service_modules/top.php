<?php
$OneDay = new DateInterval('P1D');
$addOneDay = (new DateTime($donnee['date']))->add($OneDay);
$lessOneDay = (new DateTime($donnee['date']))->sub($OneDay);
?>

<section class="row">
    <div class="container col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12 text-center">

        <!-- bouton j-1-->
        <form class="form-inline" method="post" action="service.php?id=<?php echo $serviceId; ?>" title="<?php echo $lessOneDay->format('d/m/Y')?>">
            <input type="hidden" name="atelier" value="<?php echo $donnee['atelierId'] ?>"/>
            <input type="hidden" name="date" value="<?php echo $lessOneDay->format('d/m/Y')?>"/>
            <button class="btn btn-lg btn-warning btn-rnd-left"><span class="glyphicon glyphicon-chevron-left"></span></button>
        </form>

        <!-- bouton recherche-->
        <button data-toggle="modal" data-target="#myModal" data-id="test" class="btn btn-warning btn-lg btn-carre">RECHERCHE</button>

        <!-- bouton j+1-->
        <form class="form-inline"   method="post" action="service.php?id=<?php echo $serviceId; ?>" title="<?php echo $addOneDay->format('d/m/Y')?>">
            <input type="hidden" name="atelier" value="<?php echo $donnee['atelierId'] ?>"/>
            <input type="hidden" name="date" value="<?php echo $addOneDay->format('d/m/Y')?>"/>
            <button class="btn btn-lg btn-warning btn-rnd-right"><span class="glyphicon glyphicon-chevron-right"></span></button>
        </form>

        <div class="modal fade" id="infos">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>
    </div>
</section>

<!--La Fenetre de recherche-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="text-center">Recherche</h1>
            </div>
            <div class="modal-body">
                <form  id="searchFrom" class="well" method="post" action="service.php?id=<?php echo $serviceId; ?>" onsubmit="return aform_submit('searchFrom')">

                    <div class="form-group">
                        <label for="texte">Date : </label>
                        <div class="input-group date">
                            <input id="date" name="date" type="text" class="form-control aform_date aform_dateAuto"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select">Atelier : </label>
                        <?php if(!empty($listeAtelier)){?>
                            <select name="atelier" class="form-control">
                                <?php
                                foreach ($listeAtelier as $key => $values) {
                                    if($values == $donnee['atelierName']){
                                        echo "<option value=" . $key . " selected>" . $values . "</option>";
                                    }else{
                                        echo "<option value=" . $key . ">" . $values . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <button id="singlebutton" name="singlebutton" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-ok"></span> Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/js.js"></script>
