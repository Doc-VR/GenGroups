<?php
require_once('ToJson.php');

Class Personne implements ToJson{

	Private $name;//nom
	Private $rank;//score

	function __construct($name, $rank)
	{
		$this->name = $name;
		$this->rank = $rank;
	} 

    /*
    *   implémenté de ToJson
    */

    function jsonEncode()
    {
        return get_object_vars($this);
    }

    /*
    *   Getters & Setters
    */

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getRankPersonne() {
        return $this->rank;
    }

    function setRank($rank) {
        $this->rank = $rank;
    }
}
