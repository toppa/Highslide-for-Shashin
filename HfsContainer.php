<?php

class HfsContainer extends Lib_ShashinContainer {
    private $installer;
    private $settingsMenu;
    private $headTags;

    public function __construct($autoLoader) {
        parent::__construct($autoLoader);
    }

    public function getInstaller($version) {
        if (!isset($this->installer)) {
            $this->getFunctionsFacade();
            $this->getSettings();
            $this->installer = new Admin_HfsInstaller($version);
            $this->installer->setFunctionsFacade($this->functionsFacade);
            $this->installer->setSettings($this->settings);
        }

        return $this->installer;
    }

    public function getSettingsMenu() {
        if (!isset($this->settingsMenu)) {
            $this->getFunctionsFacade();
            $this->getSettings();
            $this->settingsMenu = new Admin_HfsSettingsMenu();
            $this->settingsMenu->setFunctionsFacade($this->functionsFacade);
            $this->settingsMenu->setSettings($this->settings);
            $this->settingsMenu->setRequest($_REQUEST);
        }

        return $this->settingsMenu;
    }

    public function getHeadTags($version) {
        if (!isset($this->headTags)) {
            $this->getFunctionsFacade();
            $this->getSettings();
            $this->headTags = new Public_HfsHeadTags($version);
            $this->headTags->setFunctionsFacade($this->functionsFacade);
            $this->headTags->setSettings($this->settings);
        }

        return $this->headTags;
    }
}
