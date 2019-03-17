/**
 * Polyfill for indexOf().
 * Production steps of ECMA-262, Edition 5, 15.4.4.14
 * Referentie: http://es5.github.io/#x15.4.4.14
 */

if (!Array.prototype.indexOf) {
  Array.prototype.indexOf = function(searchElement, fromIndex) {
    var k;
    if (this == null) {
      throw new TypeError('"this" is null or not defined');
    }
    var o = Object(this);
    var len = o.length >>> 0;
    if (len === 0) {
      return -1;
    }
    var n = +fromIndex || 0;
    if (Math.abs(n) === Infinity) {
      n = 0;
    }
    if (n >= len) {
      return -1;
    }
    k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);
    while (k < len) {
      if (k in o && o[k] === searchElement) {
        return k;
      }
      k++;
    }
    return -1;
  };
}


/**
 * The plugin JQuery/Javascript function
 */

var twentynineteenLightbox = ( function($) {
  $(document).ready(function($) {

    var lightboxCSSClassName = window.twentynineteen_lightbox_options.twentynineteen_lightbox_field_cssclassname,
        lightboxGalleryTypes = window.twentynineteen_lightbox_options.twentynineteen_lightbox_field_gallerytype,
        lightboxGalleryAll = Array('alignleft','aligncenter','alignright','alignwide','alignfull'),
        imgHolderElems = [];

    // Check if there are galleries set in the options.
    if( lightboxGalleryTypes && lightboxGalleryTypes.length ) {
      $.each(lightboxGalleryTypes, function( key, val ) {

        // Add the images of the gallery to the imgHolderElems array.
        // Note: There is a WP bug https://core.trac.wordpress.org/ticket/46538 which causes a class to 'stick'.
        // This causes a conflict in CSS classes in the gallery.
        // That is why just the first CSS class in the class attribute should be used to check against the plugin options.
        if( $(".wp-block-gallery." + val)[0] ) {
          $(".wp-block-gallery." + val).each( function( index, element ) {
            classArray = $(element).attr('class').split(' ');

            // The matches of all gallerytypes in classArray.
            matches = matchesInArray( lightboxGalleryAll, classArray );

            // Select the first match.
            firstmatch = Math.min.apply( null, matches );

            // Check if the first match is equal to the current value set in options.
            // If true, add all images in the gallery to the imgHolderElems array.
            if( classArray[firstmatch] == val ) {
              $.merge(imgHolderElems, $(element).find("img"));
            }
          });
        }
      });
    }

    // Check if elements exist with the classname set in the options (or the default 'lightboxed').
    if( $("." + lightboxCSSClassName)[0] ) {
      $("." + lightboxCSSClassName).each(function( index, element ) {
        if( $(element).is("figure") ) {
          $.merge(imgHolderElems, $(element).find("img"));
        } else {
          $.merge(imgHolderElems, $(element));
        }
      });
    }

    // Add styling to lightbox control images
    $(imgHolderElems).css("cursor", "pointer");

    // Add event handler to lightbox control images
    $(imgHolderElems).click(function(e) {

      e.preventDefault();

      // Get the default (full) image source address from the <img> srcset attribute
      var image_href = $(this).attr('srcset').split(',').pop().trim().split(' ').shift();

      // Check if lightbox exists
      if( $('#lightbox-2019').length > 0 ) {

        // Reset the lightbox image
        $("#lightbox-2019-image").attr("src", "");

        // Show lightbox
        $('#lightbox-2019').fadeIn(500, function () {

          // Load image source after lightbox animation ends
          $("#lightbox-2019-image").attr("src", image_href);
        });

      } else {
        // Lightbox doesn't exist so it needs to be created
        var lightbox = document.createElement("div"),
            lightboxContent = document.createElement("div"),
            lightboxImage = document.createElement("img"),
            loader = document.createElement("div");

        lightbox.setAttribute("id", "lightbox-2019");
        lightbox.setAttribute("style", "display: none");
        lightboxContent.setAttribute("id", "lightbox-2019-content");
        loader.setAttribute("class", "loader");
        lightboxImage.setAttribute("id", "lightbox-2019-image");

        // Image source set to nothing, to be loaded after lightbox is shown
        lightboxImage.setAttribute("src", "");

        lightboxContent.appendChild(loader);
        lightboxContent.appendChild(lightboxImage); 
        lightbox.appendChild(lightboxContent);

        //insert lightbox HTML into page on the top of the body
        document.body.insertBefore(lightbox, document.getElementById("page"));

        // Show lightbox
        $('#lightbox-2019').fadeIn(500, function () {

          // Load image source after lightbox animation ends
          $("#lightbox-2019-image").attr("src", image_href);
        });
      }

      // Create click event capture for the whole page to hide lightbox if it is shown
      $('#lightbox-2019').live('click', function() {
        $('#lightbox-2019').hide();
      });
    });
  });
})( jQuery );


/**
 * Helper functions
 */

var matchesInArray = ( function () {
  "use strict";
  var func = function( needle, haystack ) {
    var ar = [];
    for( var i = 0; i < needle.length; i++ ) {
      if( haystack.indexOf(needle[i]) > -1 ) {
        ar.push( haystack.indexOf(needle[i]) );
      }
    }
    return ar;
  };
  return func;
}() );
