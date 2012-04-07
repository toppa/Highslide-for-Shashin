<?php

class Public_HfsHeadTags {
    private $version;
    private $functionsFacade;
    private $settings;

    public function __construct($version) {
        $this->version = $version;
    }

    public function setFunctionsFacade(ToppaFunctionsFacade $functionsFacade) {
        $this->functionsFacade = $functionsFacade;
        return $this->functionsFacade;
    }

    public function setSettings(Lib_ShashinSettings $settings) {
        $this->settings = $settings;
        return $this->settings;
    }

    public function run() {
        if ($this->settings->imageDisplay != 'highslide') {
            return true;
        }

        $highslideCssUrl = $this->functionsFacade->getUrlforCustomizableFile('highslide.css', __FILE__, 'Display/highslide/');
        $this->functionsFacade->enqueueStylesheet('hfsHighslideStyle', $highslideCssUrl, false, '4.1.12');
        $baseUrl = $this->functionsFacade->getPluginsUrl('/Display/', __FILE__);
        $this->functionsFacade->enqueueScript('hfsHighslide', $baseUrl . 'highslide/highslide.js', false, '4.1.12');
        $this->functionsFacade->enqueueScript('hfsSwfobject', $baseUrl . 'highslide/swfobject.js', false, '2.2');
        $this->functionsFacade->enqueueScript(
            'hfsHighslideSettings',
            $baseUrl . 'highslideSettings.js',
            array('hfsHighslide', 'shashinJs'),
            $this->version
        );

        $this->functionsFacade->localizeScript('hfsHighslideSettings', 'hfsHighslideSettings', array(
            'graphicsDir' => $baseUrl . 'highslide/graphics/',
            'outlineType' => $this->settings->highslideOutlineType,
            'dimmingOpacity' => $this->settings->highslideDimmingOpacity,
            'interval' => $this->settings->highslideInterval,
            'repeat' => $this->settings->highslideRepeat,
            'position' => $this->settings->highslideVPosition . ' ' . $this->settings->highslideHPosition,
            'hideController' => $this->settings->highslideHideController
        ));

        return true;
    }
}
