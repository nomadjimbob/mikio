<?php
/*
 * configuration metadata
 *
 */

$meta['inclFontAwesome']        = array('onoff');

$meta['customTheme']            = array('string');

$meta['navbarUseTitleIcon']     = array('onoff');
$meta['navbarUseTitleText']     = array('onoff');
$meta['navbarUseSubtitleText']  = array('onoff');
$meta['navbarCustomMenuText']   = array('string');

$meta['navbarDWMenuType']       = array('multichoice', '_choices' => array('icons', 'text', 'both'));
$meta['navbarDWMenuCombine']    = array('multichoice', '_choices' => array('seperate', 'dropdown', 'combine'));
$meta['navbarDWMenuLogout']     = array('onoff');

$meta['navbarPosLeftLeft']      = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosLeftMid']       = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosLeftRight']     = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRightLeft']     = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRightMid']      = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRightRight']    = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarLowerMenu']        = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarLowerMenuPos']     = array('multichoice', '_choices' => array('none', 'left', 'center', 'right'));

$meta['heroTitle']              = array('onoff');
$meta['heroImagePropagation']   = array('onoff');

$meta['breadcrumbPos']          = array('multichoice', '_choices' => array('none', 'top', 'hero', 'page'));
$meta['breadcrumbPrefix']       = array('string');
$meta['breadcrumbHome']         = array('multichoice', '_choices' => array('none', 'page title', 'home', 'icon'));

$meta['sidebarDismiss']         = array('onoff');
$meta['sidebarSearch']          = array('multichoice', '_choices' => array('none', 'above', 'below'));

$meta['tocFull']                = array('onoff');

$meta['pageToolsHide']          = array('onoff');
$meta['pageToolsFooter']        = array('onoff');

$meta['footerCustomMenuText']   = array('string');
$meta['footerSearch']           = array('onoff');


// $meta['discussionPage']   = array('string');
// $meta['userPage']         = array('string');
// $meta['hideTools']        = array('onoff');
// $meta['navbar']             = array('string');
