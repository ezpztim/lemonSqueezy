function swapInput(tag, type) {
	var el = document.createElement('input');
	el.id = tag.id;
	el.type = type;
	el.name = tag.name;
	el.value = tag.value;
	el.autocomplete = 'off';
	el.placeholder = 'Lozinka'; 
	var elem = document.getElementById('error');
	if ((tag.value == "" || tag.value == null) && elem.offsetParent != null) {
		el.style.borderBottom = '2px solid red';
	}
	tag.parentNode.insertBefore(el, tag);
	tag.parentNode.removeChild(tag);
}
function toggle_password(e,target){

	var tag = document.getElementById(target);
	var tag2 = document.getElementById("showhide");
	if (tag2.checked == true) swapInput(tag, 'text');
	else swapInput(tag, 'password'); 
}
var i = 0, j = 0;
document.getElementById("click").onclick = function() {
	if (i%2 == 0)
		document.getElementsByClassName("checkBoxSlider")[0].style.backgroundColor = "gold";
	else 
		document.getElementsByClassName("checkBoxSlider")[0].style.backgroundColor = "lightgray";
	i++;
}
document.getElementById("click1").onclick = function() {
	if (j%2 == 0)
		document.getElementsByClassName("checkBoxSlider")[1].style.backgroundColor = "gold";
	else 
		document.getElementsByClassName("checkBoxSlider")[1].style.backgroundColor = "lightgray";
	j++;
}
function validate() {
	var x = document.forms["login"]["username"];
	var y = document.forms["login"]["password"];
	var provera = true;
	if (x.value == null || x.value == "") {
		x.style.borderBottom = '2px solid red';
		provera = false;
	}
	if ( y.value == null || y.value == "") {
		y.style.borderBottom = '2px solid red';
		provera = false;
	}
	if (!provera) document.getElementById("error").style.display = 'block';
	return provera;
}