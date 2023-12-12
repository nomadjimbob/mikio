/* FastWiki Plugin Support */
function tpl_fastwiki_support() { }

jQuery(window).on('fastwiki:afterSwitch', function (evt, viewMode, isSectionEdit, prevViewMode) {
    if (viewMode === 'show') {
        // Check if the source element 'article.mikio-article div.mikio-article-content.content_initial #dw__toc' exists
        var sourceToc = jQuery('article.mikio-article div.mikio-article-content.content_initial #dw__toc');

        if (sourceToc.length > 0) {
            // Check if the target location 'article.mikio-article .mikio-toc #dw__toc' already has a 'dw__toc' element
            var targetToc = jQuery('article.mikio-article .mikio-toc #dw__toc');

            if (targetToc.length > 0) {
                // If the target already has a 'dw__toc', remove it
                targetToc.remove();
            }

            // Move the 'dw__toc' from the source to the target location
            sourceToc.appendTo('article.mikio-article .mikio-toc');

            // Bookcreator is shown - so we do this hack
            jQuery('.bookcreator__bookbar').hide();
        }
    }
});
