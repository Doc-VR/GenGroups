<?php
require_once('ToJson.php');

Class Equipe implements ToJson{

	Private $size; //taille de l'equipe
	Private $personnes; //array de personnes
	Private $rank; //somme des score des personnes

	function __construct($size)
	{
		$this->size = $size;
        $this->personnes = array();
		$this->rank = 0;
	}

    /*
    *   implémenté de ToJson
    */

    function jsonEncode()
    {
        $dataOfPersonnes = array();
        foreach ($this->personnes as $key => $value) 
        {
            array_push($dataOfPersonnes, $value->jsonEncode());
        }
        $dataOfEquipe = array( "taille" => $this->size, "score" => $this->rank, "personnes" => $dataOfPersonnes);
        //array_push($dataOfEquipe, "personnes" => $dataOfPersonnes);
        return $dataOfEquipe;
    }

    /*
    *   Getters & Setters
    */

    function setRank() 
    {
        foreach ($this->personnes as $value) 
        {
            $this->rank += $value->getRankPersonne();
        }
    }

    function addPersonnes($personne) {
        array_push($this->personnes, $personne);
    }

    function delPersonnes() {
        $this->personnes = array();
    }



    function getPersonnes() {
        return $this->personnes;
    }

    function getSize() {
        return $this->size;
    }

    function setSize($size) {
        $this->size = $size;
    }

    function setPersonnes($personnes) {
        $this->personnes = $personnes;
    }

    function getRankEquipe() {
        return $this->rank;
    }   
}

