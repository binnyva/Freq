<?php
require 'common.php';

$task_id = i($QUERY, 'task_id');
if(!$task_id) die("Please provide a task_id");

$task = iapp('db')->getAssoc("SELECT id,name,description FROM Task WHERE id = $task_id");

$Parsedown = new Parsedown();
$task['info'] = $Parsedown->text($task['description']);

iapp('template')->render($task);