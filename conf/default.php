<?php

/**
 * DokuWiki Mikio Template Default Configuration
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

$conf['iconTag']                = 'icon';
$conf['customTheme']            = '';
$conf['showNotifications']      = 'always';
$conf['useLESS']                = 1;
$conf['brandURLGuest']          = '';
$conf['brandURLUser']           = '';
$conf['showLightDark']          = 0;
$conf['autoLightDark']          = 0;
$conf['defaultDark']            = 0;

$conf['navbarUseTitleIcon']     = 1;
$conf['navbarTitleIconHeight']  = '';
$conf['navbarTitleIconWidth']   = '';
$conf['navbarUseTitleText']     = 1;
$conf['navbarUseTaglineText']   = 1;
$conf['navbarCustomMenuText']   = '';

$conf['navbarDWMenuType']       = 'icons';
$conf['navbarDWMenuCombine']    = 'dropdown';

$conf['navbarPosLeft']          = 'custom';
$conf['navbarPosMiddle']        = 'search';
$conf['navbarPosRight']         = 'dokuwiki';
$conf['navbarShowSub']          = 0;

$conf['navbarItemShowCreate']   = 'always';
$conf['navbarItemShowShow']     = 'always';
$conf['navbarItemShowRevs']     = 'always';
$conf['navbarItemShowBacklink'] = 'always';
$conf['navbarItemShowRecent']   = 'always';
$conf['navbarItemShowMedia']    = 'always';
$conf['navbarItemShowIndex']    = 'always';
$conf['navbarItemShowProfile']  = 'always';
$conf['navbarItemShowAdmin']    = 'always';
$conf['navbarItemShowLogin']    = 'always';
$conf['navbarItemShowLogout']   = 'always';

$conf['searchButton']           = 'icon';
$conf['searchUseTypeahead']     = 1;

$conf['heroTitle']              = 1;
$conf['heroImagePropagation']   = 1;

$conf['tagsConsolidate']        = 1;
$conf['tagsShowHero']           = 1;

$conf['breadcrumbHideHome']     = 1;
$conf['breadcrumbPosition']     = 'hero';
$conf['breadcrumbPrefix']       = 0;
$conf['breadcrumbPrefixText']   = 'Trace:';
$conf['breadcrumbSep']          = 0;
$conf['breadcrumbSepText']      = ' » ';

$conf['youarehereHideHome']     = 1;
$conf['youareherePosition']     = 'hero';
$conf['youareherePrefix']       = 0;
$conf['youareherePrefixText']   = 'You are here:';
$conf['youarehereSep']          = 0;
$conf['youarehereSepText']      = ' » ';
$conf['youarehereHome']         = 'page title';
$conf['youarehereShowLast']     = 0;

$conf['sidebarShowLeft']        = 1;
$conf['sidebarAlwaysShowLeft']  = 0;
$conf['sidebarLeftRow1']        = 'logged in user';
$conf['sidebarLeftRow2']        = 'search';
$conf['sidebarLeftRow3']        = 'content';
$conf['sidebarLeftRow4']        = 'none';
$conf['sidebarMobileDefaultCollapse']    = 1;
$conf['sidebarShowRight']       = 1;
$conf['sidebarAlwaysShowRight'] = 0;

$conf['tocFull']                = 0;

$conf['pageToolsFloating']      = 'always';
$conf['pageToolsFooter']        = 'none';

$conf['pageToolsShowCreate']    = 'always';
$conf['pageToolsShowEdit']      = 'always';
$conf['pageToolsShowRevs']      = 'always';
$conf['pageToolsShowBacklink']  = 'always';
$conf['pageToolsShowTop']       = 'always';

$conf['footerPageInfoText']     = '{file} · %lastmod% {date}[LOGGEDIN=[USER= %by% {user}][LOCKED= · %lockedby% {locked}]]';
$conf['footerCustomMenuText']   = '';
$conf['footerSearch']           = 0;
$conf['footerInPage']           = 0;

$conf['licenseType']            = 'badge';
$conf['licenseImageOnly']       = 0;

$conf['includePageUseACL']      = 1;
$conf['includePagePropagate']   = 1;

$conf['stickyTopHeader']        = 0;
$conf['stickyNavbar']           = 0;
$conf['stickyHeader']           = 0;
$conf['stickyLeftSidebar']      = 0;
