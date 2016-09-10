function ajoutChamp()
{
	var ajoute = document.getElementById('ajoute');
	var comboAjout = document.getElementById('ComboAjout');
	var clone = comboAjout.cloneNode(true);
	ajoute.appendChild(clone);
}

function suppChamp()
{

}


function envoiAjax()
{
	var nbGroup = document.getElementById('nbPerGroup').value;
	var tableNom = document.getElementsByClassName("nom");
	var tableScore = document.getElementsByClassName("score");
	
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
        	//console.log(this.responseText);
        	//var html = this.responseText;
            var json_reponse = JSON.parse(this.responseText);
           // console.log(json_reponse);
            var html = "";
            for(i = 0; i < json_reponse.length; i++)
            {
                var numGroupe = i+1;
                html +=  "<div class='panel panel-info'>"+
                        "<div class='panel-heading'>"+
                        "<h4 class='panel-title'> Groupe : "+numGroupe+" Valeur du Groupe : "+json_reponse[i].rank+"</h4>"+
                        "</div>"+
                        "<ul class='list-group'>";

                for(y = 0; y < json_reponse[i].personnes.length; y++)
                {
    				html+= "<li class='list-group-item'>"+json_reponse[i].personnes[y].name+"</li>";
                }
    					 	
    			html +=	"</ul>"+
                        "</div>";
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

    str += "groupe="+nbGroup;

    //console.log(str);

    xhttp.open("POST", "traitement.php",true);
    xhttp.setRequestHeader("content-Type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("X-Requested-With","XMLHttpRequest");
    xhttp.send(str);

}