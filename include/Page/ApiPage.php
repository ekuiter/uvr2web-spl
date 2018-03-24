<?php

class ApiPage {
    public function getLayout() {
        return null;
    }

    public function render() {
        $allowedConfigurations = array(
            "UVR1611",
            "UVR31",
            "UVR42",
            "UVR64",
            "HZR65",
            "TFM66"
        );
        if (isset($_GET["configuration"]) && in_array($_GET["configuration"], $allowedConfigurations, true))
            echo file_get_contents("spl/$_GET[configuration].xml");
    }
}

?>