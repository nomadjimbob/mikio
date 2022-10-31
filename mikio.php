<?php

/**
 * DokuWiki Mikio Template
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

namespace dokuwiki\template\mikio;

if (defined('DOKU_INC') === false) {
    die();
}

require_once('icons/icons.php');
require_once('inc/simple_html_dom.php');

class Template
{
    /**
     * @var string Template directory path from local FS.
     */
    public $tplDir  = '';

    /**
     * @var string Template directory path from web.
     */
    public $baseDir = '';

    /**
     * @var array Array of Javascript files to include in footer.
     */
    public $footerScript = [];

    /**
     * @var boolean Ignore LESS files.
     */
    public $lessIgnored = false;


    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->tplDir  = tpl_incdir();
        $this->baseDir = tpl_basedir();

        $this->registerHooks();
    }

    /**
     * Returns the instance of the class
     *
     * @return  Template        class instance
     */
    public static function getInstance()
    {
        static $instance = null;

        if (empty($instance) === true) {
            $instance = new Template();
        }

        return $instance;
    }


    /**
     * Register the themes hooks into Dokuwiki
     *
     * @return void
     */
    private function registerHooks()
    {
        global $EVENT_HANDLER;

        $events_dispatcher = [
            'TPL_METAHEADER_OUTPUT'     => 'metaheadersHandler'
        ];

        foreach ($events_dispatcher as $event => $method) {
            $EVENT_HANDLER->register_hook($event, 'BEFORE', $this, $method);
        }
    }


    /**
     * Meta handler hook for DokuWiki
     *
     * @param   \Doku_Event $event DokuWiki Event.
     * @return  void
     */
    public function metaHeadersHandler(\Doku_Event $event)
    {
        global $MIKIO_ICONS;
        global $conf;

        global $MIKIO_TEMPLATE;
        $MIKIO_TEMPLATE = '123';

        $this->includePage('theme', false, true);

        $stylesheets    = [];
        $scripts        = [];

        if (empty($this->getConf('customTheme')) === false) {
            if (file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/style.less') === true) {
                $stylesheets[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/style.less';
            } else {
                if (file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/style.css') === true) {
                    $stylesheets[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/style.css';
                }
            }
            if (file_exists($this->tplDir . 'themes/' . $this->getConf('customTheme') . '/script.js') === true) {
                $scripts[] = $this->baseDir . 'themes/' . $this->getConf('customTheme') . '/script.js';
            }
        }

        if (is_array($MIKIO_ICONS) === true && empty($this->getConf('iconTag', 'icon')) === false) {
            $icons = [];
            foreach ($MIKIO_ICONS as $icon) {
                if (isset($icon['name']) === true && isset($icon['css']) === true && isset($icon['insert']) === true) {
                    $icons[] = $icon;

                    if (empty($icon['css']) === false) {
                        if (strpos($icon['css'], '//') === false) {
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

        $scripts[] = $this->baseDir . 'assets/mikio-typeahead.js';
        $scripts[] = $this->baseDir . 'assets/mikio.js';

        if ($this->getConf('useLESS') === true) {
            $stylesheets[] = $this->baseDir . 'assets/mikio.less';
        } else {
            $stylesheets[] = $this->baseDir . 'assets/mikio.css';
        }

        /* MikioPlugin Support */
        if (plugin_load('action', 'mikioplugin') !== null) {
            if ($this->getConf('useLESS') === true) {
                $stylesheets[] = $this->baseDir . 'assets/mikioplugin.less';
            } else {
                $stylesheets[] = $this->baseDir . 'assets/mikioplugin.css';
            }
        }

        $set = [];
        foreach ($stylesheets as $style) {
            if (in_array($style, $set) === false) {
                if (strcasecmp(substr($style, -5), '.less') === 0 && $this->getConf('useLESS') === true) {
                    $style = $this->baseDir . 'css.php?css=' . str_replace($this->baseDir, '', $style);
                }

                array_unshift($event->data['link'], [
                    'type' => 'text/css',
                    'rel'  => 'stylesheet',
                    'href' => $style
                ]);
            }
            $set[] = $style;
        }

        $set = [];
        foreach ($scripts as $script) {
            if (in_array($script, $set) === false) {
                $script_params = [
                    'type'  => 'text/javascript',
                    '_data' => '',
                    'src'   => $script
                ];

                // equal to or greator than hogfather
                if ($this->dwVersionNumber() >= 20200729) {
                    // greator than hogfather - defer always on
                    if ($this->dwVersionNumber() >= 20200729) {
                        $script_params += ['defer' => 'defer'];
                    } else {
                        // hogfather - defer always on unless $conf['defer_js'] is false
                        if (array_key_exists('defer_js', $conf) === false || $conf['defer_js'] === true) {
                            $script_params += ['defer' => 'defer'];
                        }
                    }
                }

                $event->data['script'][] = $script_params;
            }//end if
            $set[] = $script;
        }//end foreach
    }


    /**
     * Print or return the footer meta data
     *
     * @param   boolean $print Print the data to buffer.
     * @return  string         HTML footer meta data
     */
    public function includeFooterMeta(bool $print = true)
    {
        $html = '';

        if (count($this->footerScript) > 0) {
            $html .= '<script type="text/javascript">function mikioFooterRun() {';
            foreach ($this->footerScript as $script) {
                $html .= $script . ';';
            }
            $html .= '}</script>';
        }


        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    // phpcs:disable Squiz.Commenting.FunctionComment.TypeHintMissing


    /**
     * Retreive and parse theme configuration options
     *
     * @param   string $key     The configuration key to retreive.
     * @param   mixed  $default If key doesn't exist, return this value.
     * @return  mixed           parsed value of configuration
     */
    public function getConf(string $key, $default = false)
    {
        $value = tpl_getConf($key, $default);

        $data = [
            ['keys' => ['navbarDWMenuType'],                'type' => 'choice',
                'values' => ['both', 'icons', 'text']
            ],
            ['keys' => ['navbarDWMenuCombine'],             'type' => 'choice',
                'values' => ['combine', 'seperate', 'dropdown']
            ],
            ['keys' => ['navbarPosLeft', 'navbarPosMiddle', 'navbarPosRight'],
                'type' => 'choice',
                'values' => ['none', 'custom', 'search', 'dokuwiki'],
                'default' => [
                    'navbarPosLeft' => 'none',
                    'navbarPosMiddle' => 'search',
                    'navbarPosRight' => 'dokuwiki'
                ]
            ],
            ['keys' => ['navbarItemShowCreate', 'navbarItemShowShow', 'navbarItemShowRevs', 'navbarItemShowBacklink',
                'navbarItemShowRecent', 'navbarItemShowMedia', 'navbarItemShowIndex', 'navbarItemShowProfile',
                'navbarItemShowAdmin'
            ],
                'type' => 'choice',
                'values' => ['always', 'logged in', 'logged out', 'never']
            ],
            ['keys' => ['navbarItemShowLogin', 'navbarItemShowLogout'],
                'type' => 'choice',
                'values' => ['always', 'never']
            ],
            ['keys' => ['searchButton'],                    'type' => 'choice',
                'values' => ['icon', 'text']
            ],
            ['keys' => ['breadcrumbPosition', 'youareherePosition'],
                'type' => 'choice',
                'values' => ['top', 'hero', 'page', 'none']
            ],
            ['keys' => ['youarehereHome'],                  'type' => 'choice',
                'values' => ['page title', 'home', 'icon', 'none']
            ],
            ['keys' => ['sidebarLeftRow1', 'sidebarLeftRow2', 'sidebarLeftRow3', 'sidebarLeftRow4'],
                'type' => 'choice',
                'values' => ['none', 'logged in user', 'search', 'content', 'tags'],
                'default' => [
                    'sidebarLeftRow1' => 'logged in user',
                    'sidebarLeftRow2' => 'search',
                    'sidebarLeftRow3' => 'content'
                ]
            ],
            ['keys' => ['pageToolsFloating', 'pageToolsFooter'],
                'type' => 'choice',
                'values' => ['always', 'none', 'page editors']
            ],
            ['keys' => ['pageToolsShowCreate', 'pageToolsShowEdit', 'pageToolsShowRevs', 'pageToolsShowBacklink',
                'pageToolsShowTop'
            ],
                'type' => 'choice',
                'values' => ['always', 'logged in', 'logged out', 'never']
            ],
            ['keys' => ['showNotifications'],               'type' => 'choice',
                'values' => ['admin', 'always', 'none']
            ],
            ['keys' => ['licenseType'],                     'type' => 'choice',
                'values' => ['badge', 'button', 'none']
            ],
            ['keys' => ['navbarUseTitleIcon'],              'type' => 'bool'],
            ['keys' => ['navbarUseTitleText'],              'type' => 'bool'],
            ['keys' => ['navbarUseTaglineText'],            'type' => 'bool'],
            ['keys' => ['navbarShowSub'],                   'type' => 'bool'],
            ['keys' => ['heroTitle'],                       'type' => 'bool'],
            ['keys' => ['heroImagePropagation'],            'type' => 'bool'],
            ['keys' => ['breadcrumbPrefix'],                'type' => 'bool'],
            ['keys' => ['breadcrumbSep'],                   'type' => 'bool'],
            ['keys' => ['youareherePrefix'],                'type' => 'bool'],
            ['keys' => ['youarehereSep'],                   'type' => 'bool'],
            ['keys' => ['sidebarShowLeft'],                 'type' => 'bool'],
            ['keys' => ['sidebarShowRight'],                'type' => 'bool'],
            ['keys' => ['tocFull'],                         'type' => 'bool'],
            ['keys' => ['footerSearch'],                    'type' => 'bool'],
            ['keys' => ['licenseImageOnly'],                'type' => 'bool'],
            ['keys' => ['includePageUseACL'],               'type' => 'bool'],
            ['keys' => ['includePagePropagate'],            'type' => 'bool'],
            ['keys' => ['youarehereHideHome'],              'type' => 'bool'],
            ['keys' => ['tagsConsolidate'],                 'type' => 'bool'],
            ['keys' => ['footerInPage'],                    'type' => 'bool'],
            ['keys' => ['sidebarMobileDefaultCollapse'],    'type' => 'bool'],
            ['keys' => ['sidebarAlwaysShowLeft'],           'type' => 'bool'],
            ['keys' => ['sidebarAlwaysShowRight'],          'type' => 'bool'],
            ['keys' => ['searchUseTypeahead'],              'type' => 'bool'],
            ['keys' => ['showLightDark'],                   'type' => 'bool'],
            ['keys' => ['youarehereShowLast'],              'type' => 'int'],

            ['keys' => ['iconTag'],                         'type' => 'string'],
            ['keys' => ['customTheme'],                     'type' => 'string'],
            ['keys' => ['navbarCustomMenuText'],            'type' => 'string'],
            ['keys' => ['breadcrumbPrefixText'],            'type' => 'string'],
            ['keys' => ['breadcrumbSepText'],               'type' => 'string'],
            ['keys' => ['youareherePrefixText'],            'type' => 'string'],
            ['keys' => ['youarehereSepText'],               'type' => 'string'],
            ['keys' => ['footerCustomMenuText'],            'type' => 'string'],
            ['keys' => ['brandURLGuest'],                   'type' => 'string'],
            ['keys' => ['brandURLUser'],                    'type' => 'string'],

            ['keys' => ['useLESS'],                         'type' => 'less'],
        ];

        foreach ($data as $row) {
            // does not check case....
            if (in_array($key, $row['keys']) === true) {
                if (array_key_exists('type', $row) === true) {
                    switch ($row['type']) {
                        case 'bool':
                            return (bool) $value;
                        case 'int':
                            return (int) $value;
                        case 'string':
                            return $value;
                        case 'less':
                            $value = (bool) $value;
                            $lessAvailable = true;

                            // check for less library
                            $lesscLib = '../../../vendor/marcusschwarz/lesserphp/lessc.inc.php';
                            if (file_exists($lesscLib) === false) {
                                $lesscLib = $_SERVER['DOCUMENT_ROOT'] . '/vendor/marcusschwarz/lesserphp/lessc.inc.php';
                            }
                            if (file_exists($lesscLib) === false) {
                                $lesscLib = '../../../../../app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php';
                            }
                            if (file_exists($lesscLib) === false) {
                                $lesscLib = $_SERVER['DOCUMENT_ROOT'] .
                                    '/app/dokuwiki/vendor/marcusschwarz/lesserphp/lessc.inc.php';
                            }
                            if (file_exists($lesscLib) === false) {
                                $lessAvailable = false;
                            }

                            // check for ctype extensions
                            if (function_exists('ctype_digit') === false) {
                                $lessAvailable = false;
                            }

                            if ($value === true && $lessAvailable === false) {
                                $this->lessIgnored = true;
                                $value = false;
                            }

                            return $value;
                    }//end switch
                }//end if

                if (in_array($value, $row['values']) === true) {
                    return $value;
                }

                if (array_key_exists('default', $row) === true) {
                    if (is_array($row['default']) === true) {
                        if (array_key_exists($key, $row['default']) === true) {
                            return $row['default'][$key];
                        }
                    } else {
                        return $row['default'];
                    }
                }

                return reset($row['values']);
            }//end if
        }//end foreach

        return $value;
    }


    // phpcs:enable


    /**
     * Check if a page exist in directory or namespace
     *
     * @param   string $page Page/namespace to search.
     * @return  boolean      if page exists
     */
    public function pageExists(string $page)
    {
        ob_start();
        tpl_includeFile($page . '.html');
        $html = ob_get_contents();
        ob_end_clean();

        if (empty($html) === false) {
            return true;
        }

        $useACL = $this->getConf('includePageUseACL');
        $propagate = $this->getConf('includePagePropagate');

        if ($propagate === true) {
            if (page_findnearest($page, $useACL) !== false) {
                return true;
            }
        } elseif ($useACL === true && auth_quickaclcheck($page) !== AUTH_NONE) {
            return true;
        }

        return false;
    }


    /**
     * Print or return page from directory or namespace
     *
     * @param   string  $page         Page/namespace to include.
     * @param   boolean $print        Print content.
     * @param   boolean $parse        Parse content before printing/returning.
     * @param   string  $classWrapper Wrap page in a div with class.
     * @return  string                contents of page found
     */
    public function includePage(string $page, bool $print = true, bool $parse = true, string $classWrapper = '')
    {
        ob_start();
        tpl_includeFile($page . '.html');
        $html = ob_get_contents();
        ob_end_clean();

        if (empty($html) === true) {
            $useACL = $this->getConf('includePageUseACL');
            $propagate = $this->getConf('includePagePropagate');
            $html = '';

            $html = tpl_include_page($page, false, $propagate, $useACL);
        }

        if (empty($html) === false && $parse === true) {
            $html = $this->parseContent($html);
        }

        if (empty($classWrapper) === false && empty($html) === false) {
            $html = '<div class="' . $classWrapper . '">' . $html . '</div>';
        }

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Print or return logged in user information
     *
     * @param   boolean $print Print content.
     * @return  string         user information
     */
    public function includeLoggedIn(bool $print = true)
    {
        $html = '';

        if (empty($_SERVER['REMOTE_USER']) === false) {
            $html .= '<div class="mikio-user-info">';
            ob_start();
            tpl_userinfo();
            $html .= ob_get_contents();
            ob_end_clean();
            $html .= '</div>';
        }

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Print or return DokuWiki Menu
     *
     * @param   boolean $print Print content.
     * @return  string         contents of the menu
     */
    public function includeDWMenu(bool $print = true)
    {
        global $lang;
        global $USERINFO;

        $loggedIn = (is_array($USERINFO) === true && count($USERINFO) > 0);
        $html = '<ul class="mikio-nav">';

        $pageToolsMenu = [];
        $siteToolsMenu = [];
        $userToolsMenu = [];

        $showIcons  = ($this->getConf('navbarDWMenuType') != 'text');
        $showText   = ($this->getConf('navbarDWMenuType') != 'icons');
        $isDropDown = ($this->getConf('navbarDWMenuCombine') != 'seperate');

        $items = (new \dokuwiki\Menu\PageMenu())->getItems();
        foreach ($items as $item) {
            if ($item->getType() !== 'top') {
                $itemHtml = '';

                $showItem = $this->getConf('navbarItemShow' . ucfirst($item->getType()));
                if (
                    $showItem !== false && (strcasecmp($showItem, 'always') === 0 ||
                    (strcasecmp($showItem, 'logged in') === 0 && $loggedIn === true) ||
                    (strcasecmp($showItem, 'logged out') === 0 && $loggedIn === false))
                ) {
                    $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown === true ? 'mikio-dropdown-item' : '') .
                        ' ' . $item->getType() . '" href="' . $item->getLink() . '" title="' . $item->getTitle() . '">';
                    if ($showIcons === true) {
                        $itemHtml .= '<span class="mikio-icon">' . inlineSVG($item->getSvg()) . '</span>';
                    }
                    if ($showText === true || $isDropDown === true) {
                        $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                    }
                    $itemHtml .= '</a>';

                    $pageToolsMenu[] = $itemHtml;
                }
            }//end if
        }//end foreach

        $items = (new \dokuwiki\Menu\SiteMenu())->getItems('action');
        foreach ($items as $item) {
            $itemHtml = '';

            $showItem = $this->getConf('navbarItemShow' . ucfirst($item->getType()));
            if (
                $showItem !== false && (strcasecmp($showItem, 'always') === 0 ||
                (strcasecmp($showItem, 'logged in') === 0 && $loggedIn === true) ||
                (strcasecmp($showItem, 'logged out') === 0 && $loggedIn === false))
            ) {
                $itemHtml .= '<a class="mikio-nav-link ' . ($isDropDown === true ? 'mikio-dropdown-item' : '') . ' ' .
                    $item->getType() . '" href="' . $item->getLink() . '" title="' . $item->getTitle() . '">';
                if ($showIcons === true) {
                    $itemHtml .= '<span class="mikio-icon">' . inlineSVG($item->getSvg()) . '</span>';
                }
                if ($showText === true || $isDropDown === true) {
                    $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                }
                $itemHtml .= '</a>';

                $siteToolsMenu[] = $itemHtml;
            }
        }//end foreach

        $items = (new \dokuwiki\Menu\UserMenu())->getItems('action');
        foreach ($items as $item) {
            $itemHtml = '';

            $showItem = $this->getConf('navbarItemShow' . ucfirst($item->getType()));
            if (
                $showItem !== false && (strcasecmp($showItem, 'always') === 0 ||
                (strcasecmp($showItem, 'logged in') === 0 && $loggedIn === true) ||
                (strcasecmp($showItem, 'logged out') === 0 && $loggedIn === false))
            ) {
                $itemHtml .= '<a class="mikio-nav-link' . ($isDropDown === true ? ' mikio-dropdown-item' : '') . ' ' .
                $item->getType() . '" href="' . $item->getLink() . '" title="' . $item->getTitle() . '">';
                if ($showIcons === true) {
                    $itemHtml .= '<span class="mikio-icon">' . inlineSVG($item->getSvg()) . '</span>';
                }
                if ($showText === true || $isDropDown === true) {
                    $itemHtml .= '<span>' . $item->getLabel() . '</span>';
                }
                $itemHtml .= '</a>';

                $userToolsMenu[] = $itemHtml;
            }
        }//end foreach


        switch ($this->getConf('navbarDWMenuCombine')) {
            case 'dropdown':
                $html .= '<li id="dokuwiki__pagetools" class="mikio-nav-dropdown">';
                $html .= '<a id="mikio_dropdown_pagetools" class="nav-link dropdown-toggle" href="#" role="button" 
data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                ($showIcons === true ? $this->mikioInlineIcon('file') : '') .
                ($showText === true ? $lang['page_tools'] : '<span class="mikio-small-only">' . $lang['page_tools'] .
                '</span>') . '</a>';
                $html .= '<div class="mikio-dropdown closed">';

                foreach ($pageToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';

                $html .= '<li id="dokuwiki__sitetools" class="mikio-nav-dropdown">';
                $html .= '<a id="mikio_dropdown_sitetools" class="nav-link dropdown-toggle" href="#" role="button" 
data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                    ($showIcons === true ? $this->mikioInlineIcon('gear') : '') .
                    ($showText === true ? $lang['site_tools'] : '<span class="mikio-small-only">' .
                    $lang['site_tools'] . '</span>') . '</a>';
                $html .= '<div class="mikio-dropdown closed">';

                foreach ($siteToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';

                $html .= '<li id="dokuwiki__usertools" class="mikio-nav-dropdown">';
                $html .= '<a id="mikio_dropdown_usertools" class="nav-link dropdown-toggle" href="#" role="button" 
data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                    ($showIcons === true ? $this->mikioInlineIcon('user') : '') .
                    ($showText === true ? $lang['user_tools'] : '<span class="mikio-small-only">' .
                    $lang['user_tools'] . '</span>') . '</a>';
                $html .= '<div class="mikio-dropdown closed">';

                foreach ($userToolsMenu as $item) {
                    $html .= $item;
                }

                $html .= '</div>';
                $html .= '</li>';

                break;

            case 'combine':
                $html .= '<li class="mikio-nav-dropdown">';
                $html .= '<a class="mikio-nav-link" href="#">' .
                    ($showIcons === true ? $this->mikioInlineIcon('wrench') : '') .
                    ($showText === true ? tpl_getLang('tools-menu') : '<span class="mikio-small-only">' .
                    tpl_getLang('tools-menu') . '</span>') . '</a>';
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
        }//end switch

        if ($this->getConf('showLightDark') === true) {
            $html .= '<li class="mikio-darklight">
<a href="#" class="mikio-control mikio-button mikio-darklight-button">' .
            $this->mikioInlineIcon('sun', 'mikio-darklight-light') .
            $this->mikioInlineIcon('moon', 'mikio-darklight-dark') .
            '</a></li>';
        }

        $html .= '</ul>';

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Create a nav element from a string. <uri>|<title>;
     *
     * @param string $str String to generate nav.
     * @return string     nav elements generated
     */
    public function stringToNav(string $str)
    {
        $html = '';

        if (empty($str) === false) {
            $items = explode(';', $str);
            if (count($items) > 0) {
                $html .= '<ul class="mikio-nav">';
                foreach ($items as $item) {
                    $parts = explode('|', $item);
                    if ($parts > 1) {
                        $html .= '<li class="mikio-nav-item"><a class="mikio-nav-link" href="' .
                            strip_tags($this->getLink(trim($parts[0]))) . '">' . strip_tags(trim($parts[1])) .
                            '</a></li>';
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
     * @param boolean $print   Print the navbar.
     * @param boolean $showSub Include the sub navbar.
     * @return string          generated content
     */
    public function includeNavbar(bool $print = true, bool $showSub = false)
    {
        global $conf, $USERINFO;

        $homeUrl = wl();

        if (plugin_isdisabled('showpageafterlogin') === false) {
            $p = &plugin_load('action', 'showpageafterlogin');
            if (empty($p) === false) {
                if (is_array($USERINFO) === true && count($USERINFO) > 0) {
                    $homeUrl = wl($p->getConf('page_after_login'));
                }
            }
        } else {
            if (is_array($USERINFO) === true && count($USERINFO) > 0) {
                $url = $this->getConf('brandURLUser');
                if (strlen($url) > 0) {
                    $homeUrl = $url;
                }
            } else {
                $url = $this->getConf('brandURLGuest');
                if (strlen($url) > 0) {
                    $homeUrl = $url;
                }
            }
        }

        $html = '';

        $html .= '<nav class="mikio-navbar'  . (($this->getConf('stickyNavbar') === true) ? ' mikio-sticky' : '') .
            '">';
        $html .= '<div class="mikio-container">';
        $html .= '<a class="mikio-navbar-brand" href="' . $homeUrl . '">';
        if ($this->getConf('navbarUseTitleIcon') === true || $this->getConf('navbarUseTitleText') === true) {
            // Brand image
            if ($this->getConf('navbarUseTitleIcon') === true) {
                $logo = $this->getMediaFile('logo', false);
                ;
                if (empty($logo) === false) {
                    $width = $this->getConf('navbarTitleIconWidth');
                    $height = $this->getConf('navbarTitleIconHeight');
                    $styles = '';

                    if (strlen($width) > 0 || strlen($height) > 0) {
                        if (ctype_digit($width) === true) {
                            $styles .= 'max-width:' . intval($width) . 'px;';
                        } elseif (preg_match('/^\d+(px|rem|em|%)$/', $width) === 1) {
                            $styles .= 'max-width:' . $width . ';';
                        } elseif (strcasecmp($width, 'none') === 0) {
                            $styles .= 'max-width:none;';
                        }

                        if (ctype_digit($height) === true) {
                            $styles .= 'max-height:' . intval($height) . 'px;';
                        } elseif (preg_match('/^\d+(px|rem|em|%)$/', $height) === 1) {
                            $styles .= 'max-height:' . $height . ';';
                        } elseif (strcasecmp($height, 'none') === 0) {
                            $styles .= 'max-height:none;';
                        }

                        if (strlen($styles) > 0) {
                            $styles = ' style="' . $styles . '"';
                        }
                    }//end if

                    $html .= '<img src="' . $logo . '" class="mikio-navbar-brand-image"' . $styles . '>';
                }//end if
            }//end if

            // Brand title
            if ($this->getConf('navbarUseTitleText') === true) {
                $html .= '<div class="mikio-navbar-brand-title">';
                $html .= '<h1 class="mikio-navbar-brand-title-text">' . $conf['title'] . '</h1>';
                if ($this->getConf('navbarUseTaglineText') === true) {
                    $html .= '<p class="claim mikio-navbar-brand-title-tagline">' . $conf['tagline'] . '</p>';
                }
                $html .= '</div>';
            }
        }//end if
        $html .= '</a>';
        $html .= '<div class="mikio-navbar-toggle"><span class="icon"></span></div>';

        // Menus
        $html .= '<div class="mikio-navbar-collapse">';

        $menus = [$this->getConf('navbarPosLeft', 'none'), $this->getConf('navbarPosMiddle', 'none'),
            $this->getConf('navbarPosRight', 'none')
        ];
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
                    $html .= $this->includeDWMenu(false);
                    break;
            }
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</nav>';

        // Sub Navbar
        if ($showSub === true) {
            $sub = $this->includePage('submenu', false);
            if (empty($sub) === false) {
                $html .= '<nav class="mikio-navbar mikio-sub-navbar">' . $sub . '</nav>';
            }
        }

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Is there a sidebar
     *
     * @param   string $prefix Sidebar prefix to use when searching.
     * @return  boolean        if sidebar exists
     */
    public function sidebarExists(string $prefix = '')
    {
        global $conf;

        if (strcasecmp($prefix, 'left') === 0) {
            $prefix = '';
        }

        return $this->pageExists($conf['sidebar' . $prefix]);
    }


    /**
     * Print or return the sidebar content
     *
     * @param   string  $prefix Sidebar prefix to use when searching.
     * @param   boolean $print  Print the generated content to the output buffer.
     * @param   boolean $parse  Parse the content.
     * @return  string          generated content
     */
    public function includeSidebar(string $prefix = '', bool $print = true, bool $parse = true)
    {
        global $conf, $ID;

        $html = '';
        $confPrefix = preg_replace('/[^a-zA-Z0-9]/', '', ucwords($prefix));
        $prefix = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($prefix));

        if (empty($confPrefix) === true) {
            $confPrefix = 'Left';
        }
        if (strcasecmp($prefix, 'left') === 0) {
            $prefix = '';
        }

        $sidebarPage = empty($conf[$prefix . 'sidebar']) === true ? $prefix . 'sidebar' : $conf[$prefix . 'sidebar'];

        if (
            $this->getConf('sidebarShow' . $confPrefix) === true && page_findnearest($sidebarPage) !== false &&
            p_get_metadata($ID, 'nosidebar', false) === null
        ) {
            $content = $this->includePage($sidebarPage . 'header', false);
            if (empty($content) === false) {
                $html .= '<div class="mikio-sidebar-header">' . $content . '</div>';
            }

            if (empty($prefix) === true) {
                $rows = [$this->getConf('sidebarLeftRow1'), $this->getConf('sidebarLeftRow2'),
                    $this->getConf('sidebarLeftRow3'), $this->getConf('sidebarLeftRow4')
                ];

                foreach ($rows as $row) {
                    switch ($row) {
                        case 'search':
                            $html .= $this->includeSearch(false);
                            break;
                        case 'logged in user':
                            $html .= $this->includeLoggedIn(false);
                            break;
                        case 'content':
                            $content = $this->includePage($sidebarPage, false);
                            if (empty($content) === false) {
                                $html .= '<div class="mikio-sidebar-content">' . $content . '</div>';
                            }
                            break;
                        case 'tags':
                            $html .= '<div class="mikio-tags"></div>';
                    }
                }
            } else {
                $content = $this->includePage($sidebarPage, false);
                if (empty($content) === false) {
                    $html .= '<div class="mikio-sidebar-content">' . $content . '</div>';
                }
            }//end if

            $content = $this->includePage($sidebarPage . 'footer', false);
            if (empty($content) === false) {
                $html .= '<div class="mikio-sidebar-footer">' . $content . '</div>';
            }
        }//end if

        if (empty($html) === true) {
            if (empty($prefix) === true && $this->getConf('sidebarAlwaysShowLeft') === true) {
                $html = '&nbsp;';
            }
            if ($this->getConf('sidebarAlwaysShow' . ucfirst($prefix)) === true) {
                $html = '&nbsp;';
            }
        }

        if (empty($html) === false) {
            $html = '<aside class="mikio-sidebar mikio-sidebar-' . (empty($prefix) === true ? 'left' : $prefix) .
                '"><a class="mikio-sidebar-toggle' .
                ($this->getConf('sidebarMobileDefaultCollapse') === true ? ' closed' : '') . '" href="#">' .
                tpl_getLang('sidebar-title') . ' <span class="icon"></span></a><div class="mikio-sidebar-collapse">' .
                $html . '</div></aside>';
        }

        if ($parse === true) {
            $html = $this->includeIcons($html);
        }
        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Print or return the page tools content
     *
     * @param   boolean $print     Print the generated content to the output buffer.
     * @param   boolean $includeId Include the dw__pagetools id in the element.
     * @return  string             generated content
     */
    public function includePageTools(bool $print = true, bool $includeId = false)
    {
        global $USERINFO;

        $loggedIn = (is_array($USERINFO) === true && count($USERINFO) > 0);
        $html = '';

        $html .= '<nav' . ($includeId === true ? ' id="dw__pagetools"' : '') . ' class="hidden-print dw__pagetools">';
        $html .= '<ul class="tools">';

        $items = (new \dokuwiki\Menu\PageMenu())->getItems();
        foreach ($items as $item) {
            $classes = [];
            $classes[] = $item->getType();
            $attr = $item->getLinkAttributes();

            if (empty($attr['class']) === false) {
                $classes = array_merge($classes, explode(' ', $attr['class']));
            }

            $classes = array_unique($classes);

            $showItem = $this->getConf('pageToolsShow' . ucfirst($item->getType()));
            if (
                $showItem !== false && (strcasecmp($showItem, 'always') === 0 ||
                (strcasecmp($showItem, 'logged in') === 0 && $loggedIn === true) ||
                (strcasecmp($showItem, 'logged out') === 0 && $loggedIn === true))
            ) {
                $html .= '<li class="' . implode(' ', $classes) . '">';
                $html .= '<a href="' . $item->getLink() . '" class="' . $item->getType() . '" title="' .
                    $item->getTitle() . '"><div class="icon">' . inlineSVG($item->getSvg()) .
                    '</div><span class="a11y">' . $item->getLabel() . '</span></a>';
                $html .= '</li>';
            }
        }//end foreach

        $html .= '</ul>';
        $html .= '</nav>';

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Print or return the search bar
     *
     * @param   boolean $print Print content.
     * @return  string         contents of the search bar
     */
    public function includeSearch(bool $print = true)
    {
        global $lang, $ID, $ACT, $QUERY;
        $html = '';

        $html .= '<form class="mikio-search search" action="' . wl() .
            '" accept-charset="utf-8" method="get" role="search">';
        $html .= '<input type="hidden" name="do" value="search">';
        $html .= '<input type="hidden" name="id" value="' . $ID . '">';
        $html .= '<input name="q" ';
        if ($this->getConf('searchUseTypeahead') === true) {
            $html .= 'class="search_typeahead" ';
        }
        $html .= 'autocomplete="off" type="search" placeholder="' . $lang['btn_search'] . '" value="' .
            ((strcasecmp($ACT, 'search') === 0) ? htmlspecialchars($QUERY) : '') . '" accesskey="f" title="[F]" />';
        $html .= '<button type="submit" title="' .  $lang['btn_search'] . '">';
        if (strcasecmp($this->getConf('searchButton'), 'icon') === 0) {
            $html .= $this->mikioInlineIcon('search');
        } else {
            $html .= $lang['btn_search'];
        }
        $html .= '</button>';
        $html .= '</form>';

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Print or return content
     *
     * @param   boolean $print Print content.
     * @return  string         contents
     */
    public function includeContent(bool $print = true)
    {
        ob_start();
        tpl_content(false);
        $html = ob_get_contents();
        ob_end_clean();

        $html = $this->includeIcons($html);
        $html = $this->parseContent($html);

        $html .= '<div style="clear:both"></div>';

        if ($this->getConf('heroTitle') === false) {
            $html = '<div class="mikio-tags"></div>' . $html;
        }

        $html = '<div class="mikio-article-content">' . $html . '</div>';

        if ($print === true) {
            echo $html;
        }
        return $html;
    }

    /**
     * Print or return footer
     *
     * @param   boolean $print Print footer.
     * @return  string         HTML string containing footer
     */
    public function includeFooter(bool $print = true)
    {
        global $ACT;

        $html = '';

        $html .= '<footer class="mikio-footer">';
        $html .= '<div class="doc">' . tpl_pageinfo(true) . '</div>';
        $html .= $this->includePage('footer', false);

        $html .= $this->stringToNav($this->getConf('footerCustomMenuText'));

        if ($this->getConf('footerSearch') === true) {
            $html .= '<div class="mikio-footer-search">';
            $html .= $this->includeSearch(false);
            $html .= '</div>';
        }

        $showPageTools = $this->getConf('pageToolsFooter');
        if (
            strcasecmp($ACT, 'show') === 0 && (strcasecmp($showPageTools, 'always') === 0 ||
            $this->userCanEdit() === true && strcasecmp($showPageTools, 'page editors') === 0)
        ) {
            $html .= $this->includePageTools(false);
        }

        $meta['licenseType']            = ['multichoice', '_choices' => ['none', 'badge', 'button']];
        $meta['licenseImageOnly']       = ['onoff'];

        $licenseType = $this->getConf('licenseType');
        if ($licenseType !== 'none') {
            $html .= tpl_license($licenseType, $this->getConf('licenseImageOnly'), true, true);
        }

        $html .= '</footer>';

        if ($print === true) {
            echo $html;
        }
        return $html;
    }


    /**
     * Print or return breadcrumb trail
     *
     * @param   boolean $print Print out trail.
     * @param   boolean $parse Parse trail before printing.
     * @return  string         HTML string containing breadcrumbs
     */
    public function includeBreadcrumbs(bool $print = true, bool $parse = true)
    {
        global $conf, $ID, $lang, $ACT;

        if (
            $this->getConf('breadcrumbHideHome') === true && strcasecmp($ID, 'start') === 0 &&
            strcasecmp($ACT, 'show') === 0 || strcasecmp($ACT, 'showtag') === 0 || $conf['breadcrumbs'] === 0
        ) {
            return '';
        }

        $html = '<div class="mikio-breadcrumbs">';
        $html .= '<div class="mikio-container">';
        if (strcasecmp($ACT, 'show') === 0) {
            if ($conf['breadcrumbs'] !== 0) {
                if ($this->getConf('breadcrumbPrefix') === false && $this->getConf('breadcrumbSep') === false) {
                    ob_start();
                    tpl_breadcrumbs();
                    $html .= ob_get_contents();
                    ob_end_clean();
                } else {
                    $sep = '•';
                    $prefix = $lang['breadcrumb'];

                    if ($this->getConf('breadcrumbSep') === true) {
                        $sep = $this->getConf('breadcrumbSepText');
                        $img = $this->getMediaFile('breadcrumb-sep', false);

                        if ($img !== false) {
                            $sep = '<img src="' . $img . '">';
                        }
                    }

                    if ($this->getConf('breadcrumbPrefix') === true) {
                        $prefix = $this->getConf('breadcrumbPrefixText');
                        $img = $this->getMediaFile('breadcrumb-prefix', false);

                        if ($img !== false) {
                            $prefix = '<img src="' . $img . '">';
                        }
                    }

                    $crumbs = breadcrumbs();

                    $html .= '<ul>';
                    if (empty($prefix) === false) {
                        $html .= '<li class="prefix">' . $prefix . '</li>';
                    }

                    $last = count($crumbs);
                    $i    = 0;
                    foreach ($crumbs as $id => $name) {
                        $i++;
                        if ($i !== 1) {
                            $html .= '<li class="sep">' . $sep . '</li>';
                        }
                        $html .= '<li' . ($i === $last ? ' class="curid"' : '') . '>';
                        $html .= tpl_pagelink($id, null, true);
                        $html .= '</li>';
                    }

                    $html .= '</ul>';
                }//end if
            }//end if
        }//end if

        $html .= '</div>';
        $html .= '</div>';

        if ($parse === true) {
            $html = $this->includeIcons($html);
        }
        if ($print === true) {
            echo $html;
        }
        return $html;
    }

    /**
     * Print or return you are here trail
     *
     * @param   boolean $print Print out trail.
     * @param   boolean $parse Parse trail before printing.
     * @return  string         HTML string containing breadcrumbs
     */
    public function includeYouAreHere(bool $print = true, bool $parse = true)
    {
        global $conf, $ID, $lang, $ACT;

        if (
            $this->getConf('youarehereHideHome') === true && strcasecmp($ID, 'start') === 0 &&
            strcasecmp($ACT, 'show') === 0 || strcasecmp($ACT, 'showtag') === 0 || $conf['youarehere'] === 0
        ) {
            return '';
        }

        $html = '<div class="mikio-youarehere">';
        $html .= '<div class="mikio-container">';
        if (strcasecmp($ACT, 'show') === 0) {
            if ($conf['youarehere'] !== 0) {
                if ($this->getConf('youareherePrefix') === false && $this->getConf('youarehereSep') === false) {
                    $html .= '<div class="mikio-bcdw">';
                    ob_start();
                    tpl_youarehere();
                    $html .= ob_get_contents();
                    ob_end_clean();
                    $html .= '</div>';
                } else {
                    $sep = ' » ';
                    $prefix = $lang['youarehere'];

                    if ($this->getConf('youarehereSep') === true) {
                        $sep = $this->getConf('youarehereSepText');
                        $img = $this->getMediaFile('youarehere-sep', false);

                        if ($img !== false) {
                            $sep = '<img src="' . $img . '">';
                        }
                    }

                    if ($this->getConf('youareherePrefix') === true) {
                        $prefix = $this->getConf('youareherePrefixText');
                        $img = $this->getMediaFile('youarehere-prefix', false);

                        if ($img !== false) {
                            $prefix = '<img src="' . $img . '">';
                        }
                    }

                    $html .= '<ul>';
                    if (empty($prefix) === false) {
                        $html .= '<li class="prefix">' . $prefix . '</li>';
                    }
                    $html .= '<li>' . tpl_pagelink(':' . $conf['start'], null, true) . '</li>';

                    $parts = explode(':', $ID);
                    $count = count($parts);

                    $part = '';
                    for ($i = 0; $i < ($count - 1); $i++) {
                        $part .= $parts[$i] . ':';
                        $page = $part;
                        if ($page === $conf['start']) {
                            continue;
                        }

                        $html .= '<li class="sep">' . $sep . '</li>';
                        $html .= '<li>' . tpl_pagelink($page, null, true) . '</li>';
                    }

                    resolve_pageid('', $page, $exists);
                    if ((isset($page) === true && $page === $part . $parts[$i]) === false) {
                        $page = $part . $parts[$i];
                        if ($page !== $conf['start']) {
                            $html .= '<li class="sep">' . $sep . '</li>';
                            $html .= '<li>' . tpl_pagelink($page, null, true) . '</li>';
                        }
                    }

                    $html .= '</ul>';
                }//end if
            }//end if

            $showLast = $this->getConf('youarehereShowLast');
            if ($showLast !== 0) {
                preg_match_all('/(<li[^>]*>.+?<\/li>)/', $html, $matches);
                if (count($matches) > 0 && count($matches[0]) > (($showLast * 2) + 2)) {
                    $count = count($matches[0]);
                    $list = '';

                    // Show Home
                    $list .= $matches[0][0] . $matches[0][1];

                    $list .= '<li>...</li>';
                    for ($i = ($count - ($showLast * 2)); $i <= $count; $i++) {
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
                    $html = preg_replace('/(<a[^>]*>)(.+?)(<\/a>)/', '$1' .
                        $this->mikioInlineIcon('home') . '$3', $html, 1);
                    break;
            }
        } else {
            $html .= '&#8810; ';
            if (isset($_GET['page']) === true) {
                $html .= '<a href="' . wl($ID, ['do' => $ACT]) . '">Back</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;';
            }
            $html .= '<a href="' . wl($ID) . '">View Page</a>';
        }//end if

        $html .= '</div>';
        $html .= '</div>';

        if ($parse === true) {
            $html = $this->includeIcons($html);
        }
        if ($print === true) {
            echo $html;
        }
        return $html;
    }

    /**
     * Get Page Title
     *
     * @return string page title
     */
    public function parsePageTitle()
    {
        global $ID;

        $title = p_get_first_heading($ID);
        if (strlen($title) <= 0) {
            $title = tpl_pagetitle(null, true);
        }
        $title = $this->includeIcons($title);

        return $title;
    }


    /**
     * Print or return hero block
     *
     * @param   boolean $print Print content.
     * @return  string         contents of hero
     */
    public function includeHero(bool $print = true)
    {
        $html = '';

        if ($this->getConf('heroTitle') === true) {
            $html .= '<div class="mikio-hero">';
            $html .= '<div class="mikio-container">';
            $html .= '<div class="mikio-hero-text">';
            if (strcasecmp($this->getConf('youareherePosition'), 'hero') === 0) {
                $html .= $this->includeYouAreHere(false);
            }
            if (strcasecmp($this->getConf('breadcrumbPosition'), 'hero') === 0) {
                $html .= $this->includeBreadcrumbs(false);
            }

            $html .= '<h1 class="mikio-hero-title">';
            $html .= $this->parsePageTitle();    // No idea why this requires a blank space afterwards to work?
            $html .= '</h1>';
            $html .= '<h2 class="mikio-hero-subtitle"></h2>';
            $html .= '</div>';

            $hero_image = $this->getMediaFile('hero', true, $this->getConf('heroImagePropagation', true));
            $hero_image_resize_class = '';
            if (empty($hero_image) === false) {
                $hero_image = ' style="background-image:url(\'' . $hero_image . '\');"';
                $hero_image_resize_class = ' mikio-hero-image-resize';
            }

            $html .= '<div class="mikio-hero-image' . $hero_image_resize_class . '"' . $hero_image .
                '><div class="mikio-tags"></div></div>';

            $html .= '</div>';
            $html .= '</div>';
        }//end if

        if ($print === true) {
            echo $html;
        }

        return $html;
    }


    /**
     * Print or return out TOC
     *
     * @param   boolean $print Print TOC.
     * @param   boolean $parse Parse icons.
     * @return  string         contents of TOC
     */
    public function includeTOC(bool $print = true, bool $parse = true)
    {
        $html = '';

        $tocHtml = tpl_toc(true);

        if (empty($tocHtml) === false) {
            $tocHtml = preg_replace(
                '/(<h3.+?toggle.+?>)(.+?)<\/h3>/',
                '$1' .
                $this->mikioInlineIcon('hamburger', 'hamburger') . '$2' .
                $this->mikioInlineIcon('down-arrow', 'down-arrow') . '</h3>',
                $tocHtml
            );
            $tocHtml = preg_replace('/<li.*><div.*><a.*><\/a><\/div><\/li>\s*/', '', $tocHtml);
            $tocHtml = preg_replace('/<ul.*>\s*<\/ul>\s*/', '', $tocHtml);

            $html .= '<div class="mikio-toc">';
            $html .= $tocHtml;
            $html .= '</div>';
        }

        if ($parse === true) {
            $html = $this->includeIcons($html);
        }

        if ($print === true) {
            echo $html;
        }

        return $html;
    }


    /**
     * Parse the string and replace icon elements with included icon libraries
     *
     * @param   string $str Content to parse.
     * @return  string      parsed string
     */
    public function includeIcons(string $str)
    {
        global $ACT, $MIKIO_ICONS;

        $iconTag = $this->getConf('iconTag', 'icon');
        if (empty($iconTag) === true) {
            return $str;
        }

        if (
            in_array($ACT, ['show', 'showtag', 'revisions', 'index', 'preview']) === true ||
            strcasecmp($ACT, 'admin') === 0 && count($MIKIO_ICONS) > 0
        ) {
            $content = $str;
            $preview = null;

            if (strcasecmp($ACT, 'preview') === 0) {
                $html = new \simple_html_dom();
                $html->stripRNAttrValues = false;
                $html->load($str, true, false);

                $preview = $html->find('div.preview');
                if (is_array($preview) === true && count($preview) > 0) {
                    $content = $preview[0]->innertext;
                }
            }

            $page_regex = '/(.*)/';
            if (stripos($str, '<pre') !== false) {
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
                                        if (strcasecmp($iconItem['name'], $e[0]) === 0) {
                                            $icon = $iconItem;

                                            $s = $icon['insert'];
                                            for ($i = 1; $i < 9; $i++) {
                                                if (count($e) < $i || empty($e[$i]) === true) {
                                                    if (isset($icon['$' . $i]) === true) {
                                                        $s = str_replace('$' . $i, $icon['$' . $i], $s);
                                                    }
                                                } else {
                                                    $s = str_replace('$' . $i, $e[$i], $s);
                                                }
                                            }

                                            $dir = '';
                                            if (isset($icon['dir']) === true) {
                                                $dir = $this->baseDir . 'icons/' . $icon['dir'] . '/';
                                            }

                                            $s = str_replace('$0', $dir, $s);

                                            break;
                                        }//end if
                                    }//end foreach
                                } else {
                                    $s = str_replace('$1', $matches[1], $icon['insert']);
                                }//end if
                            }//end if
                        }//end if

                        $s = preg_replace('/(class=")(.*)"/', '$1mikio-icon $2"', $s, -1, $count);
                        if ($count === 0) {
                            $s = preg_replace('/(<\w* )/', '$1class="mikio-icon" ', $s);
                        }

                        return $s;
                    },
                    $icons[0]
                );
            }, $content);

            if (strcasecmp($ACT, 'preview') === 0) {
                if (is_array($preview) === true && count($preview) > 0) {
                    $preview[0]->innertext = $content;
                }

                $str = $html->save();
                $html->clear();
                unset($html);
            } else {
                $str = $content;
            }
        }//end if

        return $str;
    }

    /**
     * Parse HTML for theme
     *
     * @param   string $content HTML content to parse.
     * @return  string          Parsed content
     */
    public function parseContent(string $content)
    {
        global $INPUT, $ACT;

        // Add Mikio Section titles
        if (strcasecmp($INPUT->str('page'), 'config') === 0) {
            $admin_sections = [
                // Section      Insert Before                 Icon
                'navbar'        => ['navbarUseTitleIcon',      ''],
                'search'        => ['searchButton',            ''],
                'hero'          => ['heroTitle',               ''],
                'tags'          => ['tagsConsolidate',         ''],
                'breadcrumb'    => ['breadcrumbHideHome',      ''],
                'youarehere'    => ['youarehereHideHome',      ''],
                'sidebar'       => ['sidebarShowLeft',         ''],
                'toc'           => ['tocFull',                 ''],
                'pagetools'     => ['pageToolsFloating',       ''],
                'footer'        => ['footerCustomMenuText',    ''],
                'license'       => ['licenseType',             ''],
                'acl'           => ['includePageUseACL',       ''],
                'sticky'        => ['stickyTopHeader',         ''],
            ];

            foreach ($admin_sections as $section => $items) {
                $search = $items[0];
                $icon   = $items[1];

                $content = preg_replace(
                    '/<tr(.*)>\s*<td class="label">\s*<span class="outkey">(tpl»mikio»' . $search . ')<\/span>/',
                    '<tr$1><td class="mikio-config-table-header" colspan="2">' . $this->mikioInlineIcon($icon) .
                        tpl_getLang('config_' . $section) .
                        '</td></tr><tr class="default"><td class="label"><span class="outkey">tpl»mikio»' .
                        $search . '</span>',
                    $content
                );
            }
        } elseif (strcasecmp($INPUT->str('page'), 'styling') === 0) {
            $mikioPluginMissing = true;
            /* Hide plugin fields if not installed */
            if (plugin_load('action', 'mikioplugin') !== null) {
                $mikioPluginMissing = false;
            }

            $style_headers = [
                ['title' => 'Base', 'starts_with' => '__text_'],
                ['title' => 'Code', 'starts_with' => '__code_'],
                ['title' => 'Controls', 'starts_with' => '__control_'],
                ['title' => 'Header', 'starts_with' => '__topheader_'],
                ['title' => 'Navbar', 'starts_with' => '__navbar_'],
                ['title' => 'Sub Navbar', 'starts_with' => '__subnavbar_'],
                ['title' => 'Tags', 'starts_with' => '__tag_background_color_'],
                ['title' => 'Breadcrumbs', 'starts_with' => '__breadcrumb_'],
                ['title' => 'Hero', 'starts_with' => '__hero_'],
                ['title' => 'Sidebar', 'starts_with' => '__sidebar_'],
                ['title' => 'Content', 'starts_with' => '__content_'],
                ['title' => 'TOC', 'starts_with' => '__toc_'],
                ['title' => 'Page Tools', 'starts_with' => '__pagetools_'],
                ['title' => 'Footer', 'starts_with' => '__footer_'],
                ['title' => 'Table', 'starts_with' => '__table_'],
                ['title' => 'Dropdown', 'starts_with' => '__dropdown_'],
                ['title' => 'Section Edit', 'starts_with' => '__section_edit_'],
                ['title' => 'Tree', 'starts_with' => '__tree_'],
                ['title' => 'Tabs', 'starts_with' => '__tab_'],
                ['title' => 'Mikio Plugin', 'starts_with' => '__plugin_', 'heading' => 'h2',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Primary Colours', 'starts_with' => '__plugin_primary_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Secondary Colours', 'starts_with' => '__plugin_secondary_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Success Colours', 'starts_with' => '__plugin_success_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Danger Colours', 'starts_with' => '__plugin_danger_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Warning Colours', 'starts_with' => '__plugin_warning_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Info Colours', 'starts_with' => '__plugin_info_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Light Colours', 'starts_with' => '__plugin_light_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Dark Colours', 'starts_with' => '__plugin_dark_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Link Colours', 'starts_with' => '__plugin_link_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Carousel', 'starts_with' => '__plugin_carousel_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Steps', 'starts_with' => '__plugin_steps_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Tabgroup', 'starts_with' => '__plugin_tabgroup_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Tooltip', 'starts_with' => '__plugin_tooltip_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Dark Mode', 'starts_with' => '__darkmode_', 'heading' => 'h2'],
                ['title' => 'Base', 'starts_with' => '__darkmode_text_'],
                ['title' => 'Code', 'starts_with' => '__darkmode_code_'],
                ['title' => 'Controls', 'starts_with' => '__darkmode_control_'],
                ['title' => 'Header', 'starts_with' => '__darkmode_topheader_'],
                ['title' => 'Navbar', 'starts_with' => '__darkmode_navbar_'],
                ['title' => 'Sub Navbar', 'starts_with' => '__darkmode_subnavbar_'],
                ['title' => 'Tags', 'starts_with' => '__darkmode_tag_background_color_'],
                ['title' => 'Breadcrumbs', 'starts_with' => '__darkmode_breadcrumb_'],
                ['title' => 'Hero', 'starts_with' => '__darkmode_hero_'],
                ['title' => 'Sidebar', 'starts_with' => '__darkmode_sidebar_'],
                ['title' => 'Content', 'starts_with' => '__darkmode_content_'],
                ['title' => 'TOC', 'starts_with' => '__darkmode_toc_'],
                ['title' => 'Page Tools', 'starts_with' => '__darkmode_pagetools_'],
                ['title' => 'Footer', 'starts_with' => '__darkmode_footer_'],
                ['title' => 'Table', 'starts_with' => '__darkmode_table_'],
                ['title' => 'Dropdown', 'starts_with' => '__darkmode_dropdown_'],
                ['title' => 'Section Edit', 'starts_with' => '__darkmode_section_edit_'],
                ['title' => 'Tree', 'starts_with' => '__darkmode_tree_'],
                ['title' => 'Tabs', 'starts_with' => '__darkmode_tab_'],
                ['title' => 'Mikio Plugin (Dark mode)', 'starts_with' => '__plugin_darkmode_', 'heading' => 'h2',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Primary Colours', 'starts_with' => '__plugin_darkmode_primary_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Secondary Colours', 'starts_with' => '__plugin_darkmode_secondary_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Success Colours', 'starts_with' => '__plugin_darkmode_success_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Danger Colours', 'starts_with' => '__plugin_darkmode_danger_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Warning Colours', 'starts_with' => '__plugin_darkmode_warning_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Info Colours', 'starts_with' => '__plugin_darkmode_info_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Light Colours', 'starts_with' => '__plugin_darkmode_light_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Dark Colours', 'starts_with' => '__plugin_darkmode_dark_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Link Colours', 'starts_with' => '__plugin_darkmode_link_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Carousel', 'starts_with' => '__plugin_darkmode_carousel_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Steps', 'starts_with' => '__plugin_darkmode_steps_', 'hidden' => $mikioPluginMissing],
                ['title' => 'Tabgroup', 'starts_with' => '__plugin_darkmode_tabgroup_',
                    'hidden' => $mikioPluginMissing
                ],
                ['title' => 'Tooltip', 'starts_with' => '__plugin_darkmode_tooltip_', 'hidden' => $mikioPluginMissing],
            ];

            foreach ($style_headers as $header) {
                if (array_key_exists('heading', $header) === false) {
                    $header['heading'] = 'h3';
                }

                if (array_key_exists('hidden', $header) === false) {
                    $header['hidden'] = false;
                }

                $content = preg_replace(
                    '/(<tr>\s*<td>\s*<label for="tpl__' . $header['starts_with'] . '.+?<\/tr>)/s',
                    '</tbody></table><' . $header['heading'] . ' style="display:' .
                    ($header['hidden'] === true ? 'none' : 'block') . '">' .
                    $header['title'] . '</' . $header['heading'] . '>
                    <table style="display:' . ($header['hidden'] === true ? 'none' : 'table') . '"><tbody>$1',
                    $content,
                    1
                );
            }

            $content = preg_replace('/type="color"/', 'type="text"', $content);
        }//end if

        if (strcasecmp($ACT, 'admin') === 0 && isset($_GET['page']) === false) {
            $content = preg_replace('/(<ul.*?>.*?)<\/ul>.*?<ul.*?>(.*?<\/ul>)/s', '$1$2', $content);
        }

        // Page Revisions - Table Fix
        if (strpos($content, 'id="page__revisions"') !== false) {
            $content = preg_replace(
                '/(<span class="sum">\s.*<\/span>\s.*<span class="user">\s.*<\/span>)/',
                '<span>$1</span>',
                $content
            );
        }

        $html = new \simple_html_dom();
        $html->stripRNAttrValues = false;
        $html->load($content, true, false);

        if ($html === false) {
            return $content;
        }

        /* Buttons */
        foreach ($html->find('#config__manager button') as $node) {
            $c = explode(' ', $node->class);
            if (in_array('mikio-button', $c) === false) {
                $c[] = 'mikio-button';
            }
            $node->class = implode(' ', $c);
        }


        /* Buttons - Primary */
        foreach ($html->find('#config__manager [type=submit]') as $node) {
            $c = explode(' ', $node->class);
            if (in_array('mikio-primary', $c) === false) {
                $c[] = 'mikio-primary';
            }
            $node->class = implode(' ', $c);
        }

        /* Hide page title if hero is enabled */
        if ($this->getConf('heroTitle') === true && $ACT !== 'preview') {
            $pageTitle = $this->parsePageTitle();

            foreach ($html->find('h1,h2,h3,h4') as $elm) {
                if ($elm->innertext === $pageTitle) {
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
                $j = strpos($elm->innertext, '~~', ($i + 2));
                if ($j !== false) {
                    if ($j > ($i + 16)) {
                        $subtitle = substr($elm->innertext, ($i + 16), ($j - $i - 16));
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
                        if (stripos($image, ':') === false) {
                            $image = str_replace(['{', '}'], '', $image);
                            $i = stripos($image, '?');
                            if ($i !== false) {
                                $image = substr($image, 0, $i);
                            }

                            $image = ml($image, '', true, '', false);
                        }
                    }
                }

                $this->footerScript['hero-image'] = 'mikio.setHeroImage(\'' . $image . '\')';

                $elm->innertext = preg_replace('/~~hero-image (.+?)~~.*/ui', '', $elm->innertext);
            }//end if
        }//end foreach

        /* Hero colors - ~~hero-colors [background-color] [hero-title-color] [hero-subtitle-color]
        [breadcrumb-text-color] [breadcrumb-hover-color] (use 'initial' for original color) */
        foreach ($html->find('p') as $elm) {
            $i = stripos($elm->innertext, '~~hero-colors');
            if ($i !== false) {
                $j = strpos($elm->innertext, '~~', ($i + 2));
                if ($j !== false) {
                    if ($j > ($i + 14)) {
                        $color = substr($elm->innertext, ($i + 14), ($j - $i - 14));
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
                $j = strpos($elm->innertext, '~~', ($i + 2));
                if ($j !== false) {
                    if ($j > ($i + 13)) {
                        $parts = explode(' ', substr($elm->innertext, ($i + 13), ($j - $i - 13)));
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
                }//end if
            }//end if
        }//end foreach


        /* Page Tags (tag plugin) */
        if ($this->getConf('tagsConsolidate') === true) {
            $tags = '';
            foreach ($html->find('div.tags a') as $elm) {
                $tags .= $elm->outertext;
            }

            foreach ($html->find('div.tags') as $elm) {
                $elm->innertext = '';
                $elm->setAttribute('style', 'display:none');
            }

            if (empty($tags) === false) {
                $this->footerScript['tags'] = 'mikio.setTags(\'' . $tags . '\')';
            }
        }

        // Configuration Manager
        if (strcasecmp($INPUT->str('page'), 'config') === 0) {
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
     * @param   string $str String to parse.
     * @return  string      parsed URI
     */
    public function getLink(string $str)
    {
        $i = strpos($str, '://');
        if ($i !== false) {
            return $str;
        }

        return wl($str);
    }


    /**
     * Check if the user can edit current namespace/page
     *
     * @return  boolean  user can edit
     */
    public function userCanEdit()
    {
        global $INFO;
        global $ID;

        $wiki_file = wikiFN($ID);
        if (@file_exists($wiki_file) === false) {
            return true;
        }
        if ($INFO['isadmin'] === true || $INFO['ismanager'] === true) {
            return true;
        }
        // $meta_file = metaFN($ID, '.meta');
        if ($INFO['meta']['user'] === false) {
            return true;
        }
        if ($INFO['client'] === $INFO['meta']['user']) {
            return true;
        }

        return false;
    }


    /**
     * Search for and return the uri of a media file
     *
     * @param string  $image           Image name to search for (without extension).
     * @param boolean $searchCurrentNS Search the current namespace.
     * @param boolean $propagate       Propagate search through the namespace.
     * @return string                  URI of the found media file
     */
    public function getMediaFile(string $image, bool $searchCurrentNS = true, bool $propagate = true)
    {
        global $INFO;

        $ext = ['png', 'jpg', 'gif', 'svg'];

        if ($searchCurrentNS === true) {
            $prefix[] = ':' . $INFO['namespace'] . ':';
        }
        if ($propagate === true) {
            $prefix[] = ':';
            $prefix[] = ':wiki:';
        }
        $theme = $this->getConf('customTheme');
        if (empty($theme) === false) {
            $prefix[] = 'themes/' . $theme . '/images/';
        }
        $prefix[] = 'images/';

        $search = [];
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
            if (strcasecmp(substr($img, 0, 1), ':') === 0) {
                $file    = mediaFN($img);
                $ismedia = true;
            } else {
                $file    = tpl_incdir() . $img;
                $ismedia = false;
            }

            if (file_exists($file) === true) {
                $found = true;
                break;
            }
        }

        if ($found === false) {
            return false;
        }

        if ($ismedia === true) {
            $url = ml($img, '', true, '', false);
        } else {
            $url = tpl_basedir() . $img;
        }

        return $url;
    }


    /**
     * Print or return the page title
     *
     * @param string $page Page id or empty string for current page.
     * @return string      generated content
     */
    public function getPageTitle(string $page = '')
    {
        global $ID, $conf;

        $html = '';

        if (empty($page) === true) {
            $page = $ID;
        }

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
     * @param   string $type  Icon to retreive.
     * @param   string $class Classname to insert.
     * @return  string        HTML icon content
     */
    public function mikioInlineIcon(string $type, string $class = "")
    {
        if (is_array($class) === true) {
            $class = explode(' ', $class);
        }

        if (strlen($class) > 0) {
            $class = ' ' . $class;
        }

        switch ($type) {
            case 'wrench':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1792 
1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,53.152542,1217.0847)"><path d="m 384,64 q 0,26 -19,45 -19,
19 -45,19 -26,0 -45,-19 -19,-19 -19,-45 0,-26 19,-45 19,-19 45,-19 26,0 45,19 19,19 19,45 z m 644,420 -682,-682 q -37,
-37 -90,-37 -52,0 -91,37 L 59,-90 Q 21,-54 21,0 21,53 59,91 L 740,772 Q 779,674 854.5,598.5 930,523 1028,484 z m 634,
435 q 0,-39 -23,-106 Q 1592,679 1474.5,595.5 1357,512 1216,512 1031,512 899.5,643.5 768,775 768,960 q 0,185 131.5,316.5 
131.5,131.5 316.5,131.5 58,0 121.5,-16.5 63.5,-16.5 107.5,-46.5 16,-11 16,-28 0,-17 -16,-28 L 1152,1120 V 896 l 193,
-107 q 5,3 79,48.5 74,45.5 135.5,81 61.5,35.5 70.5,35.5 15,0 23.5,-10 8.5,-10 8.5,-25 z"/></g></svg>';
            case 'file':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" 
viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,235.38983,1277.8305)" id="g2991">
<path d="M 128,0 H 1152 V 768 H 736 q -40,0 -68,28 -28,28 -28,68 v 416 H 128 V 0 z m 640,896 h 299 L 768,1195 V 896 z M 
1280,768 V -32 q 0,-40 -28,-68 -28,-28 -68,-28 H 96 q -40,0 -68,28 -28,28 -28,68 v 1344 q 0,40 28,68 28,28 68,28 h 544 
q 40,0 88,-20 48,-20 76,-48 l 408,-408 q 28,-28 48,-76 20,-48 20,-88 z" id="path2993" inkscape:connector-curvature="0" 
xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" /></g></svg>';
            case 'gear':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" 
viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,121.49153,1285.4237)" id="g3027">
<path d="m 1024,640 q 0,106 -75,181 -75,75 -181,75 -106,0 -181,-75 -75,-75 -75,-181 0,-106 75,-181 75,-75 181,-75 106,0 
181,75 75,75 75,181 z m 512,109 V 527 q 0,-12 -8,-23 -8,-11 -20,-13 l -185,-28 q -19,-54 -39,-91 35,-50 107,-138 10,-12 
10,-25 0,-13 -9,-23 -27,-37 -99,-108 -72,-71 -94,-71 -12,0 -26,9 l -138,108 q -44,-23 -91,-38 -16,-136 -29,-186 -7,-28 
-36,-28 H 657 q -14,0 -24.5,8.5 Q 622,-111 621,-98 L 593,86 q -49,16 -90,37 L 362,16 Q 352,7 337,7 323,7 312,18 186,132 
147,186 q -7,10 -7,23 0,12 8,23 15,21 51,66.5 36,45.5 54,70.5 -27,50 -41,99 L 29,495 Q 16,497 8,507.5 0,518 0,531 v 222 
q 0,12 8,23 8,11 19,13 l 186,28 q 14,46 39,92 -40,57 -107,138 -10,12 -10,24 0,10 9,23 26,36 98.5,107.5 72.5,71.5 94.5,
71.5 13,0 26,-10 l 138,-107 q 44,23 91,38 16,136 29,186 7,28 36,28 h 222 q 14,0 24.5,-8.5 Q 914,1391 915,1378 l 28,-184 
q 49,-16 90,-37 l 142,107 q 9,9 24,9 13,0 25,-10 129,-119 165,-170 7,-8 7,-22 0,-12 -8,-23 -15,-21 -51,-66.5 -36,-45.5 
-54,-70.5 26,-50 41,-98 l 183,-28 q 13,-2 21,-12.5 8,-10.5 8,-23.5 z" id="path3029" inkscape:connector-curvature="0" />
</g></svg>';
            case 'user':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" 
viewBox="0 -256 1792 1792" style="fill:currentColor"><g transform="matrix(1,0,0,-1,197.42373,1300.6102)"><path d="M 
1408,131 Q 1408,11 1335,-58.5 1262,-128 1141,-128 H 267 Q 146,-128 73,-58.5 0,11 0,131 0,184 3.5,234.5 7,285 17.5,343.5 
28,402 44,452 q 16,50 43,97.5 27,47.5 62,81 35,33.5 85.5,53.5 50.5,20 111.5,20 9,0 42,-21.5 33,-21.5 74.5,-48 41.5,
-26.5 108,-48 Q 637,565 704,565 q 67,0 133.5,21.5 66.5,21.5 108,48 41.5,26.5 74.5,48 33,21.5 42,21.5 61,0 111.5,-20 
50.5,-20 85.5,-53.5 35,-33.5 62,-81 27,-47.5 43,-97.5 16,-50 26.5,-108.5 10.5,-58.5 14,-109 Q 1408,184 1408,131 z m 
-320,893 Q 1088,865 975.5,752.5 863,640 704,640 545,640 432.5,752.5 320,865 320,1024 320,1183 432.5,1295.5 545,1408 704,
1408 863,1408 975.5,1295.5 1088,1183 1088,1024 z"/></g></svg>';
            case 'search':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" 
aria-hidden="true" style="fill:currentColor"><path d="M27 24.57l-5.647-5.648a8.895 8.895 0 0 0 1.522-4.984C22.875 9.01 
18.867 5 13.938 5 9.01 5 5 9.01 5 13.938c0 4.929 4.01 8.938 8.938 8.938a8.887 8.887 0 0 0 4.984-1.522L24.568 27 27 
24.57zm-13.062-4.445a6.194 6.194 0 0 1-6.188-6.188 6.195 6.195 0 0 1 6.188-6.188 6.195 6.195 0 0 1 6.188 6.188 6.195 
6.195 0 0 1-6.188 6.188z"/></svg>';
            case 'home':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" 
viewBox="0 -256 1792 1792" aria-hidden="true" style="fill:currentColor"><g 
transform="matrix(1,0,0,-1,68.338983,1285.4237)" id="g3015"><path d="M 1408,544 V 64 Q 1408,38 1389,19 1370,0 1344,0 H 
960 V 384 H 704 V 0 H 320 q -26,0 -45,19 -19,19 -19,45 v 480 q 0,1 0.5,3 0.5,2 0.5,3 l 575,474 575,-474 q 1,-2 1,-6 z 
m 223,69 -62,-74 q -8,-9 -21,-11 h -3 q -13,0 -21,7 L 832,1112 140,535 q -12,-8 -24,-7 -13,2 -21,11 l -62,74 q -8,10 
-7,23.5 1,13.5 11,21.5 l 719,599 q 32,26 76,26 44,0 76,-26 l 244,-204 v 195 q 0,14 9,23 9,9 23,9 h 192 q 14,0 23,-9 9,
-9 9,-23 V 840 l 219,-182 q 10,-8 11,-21.5 1,-13.5 -7,-23.5 z" id="path3017" inkscape:connector-curvature="0" 
xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" /></g></svg>';
            case 'sun':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" 
style="fill:currentColor" viewBox="0 0 16 16"><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 
0 8zm.5-9.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 11a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm5-5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm-11 
0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9.743-4.036a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707zm-7.779 7.779a.5.5 0 1 
1-.707-.707.5.5 0 0 1 .707.707zm7.072 0a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707zM3.757 4.464a.5.5 0 1 1 .707-.707.5.5 
0 0 1-.707.707z" /></svg>';
            case 'moon':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" 
style="fill:currentColor" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 
4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 
1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 
1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 
0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" /></svg>';
            case 'hamburger':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" 
style="fill:currentColor"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 
76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 
16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 
16v40c0 8.837 7.163 16 16 16z"/></svg>';
            case 'down-arrow':
                return '<svg class="mikio-iicon' . $class . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" 
aria-hidden="true" style="fill:currentColor"><path d="M16.003 18.626l7.081-7.081L25 13.46l-8.997 8.998-9.003-9 
1.917-1.916z"/></svg>';
        }//end switch

        return '';
    }

    /**
     * Finalize theme
     *
     * @return void
     */
    public function finalize()
    {
    }

    /**
     * Show Messages
     *
     * @return void
     */
    public function showMessages()
    {
        global $ACT;

        if ($this->lessIgnored === true) {
            msg(
                'useLESS is enabled on the Mikio template, however is not supported on this server',
                2,
                '',
                '',
                MSG_ADMINS_ONLY
            );
        }

        $show = $this->getConf('showNotifications');
        if (
            strcasecmp($show, 'always') === 0 ||
            (strcasecmp($show, 'admin') === 0 && strcasecmp($ACT, 'admin') === 0)
        ) {
            global $MSG, $MSG_shown;

            if (isset($MSG) === false) {
                return;
            }

            if (isset($MSG_shown) === false) {
                $MSG_shown = [];
            }

            foreach ($MSG as $msg) {
                $hash = md5($msg['msg']);
                if (isset($MSG_shown[$hash]) === true) {
                    continue;
                }
                // skip double messages

                if (info_msg_allowed($msg) === true) {
                    echo '<div class="' . $msg['lvl'] . '">';
                    echo $msg['msg'];
                    echo '</div>';
                }

                $MSG_shown[$hash] = true;
            }

            unset($GLOBALS['MSG']);
        }//end if
    }

    /**
     * Dokuwiki version
     *
     * @return  string        the dw version name
     */
    public function dwVersion()
    {
        if (function_exists('getVersionData') === true) {
            $version_data = getVersionData();
            if (is_array($version_data) === true && array_key_exists('date', $version_data) === true) {
                $version_items = explode(' ', $version_data['date']);
                if (count($version_items) >= 2) {
                    return preg_replace('/[^a-zA-Z0-9 ]+/', '', strtolower($version_items[1]));
                }
            }
        }

        return 'unknown';
    }

    /**
     * Dokuwiki version number
     *
     * @return  string        the dw version date converted to integer
     */
    public function dwVersionNumber()
    {
        if (function_exists('getVersionData') === true) {
            $version_data = getVersionData();
            if (is_array($version_data) === true && array_key_exists('date', $version_data) === true) {
                $version_items = explode(' ', $version_data['date']);
                if (count($version_items) >= 1) {
                    return intval(preg_replace('/[^0-9]+/', '', strtolower($version_items[0])));
                }
            }
        }

        return 0;
    }
}

global $TEMPLATE;
$TEMPLATE = \dokuwiki\template\mikio\Template::getInstance();
