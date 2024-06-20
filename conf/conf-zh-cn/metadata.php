<?php

/**
 * DokuWiki Mikio Template Configuration Metadata(Chinese Simplified)
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  Little-Data <https://github.com/Little-Data>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

$meta['iconTag']                = ['string'];
$meta['customTheme']            = ['string'];
$meta['showNotifications']      = ['multichoice', '__choices' => ['从不', '管理页面', '总是']];
$meta['useLESS']                = ['onoff'];
$meta['brandURLGuest']          = ['string'];
$meta['brandURLUser']           = ['string'];
$meta['showLightDark']          = ['onoff'];
$meta['autoLightDark']          = ['onoff'];

$meta['navbarUseTitleIcon']     = ['onoff'];
$meta['navbarTitleIconHeight']  = ['string'];
$meta['navbarTitleIconWidth']   = ['string'];
$meta['navbarUseTitleText']     = ['onoff'];
$meta['navbarUseTaglineText']   = ['onoff'];
$meta['navbarCustomMenuText']   = ['string'];

$meta['navbarDWMenuType']       = ['multichoice', '_choices' => ['图标', '文本', '图标与文本']];
$meta['navbarDWMenuCombine']    = ['multichoice', '_choices' => ['分离式', '下拉式', '组合式']];

$meta['navbarPosLeft']          = ['multichoice', '_choices' => ['无', '自定义', '搜索', 'dokuwiki']];
$meta['navbarPosMiddle']        = ['multichoice', '_choices' => ['无', '自定义', '搜索', 'dokuwiki']];
$meta['navbarPosRight']         = ['multichoice', '_choices' => ['无', '自定义', '搜索', 'dokuwiki']];
$meta['navbarShowSub']          = ['onoff'];

$meta['navbarItemShowCreate']   = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowShow']     = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowRevs']     = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowBacklink'] = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowRecent']   = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowMedia']    = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowIndex']    = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowProfile']  = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowAdmin']    = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['navbarItemShowLogin']    = ['multichoice', '_choices' => ['总是', '从不']];
$meta['navbarItemShowLogout']   = ['multichoice', '_choices' => ['总是', '从不']];

$meta['searchButton']           = ['multichoice', '_choices' => ['图标', '文本']];
$meta['searchUseTypeahead']     = ['onoff'];

$meta['heroTitle']              = ['onoff'];
$meta['heroImagePropagation']   = ['onoff'];

$meta['tagsConsolidate']        = ['onoff'];
$meta['tagsShowHero']           = ['onoff'];

$meta['breadcrumbHideHome']     = ['onoff'];
$meta['breadcrumbPosition']     = ['multichoice', '_choices' => ['无', '顶部', '页面大标题', '页面']];
$meta['breadcrumbPrefix']       = ['onoff'];
$meta['breadcrumbPrefixText']   = ['string'];
$meta['breadcrumbSep']          = ['onoff'];
$meta['breadcrumbSepText']      = ['string'];

$meta['youarehereHideHome']     = ['onoff'];
$meta['youareherePosition']     = ['multichoice', '_choices' => ['无', '顶部', '页面大标题', '页面']];
$meta['youareherePrefix']       = ['onoff'];
$meta['youareherePrefixText']   = ['string'];
$meta['youarehereSep']          = ['onoff'];
$meta['youarehereSepText']      = ['string'];
$meta['youarehereHome']         = ['multichoice', '_choices' => ['无', '页面标题', '首页', '图标']];
$meta['youarehereShowLast']     = ['numeric'];

$meta['sidebarShowLeft']        = ['onoff'];
$meta['sidebarAlwaysShowLeft']  = ['onoff'];
$meta['sidebarLeftRow1']        = ['multichoice', '_choices' => ['无', '已登录用户', '搜索', '内容', '标签']
];
$meta['sidebarLeftRow2']        = ['multichoice', '_choices' => ['无', '已登录用户', '搜索', '内容', '标签']
];
$meta['sidebarLeftRow3']        = ['multichoice', '_choices' => ['无', '已登录用户', '搜索', '内容', '标签']
];
$meta['sidebarLeftRow4']        = ['multichoice', '_choices' => ['无', '已登录用户', '搜索', '内容', '标签']
];
$meta['sidebarMobileDefaultCollapse']    = ['onoff'];
$meta['sidebarShowRight']       = ['onoff'];
$meta['sidebarAlwaysShowRight'] = ['onoff'];

$meta['tocFull']                = ['onoff'];

$meta['pageToolsFloating']      = ['multichoice', '_choices' => ['无', '页面编辑者', '总是']];
$meta['pageToolsFooter']        = ['multichoice', '_choices' => ['无', '页面编辑者', '总是']];

$meta['pageToolsShowCreate']    = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['pageToolsShowEdit']      = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['pageToolsShowRevs']      = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['pageToolsShowBacklink']  = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];
$meta['pageToolsShowTop']       = ['multichoice', '_choices' => ['总是', '登录', '退出登录', '从不']];

$meta['footerPageInfoText']     = ['string'];
$meta['footerCustomMenuText']   = ['string'];
$meta['footerSearch']           = ['onoff'];
$meta['footerInPage']           = ['onoff'];

$meta['licenseType']            = ['multichoice', '_choices' => ['无', '徽章', '按钮']];
$meta['licenseImageOnly']       = ['onoff'];

$meta['includePageUseACL']      = ['onoff'];
$meta['includePagePropagate']   = ['onoff'];

$meta['stickyTopHeader']        = ['onoff'];
$meta['stickyNavbar']           = ['onoff'];
$meta['stickyHeader']           = ['onoff'];
$meta['stickyLeftSidebar']      = ['onoff'];
