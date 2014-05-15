var ul;
var b = true;
function estrellas(estrellas){
	if(b){
		ul = document.querySelector("#estrellas").innerHTML;
		b=false;
	}   
	var cont=estrellas;
	var id = "#estrella";
	var i = 5;
	while(i>cont){
		var query = id.concat(i);
		var li = document.querySelector(query);
		li.src="img_ori/eg.png";
		i--;
	}
	while(cont>0){
		var query = id.concat(cont);
		var li = document.querySelector(query);
		li.src="img_ori/ed.png";
		cont--;
	}
};
function normal(){
	document.querySelector("#estrellas").innerHTML=ul;
};
function guardar(e){
	ul = document.querySelector("#estrellas").innerHTML;
	document.querySelector("#mipuntuacion").value=e;
}