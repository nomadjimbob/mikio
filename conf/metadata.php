<?php
/*
 * configuration metadata
 *
 */

$meta['includeFontAwesome'] = array('onoff');
$meta['useFontAwesome']     = array('onoff');
$meta['useTheme']           = array('string');
$meta['navbarMenuStyle']    = array('multichoice', '_choices' => array('icon', 'icon and text', 'text'));
$meta['navbarClasses']      = array('string');
$meta['useHeroTitle']       = array('onoff');
$meta['navbarMenuPosition'] = array('multichoice', '_choices' => array('none', 'left', 'center', 'right'));
$meta['navbarMenuClasses']  = array('string');
$meta['breadcrumbsLoc']     = array('multichoice', '_choices' => array('top', 'hero', 'page'));
$meta['tocfullheight']      = array('onoff');

$meta['discussionPage']   = array('string');
$meta['userPage']         = array('string');
$meta['hideTools']        = array('onoff');
$meta['navbar']             = array('string');
