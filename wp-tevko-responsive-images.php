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

//return an image with src and sizes attributes

function tevkori_get_src_sizes( $id, $size ) {
    $arr = array();
    $src = wp_get_attachment_image_src( $id, $size );
    $image = wp_get_attachment_metadata( $id );

    // default sizes
    $default_sizes = $image['sizes'];

    // choose sizes based on the users needs.
    $width = ( !empty($image['width']) && $size != 'full' ) ? $image['sizes'][$size]['width'] : $image['width'];

    // We don't want cropped thumbnails
    unset($default_sizes['thumbnail']);

    // Our loop should not include the default passed size, yet.
    unset($default_sizes[$size]);

    // First, remove sizes we don't need to check for
    foreach ($default_sizes as $key => $image_size) {
        if( $image_size['width'] > $width ) {
            unset($default_sizes[$key]);
        }
    }

    // No sizes? Checkout early
    if(!$default_sizes)
        return false;

    // Loop through each size we know should exist
    foreach($default_sizes as $key => $size) {
        
        // Reference the size directly by it's pixel dimension
        $image_src = wp_get_attachment_image_src( $id, $key );
        $arr[] = $image_src[0] . ' ' . $size['width'] .'w';
    }

    $arr[] = $src[0] . ' ' . $src[1] . 'w';

    return 'srcset="' . implode( ', ', $arr ) . '"';
}

//extend image tag to include sizes attribute

function tevkori_extend_image_tag( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
    add_filter( 'editor_max_image_size', 'tevkori_editor_image_size' );
    $srcset = tevkori_get_src_sizes( $id, $size );
    remove_filter( 'editor_max_image_size', 'tevkori_editor_image_size' );
    $html = preg_replace( '/(src\s*=\s*"(.+?)")/', '$1' . ' ' . $srcset, $html );
    return $html;
}
add_filter( 'image_send_to_editor', 'tevkori_extend_image_tag', 0, 8 );

/**
 * Disable the editor size constraint applied for images in TinyMCE.
 *
 * @param  array $max_image_size An array with the width as the first element, and the height as the second element.
 * @return array A width & height array so large it shouldn't constrain reasonable images.
 */
function tevkori_editor_image_size( $max_image_size ){
	return array( 99999, 99999 );
}