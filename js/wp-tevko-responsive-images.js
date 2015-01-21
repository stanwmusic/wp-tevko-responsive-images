"use strict";

(function() {

  /**
   * Recalculate srcset attribute after an image-update event
   */
  wp.media.events.on( 'editor:image-update', function( args ) {
    // arguments[0] = { Editor, image, metadata }
    var image = args.image,
      metadata = args.metadata;

    // if the image url has changed, recalculate srcset attributes
    if ( metadata && metadata.url !== metadata.originalUrl ) {
      // we need to get the postdata for the image because
      // the sizes array isn't passed into the editor
      var imagePostData = new wp.media.model.PostImage( metadata ),
        sizes = imagePostData.attachment.attributes.sizes;

      // calculate our target ratio and set up placeholders to hold our updated srcset data
      var newRatio = metadata.width / metadata.height,
        srcset = '',
        srcsetGroup = [];

      // grab all the sizes that match our target ratio and add them to our srcsetGroup array
      _.each(sizes, function(size){
        var sizeRatio = size.width / size.height;

        if (sizeRatio === newRatio) {
          srcsetGroup.push(size.url + ' ' + size.width + 'w');
        }
      });

      // convert the srcsetGroup array to our srcset value
      srcset = srcsetGroup.join(', ');

      // update the srcset attribute of our image
      image.setAttribute( 'srcset', srcset );
    }

  });

})();
