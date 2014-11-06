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
	echo
	'<!-- Begin picturefill -->
	<script src="' . plugins_url( 'js/picturefill.js', __FILE__ ) . '" async></script>
	<!-- End picturefill -->';
}
add_action( 'wp_footer', 'tevkori_get_picturefill' );

// ensure theme support for thumbnails exists, if not add it
function tevkori_add_thumbnail_support() {
	$supported = get_theme_support( 'post-thumbnails' );
	if( $supported == false )
		add_theme_support( 'post-thumbnails');
}

add_action( 'after_setup_theme', 'tevkori_add_thumbnail_support' );

// Add support for our desired image sizes
function tevkori_add_image_sizes() {
	//if the image size is less than 320, what do?
	add_image_size( 'super-img', 1280 );
	add_image_size( 'large-img', 960 );
	add_image_size( 'medium-img', 640 );
	add_image_size( 'small-img', 320 );
}
add_action( 'plugins_loaded', 'tevkori_add_image_sizes' );

//get the image alt tag

function tevkori_get_img_alt( $id ) {
	$alt = wp_prepare_attachment_for_js( $id )['alt'];
	$title = wp_prepare_attachment_for_js( $id )['title'];
	if ($alt) {
		return $alt;
	} else {
		return $title;
	}
}

//return an image with src and sizes attributes

function tevkori_get_src_sizes( $imageId ) {
	$arr = array();
	$origSrc = wp_get_attachment_image_src( $imageId, 'full' )[0];
	$mappings = array(
        'small-img',
        'medium-img',
        'large-img',
        'super-img'
    );
	foreach ( $mappings as $type ) {
		//right now there's now way (AFAIK) to check if a specific image size for an image exists, so this code will produce duplicate srcsets if a request is made for an image size that's greater than the width of the origional image
		$image_src = wp_get_attachment_image_src( $imageId, $type );
		$arr[] = $image_src[0] . ' ' . $image_src[1] . 'w';
	}
	return 'src="' . $origSrc . '" srcset="' . implode( ', ', $arr ) . '"';
}

//extend image tag to include sizes attribute

function tevkori_extend_image_tag( $html, $id ) {
	$html = '<img ' . tevkori_get_src_sizes( $id ) . ' alt="' . tevkori_get_img_alt( $id ) . '" />';
	return $html;
}

add_filter( 'image_send_to_editor', 'tevkori_extend_image_tag', 10, 7 );
add_filter('get_image_tag', 'tevkori_extend_image_tag', 0, 4);