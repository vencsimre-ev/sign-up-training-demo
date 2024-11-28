<?php

require 'vendor/autoload.php';
require 'src/Controllers/TrainingController.php';

use src\Controllers\TrainingController;

try {
    $controller = new TrainingController();
    $controller->handleRequest();
} catch (Exception $e) {
    echo 'Exception: ' . $e->getMessage();
}

