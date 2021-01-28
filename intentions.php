<?php
require('./common.php');

\iframe\App::$config['time_format_php'] = 'dS M';
$crud = new iframe\iframe\Crud("Intention");
$crud->items_per_page = 10;
$crud->setListingQuery("SELECT * FROM Intention ORDER BY added_on DESC");

$crud->render();
