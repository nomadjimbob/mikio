<?php

/**
 * DokuWiki Mikio Template Configuration Metadata
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

$meta['iconTag']                = ['string'];
$meta['customTheme']            = ['string'];
$meta['showNotifications']      = ['multichoice', '_choices' => ['never', 'admin', 'always']];
$meta['useLESS']                = ['onoff'];
$meta['brandURLGuest']          = ['string'];
$meta['brandURLUser']           = ['string'];
$meta['showLightDark']          = ['onoff'];
$meta['autoLightDark']          = ['onoff'];
$meta['defaultDark']            = ['onoff'];

$meta['navbarUseTitleIcon']     = ['onoff'];
$meta['navbarTitleIconHeight']  = ['string'];
$meta['navbarTitleIconWidth']   = ['string'];
$meta['navbarUseTitleText']     = ['onoff'];
$meta['navbarUseTaglineText']   = ['onoff'];
$meta['navbarCustomMenuText']   = ['string'];

$meta['navbarDWMenuType']       = ['multichoice', '_choices' => ['icons', 'text', 'both']];
$meta['navbarDWMenuCombine']    = ['multichoice', '_choices' => ['separate', 'dropdown', 'combine']];

$meta['navbarPosLeft']          = ['multichoice', '_choices' => ['none', 'custom', 'search', 'dokuwiki']];
$meta['navbarPosMiddle']        = ['multichoice', '_choices' => ['none', 'custom', 'search', 'dokuwiki']];
$meta['navbarPosRight']         = ['multichoice', '_choices' => ['none', 'custom', 'search', 'dokuwiki']];
$meta['navbarShowSub']          = ['onoff'];

$meta['navbarItemShowCreate']   = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowShow']     = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowRevs']     = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowBacklink'] = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowRecent']   = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowMedia']    = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowIndex']    = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowProfile']  = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowAdmin']    = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['navbarItemShowLogin']    = ['multichoice', '_choices' => ['always', 'never']];
$meta['navbarItemShowLogout']   = ['multichoice', '_choices' => ['always', 'never']];

$meta['searchButton']           = ['multichoice', '_choices' => ['icon', 'text']];
$meta['searchUseTypeahead']     = ['onoff'];

$meta['heroTitle']              = ['onoff'];
$meta['heroImagePropagation']   = ['onoff'];

$meta['tagsConsolidate']        = ['onoff'];
$meta['tagsShowHero']           = ['onoff'];

$meta['breadcrumbHideHome']     = ['onoff'];
$meta['breadcrumbPosition']     = ['multichoice', '_choices' => ['none', 'top', 'hero', 'page']];
$meta['breadcrumbPrefix']       = ['onoff'];
$meta['breadcrumbPrefixText']   = ['string'];
$meta['breadcrumbSep']          = ['onoff'];
$meta['breadcrumbSepText']      = ['string'];

$meta['youarehereHideHome']     = ['onoff'];
$meta['youareherePosition']     = ['multichoice', '_choices' => ['none', 'top', 'hero', 'page']];
$meta['youareherePrefix']       = ['onoff'];
$meta['youareherePrefixText']   = ['string'];
$meta['youarehereSep']          = ['onoff'];
$meta['youarehereSepText']      = ['string'];
$meta['youarehereHome']         = ['multichoice', '_choices' => ['none', 'page title', 'home', 'icon']];
$meta['youarehereShowLast']     = ['numeric'];

$meta['sidebarShowLeft']        = ['onoff'];
$meta['sidebarAlwaysShowLeft']  = ['onoff'];
$meta['sidebarLeftRow1']        = ['multichoice', '_choices' => ['none', 'logged in user', 'search', 'content', 'tags']
];
$meta['sidebarLeftRow2']        = ['multichoice', '_choices' => ['none', 'logged in user', 'search', 'content', 'tags']
];
$meta['sidebarLeftRow3']        = ['multichoice', '_choices' => ['none', 'logged in user', 'search', 'content', 'tags']
];
$meta['sidebarLeftRow4']        = ['multichoice', '_choices' => ['none', 'logged in user', 'search', 'content', 'tags']
];
$meta['sidebarMobileDefaultCollapse']    = ['onoff'];
$meta['sidebarShowRight']       = ['onoff'];
$meta['sidebarAlwaysShowRight'] = ['onoff'];

$meta['tocFull']                = ['onoff'];

$meta['pageToolsFloating']      = ['multichoice', '_choices' => ['none', 'page editors', 'always']];
$meta['pageToolsFooter']        = ['multichoice', '_choices' => ['none', 'page editors', 'always']];

$meta['pageToolsShowCreate']    = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['pageToolsShowEdit']      = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['pageToolsShowRevs']      = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['pageToolsShowBacklink']  = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];
$meta['pageToolsShowTop']       = ['multichoice', '_choices' => ['always', 'logged in', 'logged out', 'never']];

$meta['footerPageInfoText']     = ['string'];
$meta['footerCustomMenuText']   = ['string'];
$meta['footerSearch']           = ['onoff'];
$meta['footerInPage']           = ['onoff'];

$meta['licenseType']            = ['multichoice', '_choices' => ['none', 'badge', 'button']];
$meta['licenseImageOnly']       = ['onoff'];

$meta['includePageUseACL']      = ['onoff'];
$meta['includePagePropagate']   = ['onoff'];

$meta['stickyTopHeader']        = ['onoff'];
$meta['stickyNavbar']           = ['onoff'];
$meta['stickyHeader']           = ['onoff'];
$meta['stickyLeftSidebar']      = ['onoff'];
