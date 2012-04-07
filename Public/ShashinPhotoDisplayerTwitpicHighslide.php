<?php

class Public_ShashinPhotoDisplayerTwitpicHighslide extends Public_ShashinPhotoDisplayerTwitpic {
    public function __construct() {
        parent::__construct();
    }

    public function setLinkOnClick() {
        $this->linkOnClick = 'return hs.expand(this, { ';
        $this->linkOnClick .= $this->appendLinkOnClick();
        return $this->linkOnClick;
    }

    private function appendLinkOnClick() {
        $groupNumber = $this->sessionManager->getGroupCounter();

        if ($this->albumIdForAjaxPhotoDisplay) {
            $groupNumber .= '_' . $this->albumIdForAjaxPhotoDisplay;
        }

        return "autoplay: "
            . $this->settings->highslideAutoplay
            . ", slideshowGroup: 'group"
            . $groupNumber
            . "' })";
    }

    public function setLinkClass() {
        $this->linkClass = 'highslide';
        return $this->linkClass;
    }

    public function setLinkClassVideo() {
        return $this->setLinkClass();
    }

    public function setCaption() {
        parent::setCaption();
        $this->caption .= '<div class="highslide-caption">';
        $this->caption .= $this->setDivOriginalPhotoLinkForCaption();

        if ($this->dataObject->description) {
            $this->caption .= $this->dataObject->description;
        }

        $this->caption .= $this->setExifDataForCaption();
        $this->caption .= '</div>';
        return $this->caption;
    }
}
