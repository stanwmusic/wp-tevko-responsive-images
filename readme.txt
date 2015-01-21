=== RICG Responsive Images ===
Contributors: Tim Evko, Mat Marquis, Chris Coyier, Michael McGinnis, Joe McGill, Kelly Dwan, Brandon Lavigne, Andrew Nacin , George Stephanis, Helen Hou-Sandí, Bocoup, The Wordpress Core Team
Tags: Responsive, Images, Responsive Images, SRCSET, Picturefill
Requires at least: 4.1
Tested up to: 4.1
Stable tag: Trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Bringing automatic default responsive images to wordpress.

== Description ==

**If you'd like to contribute to this plugin, please do so on [Github](https://github.com/ResponsiveImagesCG/wp-tevko-responsive-images)**

This plugin works by including 4 additional image sizes for each image upload. This plugin works by including 4 additional image sizes for each image upload. Whenever wordpress outputs the image through the media uploader, or whenever a featured image is generated, those 4 sizes (as well as the initial source and the default wordpress image sizes) will be included in the image tag via the [srcset](http://css-tricks.com/responsive-images-youre-just-changing-resolutions-use-srcset/) attribute.

##Hardcoding in template files

 You can output a responsive image anywhere you'd like by using the following syntax:

`<img src="pathToImage" <?php echo tevkori_get_src_sizes( TheIdOfYourImage, theLargestImageSizeNeeded ); ?> />`

ex.)

`<img src="myimg.png" <?php echo tevkori_get_src_sizes( 11, 'tevkoriMedium-img' ); ?> />`

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.0 =
 * Uses [Picturefill 2.2.2 (Beta)](http://scottjehl.github.io/picturefill/)
 * Scripts are output to footer
 * Image sizes adjusted
 * Most importantly, the srcset syntax is being used
 - Works for cropped images!
 - Backwards compatible (images added before plugin install will still be responsive)!
