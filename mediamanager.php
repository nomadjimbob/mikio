<?php
/**
 * DokuWiki Media Manager Popup
 *
 * @author   Andreas Gohr <andi@splitbrain.org>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run from within DokuWiki
if (defined('DOKU_INC') === false) {
    die();
}

header('X-UA-Compatible: IE=edge,chrome=1');
global $conf;
global $lang;

?><!DOCTYPE html>
<html lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction'] ?>" class="popup no-js">
<head>
    <meta charset="utf-8" />
    <title>
        <?php echo hsc($lang['mediaselect'])?>
        [<?php echo strip_tags($conf['title'])?>]
    </title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php try { tpl_metaheaders(); } catch (Exception $e) { /* empty */ } ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(['favicon', 'mobile']) ?>
    <?php tpl_includeFile('meta.html') ?>
    <?php
        $baseDir = tpl_basedir();
        echo '<link type="text/css" rel="stylesheet" href="' . $baseDir . 'css.php?css=assets/mikio.less">';
        echo '<script type="text/javascript" src="' . $baseDir . 'assets/mikio.js"></script>';
    ?>
</head>

<body>
    <div id="media__manager" class="dokuwiki">
        <?php html_msgarea() ?>
        <div id="mediamgr__aside"><div class="pad">
            <h1><?php echo hsc($lang['mediaselect'])?></h1>

            <?php /* keep the id! additional elements are inserted via JS here */?>
            <div id="media__opts"></div>

            <?php tpl_mediaTree() ?>
        </div></div>

        <div id="mediamgr__content"><div class="pad">
            <?php tpl_mediaContent() ?>
        </div></div>
    </div>
</body>
</html>
