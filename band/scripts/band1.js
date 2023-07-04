var linha = 0;
var nTotLinha = 0;
var cssmenuids=["cssmenu1"]; //Enter id(s) of CSS Horizontal UL menus, separated by commas
var csssubmenuoffset=-1; //Offset of submenus from main menu. Default is 0 pixels.

var clientNavigator = "";
var janelaPDF;
if (navigator.appName.indexOf('Microsoft') != -1){
 	clientNavigator = "IE";
 }else{
 	clientNavigator = "Other";
 }


function tot_linhas(nTot){
	nTotLinha = nTot;
}

function cinza(){
	/*for (var i=1;i<=nTotLinha;i++){
		document.getElementById(i).style.background = "#F5F5F5";
	}*/
}

function overLinha(linha){
	document.getElementById(linha).style.background = "#D5EADC";
}

function outLinha(linha){
	document.getElementById(linha).style.background = "#F5F5F5";
}


/*Menus*/
function createcssmenu2(){
	//document.write('<div class="topo-dir"><div class="baixo-esq"><div class="baixo-dir">');
	for (var i=0; i<cssmenuids.length; i++){
		var ultags=document.getElementById(cssmenuids[i]).getElementsByTagName("ul")
    	for (var t=0; t<ultags.length; t++){
			ultags[t].style.top=ultags[t].parentNode.offsetHeight+csssubmenuoffset+"px"
    		var spanref=document.createElement("span")
			spanref.className="arrowdiv"
			spanref.innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;"
			ultags[t].parentNode.getElementsByTagName("a")[0].appendChild(spanref)
    		ultags[t].parentNode.onmouseover=function(){
    			this.getElementsByTagName("ul")[0].style.visibility="visible"
    		}
    		ultags[t].parentNode.onmouseout=function(){
				this.getElementsByTagName("ul")[0].style.visibility="hidden"
    		}
    	}
    //document.write('</div></div></div>');
  	}
}

if (window.addEventListener) window.addEventListener("load", createcssmenu2, false)
else if (window.attachEvent) window.attachEvent("onload", createcssmenu2)

/*Funções de validação de formulários*/
function so_numeros(Event){
	//Esta função só permite a digitação de números
	var erro = "Este campo so permite números."
	if (clientNavigator == "IE"){
 		if (Event.keyCode < 48 || Event.keyCode > 57){
 			window.alert(erro);
 			return false
 		}
 	}else{
 		if ((Event.charCode < 48 || Event.charCode > 57) && Event.keyCode == 0){
 			window.alert(erro);
 			return false
 		}
 	}
 }

 /* limpa form*/
function limpaForm(which){
	var pass=true
    for (i=0;i<which.length;i++){
    	var tempobj=which.elements[i]
        if (tempobj.type=="text"||tempobj.type=="textarea"){
        	tempobj.value = "";
        }
	}
}


 function validaData(campo){
	var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
	var msgErro = 'Formato de data inválido!';
	if ((campo.value.match(expReg)) && (campo.value!='')){
		var dia = campo.value.substring(0,2);
		var mes = campo.value.substring(3,5);
		var ano = campo.value.substring(6,10);

		if((mes==4 || mes==6 || mes==9 || mes==11) && (dia > 30)){
			window.alert("Dia incorreto!!! O mês especificado contém no máximo 30 dias.");
			campo.focus();
			return false;
		} else{
			if(ano%4!=0 && mes==2 && dia>28){
				window.alert("Dia incorreto!!!!!! O mês especificado contém no máximo 28 dias.");
				campo.focus();
				return false;
			} else{
				if(ano%4==0 && mes==2 && dia>29){
					window.alert("Dia incorreto!!!!!! O mês especificado contém no máximo 29 dias.");
					campo.focus();
					return false;
				} else{
					return true;
				}
			}
		}

	}else {
		window.alert(msgErro);
		campo.focus();
		return false;
	}
}

/* Marca/Desmarca todas as opções de um checkbox
   recebe como parâmetros o nome do formulário e true/false como opcao
   true-> marca tudo
   false -> desmarca tudo */
function marcaTudo(formulario,opcao) {
	for (i=0; i < formulario.length; i++) {
		var tempobj = formulario.elements[i];
		if (tempobj.type == "checkbox") {
			tempobj.checked=opcao;
		}
	}
}

