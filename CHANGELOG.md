- **_2025-10-01_**
    -   Fixed bug where icon engine would conflict with the mikioplugin [#42](https://github.com/nomadjimbob/mikioplugin/issues/42). Thanks nhratos.
    -   Fixed showing duplicates in "You Are Here" block for a category start page [#117](https://github.com/nomadjimbob/mikio/pull/117). Thanks box789.
    -   Fixed incorrect parsing of the search template [#114](https://github.com/nomadjimbob/mikio/issues/114). Thanks reissmann.
    -   Fixed parsing issue with special HTML characters with the hero and window title [#113](https://github.com/nomadjimbob/mikio/issues/113). Thanks nicola-myo and fiwswe.
    -   Fixed display error when updating ACLs in the admin panel [#103](https://github.com/nomadjimbob/mikio/issues/103). Thanks VNRARA.
    -   Fixed tables not visible in the ProseMirror editor [#115](https://github.com/nomadjimbob/mikio/issues/115). Thanks dutran123.
    -   Added support for the <TOC> tag in the sidebar to override the normal TOC location [#106](https://github.com/nomadjimbob/mikio/issues/106). Requested by tgrosinger.
    -   Fixed responsive TOC issue when set to full height on mobile [#100](https://github.com/nomadjimbob/mikio/issues/100). Reported by ZhongXiYi.
    -   Added support for the DO plugin [#76](https://github.com/nomadjimbob/mikio/issues/76). Requested by macin.
    -   Fixed positioning issue with the Tag and Approve plugins [#101](https://github.com/nomadjimbob/mikio/issues/101). Thanks macin.

- **_2025-09-24_**
    -    Fixed security vulnerability, parsing less error discloses the physical path. Reported by B Mercer.
    -    Fixed page tools visibility [#110](https://github.com/nomadjimbob/mikio/pull/110), [#112](https://github.com/nomadjimbob/mikio/pull/112). Thanks a2belugin, box789.
    -    Added Russian translation [#111](https://github.com/nomadjimbob/mikio/pull/111). Thanks box789.
    -    Added ability to translate Back and View Page strings in the breadcrumb [#109](https://github.com/nomadjimbob/mikio/pull/109). Thanks box789.
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