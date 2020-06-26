/*!
 * 
 *
 * Home     
 * Author   
 * License  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */


/* Object.forEach polyfill */
if (!Object.prototype.forEach) {
	Object.defineProperty(Object.prototype, 'forEach', {
		value: function (callback, thisArg) {
			if (this == null) {
				throw new TypeError('Not an object');
			}
			thisArg = thisArg || window;
			for (var key in this) {
				if (this.hasOwnProperty(key)) {
					callback.call(thisArg, this[key], key, this);
				}
			}
		}
	});
}

jQuery(document).ready(function() {
    /* Treeview Resizer */
    var seperator = jQuery('<div id="mediamgr__seperator"></div>');

    seperator.insertAfter('#mediamgr__aside');
    jQuery('#mediamgr__seperator').on('mousedown', function(e) {
        e.preventDefault();

        jQuery('#media__manager').on('mousemove', function(e) {
            var min = parseInt(jQuery('#mediamgr__aside').css('min-width'));
            var max = parseInt(jQuery('#mediamgr__aside').css('max-width'));
            
            if(isNaN(min)) { min = 0; }
            if(isNaN(max)) { max = 0; }

            if(e.pageX >= min && (max == 0 || e.pageX <= max)) {
                jQuery('#mediamgr__aside').outerWidth(e.pageX);
            }
        });
    });

    jQuery('#media__manager').on('mouseup', function(e) {
        jQuery(this).off('mousemove');
    });


    /* Treeview Highligher */
    jQuery('#media__tree').on('click', '.idx_dir', function(e) {
        mikio_media = Array();
        jQuery('.idx_dir').removeClass('active');
        jQuery(this).addClass('active');

        mikioRestyle();
    });


    /* Page format */
    var callback = function(mutationsList) {
        for(var mutation of mutationsList) {
            if (mutation.type == 'childList') {
                mutation.addedNodes.forEach(function(item, index) {
                    if(jQuery(item).hasClass('odd') || jQuery(item).hasClass('even')) {
                        mikioAddFile(item);
                        item.parentNode.removeChild(item);
                    }

                    console.log(jQuery(item).prop('tagName'));
                    if(jQuery(item).hasClass('upload')) {
                        
                    // if(jQuery(item).prop("tagName") == 'button') {
                        mikioRestyle();
                    }
                });
            }
        }
    };

    // .qq-upload-list
    
    var observer = new MutationObserver(callback);
    var config = { attributes: false, childList: true };
    var targetNode = document.getElementById('media__content');
    observer.observe(targetNode, config);


    jQuery('#media__content .odd, #media__content .even').each(function() {
       mikioAddFile(jQuery(this)[0]);
       jQuery(this).remove();
    });

    jQuery('#media__manager').on('click', '#media__hide', function(e) {
        if(jQuery(this).prop("checked") == true) {
            jQuery('#mikio-filelist tr td:nth-child(1), #mikio-filelist tr th:nth-child(1)').hide();
        } else {
            jQuery('#mikio-filelist tr td:nth-child(1), #mikio-filelist tr th:nth-child(1)').show();
        }
    });

    mikioRestyle();

    window.resizeTo(1000, 1000);
});


function mikioRestyle() {
    jQuery('div.upload').addClass('alert alert-info');
    jQuery('div.nothing').addClass('alert alert-secondary');
    jQuery('.qq-upload-button').addClass('btn btn-outline-secondary');
    jQuery('input[type=text]').addClass('form-control');
    jQuery('form').addClass('form-inline');
}

