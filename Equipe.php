<?php

Class Equipe{

	Public $pos; //position
	Public $size; //taille de l'equipe
	Public $personnes = array(); //array de personnes
	Public $rank; //somme des rank des personnes

	function __construct($pos, $size)
	{
		$this->pos= $pos;
		$this->size = $size;
		$this->rank = 0;
	}


    function getPos() {
        return $this->pos;
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

    function setPos($pos) {
        $this->pos = $pos;
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