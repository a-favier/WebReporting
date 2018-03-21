<?php
//Création de l'interval de -1jour
$lessOneDay= new DateInterval('P1D');
$calculDate = new DateTime($donnee['date']);
$calculDate= $calculDate->add($lessOneDay);
$lastSixDate = array();

//On crée la requete

$req = 'SELECT ';

$listeVariable = array($serviceName);
$result = Requete::getResult('getNomChamps', $listeVariable);

foreach ($result as $key => $value){
    $req = $req . $value['COLUMN_NAME'] .',';
}

$req =  substr($req, 0, -1);
$req = $req . ' FROM webreporting.'.$serviceName.' WHERE date = ? and idAtelier = ?';
$bdd = PDOFactory::getMysqlConnexion();
$prepared = $bdd->prepare($req);

$jourSemaine = array (1 => "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");

$flag;
//On test 6 fois -1 jour
for ($i=0;$i<7;$i++){
    $flag = true;
    $calculDate = $calculDate->sub($lessOneDay);
    if($calculDate->format('N') != 7) {
        $prepared->bindValue(2, $donnee['atelierId']);
        $prepared->bindValue(1, $calculDate->format('Y-m-d'));
        $prepared->execute();
        $result = $prepared->fetchAll();

        if(empty($result)){
            $flag = false;
        }else{
            foreach ($result[0] as $key => $value){
                if($value == 0){
                    $flag = false;
                }
            }
        }

        $lastSixDate[$jourSemaine[$calculDate->format('N')] . ' ' . $calculDate->format('d/m/Y')] = $flag;
    }
}

//On renverse le tableau pour la chronologie
$lastSixDate = array_reverse($lastSixDate);

//On récupère les objectif du service
$listeVariable = array($donnee['atelierId']);
$result = Requete::getResult('objParAtelier', $listeVariable);

?>


<section class="row">
    <div class="col-md-12">
        <h2 class="text-center">Résultats sur les six jours précédents</h2>
        <p class="text-center">(Les jours en rouge sont les jours sans saisie ou avec une saisie incomplète)</p>
    </div>
    <table class="table table-responsive table-bordered well">
        <thead>
        <tr>
            <th class="text-center">Date</th>
            <?php
            foreach ($result as $key => $value){
                echo '<th>'. $value['nom'] .'</th>';
            }
            ?>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($lastSixDate as $date => $value){
            echo '<tr>';
            if($value){
                echo '<td class="text-center alert-success">'.$date.'</td>';
                foreach ($result as $key => $value){
                    $resultatCalcul = dataDispenser::doCalcul($value['calcul'], explode(" ", $date)[1], $donnee['atelierId'], $serviceName);
                    if($resultatCalcul >= $value['objMin'] && $resultatCalcul <= $value['objMax']) {
                        echo '<td class="text-center alert-success">' . $resultatCalcul . '</td>';
                    }
                    else {
                        echo '<td class="text-center alert-danger">' . $resultatCalcul . '</td>';
                    }
                }
            }else{
                echo '<td class="text-center alert-danger">' .$date.'</td>';
                foreach ($result as $key => $value){
                    echo '<td>Aucune valeur pour ce service</td>';
                }
            }
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</section>