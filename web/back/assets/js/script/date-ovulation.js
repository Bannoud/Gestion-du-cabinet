// @copyright	2010 - LEATI (https://www.leati.com/)
var leMois;
var lAnnee;
var jChoisi, mChoisi, aChoisi;
var tousLesMois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin','Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');

function checkDate(_date) {
reg = new RegExp(/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/);
if(!reg.test(_date))return false;
tabDate = _date.split('/');
dateTest = new Date(tabDate[2], tabDate[1] - 1, tabDate[0]);
if(parseInt(tabDate[0], 10) != parseInt(dateTest.getDate(), 10)
|| parseInt(tabDate[1], 10) != parseInt(dateTest.getMonth(), 10) + parseInt(1, 10)
|| parseInt(tabDate[2], 10) != parseInt(dateTest.getFullYear(), 10) ){
return false;
}
return true;
}

function calculerDate(jEnPlus) {
      var new_date = new Date(aChoisi, mChoisi - 1, jChoisi + jEnPlus);
      var leJourAcc=new_date.getDate();
      leJourAcc=((leJourAcc<10)?'0':'')+leJourAcc; 
      var leMoisAcc=new_date.getMonth()+1;
      leMoisAcc=((leMoisAcc<10)?'0':'')+leMoisAcc;
      var lAnneeAcc=new_date.getYear();
      lAnneeAcc=((lAnneeAcc<200)?1900:0)+lAnneeAcc;  
      return leJourAcc+' '+tousLesMois[leMoisAcc-1]+' '+lAnneeAcc;
}

function affResultat() {
	laDateChoisie = document.getElementById('date').value;
	if (laDateChoisie=='') alert('Veuillez indiquer une date');
	else if (!checkDate(laDateChoisie)) alert('Veuillez indiquer une date au format jj/mm/aaaa');
    else {
		a = laDateChoisie.split('/');
		jChoisi = parseInt(a[0]);
		mChoisi = parseInt(a[1]);
		aChoisi = parseInt(a[2]);
		ajustement = document.getElementById('cycle').value-15;
		/* LES RESULTATS */
		texteResultat='<hr><p>Date de votre prochaine ovulation : '+calculerDate(ajustement)+'</p>';
		texteResultat+='<p>Prochaine p&eacute;riode de fertilit&eacute; sera entre le '+calculerDate(ajustement-2)+' et le '+calculerDate(ajustement+2)+'<p>';
		texteResultat+='<p>Date Pr&eacute;vue d\'Accouchement pour une première grossesse : '+calculerDate(274+ajustement)+'<p>';
		texteResultat+='<p>Date Pr&eacute;vue d\'Accouchement grossesses suivantes : '+calculerDate(269+ajustement)+'<p>';
		document.getElementById('resultat').innerHTML=texteResultat;
	}
}

function ajusteCycle() { if (document.getElementById('date').value!='') affResultat(); }
function buttonCalc() { affResultat(); }

function Share(Button,Type) {
	if (Type==1) var OpenUrl = 'https://www.facebook.com/sharer/sharer.php?u=';
	else var OpenUrl = 'https://twitter.com/intent/tweet?url=';
	window.open(OpenUrl+encodeURIComponent(Button.parentElement.dataset.shareurl), 'WindowShare', 'width=600, height=480, toolbar=0, location=0, directories=0, status=no, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');
}