function addTasks(e) {
	e.stopPropagation();
	$("#tasks-area").show();
	$("#tasks").focus();
}

function init() {
	$("#add-tasks").click(addTasks);
}