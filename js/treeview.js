function treeviewCollapseAll (sID){
	for (var x = 0; x<document.getElementById('objTree'+sID).getElementsByTagName('UL').length;x++){
		document.getElementById('objTree'+sID).getElementsByTagName('UL')[x].style.display='none';
		document.getElementById('objTreeCollapser'+document.getElementById('objTree'+sID).getElementsByTagName('UL')[x].id.substring(9,document.getElementById('objTree'+sID).getElementsByTagName('UL')[x].id.length)).src = 'img/expander.gif';
	}
}

function treeviewExpandAll (sID){
	for (var x = 0; x<document.getElementById('objTree'+sID).getElementsByTagName('UL').length;x++){
		document.getElementById('objTree'+sID).getElementsByTagName('UL')[x].style.display='block';
		document.getElementById('objTreeCollapser'+document.getElementById('objTree'+sID).getElementsByTagName('UL')[x].id.substring(9,document.getElementById('objTree'+sID).getElementsByTagName('UL')[x].id.length)).src = 'img/collapser.gif';
	}
}
function treeviewExpandCollapse (sID){
	var objUL = document.getElementById('objTreeUL'+sID);
	var objCollapser = document.getElementById('objTreeCollapser'+sID);

	if (objUL.style.display == 'block'){
		objUL.style.display='none';
		objCollapser.src = 'img/expander.gif';
				
	}
	else {
		objUL.style.display='block';
		objCollapser.src = 'img/collapser.gif';
	}
}