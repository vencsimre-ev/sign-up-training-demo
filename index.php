<?php

require 'vendor/autoload.php';
require 'src/Controllers/TrainingController.php';

use src\Controllers\TrainingController;

$controller = new TrainingController();
$controller->handleRequest();

