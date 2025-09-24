<?php

/**
 * DokuWiki Mikio Template Icons
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

global $MIKIO_ICONS;


/*
    You can add custom icon libraries into this file and use them
    with the theme.

    - Copy the CSS and FONT files into its own folder inside the
      icons folder

    - Add an array to the $MIKIO_ICONS array with the following keys:

        name    this is the name used to identify the icon in the
                <icon> tag
        css     the CSS file to load. If your icon collection has
                subtypes (like FontAwesome 5), you can create
                multiple entries with the same CSS file. The theme
                will prevent duplicate loadings of CSS files. You can
                also use CDN paths
        insert  what to insert in place of the icon tag. Use $1 to
                tell the theme where to insert the icon-type specified
                by the page content

    The icon tag use can use on the DokuWiki page is:

        <icon name icon-type[ extra]>

    If no name is specified in the tag, the theme will use the first
    entry in $MIKIO_ICONS

    If a name is not found in the $MIKIO_ICONS array, the tag is
    removed from the output

    If you are using a SVG library, you can also use the extra parameters
    of the icon tag. Each parameter (seperated by space) can be put
    into the insert key as $2 - $9

    If you include a key named as the parameter, if that parameter is
    not defined in the icon tag, then this will be used as the
    default value

    An example below is the twbs svg icon library. The extra parameter
    is used to define the svg fill color. You can use $0 for the URI
    path to the icons folder (defined by the dir key)
*/

/* Avoid conflicts with the Mikio Syntax Plugin */
if (plugin_load('action', 'mikioplugin') !== null) {
    return;
}

/* Font Awesome 4 */
$MIKIO_ICONS[] = ['name' => 'fa', 'css' => 'fontawesome/css/all.min.css', 'insert' => '<i class="fa fa-$1"></i>'];

/* Font Awesome 4 - CDN */
/* $MIKIO_ICONS[] = ['name' => 'fa',
    'css' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
    'insert' => '<i class="fa fa-$1"></i>']; */

/* Font Awesome 5 */
/* $fa5 = 'fontawesome5/css/all.min.css'; */
/* $MIKIO_ICONS[] = ['name' => 'fas', 'css' => $fa5, 'insert' => '<i class="fas fa-$1"></i>']; */
/* $MIKIO_ICONS[] = ['name' => 'far', 'css' => $fa5, 'insert' => '<i class="far fa-$1"></i>']; */
/* $MIKIO_ICONS[] = ['name' => 'fal', 'css' => $fa5, 'insert' => '<i class="fal fa-$1"></i>']; */
/* $MIKIO_ICONS[] = ['name' => 'fab', 'css' => $fa5, 'insert' => '<i class="fab fa-$1"></i>']; */

/* Font Awesome 5 - CDN */
/* $fa5 = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css'; */
/* $MIKIO_ICONS[] = ['name' => 'fas', 'css' => $fa5, 'insert' => '<i class="fas fa-$1"></i>']; */
/* $MIKIO_ICONS[] = ['name' => 'far', 'css' => $fa5, 'insert' => '<i class="far fa-$1"></i>']; */
/* $MIKIO_ICONS[] = ['name' => 'fal', 'css' => $fa5, 'insert' => '<i class="fal fa-$1"></i>']; */
/* $MIKIO_ICONS[] = ['name' => 'fab', 'css' => $fa5, 'insert' => '<i class="fab fa-$1"></i>']; */

/* Elusive 2 */
/* $MIKIO_ICONS[] = ['name' => 'el',
    'css' => 'elusive/css/elusive-icons.min.css',
    'insert' => '<i class="el el-$1"></i>']; */

/* Elusive 2 - CDN */
/* $MIKIO_ICONS[] = ['name' => 'el',
    'css' => '//maxcdn.bootstrapcdn.com/elusive-icons/2.0.0/css/elusive-icons.min.css',
    'insert' => '<i class="el el-$1"></i>']; */

/* TWBS - https://github.com/twbs/icons/releases */
/* $MIKIO_ICONS[] = [
    'name' => 'bi',
    'dir' => 'bootstrap-icons',
    'css' => 'bootstrap-icons/bi.css',
    'insert' => '<span class="bi-icon"
        style="background-color:$2; mask-image:url($0svg/$1.svg); -webkit-mask-image:url($0svg/$1.svg);"></span>',
    '$2' => 'black',
]; */
