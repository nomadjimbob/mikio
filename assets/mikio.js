/*!
 * 
 *
 * Home     
 * Author   
 * License  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */
"use strict";

var mikio = {
    ready: function() {
        this.addToggleClick('mikio-sidebar-toggle', 'mikio-sidebar-collapse');
        this.addToggleClick('mikio-navbar-toggle', 'mikio-navbar-collapse');

        Array.from(document.getElementsByClassName('mikio-navbar-toggle')).forEach(function(elem) {
            elem.classList.add('closed');
        });

        Array.from(document.querySelectorAll('input[type=file]')).forEach(function(elem) {
            var parentElem = elem.parentElement;
            var fileRect = elem.getBoundingClientRect();
            var parentRect = parentElem.getBoundingClientRect();
            var spanElem = document.createElement('span');

            elem.style.opacity = 0;
            parentElem.style.position = 'relative';
            spanElem.innerHTML = 'Choose file...';
            spanElem.classList.add('mikio-input-file');
            spanElem.style.left = Math.floor(fileRect.left - parentRect.left) + 'px';
            spanElem.style.width = Math.floor(fileRect.right - fileRect.left) + 'px';
            mikio.insertAfter(spanElem, elem);
            
            spanElem.addEventListener('click', function(event) {
                if(event.target.parentElement.tagName.toLowerCase() != 'label') {
                    let sibling = mikio.getPrevSibling(event.target, 'input');
                    if(typeof sibling !== 'undefined') {
                        sibling.click();
                    }
                }
            });

            elem.addEventListener('change', function() {
                if(this.files.length > 0) {
                    let mikioInput = mikio.getNextSibling(this, '.mikio-input-file');
                    if(typeof mikioInput !== 'undefined') {
                        mikioInput.innerHTML = this.files[0].name;
                    }
                }
            });
        });
    },

    insertAfter: function(newNode, existingNode) {
        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
    },

    addToggleClick: function(elemToggle, elemCollapse) {
        this.addEventListenerByClassName(elemToggle, 'click', function(event) {
            event.preventDefault();
            let nextSibling = mikio.getNextSibling(this, '.' + elemCollapse);

            if(typeof nextSibling !== 'undefined') {
                mikio.toggleCollapse(this, nextSibling);
            }
        });
    },
    
    addEventListenerByClassName: function(className, eventType, callback) {
        Array.from(document.getElementsByClassName(className)).forEach(function(elem) {
            elem.addEventListener(eventType, callback);
        });
    },

    getNextSibling: function(elem, selector) {
        var sibling = elem.nextElementSibling;
    
        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.nextElementSibling;
        }    
    },

    getPrevSibling: function(elem, selector) {
        var sibling = elem.previousElementSibling;
    
        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.previousElementSibling;
        }    
    },

    toggleCollapse: function(objToggle, objCollapse) {
        if(objToggle.classList.contains('closed')) {
            objToggle.classList.remove('closed');
            var height = objCollapse.offsetHeight;
            objCollapse.style.overflow = 'hidden';
            objCollapse.style.height = 0;
            objCollapse.style.paddingTop = 0;
            objCollapse.style.paddingBottom = 0;
            objCollapse.style.marginTop = 0;
            objCollapse.style.marginBottom = 0;
            objCollapse.offsetHeight;
            objCollapse.style.boxSizing = 'border-box';
            objCollapse.style.transitionProperty = "height, margin, padding";
            objCollapse.style.transitionDuration = '500ms';
            objCollapse.style.height = height + 'px';
            objCollapse.style.removeProperty('padding-top');
            objCollapse.style.removeProperty('padding-bottom');
            objCollapse.style.removeProperty('margin-top');
            objCollapse.style.removeProperty('margin-bottom');
            window.setTimeout(function() {
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
            objCollapse.style.height = 0;
            objCollapse.style.paddingTop = 0;
            objCollapse.style.paddingBottom = 0;
            objCollapse.style.marginTop = 0;
            objCollapse.style.marginBottom = 0;
            window.setTimeout(function() {
                objToggle.classList.add('closed');
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
};


if(document.readyState != 'loading') {
    mikio.ready();
} else {
    document.addEventListener('DOMContentLoaded', function() { mikio.ready() });
}
