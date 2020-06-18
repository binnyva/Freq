<?php
require('./common.php');

$task_id = i($QUERY, 'task_id', 0);
if($task_id) {
	// Update the Done_On field.
	if(i($QUERY, 'action') == 'toggle_status') {
		$sql->update("Event", array('done_on'=>'NOW()', 'status' => '1'), "id=$task_id");
		$QUERY['success'] = 'Marked as done';
	} elseif(i($QUERY, 'action') == 'delete') {
		$sql->remove("Event", "id=$task_id");
		$QUERY['success'] = 'Deleted.';
	}
}

$tasks = $sql->getAll("SELECT E.id,T.id AS task_id, T.name,T.description, E.todo_on, E.done_on 
							FROM Event E INNER JOIN Task T ON E.task_id=T.id WHERE E.status='0'");

iapp('template')->render();
