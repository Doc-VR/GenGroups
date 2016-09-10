<?php

Class Equipe{

	Public $size; //taille de l'equipe
	Public $personnes = array(); //array de personnes
	Public $rank; //somme des score des personnes

	function __construct($size)
	{
		$this->size = $size;
		$this->rank = 0;
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

    function addPersonnes($personne) {
        array_push($this->personnes, $personne);
    }

    function delPersonnes() {
        $this->personnes = array();
    }

    function getRankEquipe() {
        return $this->rank;
    }

    function setRank() 
    {
    	foreach ($this->personnes as $value) 
    	{
    		$this->rank += $value->getRankPersonne();
    	}
    }
}
