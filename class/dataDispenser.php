<?php

class dataDispenser
{
    public static function getInfo($name, $service ,$date){
        $listeVariable = array($service, $date);
        $result = requete::getResult($name.'Get', $listeVariable);

        return $result;
    }

    public static function translateDate($date){
        $date = explode('/', $date);
        $date = $date[2] .'/'. $date[1] .'/'. $date[0];
        return $date;
    }

    public static function getAtelierName($id){
        $listeVariable = array($id);
        $result = requete::getResult('getAtelierName', $listeVariable);
        return $result;
    }

    public  static function getServiceName($id){
        $listeVariable = array($id);
        $result = Requete::getResult('infoService', $listeVariable);
        if(isset($result[0]['adresse'])){
            return $result[0]['adresse'];
        }else{
            return false;
        }
    }

    public static function getDayDateOrdi(){
        return date("Y/m/d");
    }

    public static function getDayDateUser(){
        return date("d/m/Y");
    }

    public static function verifUserDate($date){
        if($date == ''){
            $date = self::getDayDateUser();
            $dateVerifier = array($date, true);
            return $dateVerifier;
        }

        $regex = "#[0-9]+#";
        $conformiter = true;

        //On explose la date
        $values = explode("/", $date);

        if($values[count($values)-1] == ""){
            unset($values[count($values)-1]);
        }

        //Verification que l'on ai bien une date entière
        if(count($values) == 3){
            $jour = $values[0];
            $mois = $values[1];
            $an = $values[2];
            //Verification si on a bien que du numerique
            if(preg_match($regex, $jour) || preg_match($regex, $mois) || preg_match($regex, $an)){
                //Verification du jour
                if(strlen($jour) == 1){
                    $jour = '0' . $jour;
                }
                if($jour > 31){
                    $conformiter = false;
                }

                //Verification du mois
                if($mois > 12){
                    $conformiter = false;
                }

                //Verification de l'anné
                if(strlen($an) == 2){
                    $an = '20' . $an;
                } else if(strlen($an) != 4 ){
                    $conformiter = false;
                }
            }else{
                $conformiter = false;
            }
        }else{
            $conformiter = false;
        }
        if($conformiter){
            $date = $jour .'/'. $mois .'/'. $an;
        }else {
            $date = self::getDayDateUser();
        }

        $dateVerifier = array($date, $conformiter);
        return $dateVerifier;
    }

    public static function recherche($serviceName, $serviceId, $date, $atelierId){
        $date = self::verifUserDate($date);
        if(!$date[1]){
            $_SESSION['alert']['message'] = "Date invalide ! Par defaut elle a été remplacée par la date du jour";
            $_SESSION['alert']['type'] = "danger";
        }

        $dateOrdinateur = dataDispenser::translateDate($date[0]);

        $valeur = self::getInfo($serviceName, $atelierId, $dateOrdinateur);

        //On crée l'array donnée
        $donnee = array(
            'full' => '',
            'nbChamps' => '',
            'id' => '',
            'atelierId' => '',
            'atelierName' => '',
            'date' => '',
            'dateCreation' => '',
            'dateModification' => '',
            'userId' => '',
            'userName' => '',
            'data' => array()
        );

        //On récupere les champs de la page
        $listeVariable = array($serviceName);
        $result = Requete::getResult('getNomChamps', $listeVariable);
        foreach ($result as $key => $value){
            $listeVariable = array($serviceId, $value['COLUMN_NAME']);
            $libel = Requete::getResult('getLibelChamps', $listeVariable)[0]['libel'];
            if($libel != ''){
                $champs = new champs($value['COLUMN_NAME'], $libel);
            }else{
                $champs = new champs($value['COLUMN_NAME'], $value['COLUMN_NAME']);
            }

            $donnee['data'][$value['COLUMN_NAME']] = $champs;
        }

        $donnee['nbChamps'] = count($donnee['data']);

        //Si il n'y a aucune donnée
        if(empty($valeur)){
            $donnee['full'] = false;
            $donnee['date'] = $dateOrdinateur;
            $donnee['atelierId'] = $atelierId;
            $donnee['atelierName'] = dataDispenser::getAtelierName($atelierId)[0][0];
        }else{
            $valeur = $valeur[0];
            //On remplit les variable de "base3
            $donnee['full'] = false;
            $donnee['id'] = $valeur['id'];
            $donnee['atelierId'] = $valeur['idAtelier'];
            $donnee['atelierName'] = $valeur['atelierName'];
            $donnee['date'] = str_replace("-", "/",$valeur['date']);
            $donnee['dateCreation'] = str_replace("-", "/", $valeur['dateCreation']);
            $donnee['dateModification'] = str_replace("-", "/", $valeur['dateModification']);
            $donnee['userId'] = $valeur['idUser'];
            $donnee['userName'] = $valeur['userName'];
            foreach ($donnee['data'] as $key => $value){
                $donnee['data'][$key]->setValue($valeur[$key]);
            }


        }
        return $donnee;
    }

    public static function doCalcul($calcul, $date, $atelierId, $serviceName){
        $req = 'SELECT '.$calcul.' FROM '.$serviceName.' WHERE date = ? AND idAtelier = ?';
        $bdd = PDOFactory::getMysqlConnexion();
        $prepared = $bdd->prepare($req);
        $prepared->bindValue(1, self::translateDate($date));
        $prepared->bindValue(2, $atelierId);
        $prepared->execute();
        $result = $prepared->fetchAll();

        return $result[0][0];

    }

}



