<?php

class Public_HighslideSlideshowJs {
    public function run($groupNumber) {
        return '<script type="text/javascript">'
            . "addHSSlideshow('group" . $groupNumber . "');</script>"
            . PHP_EOL;
    }
}
