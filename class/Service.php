<?php
/**
 * Created by PhpStorm.
 * User: al.favier
 * Date: 05/10/2017
 * Time: 11:30
 */

class Service
{
    private $id;
    private $nom;
    private $adresse;

    private $listeAtelier = array();

    public function __construct($id, $nom, $adresse)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function addAtelier($id, $nom){
        $this->listeAtelier[$id] = $nom;
    }

    public function getListeAtelier()
    {
        return $this->listeAtelier;
    }


    public static function listeAtelier($id){
        $listeVariable = array($id);
        $result = requete::getResult('infoServiceAdresse', $listeVariable);

        $listeAtelier = $_SESSION['listeService'][$result[0]['id']]->getListeAtelier();

        return $listeAtelier;
    }


}