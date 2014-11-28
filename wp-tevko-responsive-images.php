<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * @link              https://github.com/ResponsiveImagesCG/wp-tevko-responsive-images
 * @since             2.0.0
 * @package           http://css-tricks.com/hassle-free-responsive-images-for-wordpress/
 *
 * @wordpress-plugin
 * Plugin Name:       WP Tevko Responsive Images
 * Plugin URI:        http://css-tricks.com/hassle-free-responsive-images-for-wordpress/
 * Description:       Bringing automatic default responsive images to wordpress
 * Version:           2.0.0
 * Author:            Tim Evko
 * Author URI:        http://timevko.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */



// First we queue the polyfill
function tevkori_get_picturefill() {
	wp_enqueue_script( 'picturefill', plugins_url( 'js/picturefill.js', __FILE__ ), array(), '2.2.0', true );
}
add_action( 'wp_enqueue_scripts', 'tevkori_get_picturefill' );

// Add support for our desired image sizes
function tevkori_add_image_sizes() {
	add_image_size( 'tevkoriSuper-img', 1280 );
	add_image_size( 'tevkoriLarge-img', 960 );
	add_image_size( 'tevkoriMedium-img', 640 );
	add_image_size( 'tevkoriSmall-img', 320 );
}

add_action( 'plugins_loaded', 'tevkori_add_image_sizes' );

//stop tinyMCE from altering srcsizes atribute - WILL NOT NEED AFTER WP 4.1

function override_mce_options($initArray) {
	$opts = '*[*]';
	$initArray['valid_elements'] = $opts;
	$initArray['extended_valid_elements'] = $opts;
	return $initArray;
}

add_filter('tiny_mce_before_init', 'override_mce_options');

//return an image with src and sizes attributes

function tevkori_get_src_sizes( $imageId ) {
	$arr = array();
	$origSrc = wp_get_attachment_image_src( $imageId, 'full' )[0];
	$origWidth = wp_get_attachment_image_src( $imageId, 'full' )[1];
	$sizeAlreadyCalled = false;
	$mappings = array(
        'tevkoriSmall-img',
        'tevkoriMedium-img',
        'tevkoriLarge-img',
        'tevkoriSuper-img',
        'full'
    );
    if ( $origWidth > 320 ) {
		foreach ( $mappings as $type ) {
			//we need to prevent duplicate srcsets if an image is smaller than the size we're asking
			$image_src = wp_get_attachment_image_src( $imageId, $type );
			if ($image_src[3] && !$sizeAlreadyCalled) {
				$arr[] = $image_src[0] . ' ' . $image_src[1] . 'w';
			} elseif (!$image_src[3] && !$sizeAlreadyCalled) {
				$arr[] = $image_src[0] . ' ' . $image_src[1] . 'w';
				$sizeAlreadyCalled = true;
			} elseif (!$image_src[3] && $sizeAlreadyCalled) {
				break;
			}
		}
		return 'srcset="' . implode( ', ', $arr ) . '"';
	} else {
		return;
	}
}

//extend image tag to include sizes attribute

function tevkori_extend_image_tag( $html, $id ) {
	$srcset = tevkori_get_src_sizes( $id );
	$html = preg_replace( '/(src\s*=\s*"(.+?)")/', '$1' . ' ' . $srcset, $html );
	return $html;
}

add_filter( 'image_send_to_editor', 'tevkori_extend_image_tag', 0, 2 ); // weird bug happening here where w attributes get messed up