<?php
require_once "../configs/app.config.php";
require_once "../autoloaders.php";
$webPage = new Calculate_CubeSummation();
$action = !empty($_REQUEST["action"]) ? $_REQUEST["action"] : "start";
switch($action) {
    case "calculate":
        if($webPage->parseTestCases($_POST))
            $webPage->processTestCases();
        break;
}
$webPage->display();
?>