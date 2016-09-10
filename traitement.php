<?php

include('Personne.php');
include('Equipe.php');


set_time_limit (10); //le temps d'execution de la page en secondes

$sizeTeam = 3; //Taille de chaque groupe
$offset = 1;

$arrayRank = array();

$arrayName = array();

if (isset($_POST)) 
{

	$arrayName = array();
	$arrayRank = array();

	foreach ($_POST as $key => $value) 
	{
		if ($key == "nom") 
		{
			foreach ($value as $num => $nom) 
			{
				array_push($arrayName, $nom);
			}
		}
		elseif($key == "score")
		{
			foreach ($value as $num => $score) 
			{
				array_push($arrayRank, $score);
			}
		}
		else
		{
			$sizeTeam = $value;
		}
	}
}


if(sizeof($arrayName) == sizeof($arrayRank) && $sizeTeam >= 2) //si les 2 ont la même taille et que la taille des groupes est >= a 2
{
	$sizePersonne = sizeof($arrayName);
	$nbTeam = floor($sizePersonne/$sizeTeam); //génère le nombre d'équipes
	$modulo = $sizePersonne % $sizeTeam;
	$arrayRankTemp = $arrayRank; //on copie l'array des scores
	asort($arrayRankTemp);//pour recupèrer les score le plusbas et celui le plus haut
	$rankMax = $arrayRankTemp[sizeof($arrayRankTemp)-1];
	$rankMin = $arrayRankTemp[0];
	

	//création des objets personnes

	$arrayPersonne = array();

	for($i = 0; $i < $sizePersonne; $i++) //crée des objets Equipe
	{
		array_push($arrayPersonne, new Personne($i, $arrayName[$i], $arrayRank[$i]));
	}

	$bongroupe = true ; //condition de la boucle
	$tours = 0; //pour voir le nombre de tours
	do
	{
		//creation des array team

		$arrayTeam = array();

		for($i = 0; $i < $nbTeam; $i++) //crée des objets Equipe
		{
			array_push($arrayTeam, new Equipe($i, $sizeTeam)); //crée une equipe normal
		}

		for($i = 0; $i < $modulo; $i++)// rajoute aux equipes les personnes restantes
		{
			$arrayTeam[$i]->setSize($sizeTeam + 1);
		}

		//On mélange les objets personnes

		shuffle($arrayPersonne);

		//attribution des personnes aux équipes
		$i = 0;
		$totalRank = 0;

		foreach ($arrayTeam as $team) 
		{
			for($y = 0; $y< $team->getSize(); $y++)
			{
				$team->addPersonnes($arrayPersonne[$i]);
				$i++;
			}
			$team->setRank();
			$totalRank += $team->getRankEquipe();
		}



		$moyRank = $totalRank / $nbTeam; //on récupère le score moyen

		$offset = 2;//$moyRank - ($rankMin + $rankMax + $nbTeam); //abs($rankMax + $rankMin - $moyRank + $modulo)+0.1; //calcule la marge pour la validation des groupes

		//verification si les équipes sont bonnes

		$validation = 0;

		foreach ($arrayTeam as $team) 
		{
			if($team->getRankEquipe() <= $moyRank + $offset && $team->getRankEquipe() >= $moyRank - $offset)
			{
				$validation++;
			}
		}

		if($validation == $nbTeam) 
		{
			$bongroupe = false;
		}

		$tours ++;

	}while($bongroupe);

	/*var_dump($tours);
	var_dump($moyRank);
	var_dump($modulo);
	var_dump($offset);
	var_dump($arrayTeam);*/
	$json = json_encode($arrayTeam);
	echo $json;

}
else
{
	echo 'Error : not the same size for arrayName and arrayRank or size of team is wtf !?';
}
