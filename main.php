<?php
/**
 * DokuWiki Mikio Template
 *
 * @link     http://dokuwiki.org/template:mikio
 * @author   James Collins <james.collins@outlook.com.au>
 * @license  MIT License (https://raw.githubusercontent.com/nomadjimbob/Mikio/master/LICENSE)
 */

if (!defined('DOKU_INC')) die();

global $TEMPLATE;
require_once('mikio.php');


header('X-UA-Compatible: IE=edge,chrome=1');
?><!doctype html>
<html lang="<?php echo $conf['lang'] ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <?php tpl_metaheaders() ?>
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
  </head>
  <body class="mikio d-flex flex-column dokuwiki">
    <!-- <div class="dokuwiki"> -->

        <?php
            tpl_includeFile('topheader.html');
            if ($ACT == 'show') $TEMPLATE->includePage('topheader');
        ?>


        <!-- Navbar -->
        <nav class="navbar <?php print $TEMPLATE->getConf('navbarClasses'); ?>">
          <div id="mikio-site-title" class="mr-0 p-0">
            <div class="row">
              <?php
                $logo     = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false);
                $title    = $conf['title'];
                $tagline  = (($conf['tagline']) ? '<span class="navbar-text mikio-navbar-tagline col-12 p-0">'. $conf['tagline'] .'</span>' : '');
                
                if($logo != '' && $TEMPLATE->getConf('navbarHideImage') == false) {
                    echo '<div class="col-2 mikio-navbar-image" style="background-image:url(\'' . $logo . '\')"></div><div class="col-10">';
                } else {
                    echo '<div class="col-12">';
                }
                echo '<a href="' . wl() . '" title="' . $title . '" class="navbar-brand col-12 p-0">' . $title . '</a>' . ($tagline != '' ? $tagline : '');
                echo '</div>';
              ?>
            </div>
          </div>
          <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <!-- <div class="col-md-9"> -->
            <?php $TEMPLATE->includeSearch('left'); ?>
            <ul class="navbar-nav <?php print $TEMPLATE->getConf('navbarMenuClasses') . ' ' . $TEMPLATE->getConf('navbarMenuPosition') ?>">

                <!-- Custom Menus -->
                <?php $TEMPLATE->includeCustomMenu('navbar', false); ?>
                <?php $TEMPLATE->includeMenu('navbar'); ?>
             
            </ul>
            <?php $TEMPLATE->includeSearch('right'); ?>
          <!-- </div> -->
        </nav>

        <?php
            tpl_includeFile('header.html');
            if ($ACT == 'show') $TEMPLATE->includePage('header');
        ?>

        <!-- Breadcrumbs -->
        <?php $TEMPLATE->includeBreadcrumbs('top'); ?>

        <!-- Hero Title -->
        <?php ob_start(); ?>
        <?php $TEMPLATE->includeHero(); ?>

        <div class="d-flex flex-grow-1">
          <!-- Sidebar -->
          <?php $TEMPLATE->includeSidebar('left'); ?>

          <!-- Content -->
          <main>
            <?php
                $TEMPLATE->includeBreadcrumbs('page');
                $TEMPLATE->includeTOC('float');

                tpl_includeFile('pageheader.html');
                if ($ACT == 'show') $TEMPLATE->includePage('pageheader');

                tpl_content(false);

                tpl_includeFile('pagefooter.html');
                if ($ACT == 'show') $TEMPLATE->includePage('pagefooter');
            ?>
          </main>

          <!-- TOC -->
          <?php $TEMPLATE->includeTOC('full'); ?>

          <!-- Page Tools -->
          <?php $TEMPLATE->includePageTools('side'); ?>

        </div>

        <?php
            $content = ob_get_contents();
            ob_end_clean();
            print $TEMPLATE->parseContent($content);
        ?>

        <!-- Footer -->
        <footer class="bg-dark text-white p-3">
          <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
          <?php
            tpl_includeFile('footer.html');
            if ($ACT == 'show') $TEMPLATE->includePage('footer');

            $TEMPLATE->includeSearch('footer');
            $TEMPLATE->includeCustomMenu('footer', true);
            
            $TEMPLATE->includePageTools('footer');
            tpl_license('button')
            ?>
        </footer>

      </div>
      
      <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <!-- </div> -->
  </body>
</html>
