<?php

class Admin_HfsInstaller {
    private $version;
    private $functionsFacade;
    private $settings;
    private $settingsDefaults = array(
        'highslideForShashinVersion' => null,
        'highslideAutoplay' => 'false',
        'highslideInterval' => 5000,
        'highslideRepeat' => '1',
        'highslideOutlineType' => 'rounded-white',
        'highslideDimmingOpacity' => 0.75,
        'highslideHideController' => '0',
        'highslideVPosition' => 'top',
        'highslideHPosition' => 'center',
        'externalViewers' => array('highslide' => 'Highslide')
    );

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
        return $this->functionsFacade->callFunctionForNetworkSites(array($this, 'runForNetworkSites'));
    }

    public function runForNetworkSites() {
        $this->settings->set(array('highslideForShashinVersion' => $this->version));
        return $this->settings->set($this->settingsDefaults, true);
    }

    public function runtimeUpdate() {
        $allSettings = $this->settings->refresh();
        if (!array_key_exists('highslideForShashinVersion', $allSettings)
          || version_compare($allSettings['highslideForShashinVersion'], $this->version, '<')) {
            $this->run();
        }

        return true;
    }
}
