<table class="table table-striped table-condensed">
<?php if(!count($tasks)) { ?>
<tr><td>No pending Tasks! &nbsp;<span class="icon icon-done"></span></td></tr>
<?php } ?>
<?php foreach($tasks as $t) {?>
<tr>
<td width="20"><?php if($t['description']) { ?><a href="info.php?task_id=<?php echo $t['task_id'] ?>" class="icon icon-info">Info</a><?php } ?></td>
<td><?php echo $t['name'] ?></td>
<td><a class="icon icon-done" href="events.php?action=toggle_status&amp;task_id=<?php echo $t['id'] ?>">Done</a></td>
<td><a class="icon icon-delete confirm" href="events.php?action=delete&amp;task_id=<?php echo $t['id'] ?>">Delete</a></td>
</tr>
<?php } ?>
</table>

<form action="" method="post" id="tasks-area">
<textarea name="tasks" id="tasks" class="form-control" rows="5" placeholder="Enter Tasks for today..."></textarea>
<input type="submit" name="action" class="btn btn-primary" value="Save" />
</form>

<div id="footer">
	<a href="system/daily_cron.php">Run Cron Job</a> |
	<a href="#" id="add-tasks">Add Tasks</a>
</div>
