<?php

class DownloadPage extends ProductLinePage {
    public function getTitle() {
        return "Konfigurieren &amp; Herunterladen";
    }
    
    public function getBody() {        
        return $this->renderTemplate(
            "download",
            array(
                array("assign" => "model",
                      "to" => $this->getModelXmlString()),
                array("assign" => "configuration",
                      "to" => $this->getConfigurationXmlString())
            ));
    }

    public function getScripts() {
        return array(
            "vendor/ekuiter/feature-web/assets/js/jquery-3.2.1.min.js",
            "vendor/ekuiter/feature-web/assets/js/jquery.tristate.js",
            "node_modules/feature-configurator/bundle.js",
            "assets/configurator.js"
        );
    }
}

?>