<?php

include('Traitement.php');

set_time_limit (10); //le temps d'execution de la page en secondes

if(isset($_POST['nom']) && isset($_POST['score']) && isset($_POST['nbGroupe']))
{
	//verification supplémentaire a faire ????
	if(sizeof($_POST['nom']) == sizeof($_POST['score'])) //v&rifie si les 2 arrays on la meme taille 
	{

		$traitement = new Traitement($_POST);
		echo $traitement->reponse();
	}
	//echo "boop";
}
else
{
	echo "erreur dans le controleur";
}
