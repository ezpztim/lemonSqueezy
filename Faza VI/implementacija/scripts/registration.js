function swapInput(tag, type) {
	var el = document.createElement('input');
	el.id = tag.id;
	el.type = type;
	el.name = tag.name;
	el.value = tag.value;
	el.autocomplete = 'off';
	el.placeholder = 'Lozinka'; 
	var elem = document.getElementById('error');
	if (!(elem.offsetWidth === 0 && elem.offsetHeight === 0)) {
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
function validate() {
	var x = document.getElementById("formEmail");
	var y = document.getElementById("formPassword");
	var z = document.getElementById("formConfpassword");
	var i = document.getElementById("formName");
	var j = document.getElementById("formSurname");
	var provera1 = true;
	var provera = true;
	if (x.value == null || x.value == "") {
		x.style.borderBottom = '2px solid red';
		provera = false;
	}
	else {
		x.style.borderBottom = '2px solid lightgray';
	}
	if ( y.value == null || y.value == "") {
		y.style.borderBottom = '2px solid red';
		provera = false;
	} 
	else {
		y.style.borderBottom = '2px solid lightgray';
	}
	if (z.value == null || z.value =="") {
		z.style.borderBottom = '2px solid red';
		provera = false;
	}
	else {
		z.style.borderBottom = '2px solid lightgray';
	}
	if (i.value == null || i.value == "") {
		i.style.borderBottom = '2px solid red';
		provera = false;
	}
	else {
		i.style.borderBottom = '2px solid lightgray';
	}
	if (j.value == null || j.value == "") {
		j.style.borderBottom = '2px solid red';
		provera = false;
	}
	else {
		j.style.borderBottom = '2px solid lightgray';
	}
	if (y.value.localeCompare(z.value)) {
		y.style.borderBottom = '2px solid red';
		z.style.borderBottom = '2px solid red';
		document.getElementById("error1").style.display = 'block';
		provera1 = false;
	}
	else {
		document.getElementById("error1").style.display = 'none';
		if (provera) {
			y.style.borderBottom = '2px solid lightgray';
			z.style.borderBottom = '2px solid lightgray';
		}
	}
	if (provera == false)document.getElementById("error").style.display = 'block';
	else document.getElementById("error").style.display = 'none';

	return provera && provera1;
}
function remValidation() {
	var x = document.getElementById("formEmail");
	var y = document.getElementById("formPassword");
	var z = document.getElementById("formConfpassword");
	var i = document.getElementById("formName");
	var j = document.getElementById("formSurname");

	document.getElementById("error").style.display = 'none';
	document.getElementById("error1").style.display = 'none';

	x.style.borderBottom = '2px solid lightgray';
	y.style.borderBottom = '2px solid lightgray';
	z.style.borderBottom = '2px solid lightgray';
	i.style.borderBottom = '2px solid lightgray';
	j.style.borderBottom = '2px solid lightgray';
}