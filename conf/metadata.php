<?php

/**
 * DokuWiki Mikio Template Configuration Metadata
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */
$meta['iconTag']                = array('string');
$meta['customTheme']            = array('string');
$meta['showNotifications']      = array('multichoise', '__choices' => array('none', 'admin', 'always'));
$meta['useLESS']                = array('onoff');

$meta['navbarUseTitleIcon']     = array('onoff');
$meta['navbarUseTitleText']     = array('onoff');
$meta['navbarUseTaglineText']   = array('onoff');
$meta['navbarCustomMenuText']   = array('string');


$meta['navbarDWMenuType']       = array('multichoice', '_choices' => array('icons', 'text', 'both'));
$meta['navbarDWMenuCombine']    = array('multichoice', '_choices' => array('seperate', 'dropdown', 'combine'));

$meta['navbarPosLeft']          = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosMiddle']        = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarPosRight']         = array('multichoice', '_choices' => array('none', 'custom', 'search', 'dokuwiki'));
$meta['navbarShowSub']          = array('onoff');

$meta['navbarItemShowCreate']   = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowShow']     = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowRevs']     = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowBacklink'] = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowRecent']   = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowMedia']    = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowIndex']    = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowProfile']  = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowAdmin']    = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['navbarItemShowLogin']    = array('multichoice', '_choices' => array('always', 'never'));
$meta['navbarItemShowLogout']   = array('multichoice', '_choices' => array('always', 'never'));

$meta['searchButton']           = array('multichoice', '_choices' => array('icon', 'text'));

$meta['heroTitle']              = array('onoff');
$meta['heroImagePropagation']   = array('onoff');

$meta['tagsConsolidate']        = array('onoff');

$meta['breadcrumbHideHome']     = array('onoff');
$meta['breadcrumbPosition']     = array('multichoice', '_choices' => array('none', 'top', 'hero', 'page'));
$meta['breadcrumbPrefix']       = array('onoff');
$meta['breadcrumbPrefixText']   = array('string');
$meta['breadcrumbSep']          = array('onoff');
$meta['breadcrumbSepText']      = array('string');

$meta['youarehereHideHome']     = array('onoff');
$meta['youareherePosition']     = array('multichoice', '_choices' => array('none', 'top', 'hero', 'page'));
$meta['youareherePrefix']       = array('onoff');
$meta['youareherePrefixText']   = array('string');
$meta['youarehereSep']          = array('onoff');
$meta['youarehereSepText']      = array('string');
$meta['youarehereHome']         = array('multichoice', '_choices' => array('none', 'page title', 'home', 'icon'));
$meta['youarehereShowLast']     = array('numeric');

$meta['sidebarShowLeft']        = array('onoff');
$meta['sidebarAlwaysShowLeft']  = array('onoff');
$meta['sidebarLeftRow1']        = array('multichoice', '_choices' => array('none', 'logged in user', 'search', 'content', 'tags'));
$meta['sidebarLeftRow2']        = array('multichoice', '_choices' => array('none', 'logged in user', 'search', 'content', 'tags'));
$meta['sidebarLeftRow3']        = array('multichoice', '_choices' => array('none', 'logged in user', 'search', 'content', 'tags'));
$meta['sidebarLeftRow4']        = array('multichoice', '_choices' => array('none', 'logged in user', 'search', 'content', 'tags'));
$meta['sidebarMobileDefaultCollapse']    = array('onoff');
$meta['sidebarShowRight']       = array('onoff');
$meta['sidebarAlwaysShowRight'] = array('onoff');

$meta['tocFull']                = array('onoff');

$meta['pageToolsFloating']      = array('multichoice', '_choices' => array('none', 'page editors', 'always'));
$meta['pageToolsFooter']        = array('multichoice', '_choices' => array('none', 'page editors', 'always'));

$meta['pageToolsShowCreate']    = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['pageToolsShowEdit']      = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['pageToolsShowRevs']      = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['pageToolsShowBacklink']  = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));
$meta['pageToolsShowTop']       = array('multichoice', '_choices' => array('always', 'logged in', 'logged out', 'never'));

$meta['footerCustomMenuText']   = array('string');
$meta['footerSearch']           = array('onoff');
$meta['footerInPage']           = array('onoff');

$meta['licenseType']            = array('multichoice', '_choices' => array('none', 'badge', 'button'));
$meta['licenseImageOnly']       = array('onoff');

$meta['includePageUseACL']      = array('onoff');
$meta['includePagePropagate']   = array('onoff');

$meta['stickyTopHeader']        = array('onoff');
$meta['stickyNavbar']           = array('onoff');
$meta['stickyHeader']           = array('onoff');