// Funções do Ajax
var objLocal;
var tipoLocal;
function ajax(url,obj,tipo){
	objLocal = obj;
	tipoLocal = tipo;
	//if(obj != null) document.getElementById(obj).innerHTML = '<img src="imagens/ajax-loader.gif"> Carregando';
	//window.alert(url);
	//window.alert(objLocal.type);
	//window.alert(tipo);
	req = null;
	// Procura por um objeto nativo (Mozilla/Safari)
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChange;
		req.open("GET",url,true);
		req.send(null);
		// Procura por uma versão ActiveX (IE)
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = processReqChange;
			req.open("GET",url,true);
			req.send();
		}
	}
}

function processReqChange(){
	if (req.readyState == 4) {
		// apenas se o servidor retornar "OK"
                //alert(req.status);
		if (req.status ==200) {
			if(objLocal==null){
				if (!tipoLocal){
					carregaAjax(tipoLocal,req.responseText);
				} else {
					//window.alert(tipoLocal);
					conteudo = req.responseText;
                                        //window.alert(conteudo);
					if (conteudo.indexOf('\n') == 1){
						conteudo = conteudo.slice(2,conteudo.length);
						//window.alert(conteudo);
					};
     				InsertHTML(conteudo);// função do cadastro de materia cadmateriabi.php
				}
			} else {
				//alert(req.responseText);
				document.getElementById(objLocal).innerHTML = req.responseText;
			}
		} else {
			window.alert("Erro de AJAX. \nHouve um problema ao obter os dados: " + req.statusText);
		}
	}
}

function ajaxCadMilitar(url,obj,tipo){
	objLocal = obj;
	tipoLocal = tipo;
	//window.alert(url);
	//window.alert(objLocal.type);
	//window.alert(tipo);
	req = null;
	// Procura por um objeto nativo (Mozilla/Safari)
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChangeCadMil;
		req.open("GET",url,true);
		req.send(null);
		// Procura por uma versão ActiveX (IE)
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = processReqChangeCadMil;
			req.open("GET",url,true);
			req.send();
		}
	}
}

function processReqChangeCadMil(){
	if (req.readyState == 4) {
		if (req.status ==200) {
			//window.alert(req.responseText);
			atualizaTela(req.responseText,tipoLocal);
		} else {
			window.alert("Erro de AJAX. \nHouve um problema ao obter os dados do servidor: " + req.statusText);
		}
	}
}

function ajaxTempoSvJS(url){
	req = null;
	//alert(url);
	// Procura por um objeto nativo (Mozilla/Safari)
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = processTpSv;
		req.open("GET",url,true);
		req.send(null);
		// Procura por uma versão ActiveX (IE)
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = processTpSv;
			req.open("GET",url,true);
			req.send();
		}
	}
}

function processTpSv(){
	if (req.readyState == 4) {
		if (req.status ==200) {
			//window.alert(req.responseText);
			carregaForm(req.responseText);
		} else {
			window.alert("Erro de AJAX. \nHouve um problema ao obter os dados do servidor: " + req.statusText);
		}
	}
}

function ajaxTextoIndividual(url,obj,tipo){
	objLocal = obj;
	tipoLocal = tipo;
	//window.alert(url);
	//window.alert(objLocal.type);
	//window.alert(tipo);
	req = null;
	// Procura por um objeto nativo (Mozilla/Safari)
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChangeTextoIndiv;
		req.open("GET",url,true);
		req.send(null);
		// Procura por uma versão ActiveX (IE)
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = processReqChangeTextoIndiv;
			req.open("GET",url,true);
			req.send();
		}
	}
}

function processReqChangeTextoIndiv(){
	if (req.readyState == 4) {
		if (req.status ==200) {
			//window.alert(req.responseText);
			atualizaTextoIndiv(req.responseText);
		} else {
			window.alert("Erro de AJAX. \nHouve um problema ao obter os dados do servidor: " + req.statusText);
		}
	}
}




