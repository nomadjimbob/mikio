# Mikio DokuWiki Template

## About

`Mikio` is a Bootstrap 4 style template for [DokuWiki](http://dokuwiki.org)


## Features


  * [bootstrap styling](http://getbootstrap.com/)
  * Navbar with dropdown support
  * Subnavbar support (using a page named submenu)
  * Right sidebar
  * Hero element
  * Icon support
  * Customizable breadcrumbs
  * Subtheming support
  * Tags plugin support
  * Mobile friendly


## Changes

  * 2020-09-27
    * Sidebars now collapse by default on mobile. This can be overridden with the `sidebarMobileDefaultCollapse` option
    * The mikio LESS stylesheet is now disabled by default, with a precompilied CSS used. This can be reverted using the `useLESS` option

## Configuration

The configuration can be change with the [Configuration Manager Plugin](https://www.dokuwiki.org/plugin:config)

  * `iconTag` : icon tag to use to engage the icon engine. Default to `icon`
  * `customTheme` : the mikio subtheme to use
  * `showNotifications` : where to show site notifications for admin staff
  * `useLESS` : use the LESS compilier or direct CSS for the mikio stylesheet. Requires the ctype PHP extension installed.
  
  * `navbarUseTitleIcon` : show the site logo in the navbar
  * `navbarUseTitleText` : show the site title in the navbar
  * `navbarUseTaglineText` : show the site tagline in the navbar. Requires the `navbarUseTitleText` to be enabled
  * `navbarCustomMenuText` : custom menu to use in the navbar. Menu items are in the format of url|title with each item seperated by a semicolon. Requires one of the `navbarPos` to be set to `custom`

  * `navbarDWMenuType` : how to show the DokuWiki menu items in the navbar. Can be either icons, text or both
  * `navbarDWMenuCombine` : how to show the DokuWiki menu in the navbar. Can be either category dropdowns, single items or a combined dropdown. The combined menu title is pulled from the `tools-menu` language value

  * `navbarPosLeft` : what menu to show on the left of the navbar
  * `navbarPosMiddle` : what menu to show in the middle of the navbar
  * `navbarPosRight` : what menu to show on the right of the navbar
  * `navbarShowSub` : show the sub navbar. This menu is pulled from the `submenu` page in the current or parent namespaces. The menu is also shown on child pages. If no page is found, the sub navbar is automatically hidden

  * `searchButton` : show the search button as a icon or text

  * `heroTitle` : show the hero block on pages
  * `heroImagePropagation` : search for hero images in parent namespaces if none is found in the current namespace

  * `tagsConsolidate` : Consolidate tags found in the current page and display it in the hero, content header or sidebar

  * `breadcrumbHideHome` : hide breadcrumbs in the root namespace
  * `breadcrumbPosition` : where to display the breadcrumbs, either under the navbar, in the hero element or above the page content
  * `breadcrumbPrefix` : enable changing the breadcrumb prefix
  * `breadcrumbPrefixText` : text to set the breadcrumb prefix. Requires `breadcrumbPrefix` to be enabled
  * `breadcrumbSep` : enable changing the breadcrumb seperator
  * `breadcrumbSepText` : text to set the breadcrumb seperator. Requires `breadcrumbSep` to be enabled
  * `breadcrumbHome` : change the breadcrumb home item to none, page title of root page, 'home' or an icon/image. The 'home' text is pulled from the `home` language value
  * `breadcrumbShowLast` : only show an amount of breadcrumbs from the last. Will also show the home item in the list if enabled. Set this to `0` to show all items

  * `sidebarShowLeft` : show the left sidebar if content is found
  * `sidebarLeftRow1` : content to show in the first row of the left sidebar
  * `sidebarLeftRow2` : content to show in the second row of the left sidebar
  * `sidebarLeftRow3` : content to show in the third row of the left sidebar
  * `sidebarLeftRow4` : content to show in the forth row of the left sidebar
  * `sidebarMobileDefaultCollapse` : collapse the sidebars by default when viewed on mobile
  * `sidebarShowRight` : show the right sidebar if content is found

  * `tocFull` : show the table of contents as a full height item

  * `pageToolsFloating` : when and if to show the floating page tools
  * `pageToolsFooter` : when and if to show page tools in the footer

  * `footerCustomMenuText` : custom menu to use in the footer. Menu items are in the format of url|title with each item seperated by a semicolon
  * `footerSearch` : show the search bar in the footer

  * `licenseType` : how to show the license in the footer
  * `licenseImageOnly` : show the license in the footer as an image only. Requires `licenseType` to at least be enabled

  * `includePageUseACL` : respect ACL when including pages
  * `includePagePropagate` : search parent namespaces when including pages


## Include Pages

The following pages can be either html files in the root of the theme or a page in the namespace. Namespace pages take priority.

  * `topheader` : content to include above the navbar
  * `header` : content include below the navbar but above the page content
  * `contentheader` : content to include above the page content
  * `contentfooter` : content to include below the page content
  * `sidebarheader` : content to include above the left sidebar content
  * `sidebarfooter` : content to include below the left sidebar content
  * `rightsidebarheader` : content to include above the right sidebar content
  * `rightsidebarfooter` : content to include below the right sidebar content
  * `footer` : content to include in the footer
  * `bottomfooter` : content to include below the footer


## Include Images

The following images can be used to replace content in the theme. Images can be in the root of the theme or in the namespace. Images can be either png, jpg, gif or svg.

  * `logo` : site logo in the navbar
  * `breadcrumb-prefix` breadcrumb prefix
  * `breadcrumb-sep` breadcrumb seperator
  * `hero` hero image for hero element


## Hero Element

  * `title` : The hero title is sourced from the page title. The page title is removed from the page content
  * `subtitle` : Pages can set the subtitle by inserting `~~hero-subtitle TEXT~~` in the page content
  * `image` : The hero image is sourced from an image named hero in the current or parental namespace. Namespace searching can be confined by the `includePagePropagate` setting. Pages can also override the image by inserting `~~hero-image URL~~` in the page content. DokuWiki and external URLs are supported
  * `colors` : Colors can be overridden by including `~~hero-colors BACKGROUND_COLOR HERO_TITLE_COLOR HERO_SUBTITLE_COLOR BREADCRUMB_TEXT_COLOR BREADCRUMB_HOVER_COLOR~~`. You do not need to include all the color options. Use 'initial' to skip a color override

Namespaces can also apply the above hero settings in child pages by including the above settings in a page named `theme`. 


## Icon Engine

  * Mikio includes an icon engine that allows you to include icons in your pages by using <icon OPTIONS> in your content
  * If the icon tag conflicts with another plugin, you can change the tag from `icon` to a user set value in the settings
  * By default, Mikio enables FontAwesome 4 by also includes FontAwesome 5, Elusive 2 and Bootstrap Icons which can be enabled by uncommenting their inclusions in `/icons/icons.php`

Users can also add their own icon sets into the theme. Supported icon sets can either be webfonts or indivial files (such as a SVG library). Instructions can be found in the `/icons/icons.php` file.


## Subthemes

Subthemes should be placed in the themes directory in its own directory. LESS files are supported.


## Mikio Plugin

The [Mikio Plugin](https://github.com/nomadjimbob/mikioplugin/) is also available to add bootstrap 4 style + more elements to DokuWiki pages.


## Languages

  * `sidebar-title` : Text for the collapsable block in the sidebar
  * `tools-menu` : Text for the combined tools DokuWiki menu title
  * `home` : Text for the breadcrumb home title


## Releases

  * ***2020-10-01***
    * Fix for `sidebarMobileDefaultCollapse` option being inconsistent in code and not working correctly [#11](https://github.com/nomadjimbob/mikio/issues/11). Thanks to GJRobert for catching that.

  * ***2020-09-27***
    * Sidebars hidden by default in mobile view [#10](https://github.com/nomadjimbob/mikio/issues/10)
    * Fixed errors with the LESS compilier on some nginx configurations
    * Fixed styling and image display thumb size in media manager popup
    * Fixed text field placeholders not disappearing with text entry
    * Added support for Hogfather
    * Added option to use LESS or direct CSS. Some configurations (docker linuxserver/dokuwiki) do not have the required PHP extensions installed
    * Supports Docker linuxserver/dokuwiki container file structures

  * ***2020-09-10***
    * Floating page tools is now a UL element with classes applied from getType and getLinkAttributes. Fixes popup dialogs initiated from the a page menu [#7](https://github.com/nomadjimbob/mikio/issues/7)
    * Template.info.txt now shows correct release dates [#8](https://github.com/nomadjimbob/mikio/issues/8)
    * Fixed rightsidebar php warnings
    * Code/Pre blocks no longer have padding applied on the admin pages

  * ***2020-08-26***
    * Footer is no longer shown outside of page view
    * Public messages are now displayed on the page
    * Fixed icon rendering in hero bar
    * Fixed TOC rendering bug

  * ***2020-07-27***
    * Added option to show wiki footer in page content

  * ***2020-07-24***
    * Fixed image detail bug

  * ***2020-07-20***
    * Fixed prewrap and sidebar search bar margins 

  * ***2020-07-16***
    * Merged code block styling with pre
    * Fixed mediamanager failures on 2018-04-22a "Greebo" [#5](https://github.com/nomadjimbob/mikio/issues/5)
    * Icon tag is rendered correctly in preview [#4](https://github.com/nomadjimbob/mikio/issues/4)

  * ***2020-07-15***
    * Fixed an issue with the simple_html_dom library when editing a section of a page caused page corruption [#3](https://github.com/nomadjimbob/mikio/issues/3)

  * ***2020-07-14***
    * Added id=dokuwiki__content identifier for the page content element
    * Added styling and fixed overflow issues with pre elements
    * Fixed page width overflow issues

  * ***2020-07-09***
    * Fixed cosmetic display issues when `input[type=file]` is hidden by plugins [#2](https://github.com/nomadjimbob/mikio/issues/2)

  * ***2020-07-07***
    * Initial release


## Third Party Libraries

This theme uses a [modified version](https://github.com/nomadjimbob/simple_html_dom) of [simple_html_dom](https://sourceforge.net/projects/simplehtmldom/)

## Support

  * If you think you have found a problem, or would like to see a feature, please [open an issue](https://github.com/nomadjimbob/mikio/issues)
  * If you are a coder, feel free to create a pull request, but please be detailed about your changes!
