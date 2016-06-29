<?php
require_once "configs/app.config.php";
require_once "autoloaders.php";
$webPage = new Index();
$webPage->loadController("calculate_cubesummation");
$webPage->display();
?>