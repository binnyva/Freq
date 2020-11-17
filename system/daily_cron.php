<?php
require('../common.php');

/* Logic:
 * Create new event only if there is no existing undone event of the same task.
 * 
 */

 // Consider using this to parse: https://github.com/dragonmantank/cron-expression

$tasks = iapp('db')->getById("SELECT * FROM Task WHERE status='1'");
// dump($tasks);

// Cron last run on time...
$last_ran_on = iapp('db')->getOne("SELECT DATE_FORMAT(ran_on, '%Y-%m-%d') AS ran_on FROM Log ORDER BY ran_on DESC LIMIT 0,1");
if($last_ran_on) $check_date = strtotime($last_ran_on);
else $check_date = strtotime('yesterday');

// Un-done tasks OR  Events marked done the day this cron was run.
$existing_event_tasks = iapp('db')->getCol("SELECT task_id FROM Event WHERE status='0' OR (status='1' AND DATE(todo_on) = DATE(NOW()) )");

$run_count = 0;
while($check_date < time()) { // Run for all the days that it was not ran on.
	$insert_count = 0;

	foreach ($tasks as  $task_id => $t) {
		// if(in_array($task_id, $existing_event_tasks)) continue; // Event exists from last run. Don't add again.

		$all_day = explode(",", $t['day']);
		$all_weekday = explode(",", $t['weekday']);
		$all_month = explode(",", $t['month']);

		$match = false;
		foreach ($all_day as $day) {
			if($day == '*' or $day == date('j', $check_date)) { // Daily task should be only inserted if...
				if(date('Y-m-d', $check_date) === date('Y-m-d') // its for today(so as not to insert for every day from the last time it was run.)
					and !in_array($task_id, $existing_event_tasks)) {  // and its not already inserted.
						$match = true;
				}
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
			
			iapp('db')->insert("Event", array(
					'task_id' => $task_id,
					'todo_on' => 'NOW()',
					'status'  => '0',
				));
			$insert_count++;
		}
	}

	iapp('db')->insert("Log", array('ran_on'=>'NOW()','insert_count'=>$insert_count));
	$check_date = strtotime("+1 day", $check_date);
	$run_count++;

	if($run_count > 30) break;
}

print "<br />Done";
