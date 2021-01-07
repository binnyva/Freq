<ul class="nav nav-tabs" id="main-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="tasks-tab" data-toggle="tab" href="#tasks-pane" role="tab" aria-controls="tasks-pane" aria-selected="true">Tasks</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="intention-tab" data-toggle="tab" href="#intention-pane" role="tab" aria-controls="intention-pane" aria-selected="false">Intention</a>
  </li>
</ul>

<div class="tab-content" id="main-tab-content">
  <div class="tab-pane fade show active" id="tasks-pane" role="tabpanel" aria-labelledby="tasks-tab">
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
	<input type="submit" name="action" class="btn btn-primary" value="Add Tasks" />
	</form>

	<div class="tab-footer">
		<a href="system/daily_cron.php">Run Cron Job</a> |
		<a href="#" id="add-tasks">Add Tasks</a>
	</div>
  </div>

  <div class="tab-pane fade" id="intention-pane" role="tabpanel" aria-labelledby="intention-tab">
  	<?php foreach ($intentions as $intent) { 
  		$achived = 'pending';
  		if($intent['achieved_on']) $achived = 'achieved';
  		?>
  		<div class="priority-<?=$intent['priority'] . ' ' . $achived ?> intention ">
  			<span class="intent"><?=$intent['name']?></span>
  			<a class="icon icon-done" href="events.php?action=achive_intention&amp;intention_id=<?php echo $intent['id'] ?>">Done</a>
		</div>
  	<?php } ?>

  	<?php if(count($intentions)) { ?>
  	<div class="tab-footer">
		<a href="#" id="add-intention">Add Another Intention</a>
	</div>
	<?php } ?>

	<form action="" method="post" id="intention-area">
	<textarea name="intention" id="intention" class="form-control" rows="3" placeholder="Enter Intention for today..."></textarea>
	<input type="submit" name="action" class="btn btn-primary" value="Add Intention" />
	</form>
  </div>
</div>
