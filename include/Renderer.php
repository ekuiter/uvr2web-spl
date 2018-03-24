<?php

use \FeaturePhp as fphp;
require_once __DIR__."/Page/Page.php";
require_once __DIR__."/Page/NotFoundPage.php";
require_once __DIR__."/Page/ProductLinePage.php";

class Renderer {
    private $pageSlug;
    private $page;
    private $exception = null;

    public function __construct($page = "index", $arg = null) {
        if (!$page)
            $page = "index";
        $this->pageSlug = $page;
        $page = preg_replace('/[^a-zA-Z0-9_]+/', '', $page);
        $page = str_replace(' ', '', ucwords(str_replace('_', ' ', $page)));
        $class = "{$page}Page";
        $file = __DIR__."/Page/$class.php";
        if (file_exists($file))
            require_once $file;
        if (!class_exists($class))
            $class = "NotFoundPage";
        header("Content-Type: text/html; charset=utf-8");
        
        try {
            $this->page = new $class($arg);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    public function render() {
        try {
            if ($this->exception)
                throw $this->exception;

            $layout = $this->page->getLayout();
            if ($layout)           
                echo fphp\File\TemplateFile::render(
                    $layout,
                    array(
                        array("assign" => "scripts", "to" => $this->getScripts()),
                        array("assign" => "title", "to" => $this->page->getTitle()),
                        array("assign" => "body", "to" => $this->page->getBody()),
                        array("assign" => "nav", "to" => $this->getNavigation())
                    ),
                    __DIR__);
            else
                $this->page->render();
            
        } catch (Exception $e) {
            if (get_class($this->page) === "ErrorPage")
                echo $e->getMessage();
            else
                (new Renderer("error", $e))->render();
        }
    }

    private function getScripts() {
        $scripts = "";
        foreach ($this->page->getScripts() as $script)
            $scripts .= "<script src=\"$script\"></script>\n";
        return $scripts;
    }

    private function getNavigation() {
        $nav = "";
        foreach ($this->page->getNavigation() as $link) {
            $href = isset($link["page"]) ? "?p=$link[page]" :
                  (isset($link["href"]) ? $link["href"] : "javascript:void(0)");
            $class = 
            $class = isset($link["class"]) ? $link["class"] : "";
            $script = isset($link["script"]) ? "onclick=\"$link[script]\"" : "";

            $query = array();
            if (isset($link["preserve"]))
                foreach ($link["preserve"] as $preserve)
                    if (isset($_REQUEST[$preserve]))
                        $query[$preserve] = $_REQUEST[$preserve];
            if (!empty($query))
                $href .= "&" . http_build_query($query);

            $active = isset($link["page"]) && $this->pageSlug === $link["page"] ? "is-active" : "";
            $nav .= "<a href=\"$href\" class=\"mdl-layout__tab $active $class\" $script>$link[title]</a>\n";
        }
        return $nav;
    }
}

?>