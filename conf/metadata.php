<?php
/*
 * configuration metadata
 *
 */

$meta['iconTag']                = array('string');

$meta['inclFontAwesome']        = array('onoff');

$meta['customTheme']            = array('string');

$meta['navbarUseTitleIcon']     = array('onoff');
$meta['navbarUseTitleText']     = array('onoff');
$meta['navbarUseTaglineText']   = array('onoff');
$meta['navbarCustomMenuText']   = array('string');
$meta['navbarBackground']       = array('multichoice', '_choices' => array('none', 'dark', 'light'));

$meta['navbarDWMenuType']       = array('multichoice', '_choices' => array('icons', 'text', 'both'));
$meta['navbarDWMenuCombine']    = array('multichoice', '_choices' => array('seperate', 'dropdown', 'combine'));

$meta['navbarPosLeftLeft']      = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosLeftMid']       = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosLeftRight']     = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRightLeft']     = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRightMid']      = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRightRight']    = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarLowerMenu']        = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarLowerMenuPos']     = array('multichoice', '_choices' => array('none', 'left', 'center', 'right'));
$meta['navbarLowerBackground']  = array('multichoice', '_choices' => array('none', 'dark', 'light'));

$meta['searchButton']           = array('multichoice', '_choices' => array('icon', 'text'));

$meta['heroTitle']              = array('onoff');
$meta['heroImagePropagation']   = array('onoff');

$meta['breadcrumbPos']          = array('multichoice', '_choices' => array('none', 'top', 'hero', 'page'));
$meta['breadcrumbPrefix']       = array('onoff');
$meta['breadcrumbPrefixText']   = array('string');
$meta['breadcrumbSep']          = array('onoff');
$meta['breadcrumbSepText']      = array('string');
$meta['breadcrumbHome']         = array('multichoice', '_choices' => array('none', 'page title', 'home', 'icon'));

$meta['sidebarShowLeft']        = array('onoff');
$meta['sidebarLeftDismiss']     = array('onoff');
$meta['sidebarLeftSearch']      = array('multichoice', '_choices' => array('none', 'top', 'bottom'));
$meta['sidebarRightShow']       = array('onoff');
$meta['sidebarRightDismiss']    = array('onoff');

$meta['tocFull']                = array('onoff');

$meta['pageToolsHide']          = array('onoff');
$meta['pageToolsHideGuest']     = array('onoff');
$meta['pageToolsHideNoEdit']    = array('onoff');
$meta['pageToolsFooter']        = array('onoff');

$meta['footerCustomMenuText']   = array('string');
$meta['footerSearch']           = array('onoff');

$meta['licenseType']            = array('multichoice', '_choices' => array('none', 'badge', 'button'));
$meta['licenseImageOnly']       = array('onoff');



// $meta['discussionPage']   = array('string');
// $meta['userPage']         = array('string');
// $meta['hideTools']        = array('onoff');
// $meta['navbar']             = array('string');
