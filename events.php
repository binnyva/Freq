<?php
require('./common.php');

$task_id = i($QUERY, 'task_id', 0);
if($task_id) {
	// Update the Done_On field.
	if(i($QUERY, 'action') == 'toggle_status') {
		iapp('db')->update("Event", array('done_on'=>'NOW()', 'status' => '1'), "id=$task_id");
		$QUERY['success'] = 'Marked as done';
	} elseif(i($QUERY, 'action') == 'delete') {
		iapp('db')->remove("Event", "id=$task_id");
		$QUERY['success'] = 'Deleted.';
	}
}

if(i($QUERY, 'action') == 'Save') {
	$tasks = explode("\n", i($QUERY, 'tasks'));
	$insert_count = 0;
	foreach($tasks as $t) {
		$t = trim($t);
		if(!$t) continue;

		iapp('db')->insert("Event", [
			'task_id'	=> 0,
			'name'		=> $t,
			'todo_on'	=> 'NOW()',
			'type'		=> 'one-time',
			'status'	=> 0
		]);
		$insert_count++;
	}
	if($insert_count) $QUERY['success'] = "Inserted $insert_count task(s)";
}

$tasks = iapp('db')->getAll("SELECT E.id,T.id AS task_id, T.name,T.description, E.todo_on, E.done_on 
							FROM Event E INNER JOIN Task T ON E.task_id=T.id WHERE E.status='0'");
$one_times = iapp('db')->getAll("SELECT id,task_id,name, todo_on, done_on, '' AS description
							FROM Event WHERE status='0' AND type='one-time'");
$tasks = array_merge($tasks, $one_times);



iapp('template')->render();
