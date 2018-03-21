<?php
class Requete
{
    public static function getResult($nameReq, $listeVariable)
    {
        $bdd = PDOFactory::getMysqlConnexion();
        if ($bdd != null) {
            $prepared = $bdd->prepare("SELECT `req`.`text`, `req`.`nbVariable`, `req`.`result`, `req`.`error` FROM `webreporting`.`req` WHERE `req`.`name` = ?");
            $prepared->bindValue(1, $nameReq);
            $prepared->execute();
            $result = $prepared->fetchAll()[0];
            $prepared->closeCursor();


            $name = $result['text'];
            $nbVariable = $result['nbVariable'];
            $sortie = $result['result'];
            $error = $result['error'];

            try {
                $bdd->query("SET lc_time_names = 'fr_FR'");
            } catch (PDOException $Exception) {
                $_SESSION['alert']['message'] = "Erreur !!" . $Exception;
                $_SESSION['alert']['type'] = "danger";
            }

            try {
                $bdd->query("SET SQL_SAFE_UPDATES = 0");
            } catch (PDOException $Exception) {
                $_SESSION['alert']['message'] = "Erreur !!" . $Exception;
                $_SESSION['alert']['type'] = "danger";
            }

            try {
                $prepared = $bdd->prepare($name);
                while ($nbVariable > 0) {
                    $nbVariable = $nbVariable - 1;
                    $prepared->bindValue($nbVariable + 1, $listeVariable[$nbVariable]);
                }
                $prepared->execute();

                if ($sortie == 1) {
                    $result = $prepared->fetchAll();
                    $prepared->closeCursor();
                } else {
                    $result = "Effectuer";
                }
            } catch (PDOException $Exception) {
                $_SESSION['alert']['message'] = $error . ":" . $Exception;
                $_SESSION['alert']['type'] = "danger";
            }

            if (!isset($result)) {
                $result = 'No résult';
            }
            return $result;
        }else{
            return "no connection";
        }
    }
}