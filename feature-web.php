<?php

require_once "vendor/autoload.php";

error_reporting(0);

try {

    $featureWeb = \FeatureWeb\Core::getInstance();
    $featureWeb->setProductLineSettings(\FeaturePhp\ProductLine\Settings::fromFile("spl/uvr2web.json"));
    $featureWeb->setTemporaryDirectory("tmp");
    $featureWeb->setConfiguratorNotice(
        "<b>Note that</b> the features <em>android</em>, <em>HCP *</em>, ".
        "<em>Dometic *</em>, <em>single sensor</em>, <em>website</em> and <em>windows</em><br />".
        "are closed-source and generating products including them is not supported.");
    $featureWeb->render();

} catch (\Exception $e) {
    (new \FeatureWeb\Renderer("error", $e))->render();
}

?>