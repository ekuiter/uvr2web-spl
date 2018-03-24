<?php

class IndexPage extends Page {
    public function getTitle() {
        return "Überwache deine Heizungsregelung mit Arduino";
    }
    
    public function getBody() {
        return $this->renderTemplate("index");
    }
}

?>