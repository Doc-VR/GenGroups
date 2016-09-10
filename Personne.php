<?php

Class Personne{

	Public $pos; //position dans la liste
	Public $name;
	Public $rank;

	function __construct($pos, $name, $rank)
	{
		$this->pos = $pos;
		$this->name = $name;
		$this->rank = $rank;
	}


	function getPos() {
        return $this->pos;
    }

    function getName() {
        return $this->name;
    }

    function getRankPersonne() {
        return $this->rank;
    }

    function setPos($pos) {
        $this->pos = $pos;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setRank($rank) {
        $this->rank = $rank;
    }
}