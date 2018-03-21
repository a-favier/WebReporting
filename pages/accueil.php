<?php
    include('../frame/launcher.php');
    include('../frame/header.php');
?>

<!--Corps-->
<section class="row">
    <article class="corps col-md-8 col-sm-12">
        <h1>Bienvenue dans WebReporting</h1>
        <img class="img-responsive center-block" src="../img/prudent.jpg">
    </article>
    <div class="col-md-4 col-sm-12">
        <article class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-info"></i> Documentation</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-6 col-md-4 ">
                        <a href="../doc/helpUser.pdf" download="webreporting_docUser.pdf" class="thumbnail">
                            <img class="img-responsive" src="../img/pdf.png" alt="PDF">
                            <label class="caption">Documentation Utilisateur</label>
                        </a>
                    </div>
                    <?php if($_SESSION['admin']){?>
                    <div class="col-xs-6 col-md-4">
                        <a  href="../doc/helpAdmin.pdf" download="webreporting_docAdmin.pdf" class="thumbnail">
                            <img class="img-responsive" src="../img/pdf.png" alt="PDF">
                            <label class="caption">Documentation Administrateur</label>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <a src="../img/logo/pdf.png" alt="PDF" download="webreporting_docDev.pdf" class="thumbnail">
                            <img class="img-responsive" src="../img/pdf.png" alt="PDF">
                            <label class="caption">Documentation Développeur</label>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </article>
        <article class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-question"></i> Aide</h3>
                </div>
                <div class="panel-body">
                    <h2>Info</h2>
                    <p>WebReporting version 2.7.0</p>
                    <p>BDD : vmapp02/webReporting</p>
                    <p>Transports Prudent 2017</p>
                </div>
            </div>
        </article>
    </div>
</section>

<?php
include('../frame/footer.php');
?>

