<?php

/**
 * DokuWiki Mikio Template Main
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if (defined('DOKU_INC') === false) {
    die();
}
require_once('mikio.php');

global $TEMPLATE, $ACT, $conf, $USERINFO;

header('X-UA-Compatible: IE=edge,chrome=1');

$hasSidebar = $TEMPLATE->sidebarExists();
$showSidebar = $hasSidebar && ($ACT === 'show');

ob_start();
?>
<!doctype html>
<html lang="<?php echo $conf['lang'] ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $TEMPLATE->getPageTitle() ?></title>
    <?php
        try {
            tpl_metaheaders();
        } catch (Exception $e) {
            /* empty */
        }
        echo tpl_favicon(['favicon', 'mobile']);
        tpl_includeFile('meta.html');
    ?>
</head>
<body class="mikio<?php echo $TEMPLATE->getConf('autoLightDark') === true ? ' mikio-auto-darklight' : '' ?><?php echo $TEMPLATE->getConf('defaultDark') === true ? ' mikio-default-dark' : '' ?>">
<div id="dokuwiki__site">
    <?php
    echo '<div id="dokuwiki__top" class="site ' . tpl_classes() . (($showSidebar === true) ? ' showSidebar' : '') .
        (($hasSidebar === true) ? ' hasSidebar' : '') . '">';
    $TEMPLATE->includePage('topheader', true, true, 'mikio-page-topheader' .
        (($TEMPLATE->getConf('stickyTopHeader') === true) ? ' mikio-sticky' : ''));
    $TEMPLATE->includeNavbar(true, $ACT === 'show' && $TEMPLATE->getConf('navbarShowSub', false));
    if ($ACT === 'show' || $ACT === 'admin') {
        $TEMPLATE->includePage('header', true, true, 'mikio-page-header' .
            (($TEMPLATE->getConf('stickyHeader') === true) ? ' mikio-sticky' : ''));
    }

    /** @noinspection HtmlDeprecatedAttribute */
    echo '<a name="dokuwiki__top" id="dokuwiki__top"></a>';

    if (
        ($ACT === 'show' && $TEMPLATE->getConf('youareherePosition') === 'top') || ($ACT === 'show' &&
        $TEMPLATE->getConf('youareherePosition') === 'hero' && $TEMPLATE->getConf('heroTitle') === false) ||
        ($ACT !== 'show')
    ) {
        $TEMPLATE->includeYouAreHere();
    }
    if (
        ($ACT === 'show' && $TEMPLATE->getConf('breadcrumbPosition') === 'top') || ($ACT === 'show' &&
        $TEMPLATE->getConf('breadcrumbPosition') === 'hero' && $TEMPLATE->getConf('heroTitle') === false)
    ) {
        $TEMPLATE->includeBreadcrumbs();
    }
    if ($ACT === 'show' && $TEMPLATE->getConf('heroTitle') === true) {
        $TEMPLATE->includeHero();
    }

    echo '<main class="mikio-page">';
    echo '<div class="mikio-container">';
    if ($showSidebar === true) {
        $TEMPLATE->includeSidebar();
    }
        echo '<div class="mikio-content" id="dokuwiki__content">';
    if ($ACT === 'show' && $TEMPLATE->getConf('youareherePosition') === 'page') {
        $TEMPLATE->includeYouAreHere();
    }
    if ($ACT === 'show' && $TEMPLATE->getConf('breadcrumbPosition') === 'page') {
        $TEMPLATE->includeBreadcrumbs();
    }

            $TEMPLATE->showMessages();

            echo '<article class="mikio-article' . ($TEMPLATE->getConf('tocFull') === true && $TEMPLATE->hideTOC() === false ? ' toc-full' : '') . '">';
                if($TEMPLATE->hideTOC() === false) {
                    $TEMPLATE->includeTOC();
                }
    if ($ACT === 'show') {
        $TEMPLATE->includePage('contentheader', true, true, 'mikio-page-contentheader');
    }
                $TEMPLATE->includeContent();
    if ($ACT === 'show') {
        $TEMPLATE->includePage('contentfooter', true, true, 'mikio-page-contentfooter');
    }
            echo '</article>';
        echo '</div>';


        $showPageTools = $TEMPLATE->getConf('pageToolsFloating');
    if (
        $ACT === 'show' && ($showPageTools === 'always' || ($TEMPLATE->userCanEdit() === true &&
        $showPageTools === 'page editors'))
    ) {
        $TEMPLATE->includePageTools(true, true);
    }

        $rightsidebar = '';
    if ($showSidebar === true) {
        $rightsidebar = $TEMPLATE->includeSidebar('right');
    }

    echo '</div>';
    echo '</main>';
    echo '<div class="mikio-page-fill">';
        echo '<div class="mikio-content" style="padding:0">';
    if ($ACT === 'show' && $TEMPLATE->getConf('footerInPage') === true) {
        $TEMPLATE->includeFooter();
    }
        echo '</div>';
    if ($rightsidebar !== '') {
        echo '<aside class="mikio-sidebar mikio-sidebar-right"></aside>';
    }
    echo '</div>';

    if ($ACT === 'show' && $TEMPLATE->getConf('footerInPage') === false) {
        $TEMPLATE->includeFooter();
    }
    $TEMPLATE->includePage('bottomfooter', true, true, 'mikio-page-bottomfooter');
    ?>
    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
</div>
<?php $TEMPLATE->includeFooterMeta(); ?>
</body>
</html>
<?php
$html = ob_get_clean();
echo $html;
?>
