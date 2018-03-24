<?php

require_once "vendor/autoload.php";
require_once "include/Renderer.php";

error_reporting(0);

try {

    $page = isset($_GET["p"]) ? $_GET["p"] : null;
    $renderer = new Renderer($page);
    $renderer->render();

} catch (Exception $e) {
    (new Renderer("error", $e))->render();
}

?>