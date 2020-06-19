<?php

require 'vendor/autoload.php';

use App\IndexController;
use App\AdminController;

$index = new IndexController();
$index->index();

$ad = new AdminController();
$ad::index();
AdminController::index();