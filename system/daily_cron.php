<?php
require('../common.php');

$tasks = $sql->getAll("SELECT * FROM Task WHERE status='1'");
$existing_event_tasks = $sql->getCol("SELECT task_id FROM Event WHERE status='0'");
$last_ran_on = $sql->getOne("SELECT DATE_FORMAT(ran_on, '%Y-%m-%d') AS ran_on FROM Log ORDER BY ran_on DESC LIMIT 0,1");
if($last_ran_on) $check_date = strtotime($last_ran_on);
else $check_date = strtotime('yesterday');

$run_count = 0;
while($check_date < time()) { // Run for all the days that it was not ran on.
	$insert_count = 0;

	foreach ($tasks as $t) {
		if(in_array($t['id'], $existing_event_tasks)) continue; // Event exists from last run. Don't add again.

		$all_day = explode(",", $t['day']);
		$all_weekday = explode(",", $t['weekday']);
		$all_month = explode(",", $t['month']);

		$match = false;
		foreach ($all_day as $day) {
			if($day == '*' or $day == date('j', $check_date)) {
				$match = true;
			}
		}

		if($match) {
			$match = false;
			foreach ($all_weekday as $weekday) {
				// 0 is sunday, 6 is saturday.
				if($weekday == '*' or $weekday == date('w', $check_date)) {
					$match = true;
				}
			}
		}

		if($match) {
			$match = false;
			foreach ($all_month as $month) {
				if($month == '*' or $month == date('n', $check_date)) {
					$match = true;
				}
			}
		}

		if($match) {
			print "Task : " . $t['name'] . "<br />\n";
			
			$sql->insert("Event", array(
					'task_id' => $t['id'],
					'todo_on' => 'NOW()',
					'status'  => '0',
				));
			$insert_count++;
		}
	}

	$sql->insert("Log", array('ran_on'=>'NOW()','insert_count'=>$insert_count));
	$check_date = strtotime("+1 day", $check_date);
	$run_count++;

	if($run_count > 30) break;
}

print "<br />Done";
