<?php

namespace dokuwiki\template\mikio;

/**
 * DokuWiki Mikio Template
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license MIT License (https://raw.githubusercontent.com/nomadjimbob/Mikio/master/LICENSE)
 */

if (!defined('DOKU_INC')) die();

require_once('inc/simple_html_dom.php');

class Template {
  public $tplDir  = '';
  public $baseDir = '';


    /**
     * Class constructor
     *
     * @author  James Collins <james.collins@outlook.com.au>
     */
    public function __construct() {
      $this->tplDir  = tpl_incdir();
      $this->baseDir = tpl_basedir();
  
      $this->_registerHooks();
     }


    /**
     * Get the singleton instance
     *
     * @return Template
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
     * Register themes DokuWiki hooks
     *
     * @author  James Collins <james.collins@outlook.com.au>
     */
    private function _registerHooks() {
        global $EVENT_HANDLER;

         $events_dispatcher = array(
            'TPL_METAHEADER_OUTPUT'     => 'metaheadersHandler',
            // 'TPL_CONTENT_DISPLAY'       => 'contentHandler',
        );

        foreach ($events_dispatcher as $event => $method) {
            $EVENT_HANDLER->register_hook($event, 'BEFORE', $this, $method);
        }
    }


    /**
     * DokuWiki META Header event handler
     *
     * @author  James Collins <james.collins@outlook.com.au>
     */
    public function metaHeadersHandler(\Doku_Event $event) {
        $stylesheets    = array();
        $scripts        = array();

        if($this->getConf('useTheme') != '') {
            if(file_exists($this->tplDir . 'themes/' . $this->getConf('useTheme') . '/style.css')) {
                $stylesheets[] = $this->baseDir . 'themes/' . $this->getConf('useTheme') . '/style.css';
            }
            if(file_exists($this->tplDir . 'themes/' . $this->getConf('useTheme') . '/script.js')) {
                $scripts[] = $this->baseDir . 'themes/' . $this->getConf('useTheme') . '/script.js';
            }
        }

        if($this->getConf('includeFontAwesome') == true) $stylesheets[] = $this->baseDir . 'assets/fontawesome/css/all.min.css';

        $scripts[] = $this->baseDir . 'assets/bootstrap/popper.min.js';
        $scripts[] = $this->baseDir . 'assets/bootstrap/bootstrap.min.js';
        $stylesheets[] = $this->baseDir . 'assets/bootstrap/bootstrap.min.css';
        $stylesheets[] = $this->baseDir . 'assets/mikio.css';
      
        foreach ($stylesheets as $style) {
            array_unshift($event->data['link'], array(
                'type' => 'text/css',
                'rel'  => 'stylesheet',
                'href' => $style
            ));
        }

        foreach ($scripts as $script) {
            $event->data['script'][] = array(
                 'type'  => 'text/javascript',
              '_data' => '',
              'src'   => $script
          );
      }
    }
  
  
    /**
     * DokuWiki content event handler
     *
     * @author  James Collins <james.collins@outlook.com.au>
     */
    public function contentHandler(\Doku_Event $event)
    {
        $event->data = $this->parseContent($event->data);
    }


    /**
     * Parse configuration options
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $key        The configuration key to retreive
     * @param   mixed   $default    If key doesn't exist, return this value
     * @return  mixed               Parsed value of configuration
     */
    public function getConf($key, $default = false) {
        global $ACT, $conf;

        $value = tpl_getConf($key, $default);
        
        switch($key) {
        
            case 'navbar':  // TODO is this needed?
                $value = explode(',', $value);
                break;

            case 'showSidebar':
                if ($ACT !== 'show') {
                    return false;
                }

                return page_findnearest($conf['sidebar'], $this->getConf('useACL'));

            case 'navbarMenuStyle':
                if($value != 'text') {
                    if(!$this->getConf('useFontAwesome')) {
                        return 'text';
                    }
                }

            break;

            case 'navbarMenuPosition':
                if($value == 'right') {
                    return 'ml-md-auto';
                }

                return '';

            case 'breadcrumbsLoc':
                if(!$this->getConf('useHeroTitle') && $value == 'hero') {
                    return 'top';
                }

                if($value != 'top' && $value != 'hero' && $value != 'page') {
                    return 'page';
                }

                break;
        }

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
        if($this->getConf('useFontAwesome')) {
            return '<i class="fa fa-' . $type . '" aria-hidden="true"></i>';
        }

        return '';
    }


