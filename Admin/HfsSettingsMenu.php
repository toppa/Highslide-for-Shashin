<?php

class Admin_HfsSettingsMenu {
    private $functionsFacade;
    private $settings;
    private $validSettings = array();
    private $invalidSettings = array();
    private $successMessage;
    private $errorMessage;
    private $request;
    private $relativePathToTemplate = 'Display/settings.php';
    private $settingsGroups;
    private $refData;

    public function __construct() {
        $this->settingsGroups = array(
            'highslide' => array(
                'label' => __('Highslide Settings', 'hfs'),
                'description' => ''
            ),
        );

        $this->refData =  array(
            // Highslide settings
            'highslideAutoplay' => array(
                'input' => array('type' => 'radio', 'subgroup' => array('true' => __('Yes', 'hfs'), 'false' => __('No', 'hfs'))),
                'validateFunction' => 'in_array',
                'validValues' => array('true', 'false'),
                'label' => __('Autoplay slideshows?', 'hfs'),
                'help' => __('After someone clicks a thumbnail in a slideshow group, this determines whether the slideshow plays automatically.', 'hfs'),
                'group' => 'highslide'
            ),
            'highslideInterval' => array(
                'input' => array('type' => 'text', 'size' => 6),
                'validateFunction' => 'is_numeric',
                'label' => __('Autoplay image display time', 'hfs'),
                'help' => __('How long each photo is displayed in a autoplay slideshow (in milliseconds).', 'hfs'),
                'group' => 'highslide'
            ),
            'highslideRepeat' => array(
                'input' => array('type' => 'radio', 'subgroup' => array('1' => __('Yes', 'hfs'), '0' => __('No', 'hfs'))),
                'validateFunction' => 'in_array',
                'validValues' => array('1', '0'),
                'label' => __('Repeat slideshows?', 'hfs'),
                'help' => __('When viewing the final photo in slideshow, whether clicking "next" will start the slideshow over again with the first photo.', 'hfs'),
                'group' => 'highslide'
            ),
            'highslideOutlineType' => array(
                'input' => array(
                    'type' => 'select',
                    'subgroup' =>  array(
                        'beveled' => __('Beveled', 'hfs'),
                        'glossy-dark' => __('Glossy Dark', 'hfs'),
                        'rounded-black' => __('Rounded Black', 'hfs'),
                        'drop-shadow' => __('Drop Shadow', 'hfs'),
                        'outer-glow' => __('Outer Glow', 'hfs'),
                        'rounded-white' => __('Rounded White', 'hfs'),
                        'none' => __('None', 'hfs')
                    )
                ),
                'validateFunction' => 'in_array',
                'validValues' => array('beveled', 'glossy-dark', 'rounded-black', 'drop-shadow', 'outer-glow', 'rounded-white', 'none'),
                'label' => __('Expanded view outline style', 'hfs'),
                'help' => __('The graphic outline applied to expanded images.', 'hfs'),
                'group' => 'highslide'
            ),
            'highslideDimmingOpacity' => array(
                'input' => array('type' => 'text', 'size' => 6),
                'validateFunction' => 'is_numeric',
                'label' => __('Background dimming opacity', 'hfs'),
                'help' => __('Enter a number between 0 and 1. Indicates how much to dim the background when an image is expanded (enter 0 for no dimming). The default color is black (you can change it by editing .highslide-dimming in highslide.css.', 'hfs'),
                'group' => 'highslide'
            ),
            'highslideHideController' => array(
                'input' => array(
                    'type' => 'radio',
                    'subgroup' => array(
                        '1' => __('Yes', 'hfs'),
                        '0' => __('No', 'hfs')
                    )
                ),
                'validateFunction' => 'in_array',
                'validValues' => array('1', '0'),
                'label' => __('Hide slideshow controller on mouseout?', 'hfs'),
                'help' => __('Whether the slideshow controller should be hidden when the mouse leaves the expanded image.', 'hfs'),
                'group' => 'highslide'
            ),
            'highslideVPosition' => array(
                'input' => array(
                    'type' => 'select',
                    'subgroup' =>  array(
                        'top' => __('Top', 'hfs'),
                        'middle' => __('Middle', 'hfs'),
                        'bottom' => __('Bottom', 'hfs')
                    )
                ),
                'validateFunction' => 'in_array',
                'validValues' => array('top', 'middle', 'bottom'),
                'label' => __('Slideshow controller vertical position', 'hfs'),
                'help' => '',
                'group' => 'highslide'
            ),
            'highslideHPosition' => array(
                'input' => array(
                    'type' => 'select',
                    'subgroup' =>  array(
                        'left' => __('Left', 'hfs'),
                        'center' => __('Center', 'hfs'),
                        'right' => __('Right', 'hfs')
                    )
                ),
                'validateFunction' => 'in_array',
                'validValues' => array('left', 'center', 'right'),
                'label' => __('Slideshow controller horizontal position', 'hfs'),
                'help' => '',
                'group' => 'highslide'
            ),

        );
    }

