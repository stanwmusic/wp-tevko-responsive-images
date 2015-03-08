RICG-responsive-images
---

![Build Status](https://travis-ci.org/ResponsiveImagesCG/wp-tevko-responsive-images.svg)

Bringing automatic default responsive images to WordPress.

This plugin works by including all available image sizes for each image upload. Whenever WordPress outputs the image through the media uploader, or whenever a featured image is generated, those sizes will be included in the image tag via the [srcset](http://css-tricks.com/responsive-images-youre-just-changing-resolutions-use-srcset/) attribute.

##Documentation

###For General Users

No configuration is needed! Just install the plugin and enjoy automatic responsive images!

###For Theme Developers

**Functions**

```tevkori_get_sizes( $id, $size, $args )``` - Returns a valid source size value for use in a 'sizes' attribute. The parameters include the Id of the image, the default size of the image, and an array or string containing of size information. The Id parameter is required. [Link](https://github.com/ResponsiveImagesCG/wp-tevko-responsive-images/blob/master/wp-tevko-responsive-images.php#L28)

```tevkori_get_sizes_string( $id, $size, $args)``` - Returns an array of image sources candidates for use in a 'srcset' attribute. The parameters include the Id of the image, the default size of the image, and An array of of srcset values. The Id parameter is required. [Link](https://github.com/ResponsiveImagesCG/wp-tevko-responsive-images/blob/master/wp-tevko-responsive-images.php#L132)

```tevkori_get_srcset_string( $id, $size )``` - Returns A full 'srcset' attribute. The parameters include the Id of the image and its default size. The Id parameter is required. [Link](https://github.com/ResponsiveImagesCG/wp-tevko-responsive-images/blob/master/wp-tevko-responsive-images.php#L196)

***Hardcoding in template files***

You can output a responsive image anywhere you'd like by using the following syntax:

``<img src="pathToImage" <?php echo tevkori_get_srcset_string( TheIdOfYourImage, theLargestImageSizeNeeded ); ?> />``

ex.)

```<img src="myimg.png" <?php echo tevkori_get_srcset_string( 11, 'medium' ); ?> />```

**Dependencies**

The only external dependency included in this plugin is Picturefill - v2.2.0-beta. If you would like to remove Picturefill, add the following line to your functions.php file: ```wp_dequeue_script('picturefill')```

##Version

2.1.1

##Changelog

- Adding in wp-tevko-responsive-images.js after file not found to be in wordpress repository
- Adjusts the aspect ratio check in tevkori_get_srcset_array() to account for rounding variance

**2.1.0**

- **This version introduces a breaking change** - there are now two functions. One returns an array of srcset values, and the other returns a string with the ``srcset=".."`` html needed to generate the responsive image. To retrieve the srcset array, use ``tevkori_get_srcset_array( $id, $size )``

- When the image size is changed in the post editor, the srcset values will adjust to match the change.

**2.0.2**

- A bugfix correcting a divide by zero error. Some users may have seen this after upgrading to 2.0.1

**2.0.1**
- Only outputs the default WordPress sizes, giving theme developers the option to extend as needed
- Added support for featured images

**2.0.0**
 - Uses [Picturefill 2.2.0 (Beta)](http://scottjehl.github.io/picturefill/)
 - Scripts are output to footer
 - Image sizes adjusted
 - Most importantly, the srcset syntax is being used
 - The structure of the plugin is significantly different. The plugin now works by extending the default WordPress image tag functionality to include the srcset attribute.
 - Works for cropped images!
 - Backwards compatible (images added before plugin install will still be responsive)!
