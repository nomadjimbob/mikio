<?php

/**
 * DokuWiki Mikio Template Chinese Simplified Language for Configuration
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  Little-Data <https://github.com/Little-Data>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

$lang['iconTag']                = '用于图标标记的标签。默认值是 \'icon\' ，但如果与任何插件冲突，也可以更改。留空则禁用图标标签';
$lang['customTheme']            = '使用安装在主题目录下的 Mikio 子主题。留空使用默认样式';
$lang['showNotifications']      = '在哪里显示网站通知';
$lang['useLESS']                = '使用 LESS 编译器编译 mikio 样式表或直接使用 CSS。需要安装 PHP ctype 扩展';
$lang['brandURLGuest']          = '为访客更改徽标 URL。留空使用默认主页 URL';
$lang['brandURLUser']           = '为登录用户更改徽标 URL。留空使用默认主页 URL';
$lang['showLightDark']          = '在导航栏显示明暗切换按钮';
$lang['autoLightDark']          = '根据系统主题更改明暗主题';
$lang['defaultDark']            = '默认为用户使用深色主题'; // added by nomadjimbob using translate.google.com

$lang['navbarUseTitleIcon']     = '在菜单栏标题中显示维基图片。将在根目录或 :wiki: 命名空间或模板/子主题图片目录中搜索名为logo的图片（png/jpg/gif/svg）。';
$lang['navbarTitleIconHeight']  = '直接设置标题图标高度。支持 像素px（默认）、相对单位rem 和 相对长度单位em';
$lang['navbarTitleIconWidth']   = '直接设置标题图标宽度。支持 像素px（默认）、相对单位rem 和 相对长度单位em';
$lang['navbarUseTitleText']     = '在菜单栏标题中显示维基名称。如果禁用，还会隐藏标语';
$lang['navbarUseTaglineText']   = '在菜单栏标题中显示维基标签行';
$lang['navbarCustomMenuText']   = '允许在菜单栏中自定义菜单。格式为：url|标题，以英文分号隔开';

$lang['navbarDWMenuType']       = '以图标、文本或两种形式显示 Dokuwiki 菜单';
$lang['navbarDWMenuCombine']    = '将 Dokuwiki 菜单显示为独立项目、类别下拉菜单或合并为单一菜单';

$lang['navbarPosLeft']          = '显示左侧导航栏菜单';
$lang['navbarPosMiddle']        = '显示中部导航栏菜单';
$lang['navbarPosRight']         = '显示右侧导航栏菜单';
$lang['navbarShowSub']          = '显示子导航栏。该菜单显示子菜单页面从当前命名空间搜索到根目录的数据。建议使用列表显示菜单项';

$lang['navbarItemShowCreate']   = '显示创建页面菜单项';
$lang['navbarItemShowShow']     = '显示“显示页面”菜单项';
$lang['navbarItemShowRevs']     = '显示修订菜单项';
$lang['navbarItemShowBacklink'] = '显示反向链接菜单项';
$lang['navbarItemShowRecent']   = '显示最近更改菜单项';
$lang['navbarItemShowMedia']    = '显示媒体管理器菜单项';
$lang['navbarItemShowIndex']    = '显示网站地图菜单项';
$lang['navbarItemShowProfile']  = '显示更新个人信息菜单项';
$lang['navbarItemShowAdmin']    = '显示管理菜单项';
$lang['navbarItemShowLogin']    = '显示登录菜单项';
$lang['navbarItemShowLogout']   = '显示退出登录菜单项';

$lang['searchButton']           = '搜索按钮类型';
$lang['searchUseTypeahead']     = '在搜索栏中使用 Typeahead 页面建议';

$lang['heroTitle']              = '以顶部大标题样式显示页面';
$lang['heroImagePropagation']   = '如果没有找到顶部大标题图像，则在父命名空间中搜索顶部大标题图像';

$lang['tagsConsolidate']        = '将页面标签合并到标题、内容标题或侧边栏中';
$lang['tagsShowHero']           = '在页面顶部大标题中显示标签';

$lang['breadcrumbHideHome']     = '隐藏主页上的页面踪迹';
$lang['breadcrumbPosition']     = '页面踪迹栏在页面上的位置';
$lang['breadcrumbPrefix']       = '更改页面踪迹前缀文本';
$lang['breadcrumbPrefixText']   = '替换页面踪迹前缀文本。可以使用一张图片，将 breadcrumb-prefix.png 上传到模板的images目录中';
$lang['breadcrumbSep']          = '更改页面踪迹分隔符文本';
$lang['breadcrumbSepText']      = '更改页面踪迹分隔符文本。可以使用一张图片，将 breadcrumb-sep.png 上传到模板的images目录中';

$lang['youarehereHideHome']     = '在主页上隐藏您在这里';
$lang['youareherePosition']     = '“您在这里”在页面上的位置';
$lang['youareherePrefix']       = '更改“您在这里”前缀文本';
$lang['youareherePrefixText']   = '更改“您在这里”前缀文本。可以使用一张图片，将 youarehere-prefix.png 上传到模板的images目录中';
$lang['youarehereSep']          = '更改“您在这里”分隔符文本';
$lang['youarehereSepText']      = '更改“您在这里”分隔符文本。可以使用一张图片，将 youarehere-sep.png 上传到模板的images目录中';
$lang['youarehereHome']         = '更改页面踪迹栏中用于主页的文字或图标';
$lang['youarehereShowLast']     = '显示最后的页面踪迹数量。设置为0则显示全部';

$lang['sidebarShowLeft']        = '显示左侧边栏';
$lang['sidebarAlwaysShowLeft']  = '即使没有内容，也始终显示左侧边栏';
$lang['sidebarLeftRow1']        = '显示在左侧边栏第一行的内容';
$lang['sidebarLeftRow2']        = '显示在左侧边栏第二行的内容';
$lang['sidebarLeftRow3']        = '显示在左侧边栏第三行显示内容';
$lang['sidebarLeftRow4']        = '显示在左侧边栏第四行显示内容';
$lang['sidebarMobileDefaultCollapse']    = '在移动视图中默认隐藏边栏';
$lang['sidebarShowRight']       = '显示右侧边栏';
$lang['sidebarAlwaysShowRight'] = '即使没有内容，也始终显示右侧边栏';

$lang['tocFull']                = '将页面目录显示为全高元素';

$lang['pageToolsFloating']      = '何时显示浮动页面工具栏';
$lang['pageToolsFooter']        = '何时显示页脚工具栏';

$lang['pageToolsShowCreate']    = '显示创建页面项目';
$lang['pageToolsShowEdit']      = '显示编辑页面项目';
$lang['pageToolsShowRevs']      = '显示修订项目';
$lang['pageToolsShowBacklink']  = '显示反向链接项目';
$lang['pageToolsShowTop']       = '显示返回顶部按钮';

$lang['footerPageInfoText']     = '自定义页脚信息';
$lang['footerCustomMenuText']   = '允许在页脚自定义菜单。格式为：url|标题，中间用 ; 分隔';
$lang['footerSearch']           = '在页脚显示搜索栏';
$lang['footerInPage']           = '在文章中显示维基页脚。页脚保留在页面底部';

$lang['licenseType']            = '将页脚许可证显示为无、徽章或按钮';
$lang['licenseImageOnly']       = '仅以图片形式显示页脚许可';

$lang['includePageUseACL']      = '包含页面时遵循 ACL';
$lang['includePagePropagate']   = '在包含页面时搜索更高的命名空间';

$lang['stickyTopHeader']        = '使顶部标题部分具有粘性';
$lang['stickyNavbar']           = '使导航栏具有粘性';
$lang['stickyHeader']           = '使标题部分具有粘性';
$lang['stickyLeftSidebar']      = '使左侧边栏具有粘性';

$lang['showNotifications_o_never']      = '从不';
$lang['showNotifications_o_admin']      = '管理员';
$lang['showNotifications_o_always']      = '总是';

$lang['navbarDWMenuType_o_icons'] = '图标';
$lang['navbarDWMenuType_o_text'] = '文本';
$lang['navbarDWMenuType_o_both'] = '两个都要';

$lang['navbarDWMenuCombine_o_separate'] = '分离式';
$lang['navbarDWMenuCombine_o_dropdown'] = '下拉式';
$lang['navbarDWMenuCombine_o_combine'] = '组合';

$lang['navbarPosLeft_o_none'] = '无';
$lang['navbarPosLeft_o_custom'] = '自定义';
$lang['navbarPosLeft_o_search'] = '搜索';
$lang['navbarPosLeft_o_dokuwiki'] = 'dokuwiki';

$lang['navbarPosMiddle_o_none'] = '无';
$lang['navbarPosMiddle_o_custom'] = '自定义';
$lang['navbarPosMiddle_o_search'] = '搜索';
$lang['navbarPosMiddle_o_dokuwiki'] = 'dokuwiki';

$lang['navbarPosRight_o_none'] = '无';
$lang['navbarPosRight_o_custom'] = '自定义';
$lang['navbarPosRight_o_search'] = '搜索';
$lang['navbarPosRight_o_dokuwiki'] = 'dokuwiki';

$lang['navbarItemShowCreate_o_always'] = '总是';
$lang['navbarItemShowCreate_o_logged in'] = '已登录';
$lang['navbarItemShowCreate_o_logged out'] = '已退出登录';
$lang['navbarItemShowCreate_o_never'] = '从不';

$lang['navbarItemShowShow_o_always'] = '总是';
$lang['navbarItemShowShow_o_logged in'] = '已登录';
$lang['navbarItemShowShow_o_logged out'] = '已退出登录';
$lang['navbarItemShowShow_o_never'] = '从不';

$lang['navbarItemShowRevs_o_always'] = '总是';
$lang['navbarItemShowRevs_o_logged in'] = '已登录';
$lang['navbarItemShowRevs_o_logged out'] = '已退出登录';
$lang['navbarItemShowRevs_o_never'] = '从不';

$lang['navbarItemShowBacklink_o_always'] = '总是';
$lang['navbarItemShowBacklink_o_logged in'] = '已登录';
$lang['navbarItemShowBacklink_o_logged out'] = '已退出登录';
$lang['navbarItemShowBacklink_o_never'] = '从不';

$lang['navbarItemShowRecent_o_always'] = '总是';
$lang['navbarItemShowRecent_o_logged in'] = '已登录';
$lang['navbarItemShowRecent_o_logged out'] = '已退出登录';
$lang['navbarItemShowRecent_o_never'] = '从不';

$lang['navbarItemShowMedia_o_always'] = '总是';
$lang['navbarItemShowMedia_o_logged in'] = '已登录';
$lang['navbarItemShowMedia_o_logged out'] = '已退出登录';
$lang['navbarItemShowMedia_o_never'] = '从不';

$lang['navbarItemShowIndex_o_always'] = '总是';
$lang['navbarItemShowIndex_o_logged in'] = '已登录';
$lang['navbarItemShowIndex_o_logged out'] = '已退出登录';
$lang['navbarItemShowIndex_o_never'] = '从不';

$lang['navbarItemShowProfile_o_always'] = '总是';
$lang['navbarItemShowProfile_o_logged in'] = '已登录';
$lang['navbarItemShowProfile_o_logged out'] = '已退出登录';
$lang['navbarItemShowProfile_o_never'] = '从不';

$lang['navbarItemShowAdmin_o_always'] = '总是';
$lang['navbarItemShowAdmin_o_logged in'] = '已登录';
$lang['navbarItemShowAdmin_o_logged out'] = '已退出登录';
$lang['navbarItemShowAdmin_o_never'] = '从不';

$lang['navbarItemShowLogin_o_always'] = '总是';
$lang['navbarItemShowLogin_o_never'] = '从不';

$lang['navbarItemShowLogout_o_always'] = '总是';
$lang['navbarItemShowLogout_o_never'] = '从不';

$lang['searchButton_o_icon'] = '图标';
$lang['searchButton_o_text'] = '文本';

$lang['breadcrumbPosition_o_none'] = '无';
$lang['breadcrumbPosition_o_top'] = '顶部';
$lang['breadcrumbPosition_o_hero'] = '顶部大标题';
$lang['breadcrumbPosition_o_page'] = '页面';

$lang['youareherePosition_o_none'] = '无';
$lang['youareherePosition_o_top'] = '顶部';
$lang['youareherePosition_o_hero'] = '顶部大标题';
$lang['youareherePosition_o_page'] = '页面';

$lang['youarehereHome_o_none'] = '无';
$lang['youarehereHome_o_page title'] = '页面标题';
$lang['youarehereHome_o_home'] = '首页';
$lang['youarehereHome_o_icon'] = '图标';

$lang['sidebarLeftRow1_o_none'] = '无';
$lang['sidebarLeftRow1_o_logged in user'] = '登录的用户';
$lang['sidebarLeftRow1_o_search'] = '搜索';
$lang['sidebarLeftRow1_o_content'] = '内容';
$lang['sidebarLeftRow1_o_tags'] = '标签';

$lang['sidebarLeftRow2_o_none'] = '无';
$lang['sidebarLeftRow2_o_logged in user'] = '登录的用户';
$lang['sidebarLeftRow2_o_search'] = '搜索';
$lang['sidebarLeftRow2_o_content'] = '内容';
$lang['sidebarLeftRow2_o_tags'] = '标签';

$lang['sidebarLeftRow3_o_none'] = '无';
$lang['sidebarLeftRow3_o_logged in user'] = '登录的用户';
$lang['sidebarLeftRow3_o_search'] = '搜索';
$lang['sidebarLeftRow3_o_content'] = '内容';
$lang['sidebarLeftRow3_o_tags'] = '标签';

$lang['sidebarLeftRow4_o_none'] = '无';
$lang['sidebarLeftRow4_o_logged in user'] = '登录的用户';
$lang['sidebarLeftRow4_o_search'] = '搜索';
$lang['sidebarLeftRow4_o_content'] = '内容';
$lang['sidebarLeftRow4_o_tags'] = '标签';

$lang['pageToolsFloating_o_none'] = '无';
$lang['pageToolsFloating_o_page editors'] = '页面编辑者';
$lang['pageToolsFloating_o_always'] = '总是';

$lang['pageToolsFooter_o_none'] = '无';
$lang['pageToolsFooter_o_page editors'] = '页面编辑者';
$lang['pageToolsFooter_o_always'] = '总是';

$lang['pageToolsShowCreate_o_always'] = '总是';
$lang['pageToolsShowCreate_o_logged in'] = '已登录';
$lang['pageToolsShowCreate_o_logged out'] = '已退出登录';
$lang['pageToolsShowCreate_o_never'] = '从不';

$lang['pageToolsShowEdit_o_always'] = '总是';
$lang['pageToolsShowEdit_o_logged in'] = '已登录';
$lang['pageToolsShowEdit_o_logged out'] = '已退出登录';
$lang['pageToolsShowEdit_o_never'] = '从不';

$lang['pageToolsShowRevs_o_always'] = '总是';
$lang['pageToolsShowRevs_o_logged in'] = '已登录';
$lang['pageToolsShowRevs_o_logged out'] = '已退出登录';
$lang['pageToolsShowRevs_o_never'] = '从不';

$lang['pageToolsShowBacklink_o_always'] = '总是';
$lang['pageToolsShowBacklink_o_logged in'] = '已登录';
$lang['pageToolsShowBacklink_o_logged out'] = '已退出登录';
$lang['pageToolsShowBacklink_o_never'] = '从不';

$lang['pageToolsShowTop_o_always'] = '总是';
$lang['pageToolsShowTop_o_logged in'] = '已登录';
$lang['pageToolsShowTop_o_logged out'] = '已退出登录';
$lang['pageToolsShowTop_o_never'] = '从不';

$lang['licenseType_o_none'] = '无';
$lang['licenseType_o_badge'] = '徽章';
$lang['licenseType_o_button'] = '按钮';
