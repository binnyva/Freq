<?php
require('./common.php');

$task_id = i($QUERY, 'task_id', 0);
$action = i($QUERY, 'action', false);
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

if($action == 'Add Tasks') {
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

if($action == 'Add Intention') {
	$intentions = explode("\n", i($QUERY, 'intention'));
	$insert_count = 0;

	$existing_intentions = iapp('db')->getAll("SELECT id,name FROM Intention WHERE DATE(added_on)=DATE(NOW()) AND priority > 0");
	$priority = count($existing_intentions) + 1;

	foreach($intentions as $line) {
		$line = trim($line);
		if(!$line) continue;

		preg_match('/(\d*)(\W*)(.+)/', $line, $matches);
		$goal_id = $matches[1];
		$intent = $matches[3];
		if(!$goal_id) $goal_id = 0;

		iapp('db')->insert("Intention", [
			'priority'	=> $priority,
			'name'		=> $intent,
			'goal_id'	=> $goal_id,
			'added_on'	=> 'NOW()',
		]);
		$insert_count++;
		$priority++;
	}
	if($insert_count) $QUERY['success'] = "Inserted $insert_count intention(s)";
}

if($action === 'achive_intention') {
	$intention_id = i($QUERY, 'intention_id', 0);
	iapp('db')->update("Intention", ['done_on' => 'NOW()'], "id=$intention_id");
	$QUERY['success'] = 'Marked as done';
}

$tasks = iapp('db')->getAll("SELECT E.id,T.id AS task_id, T.name,T.description, E.todo_on, E.done_on 
							FROM Event E INNER JOIN Task T ON E.task_id=T.id WHERE E.status='0'");
$one_times = iapp('db')->getAll("SELECT id,task_id,name, todo_on, done_on, '' AS description
							FROM Event WHERE status='0' AND type='one-time'");
$goals = iapp('db')->getAll("SELECT id,name FROM Goal");
$tasks = array_merge($tasks, $one_times);

// Think of a day as 5 AM today to almost 5 AM tomorrow.
$from_time = date('Y-m-d 05:00:00');
$to_time = date('Y-m-d 04:59:59', strtotime('tomorrow'));
if(date('Y-m-d H:i:s') < $from_time) { // If time is over 12 midnight and less than 5 AM 
	$from_time = date('Y-m-d 05:00:00', strtotime('yesterday'));
	$to_time = date('Y-m-d 04:59:59');
}

$intentions = iapp('db')->getAll("SELECT id,name,priority,done_on FROM Intention 
									WHERE added_on BETWEEN '$from_time' AND '$to_time' AND priority > 0
									ORDER BY priority ASC");

iapp('template')->render();
