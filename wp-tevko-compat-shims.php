<?php
/**
 * Return a source size attribute for an image from an array of values.
 *
 * @since 2.2.0
 * @deprecated 3.0 Use wp_get_attachment_image_sizes()
 * @see wp_get_attachment_image_sizes()

 * @param int    $id   Image attachment ID.
 * @param string $size Optional. Name of image size. Default value: 'medium'.
 * @param array  $args {
 *     Optional. Arguments to retrieve posts.
 *
 *     @type array|string $sizes An array or string containing of size information.
 *     @type int          $width A single width value used in the default `sizes` string.
 * }
 * @return string|bool A valid source size value for use in a 'sizes' attribute or false.
 */
function tevkori_get_sizes( $id, $size = 'medium', $args = null ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_get_attachment_image_sizes()' );
	return wp_get_attachment_image_sizes( $id, $size, $args );
}

/**
 * Return a source size list for an image from an array of values.
 *
 * @since 2.2.0
 * @deprecated 3.0 Use wp_get_attachment_image_sizes()
 * @see wp_get_attachment_image_sizes()
 *
 * @param int    $id   Image attachment ID.
 * @param string $size Optional. Name of image size. Default value: 'medium'.
 * @param array  $args {
 *     Optional. Arguments to retrieve posts.
 *
 *     @type array|string $sizes An array or string containing of size information.
 *     @type int          $width A single width value used in the default `sizes` string.
 * }
 * @return string|bool A valid source size list as a 'sizes' attribute or false.
 */
function tevkori_get_sizes_string( $id, $size = 'medium', $args = null ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_get_attachment_image_sizes()' );
	$sizes = wp_get_attachment_image_sizes( $id, $size, $args );

	return $sizes ? 'sizes="' . esc_attr( $sizes ) . '"' : false;
}

/**
 * Get an array of image sources candidates for use in a 'srcset' attribute.
 *
 * @since 2.1.0
 * @deprecated 3.0 Use wp_get_attachment_image_srcset_array()
 * @see wp_get_attachment_image_srcset_array()
 *
 * @param int    $id   Image attachment ID.
 * @param string $size Optional. Name of image size. Default value: 'medium'.
 * @return array|bool  An array of `srcset` values or false.
 */
function tevkori_get_srcset_array( $id, $size = 'medium' ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_get_attachment_image_srcset_array()' );
	$srcset_array = wp_get_attachment_image_srcset_array( $id, $size );

	// Transform array to pre-core style.
	$arr = false;
	if ( is_array( $srcset_array ) ) {
		$arr = array();
		foreach ( $srcset_array as $source ) {
			$arr[ $source['value'] ] = $source['url'] . ' ' . $source['value'] . $source['descriptor'];
		}
	}

	/**
	 * Filter the output of tevkori_get_srcset_array().
	 *
	 * @since 2.4.0
	 * @deprecated 3.0 Use 'wp_get_attachment_image_srcset_array'
	 * @see 'wp_get_attachment_image_srcset_array'
	 *
	 * @param array        $arr   An array of image sources.
	 * @param int          $id    Attachment ID for image.
	 * @param array|string $size  Size of image, either array or string.
	 */
	return apply_filters( 'tevkori_srcset_array', $arr, $id, $size );
}

/**
 * Get the value for the 'srcset' attribute.
 *
 * @since 2.3.0
 * @deprecated 3.0 Use 'wp_get_attachment_image_srcset()'
 * @see 'wp_get_attachment_image_srcset()'
 *
 * @param int    $id   Image attachment ID.
 * @param string $size Optional. Name of image size. Default value: 'medium'.
 * @return string|bool A 'srcset' value string or false.
 */
function tevkori_get_srcset( $id, $size = 'medium' ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_get_attachment_image_srcset()' );
	$srcset_array = tevkori_get_srcset_array( $id, $size );

	if ( count( $srcset_array ) <= 1 ) {
		return false;
	}

	return implode( ', ', $srcset_array );
}

/**
 * Create a 'srcset' attribute.
 *
 * @since 2.1.0
 * @deprecated 3.0 Use 'wp_get_attachment_image_srcset()'
 * @see 'wp_get_attachment_image_srcset()'
 *
 * @param int    $id   Image attachment ID.
 * @param string $size Optional. Name of image size. Default value: 'medium'.
 * @return string|bool A full 'srcset' string or false.
 */
function tevkori_get_srcset_string( $id, $size = 'medium' ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_get_attachment_image_srcset()' );
	$srcset_value = tevkori_get_srcset( $id, $size );

	if ( empty( $srcset_value ) ) {
		return false;
	}

	return 'srcset="' . $srcset_value . '"';
}

/**
 * Filters images in post content to add 'srcset' and 'sizes'.
 *
 * @since 2.5.0
 * @deprecated 3.0 Use 'wp_make_content_images_responsive()'
 * @see 'wp_make_content_images_responsive()'
 *
 * @param string $content The raw post content to be filtered.
 * @return string Converted content with 'srcset' and 'sizes' added to images.
 */
function tevkori_filter_content_images( $content ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_make_content_images_responsive()' );
	return wp_make_content_images_responsive( $content );
}

/**
 * Add srcset and sizes to an 'img' element.
 *
 * @since 2.6.0
 * @deprecated 3.0 Use 'wp_img_add_srcset_and_sizes()'
 * @see 'wp_img_add_srcset_and_sizes()'
 *
 * @param string $image An HTML 'img' element to be filtered.
 * @return string Converted 'img' element with 'srcset' and 'sizes' added.
 */
function tevkori_img_add_srcset_and_sizes( $image ) {
	_deprecated_function( __FUNCTION__, '3.0.0', 'wp_img_add_srcset_and_sizes()' );
	return wp_img_add_srcset_and_sizes( $image );
}
