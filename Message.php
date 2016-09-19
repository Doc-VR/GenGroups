<?php
require_once('ToJson.php');

Class Message implements ToJson{

	private $erreurs;
    private $tours;
    private $offSet;

	function __construct($erreurs, $tours, $offSet)
	{
		$this->erreurs = $erreurs;
        $this->tours = $tours;
        $this->offSet = $offSet;
	} 

    /*
    *   implémenté de ToJson
    */

    function jsonEncode()
    {
        return get_object_vars($this);
    }
}
