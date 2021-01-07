
function showForm(name, e) {
	if(e) e.stopPropagation();
	$(`#${name}-area`).show();
	$(`#${name}`).focus();
}
function addTasks(e) {
	showForm("tasks", e);
}
function addIntention(e) {
	showForm("intention", e);
}

function changeTab(e) {
	const tab_link = e.target;
	const open_tab = $(tab_link).attr("id");
	localStorage.setItem('open-tab', open_tab);
}

function showOpenedTab() {
	const open_tab = localStorage.getItem('open-tab');
	if(open_tab) {
		$("#" + open_tab).tab('show');
	}
}

function init() {
	$("#add-tasks").click(addTasks);
	$("#add-intention").click(addIntention);
	$(".nav-link").click(changeTab);

	showOpenedTab();

	const intentions = $(".intention");
	if(!intentions.length) {
		showForm("intention", false)
	}
}