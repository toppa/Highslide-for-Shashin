<?php

class HighslideForShashin {
    private $version = '1.0';

    public function __construct() {
    }

    public function getVersion() {
        return $this->version;
    }

    public function install() {
        try {
            $container = new HfsContainer();
            $installer = $container->getInstaller($this->version);
            $status = $installer->run();
            return $status;
        }

        catch (Exception $e) {
            return $this->formatExceptionMessage($e);
        }
    }

    public function run() {
        add_action('admin_init', array($this, 'runtimeUpdate'));
        add_action('admin_menu', array($this, 'initSettingsMenu'));
        add_action('template_redirect', array($this, 'displayPublicHeadTags'));
    }

    public function runtimeUpdate() {
        try {
            $container = new HfsContainer();
            $installer = $container->getInstaller($this->version);
            $status = $installer->runtimeUpdate();
            return $status;
        }

        catch (Exception $e) {
            return $this->formatExceptionMessage($e);
        }

    }
    public function initSettingsMenu() {
        add_options_page(
            'Highslide for Shashin',
            'Highslide for Shashin',
            'manage_options',
            'hfs',
            array($this, 'displaySettingsMenu')
        );
    }

    public function displaySettingsMenu() {
        try {
            $container = new HfsContainer();
            $settingsMenu = $container->getSettingsMenu();
            echo $settingsMenu->run();
        }

        catch (Exception $e) {
            echo $this->formatExceptionMessage($e);
        }
    }

    public function displayPublicHeadTags() {
        try {
            $container = new HfsContainer();
            $headTags = $container->getHeadTags($this->version);
            $headTags->run();
        }

        catch (Exception $e) {
            echo $this->formatExceptionMessage($e);
        }
    }

    public function formatExceptionMessage($e) {
        return '<p><strong>'
            . __('Highslide for Shashin Error', 'hfs')
            . ':<strong></p><pre>'
            . $e->getMessage()
            . '</pre>';
    }
}
