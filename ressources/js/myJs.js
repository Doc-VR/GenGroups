function ajoutChamp(x) //rajoute un combo nom + score , x = this (le bouton ou on a cliqué)
{
    //on clone le div comboNomScoreBtn et on le met a la fin du div listCombo
	var listCombo = document.getElementById('listCombo');
	var tabComboNomScoreBtn = document.getElementsByClassName('comboNomScoreBtn');
    var comboNomScoreBtn = tabComboNomScoreBtn[tabComboNomScoreBtn.length-1];   //on prend le dernier element 
	var clone = comboNomScoreBtn.cloneNode(true);
    listCombo.appendChild(clone);

    //On change le bouton sur lequel on a cliqué 
    x.setAttribute('onclick', 'suppChamp(this)');
    x.setAttribute('id', 'supprimer');
    x.innerHTML = "<span class='glyphicon glyphicon-minus sup' ></span>";
    //verifChamps(true);
}

function suppChamp(x) //supprime un combo nom + score
{
    x.parentNode.parentNode.innerHTML = ""; // le champ est supprimé mais son conteneur div comboNomScoreBtn ne l'est pas
    //verifChamps(true);
}

function verifChamps(ajoutChamp) //ajoutChamp = true si c'est cette fonction qui l'appele
{
    var countFormErrors = 0;
    var countChampErrors = 0;
    var minElements = true;
    var errors = document.getElementById('errors')//le div dans lequel on place nos erreurs
    var divError = document.createElement("div");// le div a vec le style bootstrap alert que l'on met dans le div errors
    divError.setAttribute("class", "alert alert-danger");

    var formError = "";
    var champError;

    var nbGroup = document.getElementById('nbPerGroup').value;
    var tabNom = document.getElementsByClassName("nom");
    var tabScore = document.getElementsByClassName("score");
    var tabError = document.getElementsByClassName("errorChamp");

    if(tabNom.length < nbGroup) //si le nombre minimum de personnes par groupe n'est pas atteint
    {
        formError = "<span class='glyphicon glyphicon-remove' ></span> Le nombre minimum d'éléments n'est pas atteint<br/>";
        minElements = false;
    }
    
    for (var i = 0; i < tabNom.length; i++) 
    {
        countChampErrors = 0;
        champError = "";
        tabError[i].innerHTML = "";

        if(tabNom[i].value.length <= 2) //on affiche une erreur si le champ est trop long ou si il n'y a rien dedans
        {
            champError += "<span class='glyphicon glyphicon-remove' ></span> Le nom de l'élément n'est pas assez long<br/>";
            countChampErrors++;
        }
        else if(tabNom[i].value.length > 20)
        {
            champError += "<span class='glyphicon glyphicon-remove' ></span> Le nom de l'élément est trop long<br/>";
            countChampErrors++;
        }

        if(isNaN(tabScore[i].valueAsNumber)) //on affiche une erreur si le champ est trop long ou si il n'y a rien dedans
        {
            champError += "<span class='glyphicon glyphicon-remove' ></span> Le score n'est pas un nombre<br/>";
            countChampErrors++;
        }

        for (var y = 0; y < tabNom.length; y++) 
        {
            if(y != i && tabNom[i].value === tabNom[y].value) //si 2 noms sont identiques
            {
                champError += "<span class='glyphicon glyphicon-remove' ></span> Ce nom existe deja<br/>";
                countChampErrors++;
                break;
            }
        }

        if(countChampErrors > 0)
        {
            //on affiche les erreurs pour cette ligne
            divError.innerHTML = champError;
            tabError[i].appendChild(divError.cloneNode(true));
            countFormErrors++;
        }
    }

    errors.innerHTML = "";//on enleve les ancienes erreurs
    
    if (minElements && countFormErrors < 1)
    {
        if(ajoutChamp == false)
        {
            envoiAjax(); // si tout est bon on envoi le formulaire
        }
    }
    else
    {
        if(countFormErrors == 1)//si une erreur
        {
            formError += "<span class='glyphicon glyphicon-remove' ></span> Une erreur dans les champs";
        }
        else if(countFormErrors > 1)//si plusieurs
        {
            formError += "<span class='glyphicon glyphicon-remove' ></span> "+countFormErrors+" erreurs dans les champs";
        }

        divError.innerHTML = formError;
        errors.appendChild(divError); //on affiche les erreurs
    }
}

