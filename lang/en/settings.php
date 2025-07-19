<?php

/**
 * DokuWiki Mikio Template English Language for Configuration
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

$lang['iconTag']                = 'Tag to use to for icon tags. The default is \'icon\' but this can be changed if 
it conflicts with any plugins. Set to blank to disable icon tags';
$lang['customTheme']            = 'Use a Mikio subtheme installed into the themes directory. Leave blank for the 
detault styling';
$lang['showNotifications']      = 'Where to show site notifications';
$lang['useLESS']                = 'Use the LESS compiler for the mikio stylesheet or direct CSS. Requires PHP ctype 
extensions installed';
$lang['brandURLGuest']          = 'Change the Brand Logo URL for guests. Leave blank for default home URL';
$lang['brandURLUser']           = 'Change the Brand Logo URL for logged in users. Leave blank for default home URL';
$lang['showLightDark']          = 'Show the light/dark toggle in the navbar';
$lang['autoLightDark']          = 'Change light/dark theme based on the system preference';
$lang['defaultDark']            = 'Default to the dark theme for the user';

$lang['navbarUseTitleIcon']     = 'Show the wiki image in the menubar title. Will search for an image named logo 
(png/jpg/gif/svg) in the root or :wiki: namespace or the template/subtheme images directory';
$lang['navbarTitleIconHeight']  = 'Directly set the title icon height. Supports px (default), rem and em units';
$lang['navbarTitleIconWidth']   = 'Directly set the title icon width. Supports px (default), rem and em units';
$lang['navbarUseTitleText']     = 'Show the wiki name in the menubar title. Will also hide the tagline if disabled';
$lang['navbarUseTaglineText']   = 'Show the wiki tag line in the menubar title';
$lang['navbarCustomMenuText']   = 'Allows custom menus in the menubar. The format is url|title seperated by semicolons';

$lang['navbarDWMenuType']       = 'Show Dokuwiki menus as icons, text or both';
$lang['navbarDWMenuCombine']    = 'Show Dokuwiki menus as seperate items, a category dropdown or combined in a 
single menu';

$lang['navbarPosLeft']          = 'Menu to show on the left of the navbar';
$lang['navbarPosMiddle']        = 'Menu to show in the middle of the navbar';
$lang['navbarPosRight']         = 'Menu to show on the right of the navbar';
$lang['navbarShowSub']          = 'Show the sub navbar. This menu displays data from the submenu page searching from 
the current namespace to the root. Recommended to use lists for menu items';

$lang['navbarItemShowCreate']   = 'Show the Create Page menu item';
$lang['navbarItemShowShow']     = 'Show the Show Page menu item';
$lang['navbarItemShowRevs']     = 'Show the Revisions menu item';
$lang['navbarItemShowBacklink'] = 'Show the Backlinks menu item';
$lang['navbarItemShowRecent']   = 'Show the Recent Changes menu item';
$lang['navbarItemShowMedia']    = 'Show the Media Manager menu item';
$lang['navbarItemShowIndex']    = 'Show the Sitemap menu item';
$lang['navbarItemShowProfile']  = 'Show the Update Profile menu item';
$lang['navbarItemShowAdmin']    = 'Show the Admin menu item';
$lang['navbarItemShowLogin']    = 'Show the Login menu item';
$lang['navbarItemShowLogout']   = 'Show the Logout menu item';

$lang['searchButton']           = 'Search button type';
$lang['searchUseTypeahead']     = 'Use Typeahead page suggestions in search bar';

$lang['heroTitle']              = 'Show pages in the hero title style';
$lang['heroImagePropagation']   = 'Search for hero images in the parent namespace if no hero image is found';

$lang['tagsConsolidate']        = 'Consolidate page tags to hero, content header or sidebar';
$lang['tagsShowHero']           = 'Show tags in the page hero';

$lang['breadcrumbHideHome']     = 'Hide breadcrumb block on home page';
$lang['breadcrumbPosition']     = 'Position of the breadcrumb bar on the page';
$lang['breadcrumbPrefix']       = 'Change the breadcrumb prefix text';
$lang['breadcrumbPrefixText']   = 'Replacement breadcrumb prefix text. You can use an image by uploading 
breadcrumb-prefix.png to the template\'s images directory';
$lang['breadcrumbSep']          = 'Change the breadcrumb seperator text';
$lang['breadcrumbSepText']      = 'Replacement breadcrumb seperator text. You can use an image by uploading 
breadcrumb-sep.png to the template\'s images directory';

$lang['youarehereHideHome']     = 'Hide you are here on home page';
$lang['youareherePosition']     = 'Position of the you are here bar on the page';
$lang['youareherePrefix']       = 'Change the you are here prefix text';
$lang['youareherePrefixText']   = 'Replacement you are here prefix text. You can use an image by uploading 
youarehere-prefix.png to the template\'s images directory';
$lang['youarehereSep']          = 'Change the you are here seperator text';
$lang['youarehereSepText']      = 'Replacement you are here seperator text. You can use an image by uploading 
youarehere-sep.png to the template\'s images directory';
$lang['youarehereHome']         = 'Change the text or icon used for the Home page in the breadcrumb bar';
$lang['youarehereShowLast']     = 'Only show the last amount of breadcrumbs. Set to 0 to show all';

$lang['sidebarShowLeft']        = 'Show the left sidebar';
$lang['sidebarAlwaysShowLeft']  = 'Always show the left sidebar, even when there is no content';
$lang['sidebarLeftRow1']        = 'Content to show in the first row on the left sidebar';
$lang['sidebarLeftRow2']        = 'Content to show in the second row on the left sidebar';
$lang['sidebarLeftRow3']        = 'Content to show in the third row on the left sidebar';
$lang['sidebarLeftRow4']        = 'Content to show in the forth row on the left sidebar';
$lang['sidebarMobileDefaultCollapse']    = 'Hide the sidebars by default when in mobile view';
$lang['sidebarShowRight']       = 'Show the right sidebar';
$lang['sidebarAlwaysShowRight'] = 'Always show the right sidebar, even when there is no content';

$lang['tocFull']                = 'Show the TOC as a full height element';

$lang['pageToolsFloating']      = 'When to show the floating page toolbar';
$lang['pageToolsFooter']        = 'When to show the footer page toolbar';

$lang['pageToolsShowCreate']    = 'Show the Create Page item';
$lang['pageToolsShowEdit']      = 'Show the Edit Page item';
$lang['pageToolsShowRevs']      = 'Show the Revisions item';
$lang['pageToolsShowBacklink']  = 'Show the Backlinks item';
$lang['pageToolsShowTop']       = 'Show the Back to Top item';

$lang['footerPageInfoText']     = 'Customize the page info in the footer';
$lang['footerCustomMenuText']   = 'Allows custom menus in the footer. The format is url|title seperated by ;';
$lang['footerSearch']           = 'Show the search bar in the footer';
$lang['footerInPage']           = 'Show the wiki footer in the article. Bottom footer remains on page';

$lang['licenseType']            = 'Show the footer license as none, badges or buttons';
$lang['licenseImageOnly']       = 'Show the footer license as images only';

$lang['includePageUseACL']      = 'Respect ACL when including pages';
$lang['includePagePropagate']   = 'Search higher namespaces when including pages';

$lang['stickyTopHeader']        = 'Make the top header part sticky';
$lang['stickyNavbar']           = 'Make the navbar sticky';
$lang['stickyHeader']           = 'Make the header part sticky';
$lang['stickyLeftSidebar']      = 'Make the left sidebar sticky';

$lang['showNotifications_o_never']      = 'never';
$lang['showNotifications_o_admin']      = 'admin';
$lang['showNotifications_o_always']      = 'always';

$lang['navbarDWMenuType_o_icons'] = 'icons';
$lang['navbarDWMenuType_o_text'] = 'text';
$lang['navbarDWMenuType_o_both'] = 'both';

$lang['navbarDWMenuCombine_o_separate'] = 'separate';
$lang['navbarDWMenuCombine_o_dropdown'] = 'dropdown';
$lang['navbarDWMenuCombine_o_combine'] = 'combine';

$lang['navbarPosLeft_o_none'] = 'none';
$lang['navbarPosLeft_o_custom'] = 'custom';
$lang['navbarPosLeft_o_search'] = 'search';
$lang['navbarPosLeft_o_dokuwiki'] = 'dokuwiki';

$lang['navbarPosMiddle_o_none'] = 'none';
$lang['navbarPosMiddle_o_custom'] = 'custom';
$lang['navbarPosMiddle_o_search'] = 'search';
$lang['navbarPosMiddle_o_dokuwiki'] = 'dokuwiki';

$lang['navbarPosRight_o_none'] = 'none';
$lang['navbarPosRight_o_custom'] = 'custom';
$lang['navbarPosRight_o_search'] = 'search';
$lang['navbarPosRight_o_dokuwiki'] = 'dokuwiki';

$lang['navbarItemShowCreate_o_always'] = 'always';
$lang['navbarItemShowCreate_o_logged in'] = 'logged in';
$lang['navbarItemShowCreate_o_logged out'] = 'logged out';
$lang['navbarItemShowCreate_o_never'] = 'never';

$lang['navbarItemShowShow_o_always'] = 'always';
$lang['navbarItemShowShow_o_logged in'] = 'logged in';
$lang['navbarItemShowShow_o_logged out'] = 'logged out';
$lang['navbarItemShowShow_o_never'] = 'never';

$lang['navbarItemShowRevs_o_always'] = 'always';
$lang['navbarItemShowRevs_o_logged in'] = 'logged in';
$lang['navbarItemShowRevs_o_logged out'] = 'logged out';
$lang['navbarItemShowRevs_o_never'] = 'never';

$lang['navbarItemShowBacklink_o_always'] = 'always';
$lang['navbarItemShowBacklink_o_logged in'] = 'logged in';
$lang['navbarItemShowBacklink_o_logged out'] = 'logged out';
$lang['navbarItemShowBacklink_o_never'] = 'never';

$lang['navbarItemShowRecent_o_always'] = 'always';
$lang['navbarItemShowRecent_o_logged in'] = 'logged in';
$lang['navbarItemShowRecent_o_logged out'] = 'logged out';
$lang['navbarItemShowRecent_o_never'] = 'never';

$lang['navbarItemShowMedia_o_always'] = 'always';
$lang['navbarItemShowMedia_o_logged in'] = 'logged in';
$lang['navbarItemShowMedia_o_logged out'] = 'logged out';
$lang['navbarItemShowMedia_o_never'] = 'never';

$lang['navbarItemShowIndex_o_always'] = 'always';
$lang['navbarItemShowIndex_o_logged in'] = 'logged in';
$lang['navbarItemShowIndex_o_logged out'] = 'logged out';
$lang['navbarItemShowIndex_o_never'] = 'never';

$lang['navbarItemShowProfile_o_always'] = 'always';
$lang['navbarItemShowProfile_o_logged in'] = 'logged in';
$lang['navbarItemShowProfile_o_logged out'] = 'logged out';
$lang['navbarItemShowProfile_o_never'] = 'never';

$lang['navbarItemShowAdmin_o_always'] = 'always';
$lang['navbarItemShowAdmin_o_logged in'] = 'logged in';
$lang['navbarItemShowAdmin_o_logged out'] = 'logged out';
$lang['navbarItemShowAdmin_o_never'] = 'never';

$lang['navbarItemShowLogin_o_always'] = 'always';
$lang['navbarItemShowLogin_o_never'] = 'never';

$lang['navbarItemShowLogout_o_always'] = 'always';
$lang['navbarItemShowLogout_o_never'] = 'never';

$lang['searchButton_o_icon'] = 'icon';
$lang['searchButton_o_text'] = 'text';

$lang['breadcrumbPosition_o_none'] = 'none';
$lang['breadcrumbPosition_o_top'] = 'top';
$lang['breadcrumbPosition_o_hero'] = 'hero';
$lang['breadcrumbPosition_o_page'] = 'page';

$lang['youareherePosition_o_none'] = 'none';
$lang['youareherePosition_o_top'] = 'top';
$lang['youareherePosition_o_hero'] = 'hero';
$lang['youareherePosition_o_page'] = 'page';

$lang['youarehereHome_o_none'] = 'none';
$lang['youarehereHome_o_page title'] = 'page title';
$lang['youarehereHome_o_home'] = 'home';
$lang['youarehereHome_o_icon'] = 'icon';

$lang['sidebarLeftRow1_o_none'] = 'none';
$lang['sidebarLeftRow1_o_logged in user'] = 'logged in user';
$lang['sidebarLeftRow1_o_search'] = 'search';
$lang['sidebarLeftRow1_o_content'] = 'content';
$lang['sidebarLeftRow1_o_tags'] = 'tags';

$lang['sidebarLeftRow2_o_none'] = 'none';
$lang['sidebarLeftRow2_o_logged in user'] = 'logged in user';
$lang['sidebarLeftRow2_o_search'] = 'search';
$lang['sidebarLeftRow2_o_content'] = 'content';
$lang['sidebarLeftRow2_o_tags'] = 'tags';

$lang['sidebarLeftRow3_o_none'] = 'none';
$lang['sidebarLeftRow3_o_logged in user'] = 'logged in user';
$lang['sidebarLeftRow3_o_search'] = 'search';
$lang['sidebarLeftRow3_o_content'] = 'content';
$lang['sidebarLeftRow3_o_tags'] = 'tags';

$lang['sidebarLeftRow4_o_none'] = 'none';
$lang['sidebarLeftRow4_o_logged in user'] = 'logged in user';
$lang['sidebarLeftRow4_o_search'] = 'search';
$lang['sidebarLeftRow4_o_content'] = 'content';
$lang['sidebarLeftRow4_o_tags'] = 'tags';

$lang['pageToolsFloating_o_none'] = 'none';
$lang['pageToolsFloating_o_page editors'] = 'page editors';
$lang['pageToolsFloating_o_always'] = 'always';

$lang['pageToolsFooter_o_none'] = 'none';
$lang['pageToolsFooter_o_page editors'] = 'page editors';
$lang['pageToolsFooter_o_always'] = 'always';

$lang['pageToolsShowCreate_o_always'] = 'always';
$lang['pageToolsShowCreate_o_logged in'] = 'logged in';
$lang['pageToolsShowCreate_o_logged out'] = 'logged out';
$lang['pageToolsShowCreate_o_never'] = 'never';

$lang['pageToolsShowEdit_o_always'] = 'always';
$lang['pageToolsShowEdit_o_logged in'] = 'logged in';
$lang['pageToolsShowEdit_o_logged out'] = 'logged out';
$lang['pageToolsShowEdit_o_never'] = 'never';

$lang['pageToolsShowRevs_o_always'] = 'always';
$lang['pageToolsShowRevs_o_logged in'] = 'logged in';
$lang['pageToolsShowRevs_o_logged out'] = 'logged out';
$lang['pageToolsShowRevs_o_never'] = 'never';

$lang['pageToolsShowBacklink_o_always'] = 'always';
$lang['pageToolsShowBacklink_o_logged in'] = 'logged in';
$lang['pageToolsShowBacklink_o_logged out'] = 'logged out';
$lang['pageToolsShowBacklink_o_never'] = 'never';

$lang['pageToolsShowTop_o_always'] = 'always';
$lang['pageToolsShowTop_o_logged in'] = 'logged in';
$lang['pageToolsShowTop_o_logged out'] = 'logged out';
$lang['pageToolsShowTop_o_never'] = 'never';

$lang['licenseType_o_none'] = 'none';
$lang['licenseType_o_badge'] = 'badge';
$lang['licenseType_o_button'] = 'button';
