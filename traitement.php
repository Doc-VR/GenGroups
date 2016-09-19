<?php
include('Personne.php');
include('Equipe.php');
include('Message.php');

Class Traitement
{
	private $tailleEquipe;
	private $nbPersonne;

	private $arrayNom;
	private $arrayScore;

	private $arrayEquipe;
	private $arrayPersonne;

	private $nbEquipe;
	private $modulo;
	private $offSet;
	private $scoreTotal;
	private $scoreMoy;

	private $tours;
	private $error;

	public function __construct($arrayPost)
	{
		$this->tailleEquipe = 0;
		$this->nbPersonne = 0;

		$this->arrayNom = array();
		$this->arrayScore = array();

		$this->arrayEquipe = array();
		$this->arrayPersonne = array();

		$this->nbEquipe = 0;
		$this->modulo = 0;
		$this->offSet = 3;
		$this->scoreTotal = 0;
		$this->scoreMoy = 0;

		$this->tours = 0;
		$this->erreur = "";

		$this->extract($arrayPost);
		$this->genPersonne();

		do    		//fait la boucle tant que les groupes ne sont pas bons
		{
			$this->tours++;
			$this->genGroupe();
		}
		while($this->verification());
	}

	private function extract($arrayPost) //extrait les données envoyé en POST
	{
		foreach($arrayPost as $key => $value) 
		{
			if ($key == "nom") 
			{
				foreach ($value as $num => $nom) 
				{
					array_push($this->arrayNom, $nom);
				}
			}
			elseif($key == "score")
			{
				foreach ($value as $num => $score) 
				{
					array_push($this->arrayScore, $score);
				}
			}
			else//sinon c'est nbGroupe
			{
				$this->tailleEquipe = $value;
			}
		}

		$this->nbPersonne = sizeof($this->arrayNom);
		$this->nbEquipe = floor($this->nbPersonne / $this->tailleEquipe); //génère le nombre d'équipes
		$this->modulo = $this->nbPersonne % $this->tailleEquipe;

		//recupération du score le plus haut et plus bas pour le calcul de l'offset 

		/*$arrayRankTemp = $arrayRank; //on copie l'array des scores
		asort($arrayRankTemp);//pour recupèrer les score le plusbas et celui le plus haut
		$rankMax = $arrayRankTemp[sizeof($arrayRankTemp)-1];
		$rankMin = $arrayRankTemp[0];*/

		//$this->offSet a calculer ici !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}

	private function genPersonne() //génére les objets personnes
	{
		for($i = 0; $i < $this->nbPersonne; $i++) //crée des objets Personne
		{
			array_push($this->arrayPersonne, new Personne($this->arrayNom[$i], $this->arrayScore[$i]));
			$this->scoreTotal += $this->arrayScore[$i];
		}

		$this->scoreMoy = $this->scoreTotal / $this->nbPersonne;
	}

	private function genGroupe() //génére les groupes
	{
		//creation des array team
		$this->arrayEquipe = array();

		for($i = 0; $i < $this->nbEquipe; $i++) //crée des objets Equipe
		{
			array_push($this->arrayEquipe, new Equipe($this->tailleEquipe)); //crée une equipe normal
		}

		for($i = 0; $i < $this->modulo; $i++)// rajoute aux equipes les personnes restantes
		{
			$this->arrayEquipe[$i]->setSize($this->tailleEquipe + 1);
		}

		//On mélange les objets personnes

		shuffle($this->arrayPersonne);

		//attribution des personnes aux équipes
		$i = 0;

		foreach ($this->arrayEquipe as $team) 
		{
			for($y = 0; $y< $team->getSize(); $y++)
			{
				$team->addPersonnes($this->arrayPersonne[$i]);
				$i++;
			}
			$team->setRank();
		}
	}

	private function verification() //verification si les équipes sont bonnes
	{
		$validation = 0;

		foreach ($this->arrayEquipe as $team) 
		{
			if($team->getRankEquipe() <= $this->scoreMoy + $this->offSet && $team->getRankEquipe() >= $this->scoreMoy - $this->offSet)
			{
				$validation++;
			}
		}

		if($this->tours > 1000) //si le nombre de tours est superieur a 1000 c'est qu'aucune solution n'est possible avec l'offset actuel
		{
			$this->erreur = "Erreur : Calcul impossible l'offset est surement trop bas";
			return false;
		}

		if($validation == $this->nbEquipe) 
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function reponse() //retour le json
	{
		$message = new Message($this->erreur, $this->tours, $this->offSet);

		$dataOfEquipes = array();

		array_push($dataOfEquipes, $message->jsonEncode());

		foreach ($this->arrayEquipe as $key => $value) 
		{
			array_push($dataOfEquipes, $value->jsonEncode());
		}

		$json = json_encode($dataOfEquipes);
		
		return $json;
	}
}
