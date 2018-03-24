<?php

class FeaturesPage extends Page {
    public function getTitle() {
        return "Funktionsweise";
    }
    
    public function getBody() {
        return $this->renderTemplate("features");
    }
}

?>