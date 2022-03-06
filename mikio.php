<?php

/**
 * DokuWiki Mikio Template
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

namespace dokuwiki\template\mikio;

if (!defined('DOKU_INC')) die();

require_once('icons/icons.php');
require_once('inc/simple_html_dom.php');

class Template
{
    public $tplDir  = '';
    public $baseDir = '';
    public $footerScript = array();
    public $lessIgnored = false;


    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->tplDir  = tpl_incdir();
        $this->baseDir = tpl_basedir();

        $this->_registerHooks();
    }


    /**
     * Returns the instance of the class
     *
     * @return  Template        class instance
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Template();
        }

        return $instance;
    }


    /**
     * Register the themes hooks into Dokuwiki
     */
    private function _registerHooks()
    {
        global $EVENT_HANDLER;

        $events_dispatcher = array(
            'TPL_METAHEADER_OUTPUT'     => 'metaheadersHandler'
        );

        foreach ($events_dispatcher as $event => $method) {
            $EVENT_HANDLER->register_hook($event, 'BEFORE', $this, $method);
        }
    }


    /**
     * Meta handler hook for DokuWiki
     *
     * @param   Doku_Event  $event
     */
    public function metaHeadersHandler(\Doku_Event $event)
    {
        global $MIKIO_ICONS;

        $this->includePage('theme', FALSE, TRUE);

        $stylesheets    = array();
        $scripts        = array();

        if ($this->getConf('customTheme') != '') {
            if (file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/style.less')) {
                $stylesheets[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/style.less';
            } else {
                if (file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/style.css')) {
                    $stylesheets[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/style.css';
                }
            }
            if (file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/script.js')) {
                $scripts[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/script.js';
            }
        }

        if (is_array($MIKIO_ICONS) && $this->getConf('iconTag', 'icon') != '') {
            $icons = array();
            foreach ($MIKIO_ICONS as $icon) {
                if (isset($icon['name']) && isset($icon['css']) && isset($icon['insert'])) {
                    $icons[] = $icon;

                    if ($icon['css'] != '') {
                        if (strpos($icon['css'], '//') === FALSE) {
                            $stylesheets[] = $this->baseDir . 'icons/' . $icon['css'];
                        } else {
                            $stylesheets[] = $icon['css'];
                        }
                    }
                }
            }
            $MIKIO_ICONS = $icons;
        } else {
            $MIKIO_ICONS = [];
        }

        $scripts[] = $this->baseDir . 'assets/mikio.js';

        if ($this->getConf('useLESS')) {
            $stylesheets[] = $this->baseDir . 'assets/mikio.less';
        } else {
            $stylesheets[] = $this->baseDir . 'assets/mikio.css';
        }


        $set = [];
        foreach ($stylesheets as $style) {
            if (in_array($style, $set) == FALSE) {
                if (strtolower(substr($style, -5)) == '.less' && $this->getConf('useLESS')) {
                    $style = $this->baseDir . 'css.php?css=' . str_replace($this->baseDir, '', $style);
                }

                array_unshift($event->data['link'], array(
                    'type' => 'text/css',
                    'rel'  => 'stylesheet',
                    'href' => $style
                ));
            }
            $set[] = $style;
        }

        $set = [];
        foreach ($scripts as $script) {
            if (in_array($script, $set) == FALSE) {
                $event->data['script'][] = array(
                    'type'  => 'text/javascript',
                    '_data' => '',
                    'src'   => $script
                );
            }
            $set[] = $script;
        }
    }


    /**
     * Print or return the footer meta data
     *
     * @param   boolean $print      print the data to buffer
     */
    public function includeFooterMeta($print = TRUE)
    {
        $html = '';

        if (count($this->footerScript) > 0) {
            $html .= '<script type="text/javascript">function mikioFooterRun() {';
            foreach ($this->footerScript as $script) {
                $html .= $script . ';';
            }
            $html .= '}</script>';
        }


        if ($print) echo $html;
        return $html;
    }

    /**
     * Retreive and parse theme configuration options
     *
     * @param   string  $key        the configuration key to retreive
     * @param   mixed   $default    if key doesn't exist, return this value
     * @return  mixed               parsed value of configuration
     */
    public function getConf($key, $default = FALSE)
    {
        $value = tpl_getConf($key, $default);

        switch ($key) {
            case 'navbarDWMenuType':
                $value = strtolower($value);
                if ($value != 'icons' && $value != 'text' && $value != 'both') $value = 'both';
                break;
            case 'navbarDWMenuCombine':
                $value = strtolower($value);
                if ($value != 'seperate' && $value != 'dropdown' && $value != 'combine') $value = 'combine';
                break;
            case 'navbarPosLeft':
            case 'navbarPosMiddle':
            case 'navbarPosRight':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'custom' && $value != 'search' && $value != 'dokuwiki') {
                    if ($key == 'navbarPosLeft') $value = 'none';
                    if ($key == 'navbarPosMiddle') $value = 'search';
                    if ($key == 'navbarPosRight') $value = 'dokuwiki';
                }
                break;
            case 'navbarItemShowCreate':
            case 'navbarItemShowShow':
            case 'navbarItemShowRevs':
            case 'navbarItemShowBacklink':
            case 'navbarItemShowRecent':
            case 'navbarItemShowMedia':
            case 'navbarItemShowIndex':
            case 'navbarItemShowProfile':
            case 'navbarItemShowAdmin':
                $value = strtolower($value);
                if ($value != 'always' && $value != 'logged in' && $value != 'logged out' && $value != 'never') {
                    $value = 'always';
                }
                break;
            case 'navbarItemShowLogin':
            case 'navbarItemShowLogout':
                $value = strtolower($value);
                if ($value != 'always' && $value != 'never') {
                    $value = 'always';
                }
                break;
            case 'searchButton':
                $value = strtolower($value);
                if ($value != 'icon' && $value != 'text') $value = 'icon';
                break;
            case 'searchButton':
                $value = strtolower($value);
                if ($value != 'icon' && $value != 'text') $value = 'icon';
                break;
            case 'breadcrumbPosition':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'top' && $value != 'hero' && $value != 'page') $value = 'top';
                break;
            case 'youareherePosition':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'top' && $value != 'hero' && $value != 'page') $value = 'top';
                break;
            case 'youarehereHome':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'page title' && $value != 'home' && $value != 'icon') $value = 'page title';
                break;
            case 'sidebarLeftRow1':
            case 'sidebarLeftRow2':
            case 'sidebarLeftRow3':
            case 'sidebarLeftRow4':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'logged in user' && $value != 'search' && $value != 'content' && $value != 'tags') {
                    if ($key == 'sidebarLeftRow1') $value = 'logged in user';
                    if ($key == 'sidebarLeftRow2') $value = 'search';
                    if ($key == 'sidebarLeftRow3') $value = 'content';
                    if ($key == 'sidebarLeftRow4') $value = 'none';
                }
                break;
            case 'pageToolsFloating':
            case 'pageToolsFooter':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'page editors' && $value != 'always') {
                    if ($key == 'pageToolsFloating') $value = 'always';
                    if ($key == 'pageToolsFooter') $value = 'always';
                }
                break;
            case 'pageToolsShowCreate':
            case 'pageToolsShowEdit':
            case 'pageToolsShowRevs':
            case 'pageToolsShowBacklink':
            case 'pageToolsShowTop':
                $value = strtolower($value);
                if ($value != 'always' && $value != 'logged in' && $value != 'logged out' && $value != 'never') {
                    $value = 'always';
                }
                break;
            case 'showNotifications':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'admin' && $value != 'always') $value = 'admin';
                break;
            case 'licenseType':
                $value = strtolower($value);
                if ($value != 'none' && $value != 'badge' && $value != 'buttom') $value = 'badge';
                break;
            case 'navbarUseTitleIcon':
            case 'navbarUseTitleText':
            case 'navbarUseTaglineText':
            case 'navbarShowSub':
            case 'heroTitle':
            case 'heroImagePropagation':
            case 'breadcrumbPrefix':
            case 'breadcrumbSep':
            case 'youareherePrefix':
            case 'youarehereSep':
            case 'sidebarShowLeft':
            case 'sidebarShowRight':
            case 'tocFull':
            case 'footerSearch':
            case 'licenseImageOnly':
            case 'includePageUseACL':
            case 'includePagePropagate':
            case 'youarehereHideHome':
            case 'tagsConsolidate':
            case 'footerInPage':
            case 'sidebarMobileDefaultCollapse':
            case 'sidebarAlwaysShowLeft':
            case 'sidebarAlwaysShowRight':
                $value = (bool)$value;
                break;
            case 'youarehereShowLast':
                $value = (int)$value;
                break;
            case 'iconTag':
            case 'customTheme':
            case 'navbarCustomMenuText':
            case 'breadcrumbPrefixText':
            case 'breadcrumbSepText':
            case 'youareherePrefixText':
            case 'youarehereSepText':
            case 'footerCustomMenuText':
                break;
            case 'useLESS':
                $value = (bool)$value;
                $lessAvailable = true;

                // check for less library
                $lesscLib = '../../../vendor/marcusschwarz/lesserphp/lessc.inc.php';
                if (!file_exists($lesscLib))
                    $lesscLib = $_SERVER['DOCUMENT_ROOT'] . '/vendor/marcusschwarz/lesserphp/lessc.inc.php';
                if (!file_exists($lesscLib))
                    $lesscLib = '../../../../../app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php';
                if (!file_exists($lesscLib))
                    $lesscLib = $_SERVER['DOCUMENT_ROOT'] . '/app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php';
                if (!file_exists($lesscLib)) {
                    $lessAvailable = false;
                }

                // check for ctype extensions
                if (!function_exists('ctype_digit')) {
                    $lessAvailable = false;
                }

                if ($value && !$lessAvailable) {
                    $this->lessIgnored = true;
                    $value = false;
                }
                break;
        }

        return $value;
    }


    /**
     * Check if a page exist in directory or namespace
     *
     * @param   string  $page   page/namespace to search
     * @return  boolean         if page exists
     */
    public function pageExists($page)
    {
        ob_start();
        tpl_includeFile($page . '.html');
        $html = ob_get_contents();
        ob_end_clean();

        if ($html != '') return TRUE;

        $useACL = $this->getConf('includePageUseACL');
        $propagate = $this->getConf('includePagePropagate');

        if ($propagate) {
            if (page_findnearest($page, $useACL)) return TRUE;
        } elseif ($useACL && auth_quickaclcheck($page) != AUTH_NONE) {
            return TRUE;
        }

        return FALSE;
    }


    /**
     * Print or return page from directory or namespace
     *
     * @param   string  $page           page/namespace to include
     * @param   boolean $print          print content
     * @param   boolean $parse          parse content before printing/returning
     * @param   string  $classWrapper   wrap page in a div with class
     * @return  string                  contents of page found
     */
    public function includePage($page, $print = TRUE, $parse = TRUE, $classWrapper = '')
    {
        ob_start();
        tpl_includeFile($page . '.html');
        $html = ob_get_contents();
        ob_end_clean();

        if ($html == '') {
            $useACL = $this->getConf('includePageUseACL');
            $propagate = $this->getConf('includePagePropagate');
            $html = '';

            $html = tpl_include_page($page, false, $propagate, $useACL);
        }

        if ($html != '' && $parse) {
            $html = $this->parseContent($html);
        }

        if ($classWrapper != '' && $html != '') $html = '<div class="' . $classWrapper . '">' . $html . '</div>';

        if ($print) echo $html;
        return $html;
    }


    /**
     * Print or return logged in user information
     *
     * @param   boolean $print          print content
     * @return  string                  user information
     */
    public function includeLoggedIn($print = TRUE)
    {
        $html = '';

        if (!empty($_SERVER['REMOTE_USER'])) {
            $html .= '<div class="mikio-user-info">';
            ob_start();
            tpl_userinfo();
            $html .= ob_get_contents();
            ob_end_clean();
            $html .= '</div>';
        }

        if ($print) echo $html;
        return $html;
    }


    /**
     * Print or return DokuWiki Menu
     *
     * @param   boolean $print          print content
     * @return  string                  contents of the menu
     */
    public function includeDWMenu($print = TRUE)
    {
        global $lang;
        global $USERINFO;

        $loggedIn = (is_array($USERINFO) && count($USERINFO) > 0);
        $html = '<ul class="mikio-nav">';

        $pageToolsMenu = [];
        $siteToolsMenu = [];
        $userToolsMenu = [];

        $showIcons  = ($this->getConf('navbarDWMenuType') != 'text');
        $showText   = ($this->getConf('navbarDWMenuType') != 'icons');
        $isDropDown = ($this->getConf('navbarDWMenuCombine') != 'seperate');

        $items = (new \dokuwiki\Menu\PageMenu())->getItems();
        foreach ($items as $item) {
            if ($item->getType() != 'top') {
                $itemHtml = '';

                $showItem = $this->getConf('navbarItemShow' . ucfirst($item->getType()));
                if ($showItem !== false && ($showItem == 'always' || ($showItem == 'logged in' && $loggedIn) || ($showItem == 'logged out' && !$loggedIn))) {
                    $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown ? 'mikio-dropdown-item' : '') . ' ' . $item->getType() . '" href="' . $item->getLink() . '" title="' . $item->getTitle() . '">';
                    if ($showIcons) $itemHtml .= '<span class="mikio-icon">' . inlineSVG($item->getSvg()) . '</span>';
                    if ($showText || $isDropDown) $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                    $itemHtml .= '</a>';

                    $pageToolsMenu[] = $itemHtml;
                }
            }
        }

        $items = (new \dokuwiki\Menu\SiteMenu())->getItems('action');
        foreach ($items as $item) {
            $itemHtml = '';

            $showItem = $this->getConf('navbarItemShow' . ucfirst($item->getType()));
            if ($showItem !== false && ($showItem == 'always' || ($showItem == 'logged in' && $loggedIn) || ($showItem == 'logged out' && !$loggedIn))) {
                $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown ? 'mikio-dropdown-item' : '') . ' ' . $item->getType() . '" href="' . $item->getLink() . '" title="' . $item->getTitle() . '">';
                if ($showIcons) $itemHtml .= '<span class="mikio-icon">' . inlineSVG($item->getSvg()) . '</span>';
                if ($showText || $isDropDown) $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                $itemHtml .= '</a>';

                $siteToolsMenu[] = $itemHtml;
            }
        }

        $items = (new \dokuwiki\Menu\UserMenu())->getItems('action');
        foreach ($items as $item) {
            $itemHtml = '';

            $showItem = $this->getConf('navbarItemShow' . ucfirst($item->getType()));
            if ($showItem !== false && ($showItem == 'always' || ($showItem == 'logged in' && $loggedIn) || ($showItem == 'logged out' && !$loggedIn))) {
                $itemHtml .= '<a class="mikio-nav-link' . ($isDropDown ? ' mikio-dropdown-item' : '') . ' ' . $item->getType() . '" href="' . $item->getLink() . '" title="' . $item->getTitle() . '">';
                if ($showIcons) $itemHtml .= '<span class="mikio-icon">' . inlineSVG($item->getSvg()) . '</span>';
                if ($showText || $isDropDown) $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                $itemHtml .= '</a>';

                $userToolsMenu[] = $itemHtml;
            }
        }


        switch ($this->getConf('navbarDWMenuCombine')) {
            case 'dropdown':
                $html .= '<li id="dokuwiki__pagetools" class="mikio-nav-dropdown">';
                $html .= '<a id="mikio_dropdown_pagetools" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . ($showIcons ? $this->mikioInlineIcon('file') : '') . ($showText ? $lang['page_tools'] : '<span class="mikio-small-only">' . $lang['page_tools'] . '</span>') . '</a>';
                $html .= '<div class="mikio-dropdown closed">';

                foreach ($pageToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';

                $html .= '<li id="dokuwiki__sitetools" class="mikio-nav-dropdown">';
                $html .= '<a id="mikio_dropdown_sitetools" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . ($showIcons ? $this->mikioInlineIcon('gear') : '') . ($showText ? $lang['site_tools'] : '<span class="mikio-small-only">' . $lang['site_tools'] . '</span>') . '</a>';
                $html .= '<div class="mikio-dropdown closed">';

                foreach ($siteToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';

                $html .= '<li id="dokuwiki__usertools" class="mikio-nav-dropdown">';
                $html .= '<a id="mikio_dropdown_usertools" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . ($showIcons ? $this->mikioInlineIcon('user') : '') . ($showText ? $lang['user_tools'] : '<span class="mikio-small-only">' . $lang['user_tools'] . '</span>') . '</a>';
                $html .= '<div class="mikio-dropdown closed">';

                foreach ($userToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';

                break;

            case 'combine':
                $html .= '<li class="mikio-nav-dropdown">';
                $html .= '<a class="mikio-nav-link" href="#">' . ($showIcons ? $this->mikioInlineIcon('wrench') : '') . ($showText ? tpl_getLang('tools-menu') : '<span class="mikio-small-only">' . tpl_getLang('tools-menu') . '</span>') . '</a>';   // TODO change $lang
                $html .= '<div class="mikio-dropdown closed">';

                $html .= '<h6 class="mikio-dropdown-header">' . $lang['page_tools'] . '</h6>';
                foreach ($pageToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '<div class="mikio-dropdown-divider"></div>';
                $html .= '<h6 class="mikio-dropdown-header">' . $lang['site_tools'] . '</h6>';
                foreach ($siteToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '<div class="mikio-dropdown-divider"></div>';
                $html .= '<h6 class="mikio-dropdown-header">' . $lang['user_tools'] . '</h6>';
                foreach ($userToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';
                break;

            default:    // seperate
                foreach ($siteToolsMenu as $item) {
                    $html .= '<li class="mikio-nav-item">' . $item . '</li>';
                }

                foreach ($pageToolsMenu as $item) {
                    $html .= '<li class="mikio-nav-item">' . $item . '</li>';
                }

                foreach ($userToolsMenu as $item) {
                    $html .= '<li class="mikio-nav-item">' . $item . '</li>';
                }

                break;
        }

        $html .= '</ul>';

        if ($print) echo $html;
        return $html;
    }


    /**
     * Create a nav element from a string. <uri>|<title>;
     * 
     * @param string   $str     string to generate nav
     * @return string           nav elements generated
     */
    public function stringToNav($str)
    {
        $html = '';

        if ($str != '') {
            $items = explode(';', $str);
            if (count($items) > 0) {
                $html .= '<ul class="mikio-nav">';
                foreach ($items as $item) {
                    $parts = explode('|', $item);
                    if ($parts > 1) {
                        $html .= '<li class="mikio-nav-item"><a class="mikio-nav-link" href="' . strip_tags($this->getLink(trim($parts[0]))) . '">' . strip_tags(trim($parts[1])) . '</a></li>';
                    }
                }
                $html .= '</ul>';
            }
        }

        return $html;
    }

    /**
     * print or return the main navbar
     * 
     * @param boolean   $print      print the navbar
     * @param boolean   $showSub    include the sub navbar
     * @return string               generated content
     */
    public function includeNavbar($print = TRUE, $showSub = FALSE)
    {
        global $conf;

        $homeUrl = wl();

        if (!plugin_isdisabled('showpageafterlogin')) {
            $p = &plugin_load('action', 'showpageafterlogin');
            if ($p) {
                global $USERINFO;

                if (is_array($USERINFO) && count($USERINFO) > 0) {
                    $homeUrl = wl($p->getConf('page_after_login'));
                }
            }
        }


        $html = '';

        $html .= '<nav class="mikio-navbar'  . (($this->getConf('stickyNavbar')) ? ' mikio-sticky' : '') . '">';
        $html .= '<div class="mikio-container">';
        $html .= '<a class="mikio-navbar-brand" href="' . $homeUrl . '">';
        if ($this->getConf('navbarUseTitleIcon') || $this->getConf('navbarUseTitleText')) {

            // Brand image
            if ($this->getConf('navbarUseTitleIcon')) {
                $logo = $this->getMediaFile('logo', FALSE);;
                if ($logo != '') {
                    $html .= '<img src="' . $logo . '" class="mikio-navbar-brand-image">';
                }
            }

            // Brand title
            if ($this->getConf('navbarUseTitleText')) {
                $html .= '<div class="mikio-navbar-brand-title">';
                $html .= '<h1 class="mikio-navbar-brand-title-text">' . $conf['title'] . '</h1>';
                if ($this->getConf('navbarUseTaglineText')) {
                    $html .= '<p class="claim mikio-navbar-brand-title-tagline">' . $conf['tagline'] . '</p>';
                }
                $html .= '</div>';
            }
        }
        $html .= '</a>';
        $html .= '<div class="mikio-navbar-toggle"><span class="icon"></span></div>';

        // Menus
        $html .= '<div class="mikio-navbar-collapse">';

        $menus = array($this->getConf('navbarPosLeft', 'none'), $this->getConf('navbarPosMiddle', 'none'), $this->getConf('navbarPosRight', 'none'));
        foreach ($menus as $menuType) {
            switch ($menuType) {
                case 'custom':
                    $html .= $this->stringToNav($this->getConf('navbarCustomMenuText', ''));
                    break;
                case 'search':
                    $html .= '<div class="mikio-nav-item">';
                    $html .= $this->includeSearch(false);
                    $html .= '</div>';
                    break;
                case 'dokuwiki':
                    $html .= $this->includeDWMenu(FALSE);
                    break;
            }
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</nav>';

        // Sub Navbar
        if ($showSub) {
            $sub = $this->includePage('submenu', FALSE);
            if ($sub != '') $html .= '<nav class="mikio-navbar mikio-sub-navbar">' . $sub . '</nav>';
        }

        if ($print) echo $html;
        return $html;
    }


    /**
     * Is there a sidebar
     *
     * @param   string  $prefix     sidebar prefix to use when searching
     * @return  boolean             if sidebar exists
     */
    public function sidebarExists($prefix = '')
    {
        global $conf;

        if ($prefix == 'left') $prefix = '';

        return $this->pageExists($conf['sidebar' . $prefix]);
    }


    /**
     * Print or return the sidebar content
     *
     * @param   string  $prefix     sidebar prefix to use when searching
     * @param   boolean $print      print the generated content to the output buffer
     * @param   boolean $parse      parse the content
     * @return  string              generated content
     */
    public function includeSidebar($prefix = '', $print = TRUE, $parse = TRUE)
    {
        global $conf, $ID;

        $html = '';
        $confPrefix = preg_replace('/[^a-zA-Z0-9]/', '', ucwords($prefix));
        $prefix = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($prefix));

        if ($confPrefix == '') $confPrefix = 'Left';
        if ($prefix == 'Left') $prefix = '';

        $sidebarPage = $conf[$prefix . 'sidebar'] == '' ? $prefix . 'sidebar' : $conf[$prefix . 'sidebar'];

        if ($this->getConf('sidebarShow' . $confPrefix) && page_findnearest($sidebarPage) != FALSE && p_get_metadata($ID, 'nosidebar', FALSE) == FALSE) {
            $content = $this->includePage($sidebarPage . 'header', FALSE);
            if ($content != '') $html .= '<div class="mikio-sidebar-header">' . $content . '</div>';

            if ($prefix == '') {
                $rows = array($this->getConf('sidebarLeftRow1'), $this->getConf('sidebarLeftRow2'), $this->getConf('sidebarLeftRow3'), $this->getConf('sidebarLeftRow4'));

                foreach ($rows as $row) {
                    switch ($row) {
                        case 'search':
                            $html .= $this->includeSearch(FALSE);
                            break;
                        case 'logged in user':
                            $html .= $this->includeLoggedIn(FALSE);
                            break;
                        case 'content':
                            $content = $this->includePage($sidebarPage, FALSE);
                            if ($content != '') $html .= '<div class="mikio-sidebar-content">' . $content . '</div>';
                            break;
                        case 'tags':
                            $html .= '<div class="mikio-tags"></div>';
                    }
                }
            } else {
                $content = $this->includePage($sidebarPage, FALSE);
                if ($content != '') $html .= '<div class="mikio-sidebar-content">' . $content . '</div>';
            }

            $content = $this->includePage($sidebarPage . 'footer', FALSE);
            if ($content != '') $html .= '<div class="mikio-sidebar-footer">' . $content . '</div>';
        }

        if ($html == '') {
            if ($prefix == '' && $this->getConf('sidebarAlwaysShowLeft')) $html = '&nbsp;';
            if ($this->getConf('sidebarAlwaysShow' . ucfirst($prefix))) $html = '&nbsp;';
        }

        if ($html != '') {
            $html = '<aside class="mikio-sidebar mikio-sidebar-' . ($prefix == '' ? 'left' : $prefix) . '"><a class="mikio-sidebar-toggle' . ($this->getConf('sidebarMobileDefaultCollapse') ? ' closed' : '') . '" href="#">' . tpl_getLang('sidebar-title') . ' <span class="icon"></span></a><div class="mikio-sidebar-collapse">' . $html . '</div></aside>';
        }

        if ($parse) $html = $this->includeIcons($html);
        if ($print) echo $html;
        return $html;
    }


    /**
     * Print or return the page tools content
     *
     * @param   boolean $print      print the generated content to the output buffer
     * @param   boolean $includeId  include the dw__pagetools id in the element
     * @return  string              generated content
     */
    public function includePageTools($print = TRUE, $includeId = FALSE)
    {
        global $USERINFO;

        $loggedIn = (is_array($USERINFO) && count($USERINFO) > 0);
        $html = '';

        $html .= '<nav' . ($includeId ? ' id="dw__pagetools"' : '') . ' class="hidden-print dw__pagetools">';
        $html .= '<ul class="tools">';

        $items = (new \dokuwiki\Menu\PageMenu())->getItems();
        foreach ($items as $item) {
            $classes = array();
            $classes[] = $item->getType();
            $attr = $item->getLinkAttributes();

            if (!empty($attr['class'])) {
                $classes = array_merge($classes, explode(' ', $attr['class']));
            }

            $classes = array_unique($classes);

            $showItem = $this->getConf('pageToolsShow' . ucfirst($item->getType()));
            if ($showItem !== false && ($showItem == 'always' || ($showItem == 'logged in' && $loggedIn) || ($showItem == 'logged out' && !$loggedIn))) {
                $html .= '<li class="' . implode(' ', $classes) . '">';
                $html .= '<a href="' . $item->getLink() . '" class="' . $item->getType() . '" title="' . $item->getTitle() . '"><div class="icon">' . inlineSVG($item->getSvg()) . '</div><span class="a11y">' . $item->getLabel() . '</span></a>';
                $html .= '</li>';
            }
        }

        $html .= '</ul>';
        $html .= '</nav>';

        if ($print) echo $html;
        return $html;
    }


    /**
     * Print or return the search bar
     *
     * @param   boolean $print          print content
     * @return  string                  contents of the search bar
     */
    public function includeSearch($print = TRUE)
    {
        global $lang, $ID;
        $html = '';

        $html .= '<form class="mikio-search search" action="' . wl() . '" accept-charset="utf-8" method="get" role="search">';
        $html .= '<input type="hidden" name="do" value="search">';
        $html .= '<input type="hidden" name="id" value="' . $ID . '">';
        $html .= '<input name="q" autocomplete="off" type="search" placeholder="' . $lang['btn_search'] . '" value="' . (($ACT == 'search') ? htmlspecialchars($QUERY) : '') . '" accesskey="f" title="[F]" />';
        $html .= '<button type="submit" title="' .  $lang['btn_search'] . '">';
        if ($this->getConf('searchButton') == 'icon') {
            $html .= $this->mikioInlineIcon('search');
        } else {
            $html .= $lang['btn_search'];
        }
        $html .= '</button>';
        $html .= '</form>';



        if ($print) print $html;
        return $html;
    }


    /**
     * Print or return content
     *
     * @param   boolean $print          print content
     * @return  string                  contents
     */
    public function includeContent($print = TRUE)
    {
        ob_start();
        tpl_content(FALSE);
        $html = ob_get_contents();
        ob_end_clean();

        $html = $this->includeIcons($html);
        $html = $this->parseContent($html);

        $html .= '<div style="clear:both"></div>';

        if (!$this->getConf('heroTitle')) $html = '<div class="mikio-tags"></div>' . $html;

        $html = '<div class="mikio-article-content">' . $html . '</div>';

        if ($print) echo $html;
        return $html;
    }

    /**
     * Print or return footer
     *
     * @param   boolean  $print     print footer
     * @return  string              html string containing footer
     */
    public function includeFooter($print = TRUE)
    {
        global $ACT;

        $html = '';

        $html .= '<footer class="mikio-footer">';
        $html .= '<div class="doc">' . tpl_pageinfo(TRUE) . '</div>';
        $html .= $this->includePage('footer', FALSE);

        $html .= $this->stringToNav($this->getConf('footerCustomMenuText'));

        if ($this->getConf('footerSearch')) {
            $html .= '<div class="mikio-footer-search">';
            $html .= $this->includeSearch(FALSE);
            $html .= '</div>';
        }

        $showPageTools = $this->getConf('pageToolsFooter');
        if ($ACT == 'show' && ($showPageTools == 'always' || $this->userCanEdit() && $showPageTools == 'page editors')) $html .= $this->includePageTools(FALSE);

        $meta['licenseType']            = array('multichoice', '_choices' => array('none', 'badge', 'button'));
        $meta['licenseImageOnly']       = array('onoff');

        $licenseType = $this->getConf('licenseType');
        if ($licenseType != 'none') {
            $html .= tpl_license($licenseType, $this->getConf('licenseImageOnly'), TRUE, TRUE);
        }

        $html .= '</footer>';

        if ($print) echo $html;
        return $html;
    }


    /**
     * Print or return breadcrumb trail
     *
     * @param   boolean  $print     print out trail
     * @param   boolean  $parse     parse trail before printing
     * @return  string              html string containing breadcrumbs
     */
    public function includeBreadcrumbs($print = TRUE, $parse = TRUE)
    {
        global $conf, $ID, $lang, $ACT;

        if ($this->getConf('breadcrumbHideHome') && $ID == 'start' && $ACT == 'show' || $ACT == 'showtag') return '';

        $html = '<div class="mikio-breadcrumbs">';
        $html .= '<div class="mikio-container">';
        if ($ACT == 'show') {
            if ($conf['breadcrumbs']) {
                if (!$this->getConf('breadcrumbPrefix') && !$this->getConf('breadcrumbSep')) {
                    ob_start();
                    tpl_breadcrumbs();
                    $html .= ob_get_contents();
                    ob_end_clean();
                } else {
                    $sep = '•';
                    $prefix = $lang['breadcrumb'];

                    if ($this->getConf('breadcrumbSep')) {
                        $sep = $this->getConf('breadcrumbSepText');
                        $img = $this->getMediaFile('breadcrumb-sep', FALSE);

                        if ($img !== FALSE) {
                            $sep = '<img src="' . $img . '">';
                        }
                    }

                    if ($this->getConf('breadcrumbPrefix')) {
                        $prefix = $this->getConf('breadcrumbPrefixText');
                        $img = $this->getMediaFile('breadcrumb-prefix', FALSE);

                        if ($img !== FALSE) {
                            $prefix = '<img src="' . $img . '">';
                        }
                    }

                    $crumbs = breadcrumbs();

                    $html .= '<ul>';
                    if ($prefix != '') $html .= '<li class="prefix">' . $prefix . '</li>';

                    $last = count($crumbs);
                    $i    = 0;
                    foreach ($crumbs as $id => $name) {
                        $i++;
                        $html .= '<li class="sep">' . $sep . '</li>';
                        $html .= '<li' . ($i == $last ? ' class="curid"' : '') . '>';
                        $html .= tpl_pagelink($id, NULL, TRUE);
                        $html .= '</li>';
                    }

                    $html .= '</ul>';
                }
            }
        }

        $html .= '</div>';
        $html .= '</div>';

        if ($parse) $html = $this->includeIcons($html);
        if ($print) echo $html;
        return $html;
    }

    /**
     * Print or return you are here trail
     *
     * @param   boolean  $print     print out trail
     * @param   boolean  $parse     parse trail before printing
     * @return  string              html string containing breadcrumbs
     */
    public function includeYouAreHere($print = TRUE, $parse = TRUE)
    {
        global $conf, $ID, $lang, $ACT;

        if ($this->getConf('youarehereHideHome') && $ID == 'start' && $ACT == 'show' || $ACT == 'showtag') return '';

        $html = '<div class="mikio-youarehere">';
        $html .= '<div class="mikio-container">';
        if ($ACT == 'show') {
            if ($conf['youarehere']) {
                if (!$this->getConf('youareherePrefix') && !$this->getConf('youarehereSep')) {
                    ob_start();
                    tpl_youarehere();
                    $html .= ob_get_contents();
                    ob_end_clean();
                } else {
                    $sep = ' » ';
                    $prefix = $lang['youarehere'];

                    if ($this->getConf('youarehereSep')) {
                        $sep = $this->getConf('youarehereSepText');
                        $img = $this->getMediaFile('youarehere-sep', FALSE);

                        if ($img !== FALSE) {
                            $sep = '<img src="' . $img . '">';
                        }
                    }

                    if ($this->getConf('youareherePrefix')) {
                        $prefix = $this->getConf('youareherePrefixText');
                        $img = $this->getMediaFile('youarehere-prefix', FALSE);

                        if ($img !== FALSE) {
                            $prefix = '<img src="' . $img . '">';
                        }
                    }

                    $html .= '<ul>';
                    if ($prefix != '') $html .= '<li class="prefix">' . $prefix . '</li>';
                    $html .= '<li>' . tpl_pagelink(':' . $conf['start'], NULL, TRUE) . '</li>';

                    $parts = explode(':', $ID);
                    $count = count($parts);

                    $part = '';
                    for ($i = 0; $i < $count - 1; $i++) {
                        $part .= $parts[$i] . ':';
                        $page = $part;
                        if ($page == $conf['start']) continue;

                        $html .= '<li class="sep">' . $sep . '</li>';
                        $html .= '<li>' . tpl_pagelink($page, NULL, TRUE) . '</li>';
                    }

                    resolve_pageid('', $page, $exists);
                    if (!(isset($page) && $page == $part . $parts[$i])) {
                        $page = $part . $parts[$i];
                        if ($page != $conf['start']) {
                            $html .= '<li class="sep">' . $sep . '</li>';
                            $html .= '<li>' . tpl_pagelink($page, NULL, TRUE) . '</li>';
                        }
                    }

                    $html .= '</ul>';
                }
            }

            $showLast = $this->getConf('youarehereShowLast');
            if ($showLast != 0) {
                preg_match_all('/(<li[^>]*>.+?<\/li>)/', $html, $matches);
                if (count($matches) > 0 && count($matches[0]) > ($showLast * 2) + 2) {
                    $count = count($matches[0]);
                    $list = '';

                    // Show Home
                    $list .= $matches[0][0] . $matches[0][1];

                    $list .= '<li>...</li>';
                    for ($i = $count - ($showLast * 2); $i <= $count; $i++) {
                        $list .= $matches[0][$i];
                    }

                    $html = preg_replace('/<ul>.*<\/ul>/', '<ul>' . $list . '</ul>', $html);
                }
            }

            switch ($this->getConf('youarehereHome')) {
                case 'none':
                    $html = preg_replace('/<li[^>]*>.+?<\/li>/', '', $html, 2);
                    break;
                case 'home':
                    $html = preg_replace('/(<a[^>]*>)(.+?)(<\/a>)/', '$1' . tpl_getlang('home') . '$3', $html, 1);
                    break;
                case 'icon':
                    $html = preg_replace('/(<a[^>]*>)(.+?)(<\/a>)/', '$1' . $this->mikioInlineIcon('home') . '$3', $html, 1);
                    break;
            }
        } else {
            $html .= '&#8810; ';
            if (isset($_GET['page'])) {
                $html .= '<a href="' . wl($ID, array('do' => $ACT)) . '">Back</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;';
            }
            $html .= '<a href="' . wl($ID) . '">View Page</a>';
        }

        $html .= '</div>';
        $html .= '</div>';

        if ($parse) $html = $this->includeIcons($html);
        if ($print) echo $html;
        return $html;
    }

    /**
     * Get Page Title
     */
    public function parsePageTitle()
    {
        global $ID;

        $title = p_get_first_heading($ID);
        if (strlen($title) <= 0) $title = tpl_pagetitle(null, TRUE);
        $title = $this->includeIcons($title);

        return $title;
    }


    /**
     * Print or return hero block
     *
     * @param   boolean $print          print content
     * @return  string                  contents of hero
     */
    public function includeHero($print = TRUE)
    {
        $html = '';

        if ($this->getConf('heroTitle')) {
            $html .= '<div class="mikio-hero">';
            $html .= '<div class="mikio-container">';
            $html .= '<div class="mikio-hero-text">';
            if ($this->getConf('youareherePosition') == 'hero') $html .= $this->includeYouAreHere(FALSE);
            if ($this->getConf('breadcrumbPosition') == 'hero') $html .= $this->includeBreadcrumbs(FALSE);

            $html .= '<h1 class="mikio-hero-title">';
            $html .= $this->parsePageTitle();    // No idea why this requires a blank space afterwards to work?
            $html .= '</h1>';
            $html .= '<h2 class="mikio-hero-subtitle"></h2>';
            $html .= '</div>';

            $hero_image = $this->getMediaFile('hero', TRUE, $this->getConf('heroImagePropagation', TRUE));
            $hero_image_resize_class = '';
            if ($hero_image != '') {
                $hero_image = ' style="background-image:url(\'' . $hero_image . '\');"';
                $hero_image_resize_class = ' mikio-hero-image-resize';
            }

            $html .= '<div class="mikio-hero-image' . $hero_image_resize_class . '"' . $hero_image . '><div class="mikio-tags"></div></div>';

            $html .= '</div>';
            $html .= '</div>';
        }

        if ($print) echo $html;

        return $html;
    }


    /**
     * Print or return out TOC
     *
     * @param   boolean $print          print TOC
     * @return  string                  contents of TOC
     */
    public function includeTOC($parse = TRUE)
    {
        $html = '';

        $tocHtml = tpl_toc(true);

        if ($tocHtml != '') {
            $tocHtml = preg_replace('/<li.*><div.*><a.*><\/a><\/div><\/li>\s*/', '', $tocHtml);
            $tocHtml = preg_replace('/<ul.*>\s*<\/ul>\s*/', '', $tocHtml);

            $html .= '<div class="mikio-toc">';
            $html .= $tocHtml;
            $html .= '</div>';
        }

        if ($parse) $html = $this->includeIcons($html);
        echo $html;
    }


    /**
     * Parse the string and replace icon elements with included icon libraries
     *
     * @param   string  $str        content to parse
     * @return  string              parsed string
     */
    public function includeIcons($str)
    {
        global $ACT, $MIKIO_ICONS;

        $iconTag = $this->getConf('iconTag', 'icon');
        if ($iconTag == '') return $str;

        if ($ACT == 'show' || $ACT == 'admin' && count($MIKIO_ICONS) > 0 || $ACT == 'showtag' || $ACT == 'revisions' || $ACT == 'index' || $ACT == 'preview') {
            $content = $str;
            $preview = null;

            if ($ACT == 'preview') {
                $html = new \simple_html_dom;
                $html->stripRNAttrValues = false;
                $html->load($str, true, false);

                $preview = $html->find('div.preview');
                if (is_array($preview) && count($preview) > 0) {
                    $content = $preview[0]->innertext;
                }
            }

            $page_regex = '/(.*)/';
            if (stripos($str, '<pre')) {
                $page_regex = '/<(?!pre|\/).*?>(.*)[^<]*/';
            }

            $content = preg_replace_callback($page_regex, function ($icons) {
                $iconTag = $this->getConf('iconTag', 'icon');

                return preg_replace_callback(
                    '/&lt;' . $iconTag . ' ([\w\- #]*)&gt;(?=[^>]*(<|$))/',
                    function ($matches) {
                        global $MIKIO_ICONS;

                        $s = $matches[0];

                        if (count($MIKIO_ICONS) > 0) {
                            $icon = $MIKIO_ICONS[0];

                            if (count($matches) > 1) {
                                $e = explode(' ', $matches[1]);

                                if (count($e) > 1) {
                                    foreach ($MIKIO_ICONS as $iconItem) {
                                        if (strcasecmp($iconItem['name'], $e[0]) == 0) {
                                            $icon = $iconItem;

                                            $s = $icon['insert'];
                                            for ($i = 1; $i < 9; $i++) {
                                                if (count($e) < $i || $e[$i] == '') {
                                                    if (isset($icon['$' . $i])) {
                                                        $s = str_replace('$' . $i, $icon['$' . $i], $s);
                                                    }
                                                } else {
                                                    $s = str_replace('$' . $i, $e[$i], $s);
                                                }
                                            }

                                            $dir = '';
                                            if (isset($icon['dir'])) $dir = $this->baseDir . 'icons/' . $icon['dir'] . '/';

                                            $s = str_replace('$0', $dir, $s);

                                            break;
                                        }
                                    }
                                } else {
                                    $s = str_replace('$1', $matches[1], $icon['insert']);
                                }
                            }
                        }

                        $s = preg_replace('/(class=")(.*)"/', '$1mikio-icon $2"', $s, -1, $count);
                        if ($count == 0) {
                            $s = preg_replace('/(<\w* )/', '$1class="mikio-icon" ', $s);
                        }

                        return $s;
                    },
                    $icons[0]
                );
            }, $content);

            if ($ACT == 'preview') {
                if (is_array($preview) && count($preview) > 0) {
                    $preview[0]->innertext = $content;
                }

                $str = $html->save();
                $html->clear();
                unset($html);
            } else {
                $str = $content;
            }
        }

        return $str;
    }

    /**
     * Parse HTML for theme
     *
     * @param   string  $content    HTML content to parse
     * @return  string              Parsed content
     */
    public function parseContent($content)
    {
        global $INPUT, $ACT;

        // Add Mikio Section titles
        if ($INPUT->str('page') == 'config') {
            $admin_sections = array(
                // Section      Insert Before                       Icon
                'navbar'        => array('navbarUseTitleIcon',      ''),
                'search'        => array('searchButton',            ''),
                'hero'          => array('heroTitle',               ''),
                'tags'          => array('tagsConsolidate',         ''),
                'breadcrumb'    => array('breadcrumbHideHome',      ''),
                'youarehere'    => array('youareherePosition',      ''),
                'sidebar'       => array('sidebarShowLeft',         ''),
                'toc'           => array('tocFull',                 ''),
                'pagetools'     => array('pageToolsFloating',       ''),
                'footer'        => array('footerCustomMenuText',    ''),
                'license'       => array('licenseType',             ''),
                'acl'           => array('includePageUseACL',       ''),
                'sticky'        => array('stickyTopHeader',         ''),
            );

            foreach ($admin_sections as $section => $items) {
                $search = $items[0];
                $icon   = $items[1];

                // $content = preg_replace('/<tr(.*)>\s+<td(.*)>\s+<span(.*)>(tpl»mikio»' . $search . ')<\/span>/',
                // '<tr class="default"><td class="mikio-config-table-header" colspan="2">' . $this->mikioInlineIcon($icon) . tpl_getLang('config_' . $section) . '</td></tr><tr$1><td$2><span$3>$4</span>', $content);

                $content = preg_replace(
                    '/<tr(.*)>\s*<td class="label">\s*<span class="outkey">(tpl»mikio»' . $search . ')<\/span>/',
                    '<tr$1><td class="mikio-config-table-header" colspan="2">' . $this->mikioInlineIcon($icon) . tpl_getLang('config_' . $section) . '</td></tr><tr class="default"><td class="label"><span class="outkey">tpl»mikio»' . $search . '</span>',
                    $content
                );
            }
        }

        if ($ACT == 'admin' && !isset($_GET['page'])) {
            $content = preg_replace('/(<ul.*?>.*?)<\/ul>.*?<ul.*?>(.*?<\/ul>)/s', '$1$2', $content);
        }

        // Page Revisions - Table Fix
        if (strpos($content, 'id="page__revisions"') !== FALSE) {
            $content = preg_replace('/(<span class="sum">\s.*<\/span>\s.*<span class="user">\s.*<\/span>)/', '<span>$1</span>', $content);
        }

        $html = new \simple_html_dom;
        $html->stripRNAttrValues = false;
        $html->load($content, true, false);

        if (!$html) return $content;

        /* Buttons */
        foreach ($html->find('#config__manager button') as $node) {
            $c = explode(' ', $node->class);
            if (!in_array('mikio-button', $c)) $c[] = 'mikio-button';
            $node->class = implode(' ', $c);
        }


        /* Buttons - Primary */
        foreach ($html->find('#config__manager [type=submit]') as $node) {
            $c = explode(' ', $node->class);
            if (!in_array('mikio-primary', $c)) $c[] = 'mikio-primary';
            $node->class = implode(' ', $c);
        }

        /* Hide page title if hero is enabled */
        if ($this->getConf('heroTitle') && $ACT != 'preview') {
            $pageTitle = $this->parsePageTitle();

            foreach ($html->find('h1,h2,h3,h4') as $elm) {
                if ($elm->innertext == $pageTitle) {
                    // $elm->innertext = '';
                    $elm->setAttribute('style', 'display:none');

                    break;
                }
            }
        }

        /* Hero subtitle */
        foreach ($html->find('p') as $elm) {
            $i = stripos($elm->innertext, '~~hero-subtitle');
            if ($i !== false) {
                $j = strpos($elm->innertext, '~~', $i + 2);
                if ($j !== false) {
                    if ($j > $i + 16) {
                        $subtitle = substr($elm->innertext, $i + 16, $j - $i - 16);
                        $this->footerScript['hero-subtitle'] = 'mikio.setHeroSubTitle(\'' . $subtitle . '\')';

                        // $elm->innertext = substr($elm->innertext, 0, $i + 2) . substr($elm->innertext, $j + 2);
                        $elm->innertext = preg_replace('/~~hero-subtitle (.+?)~~.*/ui', '', $elm->innertext);
                    }

                    break;
                }
            }
        }

        /* Hero image */
        foreach ($html->find('p') as $elm) {
            $image = '';
            preg_match('/~~hero-image (.+?)~~(?!.?")/ui', $elm->innertext, $matches);
            if (count($matches) > 0) {
                preg_match('/<img.*src="(.+?)"/ui', $matches[1], $imageTagMatches);
                if (count($imageTagMatches) > 0) {
                    $image = $imageTagMatches[1];
                } else {
                    preg_match('/<a.+?>(.+?)[~<]/ui', $matches[1], $imageTagMatches);
                    if (count($imageTagMatches) > 0) {
                        $image = $imageTagMatches[1];
                    } else {
                        $image = strip_tags($matches[1]);
                        if (stripos($image, ':') === FALSE) {
                            $image = str_replace(array('{', '}'), '', $image);
                            $i = stripos($image, '?');
                            if ($i !== FALSE) {
                                $image = substr($image, 0, $i);
                            }

                            $image = ml($image, '', true, '', false);
                        }
                    }
                }

                $this->footerScript['hero-image'] = 'mikio.setHeroImage(\'' . $image . '\')';

                $elm->innertext = preg_replace('/~~hero-image (.+?)~~.*/ui', '', $elm->innertext);
            }
        }

        /* Hero colors - ~~hero-colors [background-color] [hero-title-color] [hero-subtitle-color] [breadcrumb-text-color] [breadcrumb-hover-color] (use 'initial' for original color) */
        foreach ($html->find('p') as $elm) {
            $i = stripos($elm->innertext, '~~hero-colors');
            if ($i !== false) {
                $j = strpos($elm->innertext, '~~', $i + 2);
                if ($j !== false) {
                    if ($j > $i + 14) {
                        $color = substr($elm->innertext, $i + 14, $j - $i - 14);
                        $this->footerScript['hero-colors'] = 'mikio.setHeroColor(\'' . $color . '\')';

                        $elm->innertext = preg_replace('/~~hero-colors (.+?)~~.*/ui', '', $elm->innertext);
                    }

                    break;
                }
            }
        }

        /* Hide parts - ~~hide-parts [parts]~~  */
        foreach ($html->find('p') as $elm) {
            $i = stripos($elm->innertext, '~~hide-parts');
            if ($i !== false) {
                $j = strpos($elm->innertext, '~~', $i + 2);
                if ($j !== false) {
                    if ($j > $i + 13) {
                        $parts = explode(' ', substr($elm->innertext, $i + 13, $j - $i - 13));
                        $script = '';

                        foreach ($parts as $part) {
                            // $part = trim($part);
                            if (strlen($part) > 0) {
                                $script .= 'mikio.hidePart(\'' . $part . '\');';
                            }
                        }

                        if (strlen($script) > 0) {
                            $this->footerScript['hide-parts'] = $script;
                        }

                        $elm->innertext = preg_replace('/~~hide-parts (.+?)~~.*/ui', '', $elm->innertext);
                    }

                    break;
                }
            }
        }


        /* Page Tags (tag plugin) */
        if ($this->getConf('tagsConsolidate')) {
            $tags = '';
            foreach ($html->find('div.tags a') as $elm) {
                $tags .= $elm->outertext;
            }

            foreach ($html->find('div.tags') as $elm) {
                $elm->innertext = '';
                $elm->setAttribute('style', 'display:none');
            }

            if ($tags != '') {
                $this->footerScript['tags'] = 'mikio.setTags(\'' . $tags . '\')';
            }
        }

        // Configuration Manager
        if ($INPUT->str('page') == 'config') {

            // Additional save buttons
            foreach ($html->find('#config__manager') as $cm) {
                $saveButtons = '';

                foreach ($cm->find('p') as $elm) {
                    $saveButtons = $elm->outertext;
                    $saveButtons = str_replace('<p>', '<p style="text-align:right">', $saveButtons);
                    $elm->outertext = '';
                }

                foreach ($cm->find('fieldset') as $elm) {
                    $elm->innertext .= $saveButtons;
                }
            }
        }

        $content = $html->save();
        $html->clear();
        unset($html);

        return $content;
    }


    /**
     * Get DokuWiki namespace/page/URI as link
     *
     * @param   string  $str            string to parse
     * @return  string                  parsed uri
     */
    public function getLink($str)
    {
        $i = strpos($str, '://');
        if ($i !== false) return $str;

        return wl($str);
    }


    /**
     * Check if the user can edit current namespace/page
     *
     * @return  boolean                  user can edit
     */
    public function userCanEdit()
    {
        global $INFO;
        global $ID;

        $wiki_file = wikiFN($ID);
        if (@!file_exists($wiki_file)) return true;
        if ($INFO['isadmin'] || $INFO['ismanager']) return true;
        // $meta_file = metaFN($ID, '.meta');
        if (!$INFO['meta']['user']) return true;
        if ($INFO['client'] ==  $INFO['meta']['user']) return true;

        return false;
    }


    /**
     * Search for and return the uri of a media file
     * 
     * @param string    $image              image name to search for (without extension)
     * @param bool      $searchCurrentNS    search the current namespace
     * @return string                       uri of the found media file
     */
    public function getMediaFile($image, $searchCurrentNS = TRUE, $propagate = TRUE)
    {
        global $INFO;

        $ext = array('png', 'jpg', 'gif', 'svg');

        if ($searchCurrentNS) $prefix[] = ':' . $INFO['namespace'] . ':';
        if ($propagate) {
            $prefix[] = ':';
            $prefix[] = ':wiki:';
        }
        $theme = $this->getConf('customTheme');
        if ($theme != '') $prefix[] = $this->tplDir . 'themes/' . $theme . '/images/';
        $prefix[] = 'images/';

        $search = array();
        foreach ($prefix as $pitem) {
            foreach ($ext as $eitem) {
                $search[] = $pitem . $image . '.' . $eitem;
            }
        }

        $img = '';
        $file = '';
        $url = '';
        $ismedia = false;
        $found = false;

        foreach ($search as $img) {
            if (substr($img, 0, 1) == ':') {
                $file    = mediaFN($img);
                $ismedia = true;
            } else {
                $file    = tpl_incdir() . $img;
                $ismedia = false;
            }

            if (file_exists($file)) {
                $found = true;
                break;
            }
        }

        if (!$found) return false;

        if ($ismedia) {
            $url = ml($img, '', true, '', false);
        } else {
            $url = tpl_basedir() . $img;
        }

        return $url;
    }


    /**
     * Print or return the page title
     * 
     * @param string    $page       page id or empty string for current page
     * @return string               generated content
     */
    public function getPageTitle($page = '')
    {
        global $ID, $conf;

        $html = '';

        if ($page == '') $page = $ID;

        $html = p_get_first_heading($page);
        $html = strip_tags($html);
        $html = preg_replace('/\s+/', ' ', $html);
        $html .= ' [' . strip_tags($conf['title']) . ']';
        $html = trim($html);

        return $html;
    }


    /**
     * Return inline theme icon
     *
     * @param   string  $type           icon to retreive
     * @return  string                  html icon content
     */
    public function mikioInlineIcon($type)
    {
        switch ($type) {
            case 'wrench':
                return '<svg class="mikio-iicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,53.152542,1217.0847)"><path d="m 384,64 q 0,26 -19,45 -19,19 -45,19 -26,0 -45,-19 -19,-19 -19,-45 0,-26 19,-45 19,-19 45,-19 26,0 45,19 19,19 19,45 z m 644,420 -682,-682 q -37,-37 -90,-37 -52,0 -91,37 L 59,-90 Q 21,-54 21,0 21,53 59,91 L 740,772 Q 779,674 854.5,598.5 930,523 1028,484 z m 634,435 q 0,-39 -23,-106 Q 1592,679 1474.5,595.5 1357,512 1216,512 1031,512 899.5,643.5 768,775 768,960 q 0,185 131.5,316.5 131.5,131.5 316.5,131.5 58,0 121.5,-16.5 63.5,-16.5 107.5,-46.5 16,-11 16,-28 0,-17 -16,-28 L 1152,1120 V 896 l 193,-107 q 5,3 79,48.5 74,45.5 135.5,81 61.5,35.5 70.5,35.5 15,0 23.5,-10 8.5,-10 8.5,-25 z"/></g></svg>';
            case 'file':
                return '<svg class="mikio-iicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,235.38983,1277.8305)" id="g2991"><path d="M 128,0 H 1152 V 768 H 736 q -40,0 -68,28 -28,28 -28,68 v 416 H 128 V 0 z m 640,896 h 299 L 768,1195 V 896 z M 1280,768 V -32 q 0,-40 -28,-68 -28,-28 -68,-28 H 96 q -40,0 -68,28 -28,28 -28,68 v 1344 q 0,40 28,68 28,28 68,28 h 544 q 40,0 88,-20 48,-20 76,-48 l 408,-408 q 28,-28 48,-76 20,-48 20,-88 z" id="path2993" inkscape:connector-curvature="0" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" /></g></svg>';
            case 'gear':
                return '<svg class="mikio-iicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,121.49153,1285.4237)" id="g3027"><path d="m 1024,640 q 0,106 -75,181 -75,75 -181,75 -106,0 -181,-75 -75,-75 -75,-181 0,-106 75,-181 75,-75 181,-75 106,0 181,75 75,75 75,181 z m 512,109 V 527 q 0,-12 -8,-23 -8,-11 -20,-13 l -185,-28 q -19,-54 -39,-91 35,-50 107,-138 10,-12 10,-25 0,-13 -9,-23 -27,-37 -99,-108 -72,-71 -94,-71 -12,0 -26,9 l -138,108 q -44,-23 -91,-38 -16,-136 -29,-186 -7,-28 -36,-28 H 657 q -14,0 -24.5,8.5 Q 622,-111 621,-98 L 593,86 q -49,16 -90,37 L 362,16 Q 352,7 337,7 323,7 312,18 186,132 147,186 q -7,10 -7,23 0,12 8,23 15,21 51,66.5 36,45.5 54,70.5 -27,50 -41,99 L 29,495 Q 16,497 8,507.5 0,518 0,531 v 222 q 0,12 8,23 8,11 19,13 l 186,28 q 14,46 39,92 -40,57 -107,138 -10,12 -10,24 0,10 9,23 26,36 98.5,107.5 72.5,71.5 94.5,71.5 13,0 26,-10 l 138,-107 q 44,23 91,38 16,136 29,186 7,28 36,28 h 222 q 14,0 24.5,-8.5 Q 914,1391 915,1378 l 28,-184 q 49,-16 90,-37 l 142,107 q 9,9 24,9 13,0 25,-10 129,-119 165,-170 7,-8 7,-22 0,-12 -8,-23 -15,-21 -51,-66.5 -36,-45.5 -54,-70.5 26,-50 41,-98 l 183,-28 q 13,-2 21,-12.5 8,-10.5 8,-23.5 z" id="path3029" inkscape:connector-curvature="0" /></g></svg>';
            case 'user':
                return '<svg class="mikio-iicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,197.42373,1300.6102)"><path d="M 1408,131 Q 1408,11 1335,-58.5 1262,-128 1141,-128 H 267 Q 146,-128 73,-58.5 0,11 0,131 0,184 3.5,234.5 7,285 17.5,343.5 28,402 44,452 q 16,50 43,97.5 27,47.5 62,81 35,33.5 85.5,53.5 50.5,20 111.5,20 9,0 42,-21.5 33,-21.5 74.5,-48 41.5,-26.5 108,-48 Q 637,565 704,565 q 67,0 133.5,21.5 66.5,21.5 108,48 41.5,26.5 74.5,48 33,21.5 42,21.5 61,0 111.5,-20 50.5,-20 85.5,-53.5 35,-33.5 62,-81 27,-47.5 43,-97.5 16,-50 26.5,-108.5 10.5,-58.5 14,-109 Q 1408,184 1408,131 z m -320,893 Q 1088,865 975.5,752.5 863,640 704,640 545,640 432.5,752.5 320,865 320,1024 320,1183 432.5,1295.5 545,1408 704,1408 863,1408 975.5,1295.5 1088,1183 1088,1024 z"/></g></svg>';
            case 'search':
                return '<svg class="mikio-iicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" aria-hidden="true" style="fill:currentColor"><path d="M27 24.57l-5.647-5.648a8.895 8.895 0 0 0 1.522-4.984C22.875 9.01 18.867 5 13.938 5 9.01 5 5 9.01 5 13.938c0 4.929 4.01 8.938 8.938 8.938a8.887 8.887 0 0 0 4.984-1.522L24.568 27 27 24.57zm-13.062-4.445a6.194 6.194 0 0 1-6.188-6.188 6.195 6.195 0 0 1 6.188-6.188 6.195 6.195 0 0 1 6.188 6.188 6.195 6.195 0 0 1-6.188 6.188z"/></svg>';
            case 'home':
                return '<svg class="mikio-iicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 1792" aria-hidden="true" style="fill:currentColor"><g transform="matrix(1,0,0,-1,68.338983,1285.4237)" id="g3015"><path d="M 1408,544 V 64 Q 1408,38 1389,19 1370,0 1344,0 H 960 V 384 H 704 V 0 H 320 q -26,0 -45,19 -19,19 -19,45 v 480 q 0,1 0.5,3 0.5,2 0.5,3 l 575,474 575,-474 q 1,-2 1,-6 z m 223,69 -62,-74 q -8,-9 -21,-11 h -3 q -13,0 -21,7 L 832,1112 140,535 q -12,-8 -24,-7 -13,2 -21,11 l -62,74 q -8,10 -7,23.5 1,13.5 11,21.5 l 719,599 q 32,26 76,26 44,0 76,-26 l 244,-204 v 195 q 0,14 9,23 9,9 23,9 h 192 q 14,0 23,-9 9,-9 9,-23 V 840 l 219,-182 q 10,-8 11,-21.5 1,-13.5 -7,-23.5 z" id="path3017" inkscape:connector-curvature="0" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" /></g></svg>';
        }

        return '';
    }

    /**
     * Finalize theme
     */
    public function finalize()
    {
    }

    /**
     * Show Messages
     */
    public function showMessages()
    {
        global $ACT;

        if ($this->lessIgnored) {
            msg('useLESS is enabled on the Mikio template, however is not supported on this server', 2, '', '', MSG_ADMINS_ONLY);
        }

        $show = $this->getConf('showNotifications');
        if ($show == 'always' || ($show == 'admin' && $ACT == 'admin')) {
            global $MSG, $MSG_shown;

            if (!isset($MSG)) {
                return;
            }

            if (!isset($MSG_shown)) {
                $MSG_shown = array();
            }

            foreach ($MSG as $msg) {

                $hash = md5($msg['msg']);
                if (isset($MSG_shown[$hash])) {
                    continue;
                }
                // skip double messages

                if (info_msg_allowed($msg)) {

                    print '<div class="' . $msg['lvl'] . '">';
                    print $msg['msg'];
                    print '</div>';
                }

                $MSG_shown[$hash] = true;
            }

            unset($GLOBALS['MSG']);
        }
    }
}

global $TEMPLATE;
$TEMPLATE = \dokuwiki\template\mikio\Template::getInstance();
