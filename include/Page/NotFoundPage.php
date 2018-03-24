<?php

class NotFoundPage extends Page {    
    public function __construct() {
        http_response_code(404);
    }

    public function getTitle() {
        return "404 Not Found";
    }
    
    public function getBody() {
        return $this->renderText(
            "<p>Diese Seite konnte nicht gefunden werden.</p>".
            "<p>Zurück zur <a href=\"?p=index\">Übersicht</a>.</p>");
    }
}

?>