/**
 * DokuWiki Mikio Template Javascript
 *
 * @link    http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */
"use strict";

const mikio = {
    queueResize: false,
    mikioCSS: false,
    stickyItems: [],
    stickyOffset: 0,
    stickyIndex: 2010,
    darkMode: '',

    ready: function () {
        const updateStickyScroll = function () {
            self.stickyItems.forEach((item) => {
                // noinspection JSDeprecatedSymbols
                if ((window.scrollY || window.pageYOffset) > item.offsetYTop) {
                    if (item.element.style.position !== 'fixed') {
                        let site = document.getElementById('dokuwiki__site');
                        site.style.paddingTop = ((parseInt(site.style.paddingTop) || 0) + item.element.offsetHeight) + 'px';

                        item.element.style.position = 'fixed';
                        item.element.style.top = self.stickyOffset + 'px';
                        item.element.style.zIndex = self.stickyIndex;

                        self.stickyOffset += item.element.offsetHeight;
                        self.stickyIndex--;
                    }
                } else {
                    if (item.element.style.position === 'fixed') {
                        let site = document.getElementById('dokuwiki__site');
                        site.style.paddingTop = ((parseInt(site.style.paddingTop) || 0) - item.element.offsetHeight) + 'px';
                        self.stickyOffset -= item.element.offsetHeight;
                        self.stickyIndex++;

                        item.element.style.position = 'relative';
                        item.element.style.top = null;
                        item.element.style.zIndex = null;
                    }
                }
            });
        };
        const self = this;

        this.initDarkMode();
        this.addToggleClick('mikio-sidebar-toggle', 'mikio-sidebar-collapse');
        this.addToggleClick('mikio-navbar-toggle', 'mikio-navbar-collapse');
        this.addDropdownClick('mikio-nav-dropdown', 'mikio-dropdown');
        this.indexmenuPatch();
        this.typeahead();

        this.doPluginPatch();

        const updateStickyItems = function () {
            window.removeEventListener('scroll', updateStickyScroll);

            const stickyElements = document.getElementsByClassName('mikio-sticky');
            self.stickyItems = [];
            if (stickyElements && stickyElements.length > 0) {
                const stickyOffset = stickyElements[0].offsetTop;
                let stickyHeightCount = stickyOffset;

                [].forEach.call(stickyElements, (item) => {
                    let top = stickyOffset;
                    if (item.offsetTop - stickyHeightCount > stickyHeightCount) {
                        top = stickyHeightCount;
                    }

                    self.stickyItems.push({
                        element: item,
                        offsetYTop: top,
                        debugItemTop: item.offsetTop,
                        debugOffset: stickyOffset,
                        debugHeight: stickyHeightCount
                    });
                    stickyHeightCount += item.offsetHeight;
                });

                window.addEventListener('scroll', updateStickyScroll);
                updateStickyScroll();
            }
        };


        updateStickyItems();

        window.onresize = function () {
            if (!this.queueResize) {
                this.queueResize = true;
                const self = this;
                window.setTimeout(function () {
                    self.queueResize = false;
                    Array.from(document.getElementsByClassName('mikio-dropdown')).forEach(function (elem) {
                        if (!elem.classList.contains('closed')) {
                            elem.classList.add('closed');
                        }
                    });

                    updateStickyItems();
                }, 100);
            }
        };

        // Mikio-Dropdown - Click
        Array.from(document.getElementsByClassName('mikio-dropdown')).forEach(function (elem) {
            elem.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });

        // Mikio-Dropdown - Close when clicked outside dropdown
        Array.from(document.getElementsByTagName('body')).forEach(function (elem) {
            elem.addEventListener('click', function () {
                Array.from(document.getElementsByClassName('mikio-dropdown')).forEach(function (elem) {
                    if (!elem.classList.contains('closed')) {
                        elem.classList.add('closed');
                    }
                });
            });
        });

        // Mikio-Navbar-Toggle - Fix
        Array.from(document.getElementsByClassName('mikio-navbar-toggle')).forEach(function (elem) {
            elem.classList.add('closed');
        });

        // Mikio-Dropdown - Fix
        Array.from(document.getElementsByClassName('mikio-dropdown')).forEach(function (elem) {
            elem.classList.add('closed');
        });

        // Input File - Cleanup
        Array.from(document.querySelectorAll('input[type=file]')).forEach(function (elem) {
            const style = window.getComputedStyle(elem);

            if (style.display !== 'none') {
                const parentElem = elem.parentElement;
                const fileRect = elem.getBoundingClientRect();
                const parentRect = parentElem.getBoundingClientRect();
                const spanElem = document.createElement('span');

                elem.style.opacity = '0';
                parentElem.style.position = 'relative';
                spanElem.innerHTML = 'Choose file...';
                spanElem.classList.add('mikio-input-file');
                spanElem.style.left = Math.floor(fileRect.left - parentRect.left) + 'px';
                spanElem.style.width = Math.floor(fileRect.right - fileRect.left) + 'px';
                mikio.insertAfter(spanElem, elem);

                spanElem.addEventListener('click', function (event) {
                    if (event.target.parentElement.tagName.toLowerCase() !== 'label') {
                        let sibling = mikio.getPrevSibling(event.target, 'input');
                        if (typeof sibling !== 'undefined') {
                            sibling.click();
                        }
                    }
                });

                elem.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        let mikioInput = mikio.getNextSibling(this, '.mikio-input-file');
                        if (typeof mikioInput !== 'undefined') {
                            mikioInput.innerHTML = this.files[0].name;
                        }
                    }
                });
            }
        });

        // Input - Span (Placeholder) clear when typing
        Array.from(document.querySelectorAll('.mikio.dokuwiki .mode_login fieldset label.block input.edit, .mikio.dokuwiki .mode_denied fieldset label.block input.edit')).forEach(function (elem) {
            if (elem.value.length !== 0) {
                const sibling = mikio.getPrevSibling(elem, 'span');
                if (sibling) {
                    sibling.style.display = 'none';
                }
            }

            elem.addEventListener('keydown', function (event) {
                const sibling = mikio.getPrevSibling(event.target, 'span');

                setTimeout(function () {
                    if (sibling) {
                        if (event.target.value !== '') {
                            sibling.style.display = 'none';
                        } else {
                            sibling.style.display = 'block';
                        }
                    }
                }, 50);
            });
        });

        // Admin - Exit button
        Array.from(document.querySelectorAll('a[rel="exit-admin"]')).forEach(function (elem) {
            elem.addEventListener('click', function (event) {
                event.preventDefault();

                let href = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

                let params = window.location.search;
                if (params !== '') {
                    params = params.substring(1).split('&');
                    if (params.length > 1) {
                        href += '?';
                        params.forEach(function (p) {
                            if (p.substring(0, 3) === 'id=') {
                                href += p;
                            }
                        });
                    }
                }

                window.location = href;
            });
        });

        // Admin - Back button
        Array.from(document.querySelectorAll('a[rel="exit-page"]')).forEach(function (elem) {
            elem.addEventListener('click', function (event) {
                event.preventDefault();

                let href = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

                let params = window.location.search;
                if (params !== '') {
                    params = params.substring(1).split('&');
                    if (params.length > 1) {
                        href += '?';
                        params.forEach(function (p) {
                            if (p.substring(0, 5) !== 'page=') {
                                href += p + '&';
                            }
                        });
                    }
                }

                window.location = href;
            });
        });

        // Admin - Resize large text blocks in tasks
        Array.from(document.querySelectorAll('.admin_tasks span.prompt')).forEach(function (elem) {
            if (elem.offsetHeight > 48) {
                elem.style.fontSize = '80%';
            }
        });

        let target = document.getElementById('mediamanager__page');
        if (target) {
            // Media Manager - ui-resizable is always auto
            const mediaChangedObserver = new MutationObserver(function (mutationsList) {
                for (let mutation of mutationsList) {
                    if (mutation.type === 'childList') {
                        if (mutation.addedNodes) {
                            mutation.addedNodes.forEach(function (node) {
                                if (node.nodeName === 'LI') {

                                }
                            });
                        }
                    }

                    if (mutation.type === 'attributes' && mutation.attributeName === 'style' && mutation.target && mutation.target.style.height) {
                        mutation.target.style.height = '';
                    }
                }
            });

            mediaChangedObserver.observe(target, {attributes: true, childList: true, subtree: true});
        }

        // Media Manager - file click
        Array.from(document.querySelectorAll('#mediamanager__page .filelist')).forEach(function (elem) {
            elem.addEventListener('click', function (event) {
                const liElem = event.target.closest('li');
                if (liElem && event.target.closest('ul.thumbs')) {
                    const aElem = liElem.querySelector('dd.name a');
                    if (aElem) aElem.click();
                }
            });
        });

        // Popup Media Manager - clean file info
        const mediaPopupFileInfoClean = function (elem) {
            // var file = { resolution: '', date: '', time: '', size: '' };

            const infoElem = elem.querySelector('span.info');
            if (infoElem) {
                const infoText = infoElem.innerText.replace(/(<[^>]*>|[()])/g, '');
                const detail = infoText.split(' ');
                while (detail.length < 4) {
                    detail.unshift('');
                }

                infoElem.innerHTML = detail[0] + '<br>' + detail[1] + ' ' + detail[2] + '<br>' + detail[3];
            }

            Array.from(elem.querySelectorAll('img')).forEach(function (elem) {
                elem.removeAttribute('width');
                elem.removeAttribute('height');
            });
        }

        target = document.getElementById('media__content');
        if (target) {
            Array.from(target.querySelectorAll('div.odd, div.even')).forEach(function (elem) {
                mediaPopupFileInfoClean(elem);
            });

            const mediaPopupObserver = new MutationObserver(function (mutationsList) {
                for (let mutation of mutationsList) {
                    if (mutation.type === 'childList') {
                        if (mutation.addedNodes) {
                            mutation.addedNodes.forEach(function (node) {
                                if (node.nodeName === 'DIV') {
                                    mediaPopupFileInfoClean(node);
                                }
                            });
                        }
                    }
                }
            });

            mediaPopupObserver.observe(target, {attributes: false, childList: true});
        }

        // noinspection JSUnresolvedReference
        if (window.mikioFooterRun && typeof window.mikioFooterRun === "function") window.mikioFooterRun();

        const linkElements = document.getElementsByTagName('link');
        for (let element of linkElements) {
            if (element.rel === 'stylesheet' && element.href) {
                if (element.href.includes('/lib/exe/css.php')) {
                    const mediaChangedObserver = new MutationObserver(function (mutationsList) {
                        for (let mutation of mutationsList) {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'href') {
                                if (self.mikioCSS !== false) {
                                    let elem = self.mikioCSS;
                                    let prev = elem.href;

                                    setTimeout(function () {
                                        const url = new URL(prev);
                                        const params = url.searchParams;
                                        params.set('seed', new Date().getTime().toString());
                                        url.search = params.toString();
                                        elem.href = url.toString();
                                    }, 500);
                                }
                            }
                        }
                    });

                    mediaChangedObserver.observe(element, {attributes: true, childList: true, subtree: true});
                } else if (element.href.includes('/lib/tpl/mikio/css.php')) {
                    this.mikioCSS = element;
                }
            }
        }

        // Update color text field when selector changes
        let colorSelectorInputs = document.querySelectorAll('div.mikio-color-picker input[type="color"]');
        colorSelectorInputs.forEach(input => {
            input.addEventListener('input', () => {
                let colorTextInput = document.querySelector(`div.mikio-color-picker input[for="${input.id}"]`);
                if (colorTextInput) {
                    colorTextInput.value = input.value;
                }
            });
        });

        let colorTextInputs = document.querySelectorAll('div.mikio-color-picker input[type="text"]');
        colorTextInputs.forEach(input => {
            input.addEventListener('blur', () => {
                const id = input.getAttribute('for');
                let colorSelectorInput = document.querySelector(`div.mikio-color-picker input[id="${id}"]`);
                if (colorSelectorInput) {
                    colorSelectorInput.value = this.colorToHex(input.value);
                }
            });
        });
    },

    initDarkMode: function () {
        const showLightDark = document.querySelector('.mikio-darklight-button') != null;
        if (showLightDark === true) {
            let setting = this.getCookie('lightDarkToggle');
            if (setting === 'dark' || setting === 'light' || setting === 'auto') {
                this.darkMode = setting;
            }

            if (document.querySelector('.mikio-auto-darklight') == null && setting === 'auto') {
                this.darkMode = 'light';
            }
        } else {
            if (document.querySelector('.mikio-auto-darklight') != null) {
                this.darkMode = 'auto';
            }
        }

        const self = this;

        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                self.updateDarkMode();
            });
        }

        this.addEventListenerByClassName('mikio-darklight-button', 'click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const autoAllowed = (document.querySelector('.mikio-iicon.mikio-darklight-auto') != null);

            if (self.darkMode === 'light') {
                self.darkMode = 'dark';
            } else if (self.darkMode === 'dark') {
                if (autoAllowed === true) {
                    self.darkMode = 'auto';
                } else {
                    self.darkMode = 'light';
                }
            } else if (self.darkMode === 'auto') {
                self.darkMode = 'light';
            } else {
                self.darkMode = 'dark';
            }

            self.updateDarkMode();
        });

        this.updateDarkMode();
    },

    updateDarkMode: function () {
        const html = document.querySelector('html');
        let themeMode = this.darkMode;

        if (this.darkMode === 'auto') {
            html.dataset.themeAuto = 'true';

            themeMode = 'light';
            if (window.matchMedia) {
                let prefersColorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');
                themeMode = prefersColorSchemeQuery.matches ? 'dark' : 'light';
            }
        } else {
            delete html.dataset.themeAuto;
        }

        console.log(this.darkMode);

        if(themeMode === '') {
            if(document.querySelector('body').classList.contains('mikio-default-dark')) {
                themeMode = 'dark';
            } else {
                themeMode = 'light';
            }
        }

        html.dataset.theme = `theme-${themeMode}`;
        this.setCookie('lightDarkToggle', this.darkMode);
    },

    insertAfter: function (newNode, existingNode) {
        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
    },

    addToggleClick: function (elemToggle, elemCollapse) {
        this.addEventListenerByClassName(elemToggle, 'click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            let nextSibling = mikio.getNextSibling(this, '.' + elemCollapse);

            if (typeof nextSibling !== 'undefined') {
                mikio.toggleCollapse(this, nextSibling);
            }
        });
    },

    addDropdownClick: function (elemToggle, elemCollapse) {
        this.addEventListenerByClassName(elemToggle, 'click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const dropdown = this.querySelector('.' + elemCollapse);
            if (dropdown) {
                mikio.toggleDropdown(dropdown);
            }
        });
    },

    addEventListenerByClassName: function (className, eventType, callback) {
        Array.from(document.getElementsByClassName(className)).forEach(function (elem) {
            elem.addEventListener(eventType, callback);
        });
    },

    getNextSibling: function (elem, selector) {
        let sibling = elem.nextElementSibling;

        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.nextElementSibling;
        }
    },

    getPrevSibling: function (elem, selector) {
        let sibling = elem.previousElementSibling;

        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.previousElementSibling;
        }
    },

    toggleCollapse: function (objToggle, objCollapse) {
        if (objToggle.classList.contains('closed')) {
            objToggle.classList.remove('closed');
            objToggle.classList.add('open');
            const height = objCollapse.offsetHeight;
            objCollapse.style.overflow = 'hidden';
            objCollapse.style.height = '0';
            objCollapse.style.paddingTop = '0';
            objCollapse.style.paddingBottom = '0';
            objCollapse.style.marginTop = '0';
            objCollapse.style.marginBottom = '0';
            objCollapse.offsetHeight;
            objCollapse.style.boxSizing = 'border-box';
            objCollapse.style.transitionProperty = "height, margin, padding";
            objCollapse.style.transitionDuration = '500ms';
            objCollapse.style.height = height + 'px';
            objCollapse.style.removeProperty('padding-top');
            objCollapse.style.removeProperty('padding-bottom');
            objCollapse.style.removeProperty('margin-top');
            objCollapse.style.removeProperty('margin-bottom');
            window.setTimeout(function () {
                objCollapse.style.removeProperty('height');
                objCollapse.style.removeProperty('overflow');
                objCollapse.style.removeProperty('transition-duration');
                objCollapse.style.removeProperty('transition-property');
                objCollapse.style.removeProperty('box-sizing');
            }, 500);
        } else {
            objCollapse.style.transitionProperty = 'height, margin, padding';
            objCollapse.style.transitionDuration = '500ms';
            objCollapse.style.boxSizing = 'border-box';
            objCollapse.style.height = objCollapse.offsetHeight + 'px';
            objCollapse.offsetHeight;
            objCollapse.style.overflow = 'hidden';
            objCollapse.style.height = '0';
            objCollapse.style.paddingTop = '0';
            objCollapse.style.paddingBottom = '0';
            objCollapse.style.marginTop = '0';
            objCollapse.style.marginBottom = '0';
            window.setTimeout(function () {
                objToggle.classList.add('closed');
                objToggle.classList.remove('open');
                objCollapse.style.removeProperty('height');
                objCollapse.style.removeProperty('padding-top');
                objCollapse.style.removeProperty('padding-bottom');
                objCollapse.style.removeProperty('margin-top');
                objCollapse.style.removeProperty('margin-bottom');
                objCollapse.style.removeProperty('overflow');
                objCollapse.style.removeProperty('transition-duration');
                objCollapse.style.removeProperty('transition-property');
                objCollapse.style.removeProperty('box-sizing');
            }, 500);
        }
    },


    toggleDropdown: function (objToggle) {
        if (objToggle.classList.contains('closed')) {
            objToggle.classList.remove('closed');
        } else {
            objToggle.classList.add('closed');
        }

        Array.from(document.getElementsByClassName('mikio-dropdown')).forEach(function (elem) {
            if (!elem.classList.contains('closed') && elem !== objToggle) {
                elem.classList.add('closed');
            }
        });
    },

    setHeroSubTitle: function (str) {
        Array.from(document.getElementsByClassName('mikio-hero-subtitle')).forEach(function (elem) {
            elem.innerHTML = str;
        });
    },

    setHeroImage: function (str) {
        const heroImages = document.getElementsByClassName('mikio-hero-image');

        if (heroImages.length > 0) {
            Array.from(document.getElementsByClassName('mikio-hero-image')).forEach(function (elem) {
                elem.style.backgroundImage = 'url(\'' + str + '\')';
                elem.classList.add('mikio-hero-image-resize');
            });
        } else {
            Array.from(document.getElementsByClassName('mikio-hero-text')).forEach(function (elem) {
                elem.insertAdjacentHTML('afterend', '<div class="mikio-hero-image mikio-hero-image-resize" style="background-image:url(\'' + str + '\');"></div>');
            });
        }
    },

    setHeroColor: function (str) {
        const colors = str.trim().replace(/ +(?= )/g, '').split(/(?!\(.*)\s(?![^(]*?\))/g);
        if (colors.length > 0 && colors[0] !== '') {
            Array.from(document.getElementsByClassName('mikio-hero')).forEach(function (elem) {
                elem.style.backgroundColor = colors[0];
            });

            if (colors.length > 1) {
                Array.from(document.getElementsByClassName('mikio-hero-title')).forEach(function (elem) {
                    elem.style.color = colors[1];
                });
            }

            if (colors.length > 2) {
                Array.from(document.getElementsByClassName('mikio-hero-subtitle')).forEach(function (elem) {
                    elem.style.color = colors[2];
                });
            }

            if (colors.length > 3) {
                Array.from(document.getElementsByClassName('mikio-hero')).forEach(function (parentElem) {
                    Array.from(parentElem.querySelectorAll('.mikio-breadcrumbs ul li a')).forEach(function (elem) {
                        elem.style.color = colors[3];
                    });

                    Array.from(parentElem.querySelectorAll('.mikio-breadcrumbs ul li, .mikio-breadcrumbs ul li a')).forEach(function (elem) {
                        elem.style.color = colors[3];
                        elem.onmouseover = function () { this.style.color = (colors.length > 4 ? colors[4] : 'initial'); };
                        elem.onmouseout = function () { this.style.color = colors[3]; };
                    });
                });
            }
        }
    },

    setTags: function (str) {
        Array.from(document.getElementsByClassName('mikio-tags')).forEach(function (elem) {
            elem.innerHTML = str;
        });
    },

    hidePart: function (part) {
        const selectorArray = {
            topheader: '.mikio-page-topheader',
            header: '.mikio-page-header',
            contentheader: '.mikio-page-contentheader',
            contentfooter: '.mikio-page-contentfooter',
            sidebarheader: '.mikio-sidebar-left .mikio-sidebar-header',
            sidebarfooter: '.mikio-sidebar-left .mikio-sidebar-footer',
            rightsidebarheader: '.mikio-sidebar-right .mikio-sidebar-header',
            rightsidebarfooter: '.mikio-sidebar-right .mikio-sidebar-footer',
            footer: '.mikio-footer',
            bottomfooter: '.mikio-page-bottomfooter',
            navbar: '.mikio-navbar',
            hero: '.mikio-hero'
        };

        if (selectorArray.hasOwnProperty(part)) {
            Array.from(document.querySelectorAll(selectorArray[part])).forEach(function (elem) {
                elem.style.display = 'none';
            });
        }
    },

    indexmenuPatch: function () {
        window.setTimeout(function () {
            Array.from(document.querySelectorAll('a.navSel')).forEach(function (elem) {
                let prev = mikio.getPrevSibling(elem, 'img');
                if (prev) {
                    prev.style.opacity = '1';
                }
            });
        }, 50);


        document.addEventListener('mouseover', function (event) {
            const indexmenuClasses = ['nodeUrl', 'nodeSel', 'node'];
            if ([...event.target.classList].some(className => indexmenuClasses.indexOf(className) !== -1)) {
                let prev = mikio.getPrevSibling(event.target, 'img');
                if (prev) {
                    prev.style.opacity = '1';
                }
            }
        });

        document.addEventListener('mouseout', function (event) {
            const indexmenuClasses = ['nodeUrl', 'nodeSel', 'node'];
            if ([...event.target.classList].some(className => indexmenuClasses.indexOf(className) !== -1)) {
                let prev = mikio.getPrevSibling(event.target, 'img');
                if (prev) {
                    prev.style.opacity = '';
                }
            }
        });
    },

    // Add typeahead support for quick seach. Taken from bootstrap3 theme.
    typeahead: function () {
        jQuery(".search_typeahead").typeahead({

            source: function (query, process) {

                return jQuery.post(DOKU_BASE + 'lib/exe/ajax.php',
                    {
                        call: 'qsearch',
                        q: encodeURI(query)
                    },
                    function (data) {

                        const results = [];

                        jQuery(data).find('a').each(function () {

                            const page = jQuery(this);

                            results.push({
                                name: page.text(),
                                href: page.attr('href'),
                                title: page.attr('title'),
                                category: page.attr('title').replace(/:/g, ' : '),
                            });

                        });

                        return process(results);

                    });
            },

            itemLink: function (item) {
                return item.href;
            },

            itemTitle: function (item) {
                return item.title;
            },

            followLinkOnSelect: true,
            autoSelect: false,
            items: 10,
            fitToElement: true,
            delay: 500,
            theme: 'bootstrap4',

        });
    },

    getCookie: function (cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    },

    setCookie: function (cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Lax";
    },

    clearCookie: function (cname) {
        document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax";
    },

    colorToHex: function (color) {
        // Create a canvas element
        let canvas = document.createElement('canvas');
        canvas.height = 1;
        canvas.width = 1;
        let ctx = canvas.getContext('2d');

        // Set the fillStyle to the color input
        ctx.fillStyle = color;
        ctx.fillRect(0, 0, 1, 1);

        // Get the pixel data from the canvas
        let data = ctx.getImageData(0, 0, 1, 1).data;

        // Convert the RGB values to HEX
        return '#' + ((1 << 24) + (data[0] << 16) + (data[1] << 8) + data[2]).toString(16).slice(1).toUpperCase();
    },

    doPluginPatch: function() {
        if(document.getElementsByClassName('plugin__do_usertasks').length === 0) return;

        this.addEventListenerByClassName('mikio-nav-dropdown', 'click', function(event) {
            if (jQuery('.plugin__do_usertasks_list').length) {
                jQuery('.plugin__do_usertasks_list').hide();
            }
        });

        this.addEventListenerByClassName('plugin__do_usertasks', 'click', function(event) {
            Array.from(document.getElementsByClassName('mikio-dropdown')).forEach(function (elem) {
                if (!elem.classList.contains('closed')) {
                    elem.classList.add('closed');
                }
            });
        });
    }
};

if (document.readyState !== 'loading') {
    mikio.ready();
} else {
    document.addEventListener('DOMContentLoaded', function () { mikio.ready() });
}
