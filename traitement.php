<?php

include('Personne.php');
include('Equipe.php');


set_time_limit (10); //le temps d'execution de la page en secondes

$sizeTeam = 3; //Taille de chaque groupe
$offset = 1;

$arrayRank = array(  // rank
	0 => 2,//Ibrahim
	1 => 3,//Adrien
	2 => 5,//Nicolas B
	3 => 2,//Nicolas J
	4 => 5,//Mickael
	5 => 4,//Jeremy
	6 => 3,//Iann
	7 => 1,//Kevin
	8 => 2,//Eric
	9 => 1,//Manu
	10 => 5,//Willow
	11 => 2,//Cyril
	12 => 2);//Mario

$arrayName = array(
	0 => 'Ibrahim',
	1 => 'Adrien',
	2 => 'Nicolas B',
	3 => 'Nicolas J',
	4 => 'Mickael',
	5 => 'Jeremy',
	6 => 'Iann',
	7 => 'Kevin',
	8 => 'Eric',
	9 => 'Manu',
	10 => 'Willow',
	11 => 'Cyril',
	12 => 'Mario');

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


if(sizeof($arrayName) == sizeof($arrayRank) && $sizeTeam >= 2) //si les 2 ont la meme taille et que la taille des groupes est >= a 2
{
	$sizePersonne = sizeof($arrayName);
	$nbTeam = floor($sizePersonne/$sizeTeam); //genere le nombre d'equipes
	$modulo = $sizePersonne % $sizeTeam;
	$arrayRankTemp = $arrayRank; //on copie l'array des score
	asort($arrayRankTemp);
	$rankMax = $arrayRankTemp[sizeof($arrayRankTemp)-1];
	$rankMin = $arrayRankTemp[0];
	

	//creation des objets personnes

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

		for($i = 0; $i < $modulo; $i++)// rajoute aux equipes le reste de la division
		{
			$arrayTeam[$i]->setSize($sizeTeam + 1);
		}

		//On melange les objets personnes

		shuffle($arrayPersonne);

		//attribution des personnes aux equipes
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



		$moyRank = $totalRank / $nbTeam; //on recupere le rank moyen

		$offset = 2;//$moyRank - ($rankMin + $rankMax + $nbTeam); //abs($rankMax + $rankMin - $moyRank + $modulo)+0.1; //calcule la marge pour la validation des groupes

		//verification si les equipes sont bonnes

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