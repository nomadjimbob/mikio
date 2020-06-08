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
  <body class="mikio d-flex flex-column">
    <!-- <div class="dokuwiki"> -->

        <!-- Navbar -->
        <nav class="navbar <?php print $TEMPLATE->getConf('navbarClasses'); ?>">
          <div id="mikio-site-title" class="mr-0 p-0">
            <div class="row">
              <?php
                $logo     = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false);
                $title    = $conf['title'];
                $tagline  = (($conf['tagline']) ? '<span class="navbar-text mikio-navbar-tagline col-12 p-0">'. $conf['tagline'] .'</span>' : '');
                
                if($logo != '') echo '<div class="col-2 mikio-navbar-image" style="background-image:url(\'' . $logo . '\')"></div><div class="col-9">';
                echo '<a href="' . wl() . '" title="' . $title . '" class="navbar-brand col-12 p-0">' . $title . '</a>' . ($tagline != '' ? $tagline : '');
                if($logo != '') echo '</div>';
              ?>
            </div>
          </div>
          <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <!-- <div class="col-md-9"> -->
            <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
            <ul class="navbar-nav <?php print $TEMPLATE->getConf('navbarMenuClasses') . ' ' . $TEMPLATE->getConf('navbarMenuPosition') ?>">

              <!-- User Tools -->
              <li id="dokuwiki__usertools" class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php $TEMPLATE->navbarMenuTitle('user_tools', 'user'); ?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <?php tpl_toolsevent('usertools', array(
                      'admin'     => $TEMPLATE->elementAddClass(tpl_action('admin', true, false, true), 'dropdown-item'),
                      //'userpage'  => $TEMPLATE->htmlAddClass(_tpl_action('userpage', true, false, true), 'dropdown-item'),
                      'profile'   => $TEMPLATE->elementAddClass(tpl_action('profile', true, false, true), 'dropdown-item'),
                      'register'  => $TEMPLATE->elementAddClass(tpl_action('register', true, false, true), 'dropdown-item'),
                      'login'     => $TEMPLATE->elementAddClass(tpl_action('login', true, false, true), 'dropdown-item'),
                  )); ?>
                </div>
              </li>

              <!-- Site Tools -->
              <li id="dokuwiki__sitetools" class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php $TEMPLATE->navbarMenuTitle('site_tools', 'briefcase'); ?></a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <?php tpl_toolsevent('sitetools', array(
                    'recent'    => $TEMPLATE->elementAddClass(tpl_action('recent', true, false, true), 'dropdown-item'),
                    'media'     => $TEMPLATE->elementAddClass(tpl_action('media', true, false, true), 'dropdown-item'),
                    'index'     => $TEMPLATE->elementAddClass(tpl_action('index', true, false, true), 'dropdown-item'),
                  )); ?>
                  </div>
              </li>

              <!-- Page Tools -->
              <li id="dokuwiki__pagetools" class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php $TEMPLATE->navbarMenuTitle('page_tools', 'file-text-o'); ?></a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <?php tpl_toolsevent('pagetools', array(
                    'edit'      => $TEMPLATE->elementAddClass(tpl_action('edit', true, false, true), 'dropdown-item'),
                    'revisions' => $TEMPLATE->elementAddClass(tpl_action('revisions', true, false, true), 'dropdown-item'),
                    'revert' => $TEMPLATE->elementAddClass(tpl_action('revert', true, false, true), 'dropdown-item'),
                    'backlink'     => $TEMPLATE->elementAddClass(tpl_action('backlink', true, false, true), 'dropdown-item'),
                    'subscribe'     => $TEMPLATE->elementAddClass(tpl_action('subscribe', true, false, true), 'dropdown-item'),
                  )); ?>
                  </div>
              </li>

              <?php if (!empty($_SERVER['REMOTE_USER'])) {
                  echo '<li class="user navbar-text text-nowrap">';
                  tpl_userinfo(); /* 'Logged in as ...' */
                  echo '</li>';
              }?>
          </ul>
          <!-- </div> -->
        </nav>

        <!-- Breadcrumbs -->
        <?php $TEMPLATE->includeBreadcrumbs('top'); ?>

        <!-- Hero Title -->
        <?php $TEMPLATE->includeHero(); ?>

        <div class="d-flex flex-grow-1">
          <!-- Sidebar -->
          <?php $TEMPLATE->includeSidebar('left'); ?>

          <!-- Content -->
          <main>
            <?php $TEMPLATE->includeBreadcrumbs('page'); ?>
            <?php $TEMPLATE->includeTOC('float'); ?>
            <?php tpl_content(false) ?>
          </main>

          <!-- TOC -->
          <?php $TEMPLATE->includeTOC('full'); ?>
        </div>

        <!-- Footer -->
        <footer class="bg-dark text-white p-3">
          <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
          <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
        </footer>

      </div>
      
      <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <!-- </div> -->
  </body>
</html>
