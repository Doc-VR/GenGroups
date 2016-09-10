# GenGroups
[Site Web php] Génère des groupes homogènes basés sur le score de chaque individu

## Fonctionement
On choisit le nombre d'individus par groupe ( >2 ).
Pour chaque individu on rentre son nom et son score. Le score n'a pas de limite, Il peut etre de 0 a 10 comme de 0 a 100 ou meme de 50 a 500.
Apres avoir appuyé sur Envoyer des groupes homogènes sont affichés sur le coté droit.

![Exemple](img.png)

## Composition du projet
### Classes 
* Equipe
* Personne

### Vue
* index (Affichage de la page unique)

### Traitement
* traitement.php (Reçoit la requette Ajax, la traite et renvoie une reponse)

### Ressourses
* Fichiers Bootstrap
* mycss.css (mon css)
* myjs.js (mon javascript pour faire apparaitre les champs supplementaires et envoyer la requette Ajax)

## Formules utilisé
* nbGroupe = nbPersonne / tailleEquipe
* scoreTaotal = SOMME(score chaque personne)
* scoreMoyen = scoreTotal / nbGroupe
* reste = nbPersonne % tailleEquipe
* Offset = scoreMoyen - (scoreMin + scoreMax + nbGroupe)

## A faire
* Bouton pour supprimer un champ
* Test unitaire
