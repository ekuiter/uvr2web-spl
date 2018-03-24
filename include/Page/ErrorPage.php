<?php

class ErrorPage extends Page {
    private $exception;
    
    public function __construct($exception) {
        $this->exception = $exception;
        http_response_code(500);
    }

    public function getTitle() {
        return "500 Internal Server Error";
    }

    public function getBody() {
        return $this->renderText(
            "<p>Bei deiner Anfrage ist der folgende <strong>" . get_class($this->exception) . "</strong>-Fehler aufgetreten:</p>".
            "<p><em>" . str_replace("\n", "<br>\n", $this->exception->getMessage()) . "</em></p>");
    }
}

?>