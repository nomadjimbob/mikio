<?php

/**
 * DokuWiki Mikio Template Russian Language for Configuration
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @translator https://github.com/box789
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

$lang['iconTag']                = 'Тег для использования с тегами значков. По умолчанию это \'icon\', но он может быть изменен, если конфликтует с любыми другими плагинами. Оставьте пустым, чтобы отключить теги значков';
$lang['customTheme']            = 'Использовать подтему Mikio, установленную в каталоге тем. 
Оставьте пустым для оформления по умолчанию';
$lang['showNotifications']      = 'Где показывать уведомления сайта';
$lang['useLESS']                = 'Использовать компилятор LESS для таблиц стилей mikio или прямой CSS. Требует установки расширения PHP \'ctype\'';
$lang['brandURLGuest']          = 'Изменить URL логотипа Вики для гостей. Оставьте пустым для URL по умолчанию';
$lang['brandURLUser']           = 'CИзменить URL логотипа Вики для авторизованных пользователей. Оставьте пустым для URL по умолчанию';
$lang['showLightDark']          = 'Показать переключатель темы \'Светлая/Темная\' в меню';
$lang['autoLightDark']          = 'Менять тему \'Светлая/Темная\' на основе системных предпочтений';
$lang['defaultDark']            = 'По умолчанию устанавливать Темную тему для пользователя';

$lang['navbarUseTitleIcon']     = 'Показать логотип Вики в заголовке меню. Будет искать изображение с названием \'logo\' (и расширениями - png/jpg/gif/svg) в корне или в пространстве имен :wiki: или в каталоге изображений шаблона/подтемы';
$lang['navbarTitleIconHeight']  = 'Принудительно установить высоту логотипа Вики. Поддерживает \'px\' (по умолчанию), \'rem\' и \'em\' единицы измерения';
$lang['navbarTitleIconWidth']   = 'Принудительно установить ширину логотипа Вики. Поддерживает \'px\' (по умолчанию), \'rem\' и \'em\' единицы измерения';
$lang['navbarUseTitleText']     = 'Показать название Вики в заголовке меню. Также скрывает слоган, если данная опция отключена';
$lang['navbarUseTaglineText']   = 'Показать слоган Вики в заголовке меню';
$lang['navbarCustomMenuText']   = 'Разрешить пользовательские меню в Главном меню. Формат - url|title - разделенные точкой с запятой';

$lang['navbarDWMenuType']       = 'Показывать меню Dokuwiki как значки, текст или все вместе';
$lang['navbarDWMenuCombine']    = 'Показывать меню Dokuwiki как отдельные элементы, выпадающий список по категориям или пункты, объединенные в единое меню';

$lang['navbarPosLeft']          = 'Меню для показа в левой части Главного меню';
$lang['navbarPosMiddle']        = 'Меню для показа в середине Главного меню';
$lang['navbarPosRight']         = 'Меню для показа в правой части Главного меню';
$lang['navbarShowSub']          = 'Показать подменю. Это меню отображает данные со страницы подменю, выполняя поиск submenu от текущего пространства имен и выше до корня. Рекомендуется использовать списки для пунктов меню';

$lang['navbarItemShowCreate']   = 'Показать пункт меню Создать страницу';
$lang['navbarItemShowShow']     = 'Показать пункт меню Показать страницу';
$lang['navbarItemShowRevs']     = 'Показать пункт меню История страницы';
$lang['navbarItemShowBacklink'] = 'Показать пункт меню Ссылки сюда';
$lang['navbarItemShowRecent']   = 'Показать пункт меню Недавние изменения';
$lang['navbarItemShowMedia']    = 'Показать пункт меню Управление медиафайлами';
$lang['navbarItemShowIndex']    = 'Показать пункт меню Все страницы';
$lang['navbarItemShowProfile']  = 'Показать пункт меню Профиль';
$lang['navbarItemShowAdmin']    = 'Показать пункт меню Управление';
$lang['navbarItemShowLogin']    = 'Показать пункт меню Войти';
$lang['navbarItemShowLogout']   = 'Показать пункт меню Выйти';

$lang['searchButton']           = 'Тип кнопки поиска';
$lang['searchUseTypeahead']     = 'Использовать подсказки страниц по мере набора текста в панели поиска';

$lang['heroTitle']              = 'Показать страницы в стиле Hero (Первый экран приветствия)';
$lang['heroImagePropagation']   = 'Искать изображения для блока Hero в родительских пространствах имен, если изображение для Hero не найдено в текущем';

$lang['tagsConsolidate']        = 'Консолидировать теги страниц в блоке Hero, заголовке контента или в сайдбаре';
$lang['tagsShowHero']           = 'Показывать теги в блоке Hero';

$lang['breadcrumbHideHome']     = 'Скрыть панель хлебных крошек на домашней странице';
$lang['breadcrumbPosition']     = 'Положение панели хлебных крошек на странице';
$lang['breadcrumbPrefix']       = 'Изменить текст префикса хлебных крошек';
$lang['breadcrumbPrefixText']   = 'Замена текста префикса хлебных крошек. Вы можете использовать изображение, загрузив файл breadcrumb-prefix.png в каталог изображений шаблона';
$lang['breadcrumbSep']          = 'Изменить текст разделителя хлебных крошек';
$lang['breadcrumbSepText']      = 'Замена текста разделителя хлебных крошек. Вы можете использовать изображение, загрузив файл breadcrumb-sep.png в каталог изображений шаблона';

$lang['youarehereHideHome']     = 'Скрыть панель \'Вы здесь\', на главной странице';
$lang['youareherePosition']     = 'Позиция панели \'Вы здесь\' на странице';
$lang['youareherePrefix']       = 'Изменить текст префикса панели \'Вы здесь\'';
$lang['youareherePrefixText']   = 'Замена текста префикса панели \'Вы здесь\'. Вы можете использовать изображение, загрузив файл youarehere-prefix.png в каталог изображений шаблона';
$lang['youarehereSep']          = 'Изменить текст разделителя панели \'Вы здесь\'';
$lang['youarehereSepText']      = 'Замена текста разделителя панели \'Вы здесь\'. Вы можете использовать изображение, загрузив файл youarehere-sep.png в каталог изображений шаблона';
$lang['youarehereHome']         = 'Изменить текст или значок используемый для Домашней страницы в панели \'Вы здесь\'';
$lang['youarehereShowLast']     = 'Показать только N последних хлебных крошек. Установите 0, чтобы показать все';

$lang['sidebarShowLeft']        = 'Показать левый сайдбар';
$lang['sidebarAlwaysShowLeft']  = 'Всегда показывать левый сайдбар, даже когда нет контента';
$lang['sidebarLeftRow1']        = 'Контент для отображения на первой строке левого сайдбара';
$lang['sidebarLeftRow2']        = 'Контент для отображения на второй строке левого сайдбара';
$lang['sidebarLeftRow3']        = 'Контент для отображения на третьей строке левого сайдбара';
$lang['sidebarLeftRow4']        = 'Контент для отображения на четвертой строке левого сайдбара';
$lang['sidebarMobileDefaultCollapse']    = 'По умолчанию скрыть боковые панели при мобильном просмотре';
$lang['sidebarShowRight']       = 'Показать правый сайдбар';
$lang['sidebarAlwaysShowRight'] = 'Всегда показывать правый сайдбар, даже когда нет контента';

$lang['tocFull']                = 'Показать Оглавление как элемент с полной высотой';

$lang['pageToolsFloating']      = 'Когда показывать плавающую панель инструментов страницы';
$lang['pageToolsFooter']        = 'Когда показывать в подвале панель инструментов страницы';

$lang['pageToolsShowCreate']    = 'Показать пункт Создать страницу';
$lang['pageToolsShowEdit']      = 'Показать пункт Править страницу';
$lang['pageToolsShowRevs']      = 'Показать пункт История страницы';
$lang['pageToolsShowBacklink']  = 'Показать пункт Ссылки сюда';
$lang['pageToolsShowTop']       = 'Показать пункт Наверх';

$lang['footerPageInfoText']     = 'Настроить информацию о странице в подвале';
$lang['footerCustomMenuText']   = 'Разрешить пользовательские меню в подвале. Формат - url|title, разделенные ;';
$lang['footerSearch']           = 'Показать панель поиска в подвале';
$lang['footerInPage']           = 'Показать нижний колонтитул Вики в статье. При этом общий подвал остается на странице';

$lang['licenseType']            = 'Показать лицензию в подвале: нет, значки или кнопки';
$lang['licenseImageOnly']       = 'Показать лицензию в подвале только как изображение';

$lang['includePageUseACL']      = 'Учитывать права из ACL при вложении (include) страниц';
$lang['includePagePropagate']   = 'Поиск в родительских пространствах имен при вложении (include) страниц';

$lang['stickyTopHeader']        = 'Закрепить блок верхнего заголовка (Top Header)';
$lang['stickyNavbar']           = 'Закрепить Главное меню (Navbar)';
$lang['stickyHeader']           = 'Закрепить блок заголовка (Header)';
$lang['stickyLeftSidebar']      = 'Закрепить левый сайдбар';

$lang['showNotifications_o_never']      = 'никогда';
$lang['showNotifications_o_admin']      = 'администратору';
$lang['showNotifications_o_always']      = 'всегда';

$lang['navbarDWMenuType_o_icons'] = 'значки';
$lang['navbarDWMenuType_o_text'] = 'текст';
$lang['navbarDWMenuType_o_both'] = 'все вместе';

$lang['navbarDWMenuCombine_o_separate'] = 'раздельно';
$lang['navbarDWMenuCombine_o_dropdown'] = 'выпадающий список';
$lang['navbarDWMenuCombine_o_combine'] = 'объединить';

$lang['navbarPosLeft_o_none'] = 'нет';
$lang['navbarPosLeft_o_custom'] = 'пользовательский';
$lang['navbarPosLeft_o_search'] = 'поиск';
$lang['navbarPosLeft_o_dokuwiki'] = 'dokuwiki';

$lang['navbarPosMiddle_o_none'] = 'нет';
$lang['navbarPosMiddle_o_custom'] = 'пользовательский';
$lang['navbarPosMiddle_o_search'] = 'поиск';
$lang['navbarPosMiddle_o_dokuwiki'] = 'dokuwiki';

$lang['navbarPosRight_o_none'] = 'нет';
$lang['navbarPosRight_o_custom'] = 'пользовательский';
$lang['navbarPosRight_o_search'] = 'поиск';
$lang['navbarPosRight_o_dokuwiki'] = 'dokuwiki';

$lang['navbarItemShowCreate_o_always'] = 'всегда';
$lang['navbarItemShowCreate_o_logged in'] = 'авторизован';
$lang['navbarItemShowCreate_o_logged out'] = 'не авторизован';
$lang['navbarItemShowCreate_o_never'] = 'никогда';

$lang['navbarItemShowShow_o_always'] = 'всегда';
$lang['navbarItemShowShow_o_logged in'] = 'авторизован';
$lang['navbarItemShowShow_o_logged out'] = 'не авторизован';
$lang['navbarItemShowShow_o_never'] = 'никогда';

$lang['navbarItemShowRevs_o_always'] = 'всегда';
$lang['navbarItemShowRevs_o_logged in'] = 'авторизован';
$lang['navbarItemShowRevs_o_logged out'] = 'не авторизован';
$lang['navbarItemShowRevs_o_never'] = 'никогда';

$lang['navbarItemShowBacklink_o_always'] = 'всегда';
$lang['navbarItemShowBacklink_o_logged in'] = 'авторизован';
$lang['navbarItemShowBacklink_o_logged out'] = 'не авторизован';
$lang['navbarItemShowBacklink_o_never'] = 'никогда';

$lang['navbarItemShowRecent_o_always'] = 'всегда';
$lang['navbarItemShowRecent_o_logged in'] = 'авторизован';
$lang['navbarItemShowRecent_o_logged out'] = 'не авторизован';
$lang['navbarItemShowRecent_o_never'] = 'никогда';

$lang['navbarItemShowMedia_o_always'] = 'всегда';
$lang['navbarItemShowMedia_o_logged in'] = 'авторизован';
$lang['navbarItemShowMedia_o_logged out'] = 'не авторизован';
$lang['navbarItemShowMedia_o_never'] = 'никогда';

$lang['navbarItemShowIndex_o_always'] = 'всегда';
$lang['navbarItemShowIndex_o_logged in'] = 'авторизован';
$lang['navbarItemShowIndex_o_logged out'] = 'не авторизован';
$lang['navbarItemShowIndex_o_never'] = 'никогда';

$lang['navbarItemShowProfile_o_always'] = 'всегда';
$lang['navbarItemShowProfile_o_logged in'] = 'авторизован';
$lang['navbarItemShowProfile_o_logged out'] = 'не авторизован';
$lang['navbarItemShowProfile_o_never'] = 'никогда';

$lang['navbarItemShowAdmin_o_always'] = 'всегда';
$lang['navbarItemShowAdmin_o_logged in'] = 'авторизован';
$lang['navbarItemShowAdmin_o_logged out'] = 'не авторизован';
$lang['navbarItemShowAdmin_o_never'] = 'никогда';

$lang['navbarItemShowLogin_o_always'] = 'всегда';
$lang['navbarItemShowLogin_o_never'] = 'никогда';

$lang['navbarItemShowLogout_o_always'] = 'всегда';
$lang['navbarItemShowLogout_o_never'] = 'никогда';

$lang['searchButton_o_icon'] = 'значок';
$lang['searchButton_o_text'] = 'текст';

$lang['breadcrumbPosition_o_none'] = 'нет';
$lang['breadcrumbPosition_o_top'] = 'верх';
$lang['breadcrumbPosition_o_hero'] = 'hero';
$lang['breadcrumbPosition_o_page'] = 'страница';

$lang['youareherePosition_o_none'] = 'нет';
$lang['youareherePosition_o_top'] = 'верх';
$lang['youareherePosition_o_hero'] = 'hero';
$lang['youareherePosition_o_page'] = 'страница';

$lang['youarehereHome_o_none'] = 'ничего';
$lang['youarehereHome_o_page title'] = 'заголовок страницы';
$lang['youarehereHome_o_home'] = 'домой';
$lang['youarehereHome_o_icon'] = 'значок';

$lang['sidebarLeftRow1_o_none'] = 'ничего';
$lang['sidebarLeftRow1_o_logged in user'] = 'авторизованный пользователь';
$lang['sidebarLeftRow1_o_search'] = 'поиск';
$lang['sidebarLeftRow1_o_content'] = 'контент';
$lang['sidebarLeftRow1_o_tags'] = 'теги';

$lang['sidebarLeftRow2_o_none'] = 'ничего';
$lang['sidebarLeftRow2_o_logged in user'] = 'авторизованный пользователь';
$lang['sidebarLeftRow2_o_search'] = 'поиск';
$lang['sidebarLeftRow2_o_content'] = 'контент';
$lang['sidebarLeftRow2_o_tags'] = 'метки';

$lang['sidebarLeftRow3_o_none'] = 'ничего';
$lang['sidebarLeftRow3_o_logged in user'] = 'авторизованный пользователь';
$lang['sidebarLeftRow3_o_search'] = 'поиск';
$lang['sidebarLeftRow3_o_content'] = 'контент';
$lang['sidebarLeftRow3_o_tags'] = 'метки';

$lang['sidebarLeftRow4_o_none'] = 'ничего';
$lang['sidebarLeftRow4_o_logged in user'] = 'авторизованный пользователь';
$lang['sidebarLeftRow4_o_search'] = 'поиск';
$lang['sidebarLeftRow4_o_content'] = 'контент';
$lang['sidebarLeftRow4_o_tags'] = 'метки';

$lang['pageToolsFloating_o_none'] = 'нет';
$lang['pageToolsFloating_o_page editors'] = 'редакторы страниц';
$lang['pageToolsFloating_o_always'] = 'всегда';

$lang['pageToolsFooter_o_none'] = 'нет';
$lang['pageToolsFooter_o_page editors'] = 'редакторы страниц';
$lang['pageToolsFooter_o_always'] = 'всегда';

$lang['pageToolsShowCreate_o_always'] = 'всегда';
$lang['pageToolsShowCreate_o_logged in'] = 'авторизован';
$lang['pageToolsShowCreate_o_logged out'] = 'не авторизован';
$lang['pageToolsShowCreate_o_never'] = 'никогда';

$lang['pageToolsShowEdit_o_always'] = 'всегда';
$lang['pageToolsShowEdit_o_logged in'] = 'авторизован';
$lang['pageToolsShowEdit_o_logged out'] = 'не авторизован';
$lang['pageToolsShowEdit_o_never'] = 'никогда';

$lang['pageToolsShowRevs_o_always'] = 'всегда';
$lang['pageToolsShowRevs_o_logged in'] = 'авторизован';
$lang['pageToolsShowRevs_o_logged out'] = 'не авторизован';
$lang['pageToolsShowRevs_o_never'] = 'никогда';

$lang['pageToolsShowBacklink_o_always'] = 'всегда';
$lang['pageToolsShowBacklink_o_logged in'] = 'авторизован';
$lang['pageToolsShowBacklink_o_logged out'] = 'не авторизован';
$lang['pageToolsShowBacklink_o_never'] = 'никогда';

$lang['pageToolsShowTop_o_always'] = 'всегда';
$lang['pageToolsShowTop_o_logged in'] = 'авторизован';
$lang['pageToolsShowTop_o_logged out'] = 'не авторизован';
$lang['pageToolsShowTop_o_never'] = 'никогда';

$lang['licenseType_o_none'] = 'нет';
$lang['licenseType_o_badge'] = 'значок';
$lang['licenseType_o_button'] = 'кнопка';
