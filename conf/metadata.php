<?php
/*
 * configuration metadata
 *
 */

$meta['includeFontAwesome'] = array('onoff');
$meta['useFontAwesome']     = array('onoff');
$meta['useTheme']           = array('string');
$meta['navbarIconsText']    = array('multichoice', '_choices' => array('icons', 'text', 'both'));
$meta['navbarUseDropdown']  = array('onoff');
$meta['navbarClasses']      = array('string');
$meta['useHeroTitle']       = array('onoff');
$meta['navbarMenuPosition'] = array('multichoice', '_choices' => array('none', 'left', 'center', 'right'));
$meta['navbarCustomPages']  = array('string');
$meta['navbarSearchPosition']   = array('multichoice', '_choices' => array('none', 'left', 'right'));
$meta['navbarGuestHide']    = array('onoff');
$meta['navbarHideImage']    = array('onoff');
$meta['breadcrumbsLoc']     = array('multichoice', '_choices' => array('none', 'top', 'hero', 'page'));
$meta['tocfullheight']      = array('onoff');
$meta['hidePageTools']      = array('onoff');
$meta['hidePageToolsFooter']    = array('onoff');
$meta['showCustomPagesInNavbar'] = array('onoff');
$meta['showCustomPagesInFooter'] = array('onoff');
$meta['showSearchInFooter'] = array('onoff');
$meta['showSearchInSidebar'] = array('multichoice', '_choices' => array('none', 'top', 'bottom'));

// $meta['discussionPage']   = array('string');
// $meta['userPage']         = array('string');
// $meta['hideTools']        = array('onoff');
// $meta['navbar']             = array('string');
