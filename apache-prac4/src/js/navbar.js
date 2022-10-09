window.addEventListener('resize', onResize);  // зададим обработчик события

function onResize() {  // событие при изменении размера окна / загрузке страницы
	if (window.innerWidth < 800) {
		btn_vis("visible", "hidden");
		box2_vis("none");
	} else {
		btn_vis("hidden", "hidden");
		box2_vis("inline");
	}
}

function openNav() { // нажатие на кнопку [полоски]
	btn_vis("hidden", "visible");
	box2_vis("inline");
}

function closeNav() { // нажатие на кнопку [крестик]
	btn_vis("visible", "hidden");
	box2_vis("none");
}

function btn_vis(vis_o, vis_c) { // показ/скрытие кнопок
	document.getElementById("btno").style.visibility = vis_o;
	document.getElementById("btnc").style.visibility = vis_c;
}

function box2_vis(vis) { // показ/скрытие box2
	document.getElementById("box2_1").style.display = vis;
	document.getElementById("box2_2").style.display = vis;
	document.getElementById("box2_3").style.display = vis;
	document.getElementById("box2_4").style.display = vis;
	document.getElementById("box2_5").style.display = vis;
	document.getElementById("box2_6").style.display = vis;
}