    public function setFunctionsFacade(ToppaFunctionsFacade $functionsFacade) {
        $this->functionsFacade = $functionsFacade;
        return $this->functionsFacade;
    }

    public function setSettings(Lib_ShashinSettings $settings) {
        $this->settings = $settings;
        return $this->settings;
    }

    public function setRequest(array $request) {
        $this->request = $request;
        return $this->request;
    }

    public function run() {
        if (isset($this->request['hfsAction']) && $this->request['hfsAction'] == 'updateSettings') {
            $this->validateSettings();
            $this->updateSettingsAndSetSuccessMessageIfNeeded();
            $this->setErrorMessageIfNeeded();
        }

        return $this->displayMenu();
    }

    public function displayMenu() {
        $message = $this->successMessage;
        ob_start();
        require_once($this->relativePathToTemplate);
        $settingsMenu = ob_get_contents();
        ob_end_clean();
        return $settingsMenu;
    }

    public function createHtmlForSettingsGroupHeader($groupData) {
        $html = '<tr>' . PHP_EOL
            . '<th scope="row" colspan="3"><h3>' . $groupData['label'] . '</h3></th>' . PHP_EOL
            . '</tr>' . PHP_EOL;

            if ($groupData['description']) {
                $html .= '<tr>' . PHP_EOL
                    . '<th colspan="3" scope="row">' . $groupData['description'] . '</th>' . PHP_EOL
                    . '</tr>' . PHP_EOL;
            }

        return $html;
    }

    public function createHtmlForSettingsField($setting) {
        $value = array_key_exists($setting, $this->request) ? $this->request[$setting] : $this->settings->$setting;
        $html = '<tr valign="top">' . PHP_EOL
            . '<th scope="row"><label for="' . $setting . '">'
            . $this->refData[$setting]['label']
            . '</label></th>' . PHP_EOL
            . '<td nowrap="nowrap">'
            . ToppaHtmlFormField::quickBuild($setting, $this->refData[$setting], $value)
            . '</td>' . PHP_EOL
            . '<td>' . $this->refData[$setting]['help'] . '</td>' . PHP_EOL
            . '</tr>' . PHP_EOL;
        return $html;
    }

    public function validateSettings() {
        foreach ($this->refData as $k=>$v) {
            if (array_key_exists($k, $this->request)) {
                switch ($v['validateFunction']) {
                    case 'in_array':
                        $this->validateSettingsForInArray($k, $v);
                    break;
                    case 'is_numeric':
                        $this->validateSettingsForIsNumeric($k);
                    break;
                    case 'htmlentities':
                        $this->validateSettingsForHtmlEntities($k);
                    break;
                    default:
                        throw New Exception(__('Unrecognized validation function', 'hfs'));
                }
            }

            // a checkbox group with all unchecked will not appear at all in $this->request
            elseif ($v['input']['type'] == 'checkbox') {
                $this->validSettings[$k] = array();
            }
        }

        return true;
    }

    public function validateSettingsForInArray($k, $v) {
        if (is_scalar($this->request[$k]) && in_array($this->request[$k], $v['validValues'])) {
            $this->validSettings[$k] = $this->request[$k];
        }
        elseif (is_array($this->request[$k]) && array_intersect($this->request[$k], $v['validValues'])) {
            $this->validSettings[$k] = $this->request[$k];
        }
        else {
            $this->invalidSettings[$k] = $this->request[$k];
        }
    }

    public function validateSettingsForIsNumeric($k) {
        if (is_numeric($this->request[$k])) {
            $this->validSettings[$k] = $this->request[$k];
        }

        else {
            $this->invalidSettings[$k] = $this->request[$k];
        }
    }

    public function validateSettingsForHtmlEntities($k) {
        $this->validSettings[$k] = htmlentities($this->request[$k], ENT_COMPAT, 'UTF-8');
    }

    public function setErrorMessageIfNeeded() {
        if (!empty($this->invalidSettings)) {
            $this->errorMessage = __('The following settings have invalid values. Please try again.', 'hfs');
            $this->errorMessage .= '<br /><br /><strong>';

            foreach ($this->refData as $k=>$v) {
                if (array_key_exists($k, $this->invalidSettings)) {
                    $this->errorMessage .= $v['label'] . '<br />';
                }
            }
            $this->errorMessage .= '</strong>';
        }

        return $this->errorMessage;
    }

    public function updateSettingsAndSetSuccessMessageIfNeeded() {
        if (empty($this->invalidSettings)) {
            $this->settings->set($this->validSettings);
            $this->successMessage =  __('Settings saved', 'hfs');
        }

        return $this->successMessage;
    }
}
