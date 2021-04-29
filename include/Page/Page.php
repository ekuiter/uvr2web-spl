<?php

use \FeaturePhp as fphp;

abstract class Page {
    abstract public function getBody();

    public function getTitle() {
        return "";
    }

    public function getScripts() {
        return array();
    }

    public function getNavigation() {
        return array(
            array("title" => "Übersicht", "page" => "index"),
            array("title" => "Funktionsweise", "page" => "features"),
            array("title" => "Herunterladen", "page" => "download"),
            array("title" => "GitHub", "href" => "https://github.com/ekuiter/uvr2web-spl"),
        );
    }

    public function getLayout() {
        return "Page/templates/application.html";
    }

    public function render() {}

    protected function renderTemplate($template, $rules = array()) {
        return fphp\File\TemplateFile::render(
            "templates/$template.html", $rules, __DIR__);
    }
    
    protected function renderText($html) {
        return $this->renderTemplate(
            "text",
            array(
                array("assign" => "html", "to" => $html)
            ));
    }
}

?>