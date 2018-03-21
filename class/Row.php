<?php
class Row
{
    private $data = array();

    private $methode;
    private $reqName;
    private $nbData;
    private $idAtelier;
    private $currentDate;
    private $date;
    private $idUser;
    private $serviceName;
    private $valide;

    public function __construct($post, $methode)
    {
        $this->methode = $methode;
        $this->nbData = $post['nbChamps'];
        $this->idAtelier = $post['idAtelier'];
        $this->date = $post['date'];
        $this->idUser = $post['idUser'];
        $this->serviceName = $post['serviceName'];
        $this->currentDate = date("Y/m/d H:i:s");

        $this->reqName = strtolower($this->serviceName). ucfirst(strtolower($this->methode));


        $compteur = 0;

        foreach ($post as $key => $value){
            $compteur++;
            if($compteur <= $this->nbData){
                $this->verifData($value);
                if(empty($value)){
                    $this->data[$key] = null;
                }else{
                    $this->data[$key] = $value;
                }
                $this->data[$key];
            }
        }


        $compteur = 0;
        foreach ($this->data as $key => $value){
            if($value > 0){
                $compteur++;
            }
        }

        if($compteur == 0){
            $this->valide = false;
        }else{
            $this->valide = true;
        }
    }

    public function verifData($data){
        $data = htmlspecialchars($data);
        if(!preg_match("#[0-9]+#", $data) && !empty($data)){
            $_SESSION['alert']['message'] = "Erreur !! Une valeur etait incorecte (".$data.")";
            $_SESSION['alert']['type'] = "danger";
            header('Location: ../services/'.$this->serviceName.'.php');
            exit();
        }
        if(empty($data)){
            $data = "null";
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getMethode()
    {
        return $this->methode;
    }

    /**
     * @return string
     */
    public function getReqName()
    {
        return $this->reqName;
    }

    /**
     * @return mixed
     */
    public function getNbData()
    {
        return $this->nbData;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdAtelier()
    {
        return $this->idAtelier;
    }

    /**
     * @return mixed
     */
    public function getCurrentDate()
    {
        return $this->currentDate;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isValide()
    {
        return $this->valide;
    }



}