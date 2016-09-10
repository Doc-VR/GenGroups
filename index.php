<!DOCTYPE html>
<html lang="en">
<head>
  <title>Creation de groupes aleatoire</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
  <link rel="stylesheet" href="ressources/css/myCss.css">
  <script src="ressources/js/jQuery.js"></script>
  <script src="ressources/js/bootstrap.min.js"></script>
  <script src="ressources/js/myJs.js"></script>
</head>
<body>
	<div class="container">
	  	<h1 class="text-center">Création de Groupes Aléatoires</h1>
	  	<hr>
	   	<form class="form-group col-md-6" id="formulaire">
	   		<h3 class="text-center">Formulaire</h3>
		  	<div class="form-group col-md-12">
			    <label for="nbPerGroup">Nombre de Personnes Minimum par Groupe</label>
			    <input class="form-control input-sm" id="nbPerGroup" type="number">
		  	</div>
			<div id="ajoute">
				<div id="ComboAjout">
					<div class="form-group col-md-5">
					    <label for="nomInput">Nom</label>
					    <input class="form-control nom input-sm" id="nomInput" type="text" >
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="scoreInput">Score</label>
					    <input class="form-control score input-sm" id="scoreInput" type="number" >
				  	</div>
				</div>
			</div>
		  	<div class="form-group col-md-4" id="btnAjouter">
		  		<button type='button' class="btn btn-default form-control btn-sm" id="ajouter" onclick="ajoutChamp()">
		  			<span class="glyphicon glyphicon-plus" ></span>
		  		</button>
		  	</div>
			<div class="form-group col-md-12">
			    <button type="button" class="btn btn-primary" onclick="envoiAjax()">Envoyer</button>
		  	</div>
		</form>
		<div class="col-md-6">
			<h3 class="text-center">Résultat</h3>
			<div id="results">
				
			</div>
			
		</div>
	</div>
</body>
</html>