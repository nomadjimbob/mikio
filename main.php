<?php
/**
 * DokuWiki Mikio Template
 *
 * @link     http://dokuwiki.org/template:mikio
 * @author   James Collins <james.collins@outlook.com.au>
 * @license  MIT License (https://raw.githubusercontent.com/nomadjimbob/Mikio/master/LICENSE)
 */

if (!defined('DOKU_INC')) die();
require_once('mikio.php');

global $TEMPLATE, $ACT, $conf;

header('X-UA-Compatible: IE=edge,chrome=1');
?>
<!doctype html>
<html lang="<?php echo $conf['lang'] ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo '<title>' . $TEMPLATE->includePageTitle('', FALSE) . '</title>' ?>
    <?php tpl_metaheaders() ?>
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body class="mikio dokuwiki mikio-act-<?php echo $ACT ?>">
    <?php
        $content = tpl_includeFile('topheader.html');
        if($content != '') $content = $TEMPLATE->includePage('topheader');
        if($content != '') echo '<div class="mikio-header-top">' . $content . '</div>';

        // TODO is this still needed?
        //if ($ACT == 'show')
        //$TEMPLATE->includePage('topheader');
    ?>

    <?php $TEMPLATE->includeNavbar(); ?>

    <?php
    tpl_includeFile('header.html');
    if ($ACT == 'show') $TEMPLATE->includePage('header');
    ?>

    <a name="dokuwiki__top" id="dokuwiki__top"></a>

    <!-- Breadcrumbs -->
    <?php if ($ACT == 'show' && $TEMPLATE->getConf('breadcrumbPos') == 'top' || $ACT == 'admin') $TEMPLATE->includeBreadcrumbs(); ?>

    <!-- Hero Title -->
    <?php $TEMPLATE->includeHero(); ?>

    <main class="mikio-page">
        <?php if ($ACT == 'show') $TEMPLATE->includeSidebar() ?>
        
        <div class="mikio-content">
        <?php
            if ($ACT == 'show' && $TEMPLATE->getConf('breadcrumbPos') == 'page') $TEMPLATE->includeBreadcrumbs();

            tpl_includeFile('pageheader.html');
            if ($ACT == 'show') $TEMPLATE->includePage('pageheader');

            echo '<article class="mikio-article">';
            $TEMPLATE->includeTOC();
            $TEMPLATE->includeContent(TRUE);
            echo '</article>';

            tpl_includeFile('pagefooter.html');
            if ($ACT == 'show') $TEMPLATE->includePage('pagefooter');
            ?>
        </div> 
        <?php
            global $USERINFO;

            if ($ACT == 'show' && !$TEMPLATE->getConf('pageToolsHide') && (!$TEMPLATE->getConf('pageToolsHideNoEdit') || $TEMPLATE->userCanEdit()) && (!$TEMPLATE->getConf('pageToolsHideGuest') || ($USERINFO))) {
                $TEMPLATE->includePageTools(TRUE, TRUE);
            }
        ?>
        </div>

        <?php if ($ACT == 'show') $TEMPLATE->includeSidebar('right') ?>
    </main>

    <div class="mikio-page-fill"></div>

    <!-- Footer -->
    <?php $TEMPLATE->includeFooter(); ?>

    </div>

    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
</body>
</html>