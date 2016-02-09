<?php
require('./common.php');

$crud = new Crud("Event");
$crud->setListingQuery("SELECT * FROM Event ORDER BY todo_on DESC");
$crud->render();
