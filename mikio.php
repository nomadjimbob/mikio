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
            'TPL_CONTENT_DISPLAY'       => 'contentHandler',
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
        }

        $stylesheets[] = $this->baseDir . 'css/mikio.css';
        $stylesheets[] = $this->baseDir . 'css/bootstrap.min.css';

        if($this->getConf('includeFontAwesome') == true) $stylesheets[] = $this->baseDir . 'assets/fontawesome/css/all.min.css';

        $scripts[] = $this->baseDir . 'js/bootstrap.min.js';
      
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
        $event->data = $this->normalizeContent($event->data);
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

        $title = '';

        if($this->getConf('navbarMenuStyle') != 'text') {
            $title .= $this->icon($icon);
        }

        if($this->getConf('navbarMenuStyle') != 'icon') {
            $title .= $lang['user_tools'];
        }
        
        echo $title;
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
     * Include Sidebar
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $type       Sidebar type
     * @return  boolean             If sidebar was added
     */
    public function includeSidebar($type) {
        global $conf;

        switch($type) {
            case 'left':
                if($this->getConf('showSidebar')) {
                    echo '<aside>';
                    tpl_includeFile('sidebarheader.html');
                    tpl_include_page($conf['sidebar'], 1, 1);
                    tpl_includeFile('sidebarfooter.html');
                    echo '</aside>';
    
                    return true;
                }

                return false;
        }

        return false;
    }


    public function includeBreadcrumbs() {
        global $conf;

        if($conf['breadcrumbs']) {
            print_r(breadcrumbs());
            tpl_breadcrumbs('|');
        }

        if($conf['youarehere']) {
            // print_r(youarehere());
            tpl_youarehere('|');
        }


    
        
        // $crumbs = breadcrumbs();

        // print '<ol class="breadcrumb">';
        // print '<li>' . rtrim($lang['breadcrumb'], ':') . '</li>';

        // $last = count($crumbs);
        // $i    = 0;

        // foreach ($crumbs as $id => $name) {

        //     $i++;

        //     print($i == $last) ? '<li class="active">' : '<li>';
        //     tpl_link(wl($id), hsc($name), 'title="' . $id . '"');
        //     print '</li>';

        //     if ($i == $last) {
        //         print '</ol>';
        //     }

        // }

        // print_r($crumbs);
    }

    /**
     * Parse HTML for bootstrap
     *
     * @author  James Collins <james.collins@outlook.com.au>
     *
     * @param   string  $content    HTML content to parse
     * @return  string              Parsed HTML for bootstrap
     */
    public function normalizeContent($content) {
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

        # Buttons
        foreach ($html->find('.button') as $elm) {
            if ($elm->tag == 'form') {
                continue;
            }
            $elm->class .= ' btn';
        }

        foreach ($html->find('[type=button], [type=submit], [type=reset]') as $elm) {
            $elm->class .= ' btn btn-outline-secondary';
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
}

global $TEMPLATE;

$TEMPLATE = \dokuwiki\template\mikio\Template::getInstance();