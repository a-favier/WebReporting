<!--Menu-->
<div class="row">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <a class="navbar-brand" href="accueil.php">WebReporting</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a data-toggle="dropdown" href="#">Services<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php
                    if(empty($_SESSION['listeService'])){
                        echo "<li><a>Aucun service</a></li>";
                    }
                    foreach ($_SESSION['listeService'] as $key => $value){
                        echo "<li><a href='service.php?id=" . $value->getId() . "'>" . $value->getNom() . "</a></li>";
                    }
                    ?>
                </ul>
            </li>
            <?php if($_SESSION['admin']){?>
                <li class="dropdown">
                    <a data-toggle="dropdown" href="#">Administration<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestionService.php">Gestion des services</a></li>
                        <li><a href="gestionUser.php">Gestion des utilisateurs</a></li>
                    </ul>
                </li>
            <?php }?>
        </ul>
        <form class="navbar-form navbar-right inline-form">
            <div class="form-group">
                <a href="../traitement/deco.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span> Deconnexion</a>
            </div>
        </form>
    </nav>
</div>

<?php if($_SESSION['alert']['message'] != null){
    if(!isset($_SESSION['alert']['type'])){
        $_SESSION['alert']['type'] == "danger";
    }
    ?>
    <div class="row alert-message">
        <div class="alert alert-<?php echo $_SESSION['alert']['type'] ?> alert-dismissable col-sm-10 col-sm-offset-1">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo strtoupper($_SESSION['alert']['type'])?> : </strong><?php echo $_SESSION['alert']['message'] ?>
        </div>
    </div>

    <?php
    $_SESSION['alert'] = null;
} ?>


