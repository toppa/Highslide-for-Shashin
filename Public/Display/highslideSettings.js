// The "-0" and "!!" are for type casting, as all vars brought over
// from wp_localize_script come in as strings
hs.graphicsDir = hfsHighslideSettings.graphicsDir;
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = ((hfsHighslideSettings.outlineType == "none") ? null : hfsHighslideSettings.outlineType);
hs.fadeInOut = true;
hs.dimmingOpacity = hfsHighslideSettings.dimmingOpacity-0;

// need this to make sure we don't add controls for a slideshowGroup
// more than once (if we do, a stray, extra navbar appears on the page)
window.shashinGroupIDs = new Array();

// Add the controlbar for slideshows
function addHSSlideshow(groupID) {
    if (jQuery.inArray(groupID, window.shashinGroupIDs) == -1) {
        window.shashinGroupIDs.push(groupID);

        hs.addSlideshow({
            slideshowGroup: groupID,
            interval: hfsHighslideSettings.interval-0,
            repeat: !!(hfsHighslideSettings.repeat-0),
            useControls: true,
            fixedControls: true,
            overlayOptions: {
                opacity: .75,
                position: hfsHighslideSettings.position,
                hideOnMouseOut: !!(hfsHighslideSettings.hideController-0)
            }
        });
    }
}
