<?php

Class Personne{

	Public $name;//nom
	Public $rank;//score

	function __construct($name, $rank)
	{
		$this->name = $name;
		$this->rank = $rank;
	}


    function getName() {
        return $this->name;
    }

    function getRankPersonne() {
        return $this->rank;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setRank($rank) {
        $this->rank = $rank;
    }
}
