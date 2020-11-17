<?php
require './common.php';

if(i($QUERY, 'action') == 'Save') {
	$tasks = explode("\n", i($QUERY, 'tasks'));
	$insert_count = 0;
	foreach($tasks as $t) {
		$t = trim($t);
		if(!$t) continue;

		$sql->insert("Event", [
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

iapp('template')->render();
