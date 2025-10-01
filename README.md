# Mikio — DokuWiki Template

<p align="center">
  <img src="https://raw.githubusercontent.com/nomadjimbob/mikio/main/images/screenshot.png" alt="Mikio screenshot" width="880">
</p>

**Mikio** is a modern [DokuWiki](https://www.dokuwiki.org/) template with a clean, Bootstrap-style design, flexible navigation, and full dark-mode support.  
It’s built to make your wiki look like a polished website while staying lightweight, responsive, and configurable.

---

## ✨ Features

- **Modern Bootstrap styling** with dark mode
- **Configurable navbar** with dropdowns, sub-menus, custom slots
- **Hero element** with title, subtitle, images, and colour overrides
- **Flexible sidebars** (left/right, sticky, mobile collapse)
- **Typeahead search** with optional suggestions
- **Breadcrumbs & You Are Here** (separate, configurable)
- **Tags integration** in hero or sidebar
- **Floating page tools** and full-height TOC
- **Icon engine** (FontAwesome 4/5, Bootstrap Icons, Elusive 2, or custom sets)
- **Customisable page footer info text**
- **Compatibility with popular plugins** (Translate, FastWiki, BookCreator, Tag, Approve, DO, VersionSwitcher, etc.)
- **Dark-mode logo support** for seamless theming

---

## 🚀 Quick Start

1. Use the **Theme Manager** in DokuWiki to search for **mikio** and install the current release.  

> (Alternative) Copy the `mikio` folder from [GitHub](https://github.com/nomadjimbob/mikio) into `lib/tpl/mikio` to try the latest (may be less stable).

2. In **Admin → Configuration Manager → Template**, select **mikio**.

3. (Optional) Adjust colours, width, and dark-mode preferences under **Template Style Settings**.

> 💡 Want Bootstrap-style components inside your wiki pages?  
> Install the [Mikio Plugin](https://github.com/nomadjimbob/mikioplugin).

---

## 📖 Documentation

The README is just the start - full docs, guides, and configuration reference live in the wiki:

👉 [Mikio Wiki](https://github.com/nomadjimbob/mikio/wiki)

- [Configuration Guide](https://github.com/nomadjimbob/mikio/wiki/Configuration)
- [Hero](https://github.com/nomadjimbob/mikio/wiki/Hero)
- [Macros](https://github.com/nomadjimbob/mikio/wiki/Macros)
- [Navbar](https://github.com/nomadjimbob/mikio/wiki/Configuration#navbar)
- [Sidebars](https://github.com/nomadjimbob/mikio/wiki/Configuration#sidebars)
- [Icon Engine](https://github.com/nomadjimbob/mikio/wiki/Icon-Engine)
- [Custom Footer Text](https://github.com/nomadjimbob/mikio/wiki/Configuration#custom-page-footer-info-text)
- [Breaking Changes](https://github.com/nomadjimbob/mikio/wiki#breaking-changes)
- [Releases](https://github.com/nomadjimbob/mikio/releases)

---

## 🛠️ Compatibility

- Works with recent DokuWiki releases (incl. *Librarian*).
- Fully tested with PHP 8.2.
- Designed to play nicely with popular plugins:
  - Translate 
  - FastWiki 
  - BookCreator
  - Tag 
  - Approve 
  - DO 
  - VersionSwitcher

**Comment Syntax support** converts custom control macros such as the Mikio macro `~~hero-image ...~~` into comments. If you plan to use this extension on your site, you will need to use the alternative macro format of `-~hero-image ...~-` for Mikio to detect the information.

---

## 🤝 Contributing

- **Found a bug or want a feature?** [Open an issue](https://github.com/nomadjimbob/mikio/issues).
- **Want to contribute code?** Submit a pull request — please include a clear description and screenshots if UI is affected.
- **Translations welcome!** Language files are simple to add, see existing ones in `/lang`.

---

## 📦 Releases

You’ll always find the most recent changes in [Releases](https://github.com/nomadjimbob/mikio/releases).  
The `main` branch may include features still under test.

---

## 📄 Third Party Libraries

This template uses a [[https://github.com/nomadjimbob/simple_html_dom|modified version]] of [[https://sourceforge.net/projects/simplehtmldom/|simple_html_dom]]

## 📄 License

Released under the GPLv2.  
See [LICENSE](./LICENSE) for details.

---

### ⭐ Like Mikio?
If this template makes your wiki better, consider starring the repo — it helps others discover it!