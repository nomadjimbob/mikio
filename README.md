# Mikio DokuWiki Template

![screenshot](https://github.com/nomadjimbob/mikio/blob/main/images/screenshot.png)

## About

`Mikio` is a Bootstrap 4 style template for [DokuWiki](http://dokuwiki.org)

## Features

-   [bootstrap styling](http://getbootstrap.com/)
-   Navbar with dropdown support
-   Sub navbar support (using a page named submenu)
-   Right sidebar
-   Hero element
-   Icon support
-   Customizable breadcrumbs
-   Theming support
-   Tags plugin support
-   Mobile friendly
-   Typeahead search support

## Possible Breaking Changes

-   2023-05-13

    -   Table styling had a long-standing bug found by RonaldPR which has been fixed. This fix may require updating the styling if your website was relying on this bug.

-   2022-10-04

    -   Some elements now have their own color options to allow finer control of your website design.

-   2022-04-25

    -   Added support for the defer js option in Hogsfather to override the templates default defer action of always.
    -   The new Typeahead search feature is enabled by default. This can be turned off in the config.

-   2022-03-05

    -   Breadcrumbs and You Are Here have now been seperated instead of combined. This removed the options `breadcrumbHome` and `breadcrumbShowLast` for the breadcrumbs as it only applies to the 'you are here' bar. **Breadcrumbs and You Are Here options may have reset**

-   2020-09-27
    -   Sidebars now collapse by default on mobile. This can be overridden with the `sidebarMobileDefaultCollapse` option
    -   The mikio LESS stylesheet is now disabled by default, with a precompilied CSS used. This can be reverted using the `useLESS` option

## Incompatibilities

**Comment Syntax support** converts custom control macros such as the Mikio macro `~~hero-image ...~~` into comments. If you plan to use this extension on your site, you will need to use the alternative macro format of `-~hero-image ...~-` for Mikio to detect the information.

## Configuration

The configuration can be changed with the [Configuration Manager Plugin](https://www.dokuwiki.org/plugin:config)

-   `iconTag` : icon tag to use to engage the icon engine. Default to `icon`
-   `customTheme` : the mikio theme to use, located in the `mikio/themes` directory
-   `showNotifications` : where to show site notifications for admin staff
-   `useLESS` : use the LESS compilier or direct CSS for the mikio stylesheet. Requires the ctype PHP extension installed
-   `brandURLGuest` : change the brand URL for guests. Leave blank to use the default
-   `brandURLUser` : change the brand URL for logged-in users. Leave blank to use the default

-   `navbarUseTitleIcon` : show the site logo in the navbar
-   `navbarUseTitleText` : show the site title in the navbar
-   `navbarUseTaglineText` : show the site tagline in the navbar. Requires the `navbarUseTitleText` to be enabled
-   `navbarCustomMenuText` : custom menu to use in the navbar. Menu items are in the format of url|title with each item seperated by a semicolon. Requires one of the `navbarPos` to be set to `custom`

-   `navbarDWMenuType` : how to show the DokuWiki menu items in the navbar. Can be either icons, text or both
-   `navbarDWMenuCombine` : how to show the DokuWiki menu in the navbar. Can be either category dropdowns, single items or a combined dropdown. The combined menu title is pulled from the `tools-menu` language value

-   `navbarPosLeft` : what menu to show on the left of the navbar
-   `navbarPosMiddle` : what menu to show in the middle of the navbar
-   `navbarPosRight` : what menu to show on the right of the navbar
-   `navbarShowSub` : show the sub navbar. This menu is pulled from the `submenu` page in the current or parent namespaces. The menu is also shown on child pages. If no page is found, the sub navbar is automatically hidden

-   `navbarItemShowCreate` : show the Create Page menu item
-   `navbarItemShowShow` : show the Show Page menu item
-   `navbarItemShowRevs` : show the Revisions menu item
-   `navbarItemShowBacklink` : show the Backlinks menu item
-   `navbarItemShowRecent` : show the Recent Changes menu item
-   `navbarItemShowMedia` : show the Media Manager menu item
-   `navbarItemShowIndex` : show the Sitemap menu item
-   `navbarItemShowProfile` : show the Update Profile menu item
-   `navbarItemShowAdmin` : show the Admin menu item
-   `navbarItemShowLogin` : show the Login menu item
-   `navbarItemShowLogout` : show the Logout menu item

-   `searchButton` : show the search button as an icon or text
-   `searchUseTypeahead` : use [Typeahead](https://github.com/bassjobsen/Bootstrap-3-Typeahead) page suggestions in search bar

-   `heroTitle` : show the hero block on pages
-   `heroImagePropagation` : search for hero images in parent namespaces if none is found in the current namespace

-   `tagsConsolidate` : Consolidate tags found in the current page and display it in the hero, content header or sidebar
-   `tagsShowHero` : Show the tags in the hero element of the page. Can be turned off if using the `<tags>` element in the MikioPlugin

-   `breadcrumbHideHome` : hide breadcrumbs in the root namespace
-   `breadcrumbPosition` : where to display the breadcrumbs, either under the navbar, in the hero element or above the page content
-   `breadcrumbPrefix` : enable changing the breadcrumb prefix
-   `breadcrumbPrefixText` : text to set the breadcrumb prefix. Requires `breadcrumbPrefix` to be enabled
-   `breadcrumbSep` : enable changing the breadcrumb seperator
-   `breadcrumbSepText` : text to set the breadcrumb seperator. Requires `breadcrumbSep` to be enabled

-   `youarehereHideHome` : hide you are here in the root namespace
-   `youareherePosition` : where to display the 'you are here', either under the navbar, in the hero element or above the page content
-   `youareherePrefix` : enable changing the 'you are here' prefix
-   `youareherePrefixText` : text to set the 'you are here' prefix. Requires `you are herePrefix` to be enabled
-   `youarehereSep` : enable changing the 'you are here' seperator
-   `youarehereSepText` : text to set the 'you are here' seperator. Requires `you are hereSep` to be enabled
-   `youarehereHome` : change the 'you are here' home item to none, page title of root page, 'home' or an icon/image. The 'home' text is pulled from the `home` language value
-   `youarehereShowLast` : only show an amount of you are here from the last. Will also show the home item in the list if enabled. Set this to `0` to show all items

-   `sidebarShowLeft` : show the left sidebar if content is found
-   `sidebarLeftRow1` : content to show in the first row of the left sidebar
-   `sidebarLeftRow2` : content to show in the second row of the left sidebar
-   `sidebarLeftRow3` : content to show in the third row of the left sidebar
-   `sidebarLeftRow4` : content to show in the forth row of the left sidebar
-   `sidebarMobileDefaultCollapse` : collapse the sidebars by default when viewed on mobile
-   `sidebarShowRight` : show the right sidebar if content is found

-   `tocFull` : show the table of contents as a full height item

-   `pageToolsFloating` : when and if to show the floating page tools
-   `pageToolsFooter`

-   `pageToolsShowCreate` : show the Create Page item
-   `pageToolsShowEdit` : show the Edit Page item
-   `pageToolsShowRevs` : show the Revisions item
-   `pageToolsShowBacklink` : show the Backlinks item
-   `pageToolsShowTop` : show the Back to Top item

-   `footerCustomMenuText` : custom menu to use in the footer. Menu items are in the format of url|title with each item seperated by a semicolon
-   `footerSearch` : show the search bar in the footer

-   `licenseType` : how to show the license in the footer
-   `licenseImageOnly` : show the license in the footer as an image only. Requires `licenseType` to at least be enabled

-   `includePageUseACL` : respect ACL when including pages
-   `includePagePropagate` : search parent namespaces when including pages

## Right Sidebar
The right sidebar can be applied by creating a normal wiki page called "rightsidebar". Go to http://your-wiki.com/doku.php?id=rightsidebar, click "Create this page", edit the page, save, and you're done. That's it, your saved changes will appear in your right sidebar.

## Include Pages

The following pages can be either html files in the root of the template or a page in the namespace. Namespace pages take priority.

-   `topheader` : content to include above the navbar
-   `header` : content include below the navbar but above the page content
-   `contentheader` : content to include above the page content
-   `contentfooter` : content to include below the page content
-   `sidebarheader` : content to include above the left sidebar content
-   `sidebarfooter` : content to include below the left sidebar content
-   `rightsidebarheader` : content to include above the right sidebar content
-   `rightsidebarfooter` : content to include below the right sidebar content
-   `footer` : content to include in the footer
-   `bottomfooter` : content to include below the footer

## Include Images

The following images can be used to replace content in the
template. Images can be in `TEMPLATE_ROOT/images/`,
`TEMPLATE_ROOT/themes/THEME/images/`, or in the namespace. Images can
be either png, jpg, gif or svg.

-   `logo` : site logo in the navbar
-   `breadcrumb-prefix` breadcrumb prefix
-   `breadcrumb-sep` breadcrumb seperator
-   `hero` hero image for hero element

## Hero Element

-   `title` : The hero title is sourced from the page title. The page title is removed from the page content
-   `subtitle` : Pages can set the subtitle by inserting `~~hero-subtitle TEXT~~` in the page content
-   `image` : The hero image is sourced from an image named hero in the current or parental namespace. Namespace searching can be confined by the `includePagePropagate` setting. Pages can also override the image by inserting `~~hero-image URL~~` in the page content. DokuWiki and external URLs are supported. The height of the image area is 240px while the width is 33% of the window width. It is recommended to use an image of at least 480x240 (2:1)
-   `colors` : Colors can be overridden by including `~~hero-colors BACKGROUND_COLOR HERO_TITLE_COLOR HERO_SUBTITLE_COLOR BREADCRUMB_TEXT_COLOR BREADCRUMB_HOVER_COLOR~~`. You do not need to include all the color options. Use 'initial' to skip a color override

Namespaces can also apply the above hero settings in child pages by including the above settings in a page named `theme`.

## Hiding Elements

Mikio now supports hiding elements using the `~~hide-parts (parts)~~` macro. Each element within the hide-parts macro is required to be seperated by spaces. Currently, the following parts are supported:

-   `topheader` : content above the navbar
-   `navbar` : the main navigation bar
-   `header` : content below the navbar but above the page content
-   `hero` : the page hero bar
-   `contentheader` : content above the page content
-   `contentfooter` : content below the page content
-   `sidebarheader` : content above the left sidebar content
-   `sidebarfooter` : content below the left sidebar content
-   `rightsidebarheader` : content above the right sidebar content
-   `rightsidebarfooter` : content below the right sidebar content
-   `footer` : content in the footer
-   `bottomfooter` : content below the footer

To hide the topheader, navbar and hero, you would use the macro `~~hide-parts topheader navbar hero~~`

## Icon Engine

-   Mikio includes an icon engine that allows you to include icons in your pages by using <icon OPTIONS> in your content
-   If the icon tag conflicts with another plugin, you can change the tag from `icon` to a user set value in the settings
-   By default, Mikio enables FontAwesome 4 by also includes FontAwesome 5, Elusive 2 and Bootstrap Icons which can be enabled by uncommenting their inclusions in `/icons/icons.php`

Users can also add their own icon sets into the template. Supported icon sets can either be webfonts or indivial files (such as an SVG library). Instructions can be found in the `/icons/icons.php` file.

## Customizing Page Footer Info Text

By default, Dokuwiki inserts the text `start.txt · Last modified: 2023/12/04 10:57...` on each page. This can now be customized in the config.

You can use the follow placeholders to insert page attributes:

-   `{file}` - The file name of the page
-   `{date}` - The last modification date of the page
-   `{user}` - The user whom last edited the page
-   `{locked}` - The user who has the page currently locked

You can also use Dokuwiki language settings by wrapping the string ID with the percentage symbol. For example use to the language string set against `lastmod`, use `%lastmod%`. In a default install under english, `%lastmod%` will be replaced with `Last modified:`.

There is also support for simple optional text. By wrapping text in square brackets and at the beginning of the square bracket, inserting the placeholder name followed by an equals sign, if the placeholder exists, then the contents of the square brackets will be parsed. There is also support for `LOGGEDIN` to check if there is a logged-in user.

For example the string `Hello[LOGGEDIN= by {user}]` would output as `Hello` if the vistor is a guest (not logged in) or `Hello by james` if the visitor has logged into the site.

Optionals can also be stacked, for example `Hello[LOGGEDIN=[USER= by {user}]]`. the `by {user}` would only be present if there is a logged-in user AND the page has a user editor set.

Of course, you can leave the setting blank to hide the page info altogether.

The default value which is the same standard DokuWiki is: `{file} · %lastmod% {date}[LOGGEDIN=[USER= %by% {user}][LOCKED= · %lockedby% {locked}]]`

## Themes

Themes should be placed in the themes directory, in its own directory. LESS files are supported.

## Dark Mode

Mikio now supports dark mode! When the user prefers a dark theme, or has selected dark mode, the html tag will set the theme dataset to `theme-dark`, else it will be `theme-light`.

You can detect this in CSS using:

```
:root[data-theme="theme-dark"] {
  // CSS selectors here
}
```

or in Javascript using:

```
const html = document.querySelector('html');
if(html.dataset.theme == 'theme-dark') {
  // ...
}
```

To set a Dark Mode icon in the navigation bar, upload an image named `logo-dark.png` using the media manager in the root namespace or save the image inside the images directory of the template.

## Mikio Plugin

The [Mikio Plugin](https://github.com/nomadjimbob/mikioplugin/) is also available to add bootstrap 4 style + more elements to DokuWiki pages.

If the plugin is installed, the **Template Styles Settings** page will be expanded to allow directly editing the plugin element styling.

## Languages

-   `sidebar-title` : Text for the collapsable block in the sidebar
-   `tools-menu` : Text for the combined tools DokuWiki menu title
-   `home` : Text for the breadcrumb home title

## Releases

- **_NEXT_**
   -    Fixed media manager description list not being readable in dark mode [#96](https://github.com/nomadjimbob/mikio/issues/96). Thanks macin.
   -    Improved language support in the configuration options [#94](https://github.com/nomadjimbob/mikio/issues/94). Thanks Little-Data.
   -    Added support to default to dark theme in the template options [#95](https://github.com/nomadjimbob/mikio/issues/95). Requested by jeffka11.
   -    Fix dynamic variable creation depreciation warnings in the lessc engine 
   -    Will now detect if `mbstring` is missing from your PHP installation is not use these helper methods [#102](https://github.com/nomadjimbob/mikio/issues/102). Thanks Naomitor.
   -    Fixed overflow bug with large number of trace items on small displays [#104](https://github.com/nomadjimbob/mikio/issues/104). Thanks looowizz.

- **_2025-04-24_**
   -    Fix typo preventing logged_in_user from showing [#105](https://github.com/nomadjimbob/mikio/pull/105). Thanks ChaosKid42.
   -    Added support for the Chinese language [#91](https://github.com/nomadjimbob/mikio/pull/91). Thanks Little-data.
   -    `navbarTitleIconHeight` and `navbarTitleIconWidth` will now override any automatic navbar logo height and width which fixes non-square SVGs [#98](https://github.com/nomadjimbob/mikio/issues/98). Thanks macin.
   -    Added support for Dark Mode logos in the navbar [#98](https://github.com/nomadjimbob/mikio/issues/98). Requested by macin.
   -    Fixed table alignments not being applied [#86](https://github.com/nomadjimbob/mikio/issues/86). Thanks aloade.
   -    Fixed empty menus being shown when all items have been disabled [#88](https://github.com/nomadjimbob/mikio/issues/88). Thanks aloade.
   -    Fixed styling issues in the Media Manager [#85](https://github.com/nomadjimbob/mikio/issues/85). Thanks aloade.
   -    Fixed issue with languages other than english not being supported correctly [#81](https://github.com/nomadjimbob/mikio/issues/81). Requested by Little-Data.
   -    Added support to set the maximum width of the navbar search box [#73](https://github.com/nomadjimbob/mikio/issues/73). Requested by macin.
   -    Added styling support for footnotes [#87](https://github.com/nomadjimbob/mikio/issues/87). Thanks aloade.
   -    Fixed missing configuration data.
   -    Added navbar support for versionswicher plugin [#79](https://github.com/nomadjimbob/mikio/issues/79). Requested by macin.
   -    Fixed input backgrounds not rendering colours correctly in some circumstances on the configuration page.
   -    Fixed styling on input fields in darkmode. Style.ini now supports separate input options [#82](https://github.com/nomadjimbob/mikio/issues/82). Thanks  BioSehnsucht.
   -    Fixed padding on inline code blocks to be smaller.
   -    Cleaned up the display of the versionswitcher syntax. Thanks macin.
   -    Fixed incorrect language entries [#78](https://github.com/nomadjimbob/mikio/issues/78). Thanks Little-Data.
   -    Fixed incorrect padding on code/pre blocks [#77](https://github.com/nomadjimbob/mikio/issues/77). Thanks macin.

- **_2024-06-05_**

   -    Fix tag text colouring not applying correctly.
   -    Allow hiding tags in hero if using `<tags>` element in the MikioPlugin [#70](https://github.com/nomadjimbob/mikio/issues/70). Requested by garanovich.

- **_2024-05-03_**
   -    Fixed incorrect style file names. Thanks, Wolfram.
   -    Table cell padding now adjustable through the style config page. Thanks Hakker.
   -    Added ability to style row border color through the style config page. Thanks Elanndelh.
   -    Added option to make the left sidebar sticky. Requested by Wolfram.

- **_2024-02-09_**
    -   Added support for DokuWiki Kaos
    -   Updated to support PHP 8.2
    -   Added access key support to page elements [#64](https://github.com/nomadjimbob/mikio/issues/64). Thanks rebeka-catalina.

- **_2023-12-12_**

    -   `autoDarkLight` configuration setting will override user setting when `showDarkLight` is disabled [#56](https://github.com/nomadjimbob/mikio/issues/56).
    -   Cookies used in the template now use the upcoming `SameSite` requirement.
    -   Fixed snapshots not being detected and causing script loading issues [#57](https://github.com/nomadjimbob/mikio/issues/57). Thanks schplurtz.
    -   Updated the typescript library to support jQuery compatibility mode [#57](https://github.com/nomadjimbob/mikio/issues/57). Thanks schplurtz.
    -   Fixed bug in config for showNotifications not being a dropdown.
    -   Changed default value of showNotifications to `always` to reflect DokuWiki. [#58](https://github.com/nomadjimbob/mikio/issues/58). Thanks schplurtz.
    -   Fixed z-index bug with the sub navbar. [#60](https://github.com/nomadjimbob/mikio/issues/60). Thanks schplurtz.

-   **_2023-12-11_**

    -   Fixed bug with tags not correctly coloured. [#59](https://github.com/nomadjimbob/mikio/issues/59). Thanks WetenSchaap.

-   **_2023-12-04_**

    -   Added ability to customize the page footer info text.

-   **_2023-10-30_**

    -   Added support for the FastWiki plugin. Requested by kjumybit.
    -   Fixed panels on the Administration page sometimes showing dots as part of the name.

-   **_2023-10-20_**

    -   Fixed LESS engine not being discovered when DokuWiki is hosted in a subdirectory. Thanks, Jan.

-   **_2023-10-16_**

    -   Added color picker selector back to style page. Requested by Jan.

-   **_2023-10-14_**

    -   Fixed bug where external page tools where not showing in the toolbar. Thanks, Jan.

-   **_2023-06-05_**

    -   Fixed bug with `~~hide-parts~~` no longer working. [#52](https://github.com/nomadjimbob/mikio/issues/52). Thanks nathanmcguire.
    -   Mikio Control Macros now support the format `-~SETTING~-` as well as the standard `~~SETTING~~`. This fixes an incompatibility with the [Comment Syntax support](https://www.dokuwiki.org/plugin:commentsyntax) extension.

-   **_2023-05-19_**

    -   Fixed notifications appearing in weird places at times.
    -   Setting `tpl»mikio»showNotifications` to an empty string is the same as setting it to `always`.
    -   Fixed languages not shown in dropdown correctly with the 'translate' plugin when `plugin»translation»dropdown` is turned on.
    -   Fixed some css issues on small screens.

-   **_2023-05-18_**

    -   Added automatic Light/Dark mode option (disabled by default).
    -   Added support for the [translate plugin](https://www.dokuwiki.org/plugin:translation).

-   **_2023-05-13_**

    -   Fixed tables not being styling correctly and incorrect language used in the styling config [#50](https://github.com/nomadjimbob/mikio/issues/50). Thanks RonaldPR.
    -   The themes LessC engine will output any exceptions that occur in the fallback CSS to help track issues.

-   **_2023-05-11_**

    -   Fixed empty scrollbars being shown when TOC is set to full height [#49](https://github.com/nomadjimbob/mikio/issues/49). Thanks vitaprimo and RonaldPR.
    -   Added a `noshadow` subtheme

-   **_2022-10-31_**

    -   Added support to directly editing Mikio Plugin within Template Style Settings.

-   **_2022-10-12_**

    -   Fixed blank page being displayed instead of media detail [#48](https://github.com/nomadjimbob/mikio/issues/48). Thanks spratinatin

-   **_2022-10-09_**

    -   Fixed issue of new elements not being added to CSS when a custom template style is set
    -   Fixed issue of wiki page style (existing and missing) not taking priority of link colouring
    -   Added support for styling link pseudo classes (visited, hover, active) for links and page links [#47](https://github.com/nomadjimbob/mikio/issues/47). Thanks chrbinder

-   **_2022-10-04_**

    -   Cleaned up the code to PHPCS standards
    -   Fixed breadcrumb layouts on mobile [#31](https://github.com/nomadjimbob/mikio/issues/31)
    -   Fixed Media Manager on small displays
    -   Fixed layout compatiblity on Greebo
    -   Fixed search results layout [#41](https://github.com/nomadjimbob/mikio/issues/41)
    -   Added Dark-mode support [#43](https://github.com/nomadjimbob/mikio/issues/43). Thanks chrbinder
    -   Fixed incorrect file names listed [#45](https://github.com/nomadjimbob/mikio/issues/45). Thanks babudro
    -   Fixed sidebars not showing [#46](https://github.com/nomadjimbob/mikio/issues/46). Thanks dasbenjo

-   **_2022-05-10_**

    -   Added support to directly set title icon width and height in config. Thanks AlexiaR

-   **_2022-05-05_**

    -   Fixed searching for images in the theme directory [#42](https://github.com/nomadjimbob/mikio/issues/42). Thanks cmacmackin
    -   Added support for the defer js option, previously always deferred [#39](https://github.com/nomadjimbob/mikio/issues/39). Thanks cmacmackin
    -   Added typeahead search [#40](https://github.com/nomadjimbob/mikio/issues/40). Thanks cmacmackin
    -   Fixed double breadcrumb options on admin pages
    -   Added sticky top header, navbar and header options. Thanks chitland

-   **_2022-03-05_**

    -   Fixed page tools in footer not being horizontal [#38](https://github.com/nomadjimbob/mikio/issues/38). Thanks chitland
    -   Fixed Mikio Config headers disappearing in some cases
    -   Separated Breadcrumbs and You Are Here items [#36](https://github.com/nomadjimbob/mikio/issues/36). Thanks chitland

-   **_2021-12-11_**

    -   Added table row background styling options
    -   Fixed styling issue when using the indexmenu plugin [#35](https://github.com/nomadjimbob/mikio/issues/35). Thanks 3ole.
    -   Fixed inconsitant tab/spaces in mikio.less and mikio.css
    -   Removed debug logs from mikio.js
    -   Fixed input placeholders not hiding in prepopulated fields [#34](https://github.com/nomadjimbob/mikio/issues/34)
    -   Added option to hide menu and page tool items [#32](https://github.com/nomadjimbob/mikio/issues/32). Thanks annievoss.
    -   Fixed compadibility with BookCreator [#26](https://github.com/nomadjimbob/mikio/issues/26). Thanks johncourtland.
    -   Fixed Greebo styling errors not present in Hogsfather

-   **_2021-08-11_**

    -   Fixed path check on Windows [#33](https://github.com/nomadjimbob/mikio/issues/33)
    -   Recompilied CSS

-   **_2021-06-17_**

    -   Added support for navbar title link to use showpageafterlogin setting if installed [#27](https://github.com/nomadjimbob/mikio/issues/27)

-   **_2021-06-09_**

    -   TOC is now full width on mobile [#25](https://github.com/nomadjimbob/mikio/issues/25)
    -   Hamburger and sidebar icons are now displayed correctly [#23](https://github.com/nomadjimbob/mikio/issues/23), [#24](https://github.com/nomadjimbob/mikio/issues/24)
    -   Site width is now available under Template Style Settings [#22](https://github.com/nomadjimbob/mikio/issues/22)
    -   TOC is now sticky when set to full height [#21](https://github.com/nomadjimbob/mikio/issues/21)
    -   Added support to the theme being linked by a symbolic link [#20](https://github.com/nomadjimbob/mikio/issues/20)
    -   Mikio will now fall back to using CSS when there is the LESS engine is not detected [#20](https://github.com/nomadjimbob/mikio/issues/20)

-   **_2021-03-10_**

    -   Fixed bad breadcrumb URL formatting on sites using userewrite [#19](https://github.com/nomadjimbob/mikio/issues/19)

-   **_2021-03-04_**

    -   Added support to hide page elements [#18](https://github.com/nomadjimbob/mikio/issues/18)

-   **_2021-01-22_**

    -   Fixed a syntax error with the core css

-   **_2020-11-12_**

    -   Corrected terminology in readme to match Dokuwiki [#17](https://github.com/nomadjimbob/mikio/issues/17)
    -   Fix showing part of the sidebar when it should be hidden in certain conditions [#16](https://github.com/nomadjimbob/mikio/issues/16)
    -   Added option to always show the sidebar, even when there is no content [#16](https://github.com/nomadjimbob/mikio/issues/16)

-   **_2020-10-07_**

    -   Fixed hero header parsing on some servers
    -   Fixed safari color picker issue [#14](https://github.com/nomadjimbob/mikio/issues/14)
    -   LESS now defaults to enabled with fallback to ctype functions built into mikio for docker apps [#13](https://github.com/nomadjimbob/mikio/issues/13)
    -   Fix for Template Style Settings being ignored [#12](https://github.com/nomadjimbob/mikio/issues/12)

-   **_2020-10-01_**

    -   Fix for `sidebarMobileDefaultCollapse` option being inconsistent in code and not working correctly [#11](https://github.com/nomadjimbob/mikio/issues/11). Thanks to GJRobert for catching that.

-   **_2020-09-27_**

    -   Sidebars hidden by default in mobile view [#10](https://github.com/nomadjimbob/mikio/issues/10)
    -   Fixed errors with the LESS compilier on some nginx configurations
    -   Fixed styling and image display thumb size in media manager popup
    -   Fixed text field placeholders not disappearing with text entry
    -   Added support for Hogfather
    -   Added option to use LESS or direct CSS. Some configurations (docker linuxserver/dokuwiki) do not have the required PHP extensions installed
    -   Supports Docker linuxserver/dokuwiki container file structures

-   **_2020-09-10_**

    -   Floating page tools is now a UL element with classes applied from getType and getLinkAttributes. Fixes popup dialogs initiated from the page menu [#7](https://github.com/nomadjimbob/mikio/issues/7)
    -   Template.info.txt now shows correct release dates [#8](https://github.com/nomadjimbob/mikio/issues/8)
    -   Fixed rightsidebar php warnings
    -   Code/Pre blocks no longer have padding applied on the admin pages

-   **_2020-08-26_**

    -   Footer is no longer shown outside of page view
    -   Public messages are now displayed on the page
    -   Fixed icon rendering in hero bar
    -   Fixed TOC rendering bug

-   **_2020-07-27_**

    -   Added option to show wiki footer in page content

-   **_2020-07-24_**

    -   Fixed image detail bug

-   **_2020-07-20_**

    -   Fixed prewrap and sidebar search bar margins

-   **_2020-07-16_**

    -   Merged code block styling with pre
    -   Fixed mediamanager failures on 2018-04-22a "Greebo" [#5](https://github.com/nomadjimbob/mikio/issues/5)
    -   Icon tag is rendered correctly in preview [#4](https://github.com/nomadjimbob/mikio/issues/4)

-   **_2020-07-15_**

    -   Fixed an issue with the simple_html_dom library when editing a section of a page caused page corruption [#3](https://github.com/nomadjimbob/mikio/issues/3)

-   **_2020-07-14_**

    -   Added id=dokuwiki\_\_content identifier for the page content element
    -   Added styling and fixed overflow issues with pre elements
    -   Fixed page width overflow issues

-   **_2020-07-09_**

    -   Fixed cosmetic display issues when `input[type=file]` is hidden by plugins [#2](https://github.com/nomadjimbob/mikio/issues/2)

-   **_2020-07-07_**
    -   Initial release

## Third Party Libraries

This template uses a [modified
version](https://github.com/nomadjimbob/simple_html_dom) of
[simple_html_dom](https://sourceforge.net/projects/simplehtmldom/) and
[bootstrap-3-typeahead](https://github.com/bassjobsen/Bootstrap-3-Typeahead).

## Support

-   If you think you have found a problem, or would like to see a feature, please [open an issue](https://github.com/nomadjimbob/mikio/issues)
-   If you are a coder, feel free to create a pull request, but please be detailed about your changes!