//Monta o preview do cad materia BI
function montaPreview(codMateria){
		if (janelaPDF != null){
			janelaPDF.close();
		}
		if (janelaPDF == undefined){
			janelaPDF = window.open("mostra_materia_pdf.php?codMateria="+codMateria,"","height=500,width=900");
		}else if (janelaPDF.closed){
			janelaPDF = window.open("mostra_materia_pdf.php?codMateria="+codMateria,"","height=500,width=900");
		}
	}
	// Preview do cadAssuntoEspecífico
	function montaPreview2(codAssGer,CodAssEsp){
		var url = "mostra_assunto_pdf.php?codAssGer="+codAssGer+"&CodAssEsp="+CodAssEsp;
		if ((janelaPDF == undefined)){
			janelaPDF = window.open(url,"","height=500,width=900");
		}else if (janelaPDF.closed){
			janelaPDF = window.open(url,"","height=500,width=900");
		}
		//janelaPDF.document.write("teste");
		if (janelaPDF != null){
			janelaPDF.close();
			janelaPDF = window.open(url,"","height=500,width=900");
		}
	}

	function viewPDF2(url){

        // parâmetro com valor randômico adicionado a URL da página, 
        // fazendo com que o navegador não leia o cache e busque pelo arquivo PDF mais novo.
        url = url + "?r=" + Math.floor(Math.random()*100);
  
        if ((janelaPDF == undefined)){
            janelaPDF = window.open(url,"","height=500,width=900");
         }

        if (janelaPDF.closed){
            janelaPDF = window.open(url,"","height=500,width=900");
        }

        if (janelaPDF != null){
            janelaPDF.focus();
         }

}

	function viewConfig(url){
		if ((janelaPDF == undefined)){
			janelaPDF = window.open(url,"Gera Banco Sisbol","height=500,width=900,resizable=1,scrollbars=1");
		}
		if (janelaPDF.closed){
			janelaPDF = window.open(url,"Gera Banco Sisbol","height=500,width=900,resizable=1,scrollbars=1");
		}
		if (janelaPDF != null){
			janelaPDF.focus();
		}
	}
	// extract front part of string prior to searchString
	function getFront(mainStr,searchStr){
		foundOffset = mainStr.indexOf(searchStr)
		if (foundOffset == -1) {
			return null
		}
		return mainStr.substring(0,foundOffset)
	}
// extract back end of string after searchString
	function getEnd(mainStr,searchStr) {
	foundOffset = mainStr.indexOf(searchStr)
	if (foundOffset == -1) {
		return null
	}
	return mainStr.substring(foundOffset+searchStr.length,mainStr.length)
	}
// insert insertString immediately before searchString
	function insertString(mainStr,searchStr,insertStr) {
		var front = getFront(mainStr,searchStr)
		var end = getEnd(mainStr,searchStr)
		if (front != null && end != null) {
			return front + insertStr + searchStr + end
		}
		return null
	}
// remove deleteString
	function deleteString(mainStr,deleteStr) {
		return replaceString(mainStr,deleteStr,"")
	}

	function replaceString(mainStr,searchStr,replaceStr) {
		var front = getFront(mainStr,searchStr)
		var end = getEnd(mainStr,searchStr)
		if (front != null && end != null) {
			return front + replaceStr + end
		}
			return null
	}

	function isEnterKey(evt) {
		var key_code = evt.keyCode  ? evt.keyCode  :
                       evt.charCode ? evt.charCode :
                       evt.which    ? evt.which    : void 0;

		if (key_code == 13){
       	return true;
    	}
	}
	function isEscKey(evt) {
				var key_code = evt.keyCode  ? evt.keyCode  :
       	     	evt.charCode ? evt.charCode :
                evt.which    ? evt.which    : void 0;
				if (key_code == 27){
       				return true;
    			}
	}

	function dataInPeriodo(datapesq,dataini,datafim){
		dataPesq = parseInt(datapesq.split("/")[2].toString() + datapesq.split("/")[1].toString() + datapesq.split("/")[0].toString());
		dataIni = parseInt(dataini.split("/")[2].toString() + dataini.split("/")[1].toString() + dataini.split("/")[0].toString());
		dataFim = parseInt(datafim.split("/")[2].toString() + datafim.split("/")[1].toString() + datafim.split("/")[0].toString());
		if (dataPesq < dataIni) return false;
		if (dataPesq > dataFim) return false;
		return true;
	}

	  function html_entity_decode(str){
      try{
	      var tarea=document.createElement('textarea');
    	  tarea.innerHTML = str; return tarea.value;
      	  tarea.parentNode.removeChild(tarea);
      }
      	catch(e)
      {
      	//for IE add <div id="htmlconverter" style="display:none;"></div> to the page
      	document.getElementById("htmlconverter").innerHTML = '<textarea id="innerConverter">' + str + '</textarea>';
      	var content = document.getElementById("innerConverter").value;
      	document.getElementById("htmlconverter").innerHTML = "";
      	return content;
      }
      }


