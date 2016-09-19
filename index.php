<!DOCTYPE html>
<html lang="en">
<head>
  <title>Création de groupes Aléatoires</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
  <link rel="stylesheet" href="ressources/css/myCss.css">
  <script src="ressources/js/jQuery.js"></script>
  <script src="ressources/js/bootstrap.min.js"></script>
  <script src="ressources/js/myJs.js"></script>
</head>
<body>
	<!-- ensemble  -->
	<div class="container">
	  	<h1 class="text-center">Création de Groupes Aléatoires</h1>
	  	<hr>
	  	<!-- Coté gauche -->
	   	<form class="form-group col-md-6" id="formulaire">
	   		<h3 class="text-center">Formulaire</h3>
	   		<!-- Champ nbPersonnes -->
		  	<div class="form-group col-md-12">
			    <label for="nbPerGroup">Nombre d'Eléments Minimum par Groupe</label>
			    <input class="form-control input-sm" id="nbPerGroup" type="number">
		  	</div>
			<div id="listCombo">
				<div class="comboNomScoreBtn">
					<!-- Champ nom -->
					<div class="form-group col-md-5">
					    <label for="nomInput">Nom</label>
					    <input class="form-control nom input-sm" id="nomInput" type="text" onkeyup="verifChamps(true)" >
				  	</div>
				  	<!-- Champ score -->
				  	<div class="form-group col-md-3">
					    <label for="scoreInput">Score</label>
					    <input class="form-control score input-sm" id="scoreInput" type="number" onchange="verifChamps(true)" >
				  	</div>
				  	<!-- Bouton d'ajout ou de suppression de champs -->
				  	<div class="form-group col-md-4" id="btnAjouter">
				  		<button type='button' class="btn btn-default form-control btn-sm" id="ajouter" onclick="ajoutChamp(this)">
				  			<span class="glyphicon glyphicon-plus add" ></span>
				  		</button>
				  	</div>
				  	<!-- Affiche des erreurs specifique a un champ -->
				  	<div class="form-group col-md-12 errorChamp">
					    
				  	</div>
				</div>
			</div>
			<!-- Affichage des erreurs -->
			<div class="form-group col-md-12" id="errors">
			    
		  	</div>
			<!-- Bouton envoyer -->
			<div class="form-group col-md-12">
			    <div class="checkbox">
			   		<label><input type="checkbox" value="" id="scorePer" >Afficher le score des éléments</label>
			    </div>
			    <div class="checkbox">
			    	<label><input type="checkbox" value="" id="scoreEqu">Afficher le score des groupes</label>
			    </div>
			    <button type="button" class="btn btn-primary" onclick="verifChamps(false)">Envoyer</button>
		  	</div>
		</form>
		<!-- Coté droit -->
		<div class="col-md-6">
			<h3 class="text-center">Résultat</h3>
			<div id="results">
				
			</div>
		</div>
	</div>
</body>
</html>
