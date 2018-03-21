<?php
/**
 * Created by PhpStorm.
 * User: al.favier
 * Date: 25/10/2017
 * Time: 14:29
 */

class Champs
{
    private $name;
    private $libel;
    private $value;


    public function __construct($name, $libel)
    {
        $this->name = $name;
        $this->libel = $libel;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLibel()
    {
        return $this->libel;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }






}