function mikioAddFile(item) {
    var file = {title: '', path: '', resolution: '', date: '', time: '', size: '', image: ''};
    var display = (jQuery('#media__hide').prop('checked') == true ? 'none' : 'table-cell');
    var thumb = '';

    file['title'] = jQuery(item).find('a.select').html();
    file['path'] = jQuery(item).find('a.select').attr('id');
    file['class'] = jQuery(item).find('a.select').attr('class');
    
    var info = jQuery(item).find('span.info').html();
    info = info.replace(/(<[^>]*>|[\(\)])/g, '');
    var detail = info.split(' ');
    
    while(detail.length < 4) {
        detail.unshift('');
    }

    file['resolution'] = detail[0];
    file['date'] = detail[1];
    file['time'] = detail[2];
    file['size'] = detail[3];

    file['image'] = jQuery(item).find('.thumb img').attr('src');
    if(typeof(file['image']) == 'undefined') {
        thumb = mikioGenerateFileIcon(file['title'].split('.').pop());
    } else {
        thumb = '<div class="mikio-fileimage" style="background-image:url(\'' + file['image'] + '\');"></div>';
    }



        /*

        <a id="h_:7c910612887a9dae366080ffa3724492.png" class="select mediafile mf_png">7c910612887a9dae366080ffa3724492.png</a>

        <span class="info">(375×340 <i>2020/05/01 10:56</i> 16.4&nbsp;KB)</span>
       
       <a href="/lib/exe/fetch.php?media=7c910612887a9dae366080ffa3724492.png" target="_blank"><img src="/lib/images/magnifier.png" alt="View original file" title="View original file" class="btn"></a>
       <a href="/doku.php?id=start&amp;do=media&amp;image=7c910612887a9dae366080ffa3724492.png&amp;ns=" target="_blank"><img src="/lib/images/mediamanager.png" alt="Media Manager" title="Media Manager" class="btn"></a>
       <a href="/lib/exe/mediamanager.php?delete=7c910612887a9dae366080ffa3724492.png&amp;sectok=0e5876bfcacbb9654c5d314547673105" class="btn_media_delete" title="7c910612887a9dae366080ffa3724492.png"><img src="/lib/images/trash.png" alt="Delete" title="Delete" class="btn"></a>

        <div class="detail" aria-expanded="true"><div class="thumb"><a id="d_:7c910612887a9dae366080ffa3724492.png" class="select"><img src="/lib/exe/fetch.php?w=120&amp;h=108&amp;t=1588294603&amp;tok=7e1a68&amp;media=7c910612887a9dae366080ffa3724492.png" width="120" height="108" alt="7c910612887a9dae366080ffa3724492.png"></a></div></div>
       */

        // if(jQuery('#mikio-filelist').length == 0) {
        //     jQuery('#media__content').append('<table id="mikio-filelist"><tr><th>Title</th><th>Path</th><th>Info</th></tr><tbody></tbody></table>');
        // }

        // mikio_media.forEach(function(item, ignored) {
        //     jQuery('#mikio-filelist tbody').append('<tr><td>' + item['title'] + '</td><td>' + item['path'] + '</td><td>' + item['resolution'] + '</td></tr>');
        // });
    if(jQuery('#mikio-filelist tbody').length == 0) {
        jQuery('#media__content').append('<table id="mikio-filelist"><thead><tr><th style="display:' + display + '"></th><th>File</th><th>Date</th><th>Size</th><th>Resolution</th></tr></thead><tbody></tbody></table>');
    }

    jQuery('#mikio-filelist tbody').append('<tr><td style="display:' + display + '">' + thumb + '</td><td><a id="' + file['path'] + '" class="select">' + file['title'] + '</a></td><td>' + file['date'] + ' ' + file['time'] + '</td><td>' + file['size'] + '</td><td>' + file['resolution'] + '</td></tr>');
}

function mikioGenerateFileIcon(ext) {
    var extColours = {
        'd11723': ['pdf'],
        '08783b': ['xls', 'csv'],
        '1458bc': ['doc', 'txt'],
        'c43e1b': ['ppt'],
        '1ab9cf': ['gif', 'png', 'jpg', 'jpe', 'raw', 'svg'],
        'e50088': ['mov', 'avi', 'mp4', 'mp2'],
        'f08e1b': ['wav', 'aif', 'mp3'],
        '88bf3c': ['htm', 'css', 'js', 'sh', 'xml'],
    };

    var colour = '000';
    var html = '';
    
    ext = ext.toLowerCase();
    extColours.forEach(function(item, key) {
        item.forEach(function(value, index) {
            if(ext.startsWith(value)) {
                colour = key;
            }
        });
    });

    html += '<svg class="mikio-svg-file" viewBox="0 0 20 20">';
    html += '<path fill="#666" d="M17.206,5.45l0.271-0.27l-4.275-4.274l-0.27,0.269V0.9H3.263c-0.314,0-0.569,0.255-0.569,0.569v17.062';
    html += 'c0,0.314,0.255,0.568,0.569,0.568h13.649c0.313,0,0.569-0.254,0.569-0.568V5.45H17.206z M12.932,2.302L16.08,5.45h-3.148V2.302z';
    html += 'M16.344,17.394c0,0.314-0.254,0.569-0.568,0.569H4.4c-0.314,0-0.568-0.255-0.568-0.569V2.606c0-0.314,0.254-0.568,0.568-0.568';
    html += 'h7.394v4.55h4.55V17.394z"></path>';
    html += '<rect fill="#' + colour + '" x="0" y="11.1" rx="1" width="14.9" height="6" />';
    html += '<text x="7.6" y="15.5" fill="white" font-family="sans-serif" font-weight="bold" font-size="5" text-anchor="middle">' + ext + '</text>';
    html += '</svg>';

    return html;
}