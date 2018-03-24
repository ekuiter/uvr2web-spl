<?php

use \FeaturePhp as fphp;

abstract class ProductLinePage extends Page {
    protected $productLine;
    protected $configuration;
    protected $product;
    protected $downloadReady = false;
    
    public function __construct() {
        $this->productLine = new fphp\ProductLine\ProductLine(
            fphp\ProductLine\Settings::fromFile("spl/uvr2web.json"));

        if (isset($_REQUEST["configuration"]))
            $this->configuration = new fphp\Model\Configuration(
                $this->productLine->getModel(),
                fphp\Model\XmlConfiguration::fromRequest("configuration")
            );
        else
            $this->configuration = $this->productLine->getDefaultConfiguration();
        fphp\Specification\ReplacementRule::setConfiguration($this->configuration);

        if (isset($_REQUEST["download"])) {
            $this->product = $this->productLine->getProduct($this->configuration);
            $this->product->generateFiles();
            $this->downloadReady = true;
        }
    }

    public function getModelXmlString() {
        return $this->productLine->getModel()->getXmlModel()->getXmlParser()->getXmlString();
    }

    public function getConfigurationXmlString() {
        return $this->configuration->getXmlConfiguration()->getXmlParser()->getXmlString();
    }

    public function getLayout() {
        return $this->downloadReady ? null : parent::getLayout();
    }

    public function render() {
        $this->product->export(new fphp\Exporter\DownloadZipExporter("tmp"));
    }
}

?>