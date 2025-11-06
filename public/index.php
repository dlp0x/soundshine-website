<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Classes\StaticContent as StaticContent;

require '../vendor/autoload.php';
if (!file_exists('../config/config.php')) {

    StaticContent::getStyleSheet();
    StaticContent::noScriptInstalled();
    StaticContent::getScriptFiles();
} else {
    require('../routes/web.php');
    if (is_array($match)) {

        $params = $match['params'];
        require '../resources/views/layout/header.php';
        require "../resources/views/{$match['target']}.php";
        require '../resources/views/layout/footer.php';
    } else {
        require "../resources/views/404.php";
    }
}
