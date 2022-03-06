<?php
/**
 * DokuWiki Mikio Template Main
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if (!defined('DOKU_INC')) die();
require_once('mikio.php');

global $TEMPLATE, $ACT, $conf, $USERINFO;

header('X-UA-Compatible: IE=edge,chrome=1');

$hasSidebar = $TEMPLATE->sidebarExists();
$showSidebar = $hasSidebar && ($ACT=='show');

?>
<!doctype html>
<html lang="<?php echo $conf['lang'] ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
        echo '<title>' . $TEMPLATE->getPageTitle() . '</title>';
        tpl_metaheaders();
        echo tpl_favicon(array('favicon', 'mobile'));
        tpl_includeFile('meta.html');
    ?>
</head>

<body class="mikio dokuwiki">
<div id="dokuwiki__site">
<?php
    echo '<div id="dokuwiki__top" class="site ' . tpl_classes() . (($showSidebar) ? ' showSidebar' : '') . (($hasSidebar) ? ' hasSidebar' : '') . '">';
    $TEMPLATE->includePage('topheader', TRUE, TRUE, 'mikio-page-topheader' . (($TEMPLATE->getConf('stickyTopHeader')) ? ' mikio-sticky' : ''));
    $TEMPLATE->includeNavbar(TRUE, $TEMPLATE->getConf('navbarShowSub', FALSE) && $ACT == 'show');
    if($ACT == 'show' || $ACT == 'admin') $TEMPLATE->includePage('header', TRUE, TRUE, 'mikio-page-header' . (($TEMPLATE->getConf('stickyHeader')) ? ' mikio-sticky' : ''));

    echo '<a name="dokuwiki__top" id="dokuwiki__top"></a>';

    if(($ACT == 'show' && $TEMPLATE->getConf('youareherePosition') == 'top') || ($ACT == 'show' && $TEMPLATE->getConf('youareherePosition') == 'hero' && $TEMPLATE->getConf('heroTitle') == FALSE) || ($ACT != 'show')) $TEMPLATE->includeYouAreHere();
    if(($ACT == 'show' && $TEMPLATE->getConf('breadcrumbPosition') == 'top') || ($ACT == 'show' && $TEMPLATE->getConf('breadcrumbPosition') == 'hero' && $TEMPLATE->getConf('heroTitle') == FALSE)) $TEMPLATE->includeBreadcrumbs();
    if($ACT == 'show' && $TEMPLATE->getConf('heroTitle')) $TEMPLATE->includeHero();

    echo '<main class="mikio-page">';
    echo '<div class="mikio-container">';
        if($showSidebar) $TEMPLATE->includeSidebar();
        echo '<div class="mikio-content" id="dokuwiki__content">';
            if($ACT == 'show' && $TEMPLATE->getConf('youareherePosition') == 'page') $TEMPLATE->includeYouAreHere();
            if($ACT == 'show' && $TEMPLATE->getConf('breadcrumbPosition') == 'page') $TEMPLATE->includeBreadcrumbs();

            $TEMPLATE->showMessages();

            echo '<article class="mikio-article' . ($TEMPLATE->getConf('tocFull') ? ' toc-full' : '') . '">';
                $TEMPLATE->includeTOC();
                if($ACT == 'show') $TEMPLATE->includePage('contentheader', TRUE, TRUE, 'mikio-page-contentheader');
                $TEMPLATE->includeContent();
                if($ACT == 'show') $TEMPLATE->includePage('contentfooter', TRUE, TRUE, 'mikio-page-contentfooter');
            echo '</article>';
        echo '</div>';


        $showPageTools = $TEMPLATE->getConf('pageToolsFloating');
        if ($ACT == 'show' && ($showPageTools == 'always' || $TEMPLATE->userCanEdit() && $showPageTools == 'page editors')) $TEMPLATE->includePageTools(TRUE, TRUE);

        $rightsidebar = '';
        if($showSidebar) $rightsidebar = $TEMPLATE->includeSidebar('right');
    echo '</div>';
    echo '</main>';
    echo '<div class="mikio-page-fill">';
        echo '<div class="mikio-content" style="padding:0">';
        if($TEMPLATE->getConf('footerInPage') == TRUE && $ACT=='show') $TEMPLATE->includeFooter();
        echo '</div>';
        if($rightsidebar != '') echo '<aside class="mikio-sidebar mikio-sidebar-right"></aside>';
    echo '</div>';

    if($TEMPLATE->getConf('footerInPage') == FALSE && $ACT=='show') $TEMPLATE->includeFooter();
    $TEMPLATE->includePage('bottomfooter', TRUE, TRUE, 'mikio-page-bottomfooter');
?>
    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
</div></div>
<?php $TEMPLATE->includeFooterMeta(); ?>
</body>
<?php $TEMPLATE->finalize(); ?>
</html>