function envoiAjax()
{
	var nbGroup = document.getElementById('nbPerGroup').value;
	var tableNom = document.getElementsByClassName("nom");
	var tableScore = document.getElementsByClassName("score");
    var isScorePer = document.getElementById('scorePer').checked;
    var isScoreEqu = document.getElementById('scoreEqu').checked;

	
	var tableScoreValue = [];
	var tableNomValue = [];

	var tableLength = tableScore.length;
	for (var i = 0; i < tableLength ; i++)
	{
		tableScoreValue.push(tableScore[i].valueAsNumber);
		tableNomValue.push(tableNom[i].value);
	}


	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            //var html = this.responseText;

            var json_reponse = JSON.parse(this.responseText);

            var html = "";

            html += "<div class='panel panel-success'>"+ //on affiche les paramètres
                        "<div class='panel-heading'>"+
                        "<h4 class='panel-title'>Paramètres</h4>"+
                        "</div>"+
                        "<ul class='list-group'>"+
                        "<li class='list-group-item'>Nombre d'essais avant de trouver la bonne solution : <strong>"+json_reponse[0].tours+"</strong></li>"+
                        "<li class='list-group-item'>Marge d'erreur lors du calcul des groupes : <strong>"+json_reponse[0].offSet+"</strong></li>"+
                        "</ul>"+
                        "</div>";

            if(json_reponse[0].erreurs != "") //si il y a une erreur on l'affiche
            {
                html +=  "<div class='panel panel-danger'>"+
                        "<div class='panel-heading'>"+
                        "<h4 class='panel-title'>Erreur</h4>"+
                        "</div>"+
                        "<ul class='list-group'>"+
                        "<li class='list-group-item'>"+json_reponse[0].erreurs+"</li>"+
                        "</ul>"+
                        "</div>";
            }
            else    //sinon on affiche les groupes
            {
                for(i = 1; i < json_reponse.length; i++)
                {
                    var numGroupe = i;
                    var scoreGroupe = "";
                    var scorePersonne = "";

                    if(isScoreEqu)
                    {
                        scoreGroupe = "Score : <strong>"+json_reponse[i].score+"</strong>";
                    }

                    html +=  "<div class='panel panel-primary'>"+
                            "<div class='panel-heading'>"+
                            "<h4 class='panel-title'> Groupe : "+numGroupe+" Taille : "+json_reponse[i].taille+" "+scoreGroupe+"</h4>"+
                            "</div>"+
                            "<ul class='list-group'>";

                    for(y = 0; y < json_reponse[i].personnes.length; y++)
                    {
                        if(isScorePer)
                        {
                            scorePersonne = json_reponse[i].personnes[y].rank;
                        }

                        html+= "<li class='list-group-item'>"+json_reponse[i].personnes[y].name+" <span class='badge'>"+scorePersonne+"</span></li>";
                    }
                                
                    html += "</ul>"+
                            "</div>";

                }
            }

            document.getElementById("results").innerHTML = html;
        }
    };

    var str = "";

    for (var i = 0; i < tableLength; i++) 
    { 
    	str += "nom["+i+"]="+tableNomValue[i]+"&";	
    }

    for (var i = 0; i < tableLength; i++) 
    { 
    	str += "score["+i+"]="+tableScoreValue[i]+"&";	
    }

    str += "nbGroupe="+nbGroup;


    xhttp.open("POST", "controleur.php",true);
    xhttp.setRequestHeader("content-Type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("X-Requested-With","XMLHttpRequest");
    xhttp.send(str);
}