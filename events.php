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

$tasks = $sql->getAll("SELECT E.id,T.name, E.todo_on, E.done_on FROM Event E INNER JOIN Task T ON E.task_id=T.id WHERE E.status='0'");
?><!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Task</title>
<link href="http://localhost/Projects/Freq/css/style.css" rel="stylesheet" type="text/css" />
<link href="http://localhost/Projects/Freq/images/silk_theme.css" rel="stylesheet" type="text/css" />
<link href="http://localhost/Projects/Freq/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="http://localhost/Projects/Freq/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="content">
<div id="error-message" <?php echo ($QUERY['error']) ? '':'style="display:none;"';?>><?php
	if(isset($PARAM['error'])) print strip_tags($PARAM['error']); //It comes from the URL
	else print $QUERY['error']; //Its set in the code(validation error or something.
?></div>
<!-- Begin Content -->
<table class="table table-striped table-condensed">
<?php foreach($tasks as $t) {?>
<tr>
<td><?php echo $t['name'] ?></td>
<td><a class="icon done" href="events.php?action=toggle_status&amp;task_id=<?php echo $t['id'] ?>">Done</a></td>
<td><a class="icon delete confirm" href="events.php?action=delete&amp;task_id=<?php echo $t['id'] ?>">Delete</a></td>
</tr>
<?php } ?>
</table>
<!-- End Content -->
</div>

<script src="http://localhost/Projects/Freq/js/library/jquery.js" type="text/javascript"></script>
<script src="http://localhost/Projects/Freq/js/application.js" type="text/javascript"></script>
</html>

