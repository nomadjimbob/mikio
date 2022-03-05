# Mikio DokuWiki Template

![screenshot](https://github.com/nomadjimbob/mikio/blob/master/images/screenshot.png)

## About

`Mikio` is a Bootstrap 4 style template for [DokuWiki](http://dokuwiki.org)

## Features

- [bootstrap styling](http://getbootstrap.com/)
- Navbar with dropdown support
- Subnavbar support (using a page named submenu)
- Right sidebar
- Hero element
- Icon support
- Customizable breadcrumbs
- Theming support
- Tags plugin support
- Mobile friendly

## Changes

- 2022-03-05
  - Breadcrumbs and You Are Here have now been seperated instead of combined. This removed the options `breadcrumbHome` and `breadcrumbShowLast` for the breadcrumbs as it only applies to the you are here bar. **Breadcrumbs and You Are Here options may have reset**

- 2020-09-27
  - Sidebars now collapse by default on mobile. This can be overridden with the `sidebarMobileDefaultCollapse` option
  - The mikio LESS stylesheet is now disabled by default, with a precompilied CSS used. This can be reverted using the `useLESS` option

## Configuration

The configuration can be change with the [Configuration Manager Plugin](https://www.dokuwiki.org/plugin:config)

- `iconTag` : icon tag to use to engage the icon engine. Default to `icon`
- `customTheme` : the mikio theme to use, located in the `mikio/themes` directory
- `showNotifications` : where to show site notifications for admin staff
- `useLESS` : use the LESS compilier or direct CSS for the mikio stylesheet. Requires the ctype PHP extension installed

- `navbarUseTitleIcon` : show the site logo in the navbar
- `navbarUseTitleText` : show the site title in the navbar
- `navbarUseTaglineText` : show the site tagline in the navbar. Requires the `navbarUseTitleText` to be enabled
- `navbarCustomMenuText` : custom menu to use in the navbar. Menu items are in the format of url|title with each item seperated by a semicolon. Requires one of the `navbarPos` to be set to `custom`

- `navbarDWMenuType` : how to show the DokuWiki menu items in the navbar. Can be either icons, text or both
- `navbarDWMenuCombine` : how to show the DokuWiki menu in the navbar. Can be either category dropdowns, single items or a combined dropdown. The combined menu title is pulled from the `tools-menu` language value

- `navbarPosLeft` : what menu to show on the left of the navbar
- `navbarPosMiddle` : what menu to show in the middle of the navbar
- `navbarPosRight` : what menu to show on the right of the navbar
- `navbarShowSub` : show the sub navbar. This menu is pulled from the `submenu` page in the current or parent namespaces. The menu is also shown on child pages. If no page is found, the sub navbar is automatically hidden

- `navbarItemShowCreate` : show the Create Page menu item
- `navbarItemShowShow` : show the Show Page menu item
- `navbarItemShowRevs` : show the Revisions menu item
- `navbarItemShowBacklink` : show the Backlinks menu item
- `navbarItemShowRecent` : show the Recent Changes menu item
- `navbarItemShowMedia` : show the Media Manager menu item
- `navbarItemShowIndex` : show the Sitemap menu item
- `navbarItemShowProfile` : show the Update Profile menu item
- `navbarItemShowAdmin` : show the Admin menu item
- `navbarItemShowLogin` : show the Login menu item
- `navbarItemShowLogout` : show the Logout menu item

- `searchButton` : show the search button as a icon or text

- `heroTitle` : show the hero block on pages
- `heroImagePropagation` : search for hero images in parent namespaces if none is found in the current namespace

- `tagsConsolidate` : Consolidate tags found in the current page and display it in the hero, content header or sidebar

- `breadcrumbHideHome` : hide breadcrumbs in the root namespace
- `breadcrumbPosition` : where to display the breadcrumbs, either under the navbar, in the hero element or above the page content
- `breadcrumbPrefix` : enable changing the breadcrumb prefix
- `breadcrumbPrefixText` : text to set the breadcrumb prefix. Requires `breadcrumbPrefix` to be enabled
- `breadcrumbSep` : enable changing the breadcrumb seperator
- `breadcrumbSepText` : text to set the breadcrumb seperator. Requires `breadcrumbSep` to be enabled

- `youarehereHideHome` : hide you are here in the root namespace
- `youareherePosition` : where to display the you are here, either under the navbar, in the hero element or above the page content
- `youareherePrefix` : enable changing the you are here prefix
- `youareherePrefixText` : text to set the you are here prefix. Requires `you are herePrefix` to be enabled
- `youarehereSep` : enable changing the you are here seperator
- `youarehereSepText` : text to set the you are here seperator. Requires `you are hereSep` to be enabled
- `youarehereHome` : change the you are here home item to none, page title of root page, 'home' or an icon/image. The 'home' text is pulled from the `home` language value
- `youarehereShowLast` : only show an amount of you are here from the last. Will also show the home item in the list if enabled. Set this to `0` to show all items

- `sidebarShowLeft` : show the left sidebar if content is found
- `sidebarLeftRow1` : content to show in the first row of the left sidebar
- `sidebarLeftRow2` : content to show in the second row of the left sidebar
- `sidebarLeftRow3` : content to show in the third row of the left sidebar
- `sidebarLeftRow4` : content to show in the forth row of the left sidebar
- `sidebarMobileDefaultCollapse` : collapse the sidebars by default when viewed on mobile
- `sidebarShowRight` : show the right sidebar if content is found

- `tocFull` : show the table of contents as a full height item

- `pageToolsFloating` : when and if to show the floating page tools
- `pageToolsFooter`

- `pageToolsShowCreate` : show the Create Page item
- `pageToolsShowEdit` : show the Edit Page item
- `pageToolsShowRevs` : show the Revisions item
- `pageToolsShowBacklink` : show the Backlinks item
- `pageToolsShowTop` : show the Back to Top item

- `footerCustomMenuText` : custom menu to use in the footer. Menu items are in the format of url|title with each item seperated by a semicolon
- `footerSearch` : show the search bar in the footer

- `licenseType` : how to show the license in the footer
- `licenseImageOnly` : show the license in the footer as an image only. Requires `licenseType` to at least be enabled

- `includePageUseACL` : respect ACL when including pages
- `includePagePropagate` : search parent namespaces when including pages

## Include Pages

The following pages can be either html files in the root of the template or a page in the namespace. Namespace pages take priority.

- `topheader` : content to include above the navbar
- `header` : content include below the navbar but above the page content
- `contentheader` : content to include above the page content
- `contentfooter` : content to include below the page content
- `sidebarheader` : content to include above the left sidebar content
- `sidebarfooter` : content to include below the left sidebar content
- `rightsidebarheader` : content to include above the right sidebar content
- `rightsidebarfooter` : content to include below the right sidebar content
- `footer` : content to include in the footer
- `bottomfooter` : content to include below the footer

## Include Images

The following images can be used to replace content in the template. Images can be in the root of the template or in the namespace. Images can be either png, jpg, gif or svg.

- `logo` : site logo in the navbar
- `breadcrumb-prefix` breadcrumb prefix
- `breadcrumb-sep` breadcrumb seperator
- `hero` hero image for hero element

## Hero Element

- `title` : The hero title is sourced from the page title. The page title is removed from the page content
- `subtitle` : Pages can set the subtitle by inserting `~~hero-subtitle TEXT~~` in the page content
- `image` : The hero image is sourced from an image named hero in the current or parental namespace. Namespace searching can be confined by the `includePagePropagate` setting. Pages can also override the image by inserting `~~hero-image URL~~` in the page content. DokuWiki and external URLs are supported
- `colors` : Colors can be overridden by including `~~hero-colors BACKGROUND_COLOR HERO_TITLE_COLOR HERO_SUBTITLE_COLOR BREADCRUMB_TEXT_COLOR BREADCRUMB_HOVER_COLOR~~`. You do not need to include all the color options. Use 'initial' to skip a color override

Namespaces can also apply the above hero settings in child pages by including the above settings in a page named `theme`.

## Hiding Elements

Mikio now supports hiding elements using the `~~hide-parts (parts)~~` macro. Each element within the hide-parts macro is required to be seperated by spaces. Currently the following parts are supported:

- `topheader` : content above the navbar
- `navbar` : the main navigation bar
- `header` : content below the navbar but above the page content
- `hero` : the page hero bar
- `contentheader` : content above the page content
- `contentfooter` : content below the page content
- `sidebarheader` : content above the left sidebar content
- `sidebarfooter` : content below the left sidebar content
- `rightsidebarheader` : content above the right sidebar content
- `rightsidebarfooter` : content below the right sidebar content
- `footer` : content in the footer
- `bottomfooter` : content below the footer

To hide the topheader, navbar and hero, you would use the macro `~~hide-parts topheader navbar hero~~`

## Icon Engine

- Mikio includes an icon engine that allows you to include icons in your pages by using <icon OPTIONS> in your content
- If the icon tag conflicts with another plugin, you can change the tag from `icon` to a user set value in the settings
- By default, Mikio enables FontAwesome 4 by also includes FontAwesome 5, Elusive 2 and Bootstrap Icons which can be enabled by uncommenting their inclusions in `/icons/icons.php`

Users can also add their own icon sets into the template. Supported icon sets can either be webfonts or indivial files (such as a SVG library). Instructions can be found in the `/icons/icons.php` file.

## Themes

Themes should be placed in the themes directory, in its own directory. LESS files are supported.

## Mikio Plugin

The [Mikio Plugin](https://github.com/nomadjimbob/mikioplugin/) is also available to add bootstrap 4 style + more elements to DokuWiki pages.

## Languages

- `sidebar-title` : Text for the collapsable block in the sidebar
- `tools-menu` : Text for the combined tools DokuWiki menu title
- `home` : Text for the breadcrumb home title

## Releases

- **_2022-03-05_**

  - Fixed page tools in footer not being horizontal [#38]. Thanks chitland
  - Fixed Mikio Config headers disappearing in some cases
  - Separated Breadcrumbs and You Are Here items [#36]. Thanks chitland

- **_2021-12-11_**

  - Added table row background styling options
  - Fixed styling issue when using the indexmenu plugin [#35](https://github.com/nomadjimbob/mikio/issues/35). Thanks 3ole.
  - Fixed inconsitant tab/spaces in mikio.less and mikio.css
  - Removed debug logs from mikio.js
  - Fixed input placeholders not hiding in prepopulated fields [#34](https://github.com/nomadjimbob/mikio/issues/34)
  - Added option to hide menu and page tool items [#32](https://github.com/nomadjimbob/mikio/issues/32). Thanks annievoss.
  - Fixed compadibility with BookCreator [#26](https://github.com/nomadjimbob/mikio/issues/26). Thanks johncourtland.
  - Fixed Greebo styling errors not present in Hogsfather

- **_2021-08-11_**

  - Fixed path check on Windows [#33](https://github.com/nomadjimbob/mikio/issues/33)
  - Recompilied CSS

- **_2021-06-17_**

  - Added support for navbar title link to use showpageafterlogin setting if installed [#27](https://github.com/nomadjimbob/mikio/issues/27)

- **_2021-06-09_**

  - TOC is now full width on mobile [#25](https://github.com/nomadjimbob/mikio/issues/25)
  - Hamburger and sidebar icons are now displayed correctly [#23](https://github.com/nomadjimbob/mikio/issues/23), [#24](https://github.com/nomadjimbob/mikio/issues/24)
  - Site width is now available under Template Style Settings  [#22](https://github.com/nomadjimbob/mikio/issues/22)
  - TOC is now sticky when set to full height [#21](https://github.com/nomadjimbob/mikio/issues/21)
  - Added support to the theme being linked by a symbolic link [#20](https://github.com/nomadjimbob/mikio/issues/20)
  - Mikio will now fallback to using CSS when there is the LESS engine is not detected [#20](https://github.com/nomadjimbob/mikio/issues/20)

- **_2021-03-10_**

  - Fixed bad breadcrumb URL formatting on sites using userewrite [#19](https://github.com/nomadjimbob/mikio/issues/19)

- **_2021-03-04_**

  - Added support to hide page elements [#18](https://github.com/nomadjimbob/mikio/issues/18)

- **_2021-01-22_**

  - Fixed a syntax error with the core css

- **_2020-11-12_**

  - Corrected terminology in readme to match Dokuwiki [#17](https://github.com/nomadjimbob/mikio/issues/17)
  - Fix showing part of the sidebar when it should be hidden in certain conditions [#16](https://github.com/nomadjimbob/mikio/issues/16)
  - Added option to always show the sidebar, even when there is no content [#16](https://github.com/nomadjimbob/mikio/issues/16)

- **_2020-10-07_**

  - Fixed hero header parsing on some servers
  - Fixed safari color picker issue [#14](https://github.com/nomadjimbob/mikio/issues/14)
  - LESS now defaults to enabled with fallback to ctype functions built into mikio for docker apps [#13](https://github.com/nomadjimbob/mikio/issues/13)
  - Fix for Template Style Settings being ignored [#12](https://github.com/nomadjimbob/mikio/issues/12)

- **_2020-10-01_**

  - Fix for `sidebarMobileDefaultCollapse` option being inconsistent in code and not working correctly [#11](https://github.com/nomadjimbob/mikio/issues/11). Thanks to GJRobert for catching that.

- **_2020-09-27_**

  - Sidebars hidden by default in mobile view [#10](https://github.com/nomadjimbob/mikio/issues/10)
  - Fixed errors with the LESS compilier on some nginx configurations
  - Fixed styling and image display thumb size in media manager popup
  - Fixed text field placeholders not disappearing with text entry
  - Added support for Hogfather
  - Added option to use LESS or direct CSS. Some configurations (docker linuxserver/dokuwiki) do not have the required PHP extensions installed
  - Supports Docker linuxserver/dokuwiki container file structures

- **_2020-09-10_**

  - Floating page tools is now a UL element with classes applied from getType and getLinkAttributes. Fixes popup dialogs initiated from the a page menu [#7](https://github.com/nomadjimbob/mikio/issues/7)
  - Template.info.txt now shows correct release dates [#8](https://github.com/nomadjimbob/mikio/issues/8)
  - Fixed rightsidebar php warnings
  - Code/Pre blocks no longer have padding applied on the admin pages

- **_2020-08-26_**

  - Footer is no longer shown outside of page view
  - Public messages are now displayed on the page
  - Fixed icon rendering in hero bar
  - Fixed TOC rendering bug

- **_2020-07-27_**

  - Added option to show wiki footer in page content

- **_2020-07-24_**

  - Fixed image detail bug

- **_2020-07-20_**

  - Fixed prewrap and sidebar search bar margins

- **_2020-07-16_**

  - Merged code block styling with pre
  - Fixed mediamanager failures on 2018-04-22a "Greebo" [#5](https://github.com/nomadjimbob/mikio/issues/5)
  - Icon tag is rendered correctly in preview [#4](https://github.com/nomadjimbob/mikio/issues/4)

- **_2020-07-15_**

  - Fixed an issue with the simple_html_dom library when editing a section of a page caused page corruption [#3](https://github.com/nomadjimbob/mikio/issues/3)

- **_2020-07-14_**

  - Added id=dokuwiki\_\_content identifier for the page content element
  - Added styling and fixed overflow issues with pre elements
  - Fixed page width overflow issues

- **_2020-07-09_**

  - Fixed cosmetic display issues when `input[type=file]` is hidden by plugins [#2](https://github.com/nomadjimbob/mikio/issues/2)

- **_2020-07-07_**
  - Initial release

## Third Party Libraries

This template uses a [modified version](https://github.com/nomadjimbob/simple_html_dom) of [simple_html_dom](https://sourceforge.net/projects/simplehtmldom/)

## Support

- If you think you have found a problem, or would like to see a feature, please [open an issue](https://github.com/nomadjimbob/mikio/issues)
- If you are a coder, feel free to create a pull request, but please be detailed about your changes!