    /**
     * Print the Navbar menu title/icon
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $type       The type of icon to return
     * @return  string              HTML for icon element
     */
    public function navbarMenuTitle($title, $icon) {
        global $lang;

        $menu = '';

        if($this->getConf('navbarMenuStyle') != 'text') {
            $menu .= $this->icon($icon);
        }

        if($this->getConf('navbarMenuStyle') != 'icon') {
            $menu .= $lang[$title];
        }
        
        echo $menu;
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
  
  
    /**
     * Include Page
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $location
     * @param   boolean $return
     * @return  string
     */
    public function includePage($location, $return = false)
    {

        $content = '';

        if($content === '') $content = tpl_include_page($location, 0, 1, $this->getConf('useACL'));

        if($content === '') return '';

        $content = $this->parseContent($content);

        if($return) return $content;

        print $content;
        return '';
    }

    public function includeLoggedIn() {
        if (!empty($_SERVER['REMOTE_USER'])) {
            echo '<li class="user navbar-text text-nowrap">';
            tpl_userinfo(); /* 'Logged in as ...' */
            echo '</li>';
        }
    }


    /**
     * Include Menus
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $location
     */
    public function includeMenu($location) {
        global $lang;
        global $USERINFO;

        $conf = $this->getConf('navbarIconsText');
        $dropdown = $this->getConf('navbarUseDropdown');
        $hideIcons = ($conf == 'text');
        $hideText = ($conf == 'icons');
        $guestMode = $this->getConf('navbarGuestHide') && ($USERINFO == false);

        if(!$hideText && !$hideIcons) $hideText = false;        
        
        if(!$guestMode) {
            // Page tools
            $items = (new \dokuwiki\Menu\PageMenu())->getItems();
            print '<li id="dokuwiki__pagetools" class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . (!$hideIcons ? $this->icon('file') : '') . (!$hideText ? $lang['page_tools'] : '') . '</a><div class="dropdown-menu dropdown-menu-right">';
            foreach($items as $item) {
                if($item->getType() != 'top') {
                    print '<a class="' . ($dropdown ? 'dropdown-item' : 'nav-item nav-link') . '" href="'.$item->getLink().'" title="'.$item->getTitle().'">';
                    if(!$hideIcons) print '<span class="icon">'.inlineSVG($item->getSvg()).'</span>';
                    if(!$hideText || $dropdown) print '<span>' . $item->getLabel() . '</span>';
                    print '</a>';
                }
            }
            if($dropdown) print '</div></li>';

            // Site tools
            $items = (new \dokuwiki\Menu\SiteMenu())->getItems('action ');

            print '<li id="dokuwiki__sitetools" class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . (!$hideIcons ? $this->icon('gear') : '') . (!$hideText ? $lang['site_tools'] : '') . '</a><div class="dropdown-menu dropdown-menu-right">';
            foreach($items as $item) {
                print '<a class="' . ($dropdown ? 'dropdown-item' : 'nav-item nav-link') . '" href="'.$item->getLink().'" title="'.$item->getTitle().'">';
                if(!$hideIcons) print '<span class="icon">'.inlineSVG($item->getSvg()).'</span>';
                if(!$hideText || $dropdown) print '<span>' . $item->getLabel() . '</span>';
                print '</a>';
            }
            if($dropdown) print '</div></li>';
        }

        // User tools
        $items = (new \dokuwiki\Menu\UserMenu())->getItems('action');
        if(!$guestMode) print '<li id="dokuwiki__usertools" class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . (!$hideIcons ? $this->icon('user') : '') . (!$hideText ? $lang['user_tools'] : '') . '</a><div class="dropdown-menu dropdown-menu-right">';
        foreach($items as $item) {
            if(!$guestMode || $item->getType() == 'login') {
                print '<a class="' . (($dropdown && !$guestMode) ? 'dropdown-item' : 'nav-item nav-link') . '" href="'.$item->getLink().'" title="'.$item->getTitle().'">';
                if(!$hideIcons) print '<span class="icon">'.inlineSVG($item->getSvg()).'</span>';
                if(!$hideText || ($dropdown && !$guestMode)) print '<span>' . $item->getLabel() . '</span>';
                print '</a>';
            }
        }
        if($dropdown && !$guestMode) print '</div></li>';
        
    }

    /**
     * Include Sidebar
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $type       Sidebar type
     * @return  boolean             If sidebar was added
     */
    public function includeSidebar($type) {
        global $conf;
        global $ID;

        $useACL = true; // Add these as config options?
        $propagate = true;
        $checkPropagate = true; // Add these as config options?

        switch($type) {
            case 'left':
                if($this->getConf('showSidebar') && page_findnearest($conf['sidebar'], $useACL) != false && p_get_metadata($ID, 'nosidebar', false) == false) {
                    $sidebar = tpl_includeFile('sidebarheader.html', false);

                    $sidebar .= $this->includeSearch('sidebar-top', false);

                    $confSidebar = tpl_include_page($conf['sidebar'], false, $propagate, $useACL);
                    if($checkPropagate && $confSidebar == '') {
                        $confSidebar = tpl_include_page($conf['sidebar'], false, false, $useACL);
                    }
                    $sidebar .= $confSidebar;

                    $sidebar .= $this->includeSearch('sidebar-bottom', false);
                    $sidebar .= tpl_includeFile('sidebarfooter.html', false);

                    if($sidebar != '') {
                        print '<aside class="col-md-2">' . $sidebar . '</aside>';
                    }

                    return true;
                }

                return false;       
        }

        return false;
    }

    /**
     * Include Page Tools
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $location       Page tools location
     * @return  boolean             If page tools was added
     */
    public function includePageTools($location) {
        $id = '';
        $group_class = 'btn-group';

        if((!$this->getConf('hidePageTools') && $location == 'side') || (!$this->getConf('hidePageToolsFooter') && $location == 'footer')) {
            if($location == 'side') {
                $id = 'dw__pagetools';
                $group_class = 'btn-group-vertical';
            }

            print '<nav id="' . $id . '" class="hidden-print dw__pagetools">';
                print '<div class="' . $group_class . '">';

                $items = (new \dokuwiki\Menu\PageMenu())->getItems();
                foreach($items as $item) {
                    print '<a class="btn btn-sm btn-light" href="'.$item->getLink().'" title="'.$item->getTitle().'">'
                    .'<span class="icon">'.inlineSVG($item->getSvg()).'</span>'
                    . '<span class="a11y">'.$item->getLabel().'</span>'
                    . '</a>';
                }
                
                print '</div>';
            print '</nav>';
        }
    }

    /**
     * Include Search
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $location   Search location
     * @return  boolean             If search was added
     */
    public function includeSearch($location, $print=true) {
        global $lang;

        //<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        $out = '';

        if($location == $this->getConf('navbarSearchPosition') || ($location == 'footer' && $this->getConf('showSearchInFooter')) || ($location == 'sidebar-top' && $this->getConf('showSearchInSidebar') == 'top') || ($location == 'sidebar-bottom' && $this->getConf('showSearchInSidebar') == 'bottom')) {
            $out .= '<form action="' . wl($ID) . '" accept-charset="utf-8" class="form-inline search" id="dw__search" method="get" role="search">';
                $out .= '<div class="input-group"><input id="sqsearch" autocomplete="off" type="search" placeholder="' . $lang['btn_search'] . '" value="' . (($ACT == 'search') ? htmlspecialchars($QUERY) : '') . '" accesskey="f" name="q" class="form-control" title="[F]" style="height:auto"/>';
                    $out .= '<div class="input-group-append"><button class="btn btn-secondary" type="submit" title="' .  $lang['btn_search'] . '">';
                        $out .= $this->icon('search'); //$lang['btn_search'];  // TODO show icon if conf says and font awesome installed
                    $out .= '</button></div></div>';
                    $out .= '<input type="hidden" name="do" value="search" />';
            $out .= '</form>';
        }

        if($print) {
            print $out;
            return '';
        }

        return $out;
    }


    /**
     * Include Custom menus
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $location   menu location
     * @return  boolean             If menu was added
     */
    public function includeCustomMenu($location, $addOuter=true) {
        if(($location == 'navbar' && $this->getConf('showCustomPagesInNavbar')) || ($location == 'footer' && $this->getConf('showCustomPagesInFooter'))) {
            if($addOuter) {
                print '<ul class="nav">';
            }

            $menuList = $this->getConf('navbarCustomPages');
            
            if($menuList != '') {
                $menuList = explode(',', $menuList);
                
                foreach($menuList as $item) {
                    $i = strpos($item, '|');
                    if($i !== false) {
                        $url = $this->getLink(trim(substr($item, 0, $i)));
                        $title = trim(substr($item, $i + 1));

                        print('<li class="nav-item"><a href="' . $url . '" class="nav-link">' . $title . '</a></li>');
                    }
                }
            }        

            if($addOuter) {
                print '</ul>';
            }
        }
    }

    /**
     * Print out breadcrumbs
     *
     * @author  James Collins <james.collins@outlook.com.au>
     * 
     * @param   string  $location   Location of breadcrumbs
     */
    public function includeBreadcrumbs($location) {
        if($location == $this->getConf('breadcrumbsLoc')) {
            global $conf;

            print '<div class="mikio-breadcrumbs">';

            if($conf['breadcrumbs']) {
                tpl_breadcrumbs();
            }
    
            if($conf['youarehere']) {
                tpl_youarehere();
            }    

            print '</div>';
        }
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
            if($this->getConf('useHeroTitle')) {
                print '<div class="mikio-hero d-flex flex-row">';
                    print '<div class="mikio-hero-text flex-grow-1">';
                        $this->includeBreadcrumbs('hero');
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
     * @author  James Collins <james.collins@outlook.com.au>
     */
    public function includeTOC($location) {
        if($this->getConf('tocfullheight') && $location === 'full') {
            $toc = tpl_toc(true);
            
            if($toc != '') {
                print '<div class="mikio-toc mikio-toc-full">';
                print $toc;
                print '</div>';
            }
        } else if(!$this->getConf('tocfullheight') && $location === 'float') {
            $toc = tpl_toc(true);
            
            if($toc != '') {
                print '<div class="mikio-toc mikio-toc-float">';
                print $toc;
                print '</div>';
            }
        }
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
        $html = new \simple_html_dom;
        $html->load($content, true, false);

        # Return original content if Simple HTML DOM fail or exceeded page size (default MAX_FILE_SIZE => 600KB)
        if (!$html) {
            return $content;
        }

        # Hide page title if hero is enabled
        if($this->getConf('useHeroTitle')) {
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

        # Buttons
        foreach ($html->find('.button') as $elm) {
            if ($elm->tag == 'form') {
                continue;
            }
            $elm->class .= ' btn';
        }

        foreach ($html->find('[type=button], [type=submit], [type=reset]') as $elm) {
            if(stripos($elm->class, 'btn') === false) {
                $elm->class .= ' btn btn-outline-secondary';
            }
        }

        # Section Edit Button
        foreach ($html->find('.btn_secedit [type=submit]') as $elm) {
            $elm->class .= ' btn-sm';
        }

        # Section Edit icons
        foreach ($html->find('.secedit.editbutton_section button') as $elm) {
            $elm->innertext = '<i class="fa fa-edit" aria-hidden="true"></i> ' . $elm->innertext;
        }

        $content = $html->save();
        
        $html->clear();
        unset($html);

        return $content;
    }


    /*** GET LINK ***/
    public function getLink($str) {
        $i = strpos($str, '://');
        if($i !== false) return $str;

        return wl($str);
    }
}

global $TEMPLATE;

$TEMPLATE = \dokuwiki\template\mikio\Template::getInstance();