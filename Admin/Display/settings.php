<div class="wrap">
    <?php include_once $this->functionsFacade->getPluginsPath() . '/shashin/Admin/Display/donate.php'; ?>

    <?php screen_icon() ?>
    <h2><?php _e('Highslide for Shashin', 'hfs');?></h2>
    <?php
        if ($this->successMessage) {
            echo '<div id="message" class="updated"><p>' . $this->successMessage .'</p></div>';
            $this->successMessage = null;
        }

        elseif ($this->errorMessage) {
            echo '<div id="message" class="error"><p>' . $this->errorMessage .'</p></div>';
            $this->errorMessage = null;
        }
    ?>
    <form method="post">
        <?php $this->functionsFacade->createAdminHiddenInputFields('hfs'); ?>
        <input type="hidden" name="hfsAction" value="updateSettings" />
        <table class="form-table">
        <?php
            foreach ($this->settingsGroups as $groupName=>$groupData) {
                echo $this->createHtmlForSettingsGroupHeader($groupData);

                foreach ($this->refData as $k=>$v) {
                    if ($v['group'] == $groupName) {
                        echo $this->createHtmlForSettingsField($k);
                    }
                }
            }
        ?>
        </table>
        <p class="submit"><input class="button-primary" type="submit" name="save" value="<?php _e('Save Settings', 'hfs'); ?>" /></p>
    </form>
</div>
