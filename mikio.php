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

class Template {
    public $tplDir  = '';
    public $baseDir = '';


    /**
     * Class constructor
     */
    public function __construct() {
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
    private function _registerHooks() {
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
    public function metaHeadersHandler(\Doku_Event $event) {
        global $MIKIO_ICONS;
        
        $stylesheets    = array();
        $scripts        = array();

        if($this->getConf('customTheme') != '') {
            if(file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/style.css')) {
                $stylesheets[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/style.css';
            }
            if(file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/script.js')) {
                $scripts[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/script.js';
            }
        }

        if(is_array($MIKIO_ICONS)) {
            $icons = Array();
            foreach($MIKIO_ICONS as $icon) {
                if(isset($icon['name']) && isset($icon['css']) && isset($icon['insert'])) {
                    $icons[] = $icon;

                    if($icon['css'] != '') {
                        if(strpos($icon['css'], '//') === FALSE) {
                            // $stylesheets[] = $this->baseDir . 'icons/' . $icon['css'];
                        } else {
                            // $stylesheets[] = $icon['css'];
                        }
                    }
                }
            }
            $MIKIO_ICONS = $icons;
        } else {
            $MIKIO_ICONS = [];
        }

        $scripts[] = $this->baseDir . 'assets/mikio.js';
        $stylesheets[] = $this->baseDir . 'assets/mikio.less';
       
        $set = [];
        foreach ($stylesheets as $style) {
            if(in_array($style, $set) == FALSE) {
                if(strtolower(substr($style, -5)) == '.less') {
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
            if(in_array($script, $set) == FALSE) {
                $event->data['script'][] = array(
                    'type'  => 'text/javascript',
                    '_data' => '',
                    'src'   => $script);
            }
            $set[] = $script;
        }
    }
  
  
    /**
     * DokuWiki content event handler
     *
     * @author  James Collins <james.collins@outlook.com.au>
     */
    /*public function contentHandler(\Doku_Event $event)
    {
        $event->data = $this->parseContent($event->data);
    }*/


    /** ----
     * Retreive and parse theme configuration options
     *
     * @param   string  $key        the configuration key to retreive
     * @param   mixed   $default    if key doesn't exist, return this value
     * @return  mixed               parsed value of configuration
     */
    public function getConf($key, $default = FALSE) {

        $value = tpl_getConf($key, $default);
        
        // switch($key) {

        // }

        return $value;
    }
  
    
    /**
     * Icon
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $type       The type of icon to return
     * @return  string              HTML for icon element
     */
    public function icon($type) {
        return '<i class="fa fa-' . $type . '" aria-hidden="true"></i>';
    }




     /**
     * Add class to first DOM element
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $content    HTML DOM
     * @param   string  $class      Class to add DOM elements
     * @return  string              HTML DOM with class added
     */
    public function elementAddClass($html, $class) {
        preg_match('/class.*?".*?"/', $html, $matches);
        if(count($matches) > 0) {
            preg_match('/[" ]'.$class.'[" ]/', $matches[0], $matches);
            if(count($matches) == 0) {
                return preg_replace('/(class.*?=.*?")/', '${1}'.$class.' ', $html, 1);
            }
        } else {
            return preg_replace('/>/', 'class="'.$class.'">', $html, 1);
        }

        return $html;
    }
  
  
    public function includeFile($file, $print = true) {
        $html = '';
        
        if(!$print) {
            ob_start();
        }
        
        tpl_includeFile($file);

        if(!$print) {
            $html = ob_get_contents();
            ob_end_clean();
        }

        return $html;
    }

    /**
     * include page from namespace
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $page   namespace to include
     * @param   boolean $print  print content
     * @param   boolean $parse  parse content before printing/returning
     * @return  string          contents of page found
     */
    public function includePage($page, $print = TRUE, $parse = TRUE)
    {
        $useACL = TRUE; // TODO Add these as config options?
        $propagate = TRUE;
        $checkPropagate = TRUE; // TODO Add these as config options?
        $html = '';

        $html = tpl_include_page($page, false, $propagate, $useACL);
        if($html == '' && $checkPropagate) {
            $html = tpl_include_page($page, false, false, $useACL);
        }

        if($html != '' && $parse) {
            $html = $this->parseContent($html);
        }

        if($print) echo $html;

        return $html;
    }

    public function includeLoggedIn() {
        if (!empty($_SERVER['REMOTE_USER'])) {
            echo '<li class="user navbar-text text-nowrap">';
            tpl_userinfo(); /* 'Logged in as ...' */
            echo '</li>';
        }
    }


    public function includeMenu($type, $print = true, $class = '') {
        global $lang;
        global $USERINFO;
        $html = '<ul class="mikio-nav ' . $class . '">';

        switch($type) {
            
            case 'none';
                return '';
            
            case 'custom':
            case 'footer':
                $items = [];

                if($type == 'footer') {
                    $items = explode(';', $this->getConf('footerCustomMenuText', ''));
                } else {
                    $items = explode(';', $this->getConf('navbarCustomMenuText', ''));
                }

                foreach($items as $item) {
                    $parts = explode('|', $item);
                    if($parts > 1) {
                        $html .= '<li class="mikio-nav-item"><a class="mikio-nav-link" href="' . strip_tags($this->getLink(trim($parts[0]))) . '">' . strip_tags(trim($parts[1])) . '</a></li>';
                    }
                }

                break;

            case 'dokuwiki':
                $pageToolsMenu = [];
                $siteToolsMenu = [];
                $userToolsMenu = [];

                $showIcons  = ($this->getConf('navbarDWMenuType') != 'text');
                $showText   = ($this->getConf('navbarDWMenuType') != 'icons');
                $isDropDown = ($this->getConf('navbarDWMenuCombine') != 'seperate');

                $items = (new \dokuwiki\Menu\PageMenu())->getItems();
                foreach($items as $item) {
                    if($item->getType() != 'top') {
                        $itemHtml = '';

                        $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown ? 'mikio-dropdown-item' : '') . '" href="'.$item->getLink().'" title="'.$item->getTitle().'">';
                        if($showIcons) $itemHtml .= '<span class="mikio-icon">'.inlineSVG($item->getSvg()).'</span>';
                        if($showText || $isDropDown) $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                        $itemHtml .= '</a>';

                        $pageToolsMenu[] = $itemHtml;
                    }
                }

                $items = (new \dokuwiki\Menu\SiteMenu())->getItems('action ');
                foreach($items as $item) {
                    $itemHtml = '';

                    $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown ? 'mikio-dropdown-item' : '') . '" href="'.$item->getLink().'" title="'.$item->getTitle().'">';
                    if($showIcons) $itemHtml .= '<span class="mikio-icon">'.inlineSVG($item->getSvg()).'</span>';
                    if($showText || $isDropDown) $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                    $itemHtml .= '</a>';

                    $siteToolsMenu[] = $itemHtml;
                }
    
                $items = (new \dokuwiki\Menu\UserMenu())->getItems('action');
                foreach($items as $item) {
                    $itemHtml = '';

                    $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown ? 'mikio-dropdown-item' : '') . '" href="'.$item->getLink().'" title="'.$item->getTitle().'">';
                    if($showIcons) $itemHtml .= '<span class="mikio-icon">'.inlineSVG($item->getSvg()).'</span>';
                    if($showText || $isDropDown) $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                    $itemHtml .= '</a>';

                    $userToolsMenu[] = $itemHtml;
                }
        

                switch($this->getConf('navbarDWMenuCombine')) {
                    case 'dropdown':
                        $html .= '<li id="dokuwiki__pagetools" class="mikio-nav-dropdown">';
                        $html .= '<a id="mikio_dropdown_pagetools" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . ($showIcons ? $this->icon('file') : '') . ($showText ? $lang['page_tools'] : '') . '</a>';
                        $html .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="mikio_dropdown_pagetools">';

                        foreach($pageToolsMenu as $item) {
                            $html .= $item;
                        }

                        $html .= '</div>';
                        $html .= '</li>';

                        $html .= '<li id="dokuwiki__sitetools" class="nav-item dropdown mikio-navbar-dropdown">';
                        $html .= '<a id="mikio_dropdown_sitetools" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . ($showIcons ? $this->icon('gear') : '') . ($showText ? $lang['site_tools'] : '') . '</a>';
                        $html .= '<div class="dropdown-menu dropdown-menu-right">';

                        foreach($siteToolsMenu as $item) {
                            $html .= $item;
                        }

                        $html .= '</div>';
                        $html .= '</li>';

                        $html .= '<li id="dokuwiki__usertools" class="nav-item dropdown mikio-navbar-dropdown">';
                        $html .= '<a id="mikio_dropdown_usertools" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . ($showIcons ? $this->icon('user') : '') . ($showText ? $lang['user_tools'] : '') . '</a>';
                        $html .= '<div class="dropdown-menu dropdown-menu-right">';

                        foreach($userToolsMenu as $item) {
                            $html .= $item;
                        }

                        $html .= '</div>';
                        $html .= '</li>';

                        break;

                    case 'combine':
                        $html .= '<li class="mikio-nav-dropdown">';
                        $html .= '<a class="mikio-nav-link" href="#">' . ($showIcons ? $this->icon('wrench') : '') . '' . '</a>';   // TODO change $lang
                        $html .= '<div class="mikio-dropdown">';

                        $html .= '<h6 class="mikio-dropdown-header">' . $lang['page_tools'] . '</h6>';
                        foreach($pageToolsMenu as $item) {
                            $html .= $item;
                        }

                        $html .= '<div class="mikio-dropdown-divider"></div>';
                        $html .= '<h6 class="mikio-dropdown-header">' . $lang['site_tools'] . '</h6>';
                        foreach($siteToolsMenu as $item) {
                            $html .= $item;
                        }

                        $html .= '<div class="mikio-dropdown-divider"></div>';
                        $html .= '<h6 class="mikio-dropdown-header">' . $lang['user_tools'] . '</h6>';
                        foreach($userToolsMenu as $item) {
                            $html .= $item;
                        }

                        $html .= '</div>';
                        $html .= '</li>';
                        break;

                    default:    // seperate
                        foreach($userToolsMenu as $item) {
                            $html .= '<li class="nav-item mikio-navbar-seperate">' . $item . '<li>';
                        }

                        foreach($siteToolsMenu as $item) {
                            $html .= '<li class="nav-item mikio-navbar-seperate">' . $item . '<li>';
                        }

                        foreach($pageToolsMenu as $item) {
                            $html .= '<li class="nav-item mikio-navbar-seperate">' . $item . '<li>';
                        }

                        break;
                }

                
                break;

        }

        $html .= '</ul>';

        if($print) {
            echo $html;
            return '';
        }

        return $html;
    }


    /** ----
     * print or return the main navbar
     * 
     * @param boolean   $print      print the 
     * 
     * @return string               generated content
     */
    public function includeNavbar($print = TRUE) {
        global $conf;
        $html = '';
        $class = '';

        $html .= '<nav class="mikio-navbar">';
        $html .= '<a class="mikio-navbar-brand" href="' . wl() . '">';
        if($this->getConf('navbarUseTitleIcon') || $this->getConf('navbarUseTitleText')) {

            // Brand image
            if($this->getConf('navbarUseTitleIcon')) {
                $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png', 'images/logo.jpg', 'images/logo.gif'), false);
                if($logo != '') {
                    $html .= '<img src="' . $logo . '" class="mikio-navbar-brand-image">';
                }
            }

            // Brand title
            if($this->getConf('navbarUseTitleText')) {
                $html .= '<div class="mikio-navbar-brand-title">';
                    $html .= '<div class="mikio-navbar-brand-title-text">' . $conf['title'] . '</div>';
                    if($this->getConf('navbarUseTaglineText')) {
                        $html .= '<div class="mikio-navbar-brand-title-tagline">' . $conf['tagline'] . '</div>';
                    }
                $html .= '</div>';
            }
        }
        $html .= '</a>';
        $html .= '<div class="mikio-navbar-toggle"><svg viewBox="0 0 32 32" preserveAspectRatio="xMidYMin" aria-hidden="true"><path d="M6.001 7.128L6 10.438l19.998-.005L26 7.124zM6.001 21.566L6 24.876l19.998-.006.002-3.308zM6.001 14.341L6 17.65l19.998-.004.002-3.309z"></path></svg></div>';
        // $html .= '</div>';

        // Menus
        $html .= '<div class="mikio-navbar-collapse">';

            $html .= '<div class="mikio-nav-item">';
            $html .= $this->includeSearch(false);
            $html .= '</div>';

            $html .= '<div class="mikio-nav-item">';
            $menu = $this->getConf('navbarPosRightRight');
            $html .= $this->includeMenu($menu, false);
            $html .= '</div>';

        $html .= '</div>';

        $html .= '</nav>';

        // Seperate Menubar
        if($this->getConf('navbarLowerMenu') != 'none') {
            $class = $this->getConf('navbarLowerBackground');
            if($class == 'none') {
                $class = '';
            } else {
                $class = 'navbar-' . $class;
            }

            $pos = $this->getConf('navbarLowerMenuPos');
            if($pos == 'right') {
                $class .= ' justify-content-end';
            } else if($pos == 'center') {
                $class .= ' justify-content-center';
            }

            $html .= '<nav class="mikio-lower-navbar navbar navbar-expand flex-column flex-md-row ' . $class . '">';
            
            $menu = $this->getConf('navbarLowerMenu');
            if($menu != 'none' && $menu != 'search') {
                $html .= '<div class="mikio-nav-item navbar-nav-scroll">';
                $html .= $this->includeMenu($menu, false);
                $html .= '</div>';
                $class = '';
            } else if($menu == 'search') {
                $html .= '<div class="mikio-nav-item">';
                $html .= $this->includeSearch(false);
                $html .= '</div>';
                $class = '';
            }

            $html .= '</nav>';
        }

        if($print) {
            echo $html;
            return '';
        }

        return $html;
    }


    /** ----
     * Print or return the sidebar content
     *
     * @param   string  $prefix     sidebar prefix to use when searching
     * @param   boolean $print      print the generated content to the output buffer
     * @param   boolean $parse      parse the content
     * 
     * @return  string              generated content
     */
    public function includeSidebar($prefix = '', $print = TRUE, $parse = TRUE) {
        global $conf, $ID;

        $html = '';
        $confPrefix = preg_replace('/[^a-zA-Z0-9]/', '', ucwords($prefix));
        $prefix = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($prefix));
        
        if($confPrefix == '') $confPrefix = 'Left';
        if($prefix == 'Left') $prefix = '';

        if($this->getConf('sidebarShow' . $confPrefix) && page_findnearest($conf[$prefix . 'sidebar']) != FALSE && p_get_metadata($ID, 'nosidebar', FALSE) == FALSE) {

            $content = $this->includeFile('sidebar' . $prefix . 'header.html', FALSE);
            if($content != '') $html .= '<div class="mikio-sidebar-header">' . $content . '</div>';

            if($prefix == '' && $this->getConf('sidebarLeftSearch') == 'top') $html .= $this->includeSearch(FALSE);
            
            $content = $this->includePage($conf[$prefix . 'sidebar'], FALSE);
            if($content != '') $html .= '<div class="mikio-sidebar-content">' . $content . '</div>';

            if($prefix == '' && $this->getConf('sidebarLeftSearch') == 'bottom') $html .= $this->includeSearch(FALSE);

            $content = $this->includeFile('sidebar' . $prefix . 'footer.html', FALSE);
            if($content != '') $html .= '<div class="mikio-sidebar-footer">' . $content . '</div>';
        }

        if($html != '') {
            $html = '<aside class="mikio-sidebar mikio-sidebar-' . ($prefix == '' ? 'left' : $prefix) . '"><a class="mikio-sidebar-toggle" href="#">' . tpl_getLang('sidebar-title') . '</a><div class="mikio-sidebar-collapse">'. $html . '</div></aside>';
        }

        if($parse) $html = $this->includeIcons($html);
        if($print) echo $html;
        return $html;
    }


    /** ----
     * Print or return the page tools content
     *
     * @param   boolean $print      print the generated content to the output buffer
     * @param   boolean $includeId  include the dw__pagetools id in the element
     * 
     * @return  string              generated content
     */
    public function includePageTools($print = TRUE, $includeId = FALSE) {
        $html = '';

        $html .= '<nav' . ($includeId ? ' id="dw__pagetools"' : '') . ' class="hidden-print dw__pagetools">';

        $items = (new \dokuwiki\Menu\PageMenu())->getItems();
        foreach($items as $item) {
            $html .= '<a href="'.$item->getLink().'" title="'.$item->getTitle().'"><span class="icon">'.inlineSVG($item->getSvg()).'</span><span class="a11y">'.$item->getLabel().'</span></a>';
        }
        
        $html .= '</nav>';

        if($print) echo $html;
        return $html;
    }


    public function includeSearch($print = TRUE, $class = '') {
        global $lang;
        $html = '';

        // $html .= '<div class="mikio-search">';
        $html .= '<form class="mikio-search" action="' . wl($ID) . '" accept-charset="utf-8" method="get" role="search">';
            $html .= '<input class="mikio-control" autocomplete="off" type="search" placeholder="' . $lang['btn_search'] . '" value="' . (($ACT == 'search') ? htmlspecialchars($QUERY) : '') . '" accesskey="f" title="[F]" />';
                $html .= '<button class="mikio-control" type="submit" title="' .  $lang['btn_search'] . '">';
                    if($this->getConf('searchButton') == 'icon') {
                        $html .= $this->icon('search');
                    } else {
                        $html .= $lang['btn_search'];
                    }
                $html .= '</button>';
        $html .= '</form>';
        // $html .= '</div>';

        // $html .= '<div class="mikio-search ' . $class . '">';
        // $html .= '<form action="' . wl($ID) . '" accept-charset="utf-8" class="form-inline search" method="get" role="search">';
        //     $html .= '<div class="input-group"><input id="sqsearch" autocomplete="off" type="search" placeholder="' . $lang['btn_search'] . '" value="' . (($ACT == 'search') ? htmlspecialchars($QUERY) : '') . '" accesskey="f" name="q" class="form-control" title="[F]" />';
        //         $html .= '<div class="input-group-append"><button class="btn btn-secondary" type="submit" title="' .  $lang['btn_search'] . '">';
        //             if($this->getConf('searchButton') == 'icon') {
        //                 $html .= $this->icon('search');
        //             } else {
        //                 $html .= $lang['btn_search'];
        //             }
        //         $html .= '</button></div></div>';
        //         $html .= '<input type="hidden" name="do" value="search" />';
        // $html .= '</form>';
        // $html .= '</div>';

        if($print) {
            print $html;
            return '';
        }

        return $html;
    }


    public function includeContent($print = FALSE) {
        ob_start();
        tpl_content(false);
        $html = ob_get_contents();
        ob_end_clean();

        $html = $this->includeIcons($html);
        $html = $this->parseContent($html);

        $html .= '<div style="clear:both"></div>';

        if($print) echo $html;
        return $html;
    }

    /** ----
     * Print or return footer
     *
     * @param   boolean  $print     print footer
     * @return  string              html string containing footer
     */
    public function includeFooter($print = TRUE) {
        global $ACT;

        $html = '';

        $html .= '<footer class="mikio-footer">';
        $html .= '<div class="doc">' . tpl_pageinfo(TRUE) . '</div>';
        $html .= $this->includeFile(TRUE);
        if($ACT == 'show') {
            $this->includePage('footer');
        }

        if($this->getConf('footerCustomMenuText') != '') {
            $html .= $this->includeMenu('footer', FALSE);
        }
        
        if($this->getConf('footerSearch')) {
            $html .= '<div class="mikio-footer-search">';
            $html .= $this->includeSearch(FALSE);
            $html .= '</div>';
        }
        
        if($this->getConf('pageToolsFooter') != '' && $ACT == 'show') {
            $html .= $this->includePageTools(FALSE);
        }

        $meta['licenseType']            = array('multichoice', '_choices' => array('none', 'badge', 'button'));
        $meta['licenseImageOnly']       = array('onoff');
        
        $licenseType = $this->getConf('licenseType');
        if($licenseType != 'none') {
            $html .= tpl_license($licenseType, $this->getConf('licenseImageOnly'), TRUE, TRUE);
        }

        $html .= '</footer>';

        if($print) echo $html;
        return $html;
    }


    /** ----
     * Print or return breadcrumb trail
     *
     * @param   boolean  $print     print out trail
     * @param   boolean  $parse     parse trail before printing
     * @return  string              html string containing breadcrumbs
     */
    public function includeBreadcrumbs($print = TRUE, $parse = TRUE) {
        global $conf, $ID, $lang;

        $html = '<div class="mikio-breadcrumbs">';

        if($conf['breadcrumbs']) {
            if(!$this->getConf('breadcrumbPrefix') && !$this->getConf('breadcrumbSep')) {
                ob_start();
                tpl_breadcrumbs();
                $html .= ob_get_contents();
                ob_end_clean();
            } else {
                $sep = '•';
                $prefix = $lang['breadcrumb'];
                
                if($this->getConf('breadcrumbSep')) {
                    $sep = $this->getConf('breadcrumbSepText');
                    $img = $this->getMediaFile('breadcrumb-sep');
                    
                    if($img !== FALSE) {
                        $sep = '<img src="' . $img . '">';
                    }
                }

                if($this->getConf('breadcrumbPrefix')) {
                    $prefix = $this->getConf('breadcrumbPrefixText');
                    $img = $this->getMediaFile('breadcrumb-prefix');
                    
                    if($img !== FALSE) {
                        $prefix = '<img src="' . $img . '">';
                    }
                }   

                $crumbs = breadcrumbs();

                $html .= '<ul>';
                if($prefix != '') $html .= '<li class="prefix">' . $prefix . '</li>';

                $last = count($crumbs);
                $i    = 0;
                foreach($crumbs as $id => $name) {
                    $i++;
                    $html .= '<li class="sep">' . $sep . '</li>';
                    $html .= '<li' . ($i == $last ? ' class="curid"' : '') . '>';
                    $html .= tpl_pagelink($id, NULL, TRUE);
                    $html .= '</li>';
                }

                $html .= '</ul>';
            }
        } else if($conf['youarehere']) {
            if(!$this->getConf('breadcrumbPrefix') && !$this->getConf('breadcrumbSep')) {
                ob_start();
                tpl_youarehere();
                $html .= ob_get_contents();
                ob_end_clean();
            } else {
                $sep = ' » ';
                $prefix = $lang['youarehere'];
                
                if($this->getConf('breadcrumbSep')) {
                    $sep = $this->getConf('breadcrumbSepText');
                    $img = $this->getMediaFile('breadcrumb-sep');
                    
                    if($img !== FALSE) {
                        $sep = '<img src="' . $img . '">';
                    }
                }

                if($this->getConf('breadcrumbPrefix')) {
                    $prefix = $this->getConf('breadcrumbPrefixText');
                    $img = $this->getMediaFile('breadcrumb-prefix');
                    
                    if($img !== FALSE) {
                        $prefix = '<img src="' . $img . '">';
                    }
                }   

                $html .= '<ul>';
                if($prefix != '') $html .= '<li class="prefix">' . $prefix . '</li>';
                $html .= '<li>' . tpl_pagelink(':'.$conf['start'], NULL, TRUE) . '</li>';

                $parts = explode(':', $ID);
                $count = count($parts);

                $part = '';
                for($i = 0; $i < $count - 1; $i++) {
                    $part .= $parts[$i].':';
                    $page = $part;
                    if($page == $conf['start']) continue;

                    $html .= '<li class="sep">' . $sep . '</li>';
                    $html .= '<li>' . tpl_pagelink($page, NULL, TRUE) . '</li>';
                }

                resolve_pageid('', $page, $exists);
                if(!(isset($page) && $page == $part.$parts[$i])) {
                    $page = $part.$parts[$i];
                    if($page != $conf['start']) {
                        $html .= '<li class="sep">' . $sep . '</li>';
                        $html .= '<li>' . tpl_pagelink($page, NULL, TRUE) . '</li>';
                    }
                }

                $html .= '</ul>';
            }
        }    

        $html .= '</div>';
        
        if($parse) $html = $this->includeIcons($html);
        if($print) echo $html;
        return $html;
    }



    /**
     * Print out hero
     *
     * @author  James Collins <james.collins@outlook.com.au>
     */
    public function includeHero() {
        global $ACT;
        global $INFO;

        // file_put_contents('output.txt', print_r($INFO, true));

        if($ACT == 'show') {
            if($this->getConf('heroTitle')) {
                print '<div class="mikio-hero d-flex flex-row">';
                    print '<div class="mikio-hero-text flex-grow-1">';
                        if ($ACT == 'show' && $this->getConf('breadcrumbPos') == 'hero') print $this->includeBreadcrumbs();

                        print '<h1 id="mikio-hero-title">';
                            print tpl_pagetitle(null, true).' ';    // No idea why this requires a blank space afterwards to work?
                        print '</h1>';
                        print '<h2 class="mikio-hero-subtext">';
                            // print $this->heroSubtitle;       // TODO scrape page for hero subtitle
                        print '</h2>';
                    print '</div>';


                    $hero_image = tpl_getMediaFile(array(':' . $INFO['namespace'] . ':hero.png', ':' . $INFO['namespace'] . ':hero.jpg', ':hero.png', ':hero.jpg', ':wiki:hero.png', ':wiki:hero.jpg', 'images/hero.png', 'images/hero.jpg'), false);
                    if($hero_image != '') $hero_image = ' style="background-image:url(\''.$hero_image.'\');"';

                    print '<div class="mikio-hero-image"' . $hero_image . '></div>';
                print '</div>';
            }
        }
    }


    /**
     * Print out TOC
     *
     * @param   boolean 
     * 
     * @author  James Collins <james.collins@outlook.com.au>
     */
    public function includeTOC($parse = TRUE) {
        $html = '';

        $tocHtml = tpl_toc(true);
        
        if($tocHtml != '') {
            $tocHtml = preg_replace('/<li.*><div.*><a.*><\/a><\/div><\/li>\s*/', '', $tocHtml);

            $html .= '<div class="mikio-toc">';
            $html .= $tocHtml;
            $html .= '</div>';
        }

        if($parse) $html = $this->includeIcons($html);
        echo $html;
    }
    
    
    /** ----
     * Parse the string and replace icon elements with included icon libraries
     *
     * @param   string  $str        content to parse
     * @return  string              parsed string
     */
    public function includeIcons($str) {
        global $ACT, $MIKIO_ICONS;
        
        $iconTag = $this->getConf('iconTag', 'icon');

        if($ACT == 'show' || $ACT == 'admin' && count($MIKIO_ICONS) > 0) {
            $str = preg_replace_callback('/&lt;' . $iconTag . ' ([\w\- #]*)&gt;(?=[^>]*(<|$))/', 
                function ($matches) {
                    global $MIKIO_ICONS;

                    $s = $matches[0];

                    if(count($MIKIO_ICONS) > 0) {
                        $icon = $MIKIO_ICONS[0];
                        
                        if(count($matches) > 1) {
                            $e = explode(' ', $matches[1]);
                            
                            if(count($e) > 1) {
                                foreach($MIKIO_ICONS as $iconItem) {
                                    if(strcasecmp($iconItem['name'], $e[0]) == 0) {
                                        $icon = $iconItem;
                                        
                                        $s = $icon['insert'];
                                        for($i = 1; $i < 9; $i++) {
                                            if(count($e) < $i || $e[$i] == '') {
                                                if(isset($icon['$'.$i])) {
                                                    $s = str_replace('$' . $i, $icon['$'.$i], $s);
                                                }
                                            } else {
                                                $s = str_replace('$' . $i, $e[$i], $s);
                                            }
                                        }

                                        $dir = '';
                                        if(isset($icon['dir'])) $dir = $this->baseDir . 'icons/' . $icon['dir'] . '/';

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
                    if($count == 0) {
                        $s = preg_replace('/(<\w* )/', '$1class="mikio-icon" ', $s);
                    }

                    return $s;
                },
                $str);
        }

        return $str;
    }

    /**
     * Parse HTML for bootstrap
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $content    HTML content to parse
     * @return  string              Parsed HTML for bootstrap
     */
    public function parseContent($content) {
        global $INPUT, $ACT;



        /*
        return $content;

        if($INPUT->str('page') == 'config') {
            // Mikio sections
            $admin_sections = array(
                // Section                  Insert Before           Icon
                'navbar'            => array('navbarUseTitleIcon',       'mdi:palette'),
            );

            foreach ($admin_sections as $section => $items) {

                $search = $items[0];
                $icon   = $items[1];

                // $content = preg_replace('/<tr(.*)>\s+<td(.*)>\s+<span(.*)>(tpl»mikio»' . $search . ')<\/span>/',
                //     '</table></div></fieldset><fieldset id="bootstrap3__' . $section . '"><legend>' . $icon . ' ' . tpl_getLang("config_$section") . '</legend><div class="table-responsive"><table class="table table-hover table-condensed inline"><tr$1><td$2><span$3>$4</span>', $content);

                $content = preg_replace('/<tr(.*)>\s+<td(.*)>\s+<span(.*)>(tpl»mikio»' . $search . ')<\/span>/',
                '<tr class="default"><td class="mikio-config-table-header" colspan="2">' . tpl_getLang('config_' . $section) . '</td></tr><tr$1><td$2><span$3>$4</span>', $content);

                

       
            }
        }
*/

        

        $html = new \simple_html_dom;
        $html->load($content, true, false);

        if (!$html) return $content;

        /* Buttons */
        foreach($html->find('#config__manager button') as $node) {
            $c = explode(' ', $node->class);
            if(!in_array('mikio-button', $c)) $c[] = 'mikio-button';
            $node->class = implode(' ', $c);
        }


        /* Buttons - Primary */
        foreach($html->find('#config__manager [type=submit]') as $node) {
            $c = explode(' ', $node->class);
            if(!in_array('mikio-primary', $c)) $c[] = 'mikio-primary';
            $node->class = implode(' ', $c);
        }




        $content = $html->save();
        $html->clear();
        unset($html);

        return $content;







        # Hide page title if hero is enabled
        if($this->getConf('heroTitle')) {
            $pageTitle = tpl_pagetitle(null, true);
            
            foreach($html->find('h1,h2,h3,h4') as $elm) {
                if($elm->innertext == $pageTitle) {
                    $elm->innertext = '';
                    break;
                }
            }
        }

        # Hero subtitle
        foreach($html->find('p') as $elm) {
            $i = stripos($elm->innertext, '~~hero-subtitle');
            if($i !== false) {
                $j = strpos($elm->innertext, '~~', $i + 2);
                if($j !== false) {
                    if($j > $i + 16) {
                        $subtitle = substr($elm->innertext, $i + 16, $j - $i - 16);
                        foreach($html->find('.mikio-hero-subtext') as $subtitleElm) {
                           $subtitleElm->innertext = $subtitle;
                        }
                    }

                    $elm->innertext = substr($elm->innertext, $j + 2);
                    break;
                }
            }
        }

        // Buttons
        // foreach($html->find('.button') as $elm) {
        //     if ($elm->tag == 'form') {
        //         continue;
        //     }
        //     $elm->class .= ' btn';
        // }

        foreach($html->find('#config__manager [type=submit], #edbtn__save, #dw__login [type=submit]') as $elm) {
            if(stripos($elm->class, 'btn') === FALSE) {
                $elm->class .= ' btn btn-primary';
            }
        }

        foreach($html->find('button, [type=button], [type=submit], [type=reset]') as $elm) {
            if(stripos($elm->class, 'btn') === FALSE) {
                $elm->class .= ' btn btn-outline-secondary';
            }
        }

        foreach($html->find('.btn_secedit [type=submit]') as $elm) {
            $elm->class .= ' btn-sm';
        }


        # Section Edit icons
        foreach($html->find('.secedit.editbutton_section button') as $elm) {
            $elm->innertext = '<i class="fa fa-edit" aria-hidden="true"></i> ' . $elm->innertext;
        }

        // Success
        foreach($html->find('div.success') as $elm) {
            $elm->class = 'alert alert-success'; //str_ireplace('success', 'alert alert-success', $elm->class);
        }

        // Error
        foreach($html->find('div.error') as $elm) {
            $elm->class = 'alert alert-danger'; //str_ireplace('success', 'alert alert-success', $elm->class);
        }

        // Forms
        foreach($html->find('input, select') as $elm) {
            $elm->class .= ' form-control';
        }

        foreach($html->find('h1, h2, h3, h4, h5') as $elm) {
            preg_match_all('/&lt;(.*)&gt;/iU', $elm->innertext, $matches);
            if(count($matches) >= 2 && (count($matches[0]) == count($matches[1]))) {
                for($i = 0; $i < count($matches[0]); $i++) {
                    $icon = '';

                    $class = explode(' ', $matches[1][$i]);
                    if(count($class) >= 2) {
                        $icon = '<i class="fa fa-' . $class[1] . '"></i>';
                    }
                    
                    $elm->innertext = str_ireplace($matches[0][$i], $icon, $elm->innertext);
                    }
            }
        }

        // Tables
        foreach($html->find('table') as $elm) {
            $elm->class .= ' table-striped';
        }

        // Tabs
        foreach($html->find('ul.tabs') as $tabs) {
            $tabs->class = 'nav nav-tabs';
            foreach($tabs->find('li') as $tab) {
                $tab->class .= ' nav-item';

                foreach($tab->find('a') as $link) {
                    if(stripos($tab->class, 'active') !== FALSE) {
                        $link->class .= 'active';
                    }

                    $link->class .= ' nav-link';
                }
            }
        }

        // Toolbar
        foreach($html->find('.tool__bar') as $toolbar) {
            $toolbar->class .= ' btn-group';
        }

        // Configuration Manager
        if($INPUT->str('page') == 'config') {

            // Additional save buttons
            foreach ($html->find('#config__manager') as $cm) {
                $saveButtons = '';

                foreach($cm->find('p') as $elm) {
                    $saveButtons = $elm->outertext;
                    $elm->outertext = '';
                }

                foreach($cm->find('fieldset') as $elm) {
                    $elm->innertext .= $saveButtons;
                }
            }

        }
        
        $content = $html->save();
        $html->clear();
        unset($html);

        // Remove icons
        // $content = preg_replace('/&lt;icon .*&gt;[ +]/', '', $content);
        $content = $this->includeIcons($content);

        return $content;
    }


    /*** GET LINK ***/
    public function getLink($str) {
        $i = strpos($str, '://');
        if($i !== false) return $str;

        return wl($str);
    }


    public function userCanEdit() {
        global $INFO;
        global $ID;

        $wiki_file = wikiFN($ID);
        if (@!file_exists($wiki_file)) return true;
        if ($INFO['isadmin'] || $INFO['ismanager']) return true;
        $meta_file = metaFN($ID, '.meta');
        if (!$INFO['meta']['user']) return true;
        if ($INFO['client'] ==  $INFO['meta']['user']) return true;

        return false;
    }


    public function getMediaFile($image) {
        global $INFO;
        $prefix = array(':'.$INFO['namespace'].':', ':', ':wiki:');
        $ext = array('png', 'jpg', 'gif', 'svg');

        $prefix[] = ':'.$INFO['namespace'].':';
        $prefix[] = ':';
        $prefix[] = ':wiki:';
        $theme = $this->getConf('customTheme');
        if($theme != '') $prefix[] = $this->tplDir . 'themes/' . $theme . '/images/';
        $prefix[] = 'images/';

        $search = array();
        foreach($prefix as $pitem) {
            foreach($ext as $eitem) {
                $search[] = $pitem . $image . '.' . $eitem;
            }
        }

        $img = '';
        $file = '';
        $url = '';
        $ismedia = false;
        $found = false;

        foreach($search as $img) {
            if(substr($img, 0, 1) == ':') {
                $file    = mediaFN($img);
                $ismedia = true;
            } else {
                $file    = tpl_incdir().$img;
                $ismedia = false;
            }
    
            if(file_exists($file)) {
                $found = true;
                break;
            }
        }

        if(!$found) return false;

        if($ismedia) {
            $url = ml($img, '', true, '', false);
        } else {
            $url = tpl_basedir().$img;
        }
    
        return $url;
    }

    /** ----
     * Print or return the page title
     * 
     * @param string    $page       page id or empty string for current page
     * @param boolean   $print      print the generated content to the output buffer
     * 
     * @return string               generated content
     */
    public function includePageTitle($page = '', $print = TRUE) {
        global $ID, $conf;

        $html = '';

        if($page == '') $page = $ID;

        $html = p_get_first_heading($page);
        $html = strip_tags($html);
        $html = preg_replace('/\s+/', ' ', $html);
        $html .= ' [' . strip_tags($conf['title']) . ']';
        $html = trim($html);

        if($print) echo $html;
        return $html;
    }
}



global $TEMPLATE;
$TEMPLATE = \dokuwiki\template\mikio\Template::getInstance();
