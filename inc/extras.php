<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package michelle-y-burke
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function michelle_y_burke_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'michelle_y_burke_body_classes' );


/**
 * Option to update footer text
 *
 * Adapted from https://wordpress.org/themes/visual/
 */

function michelle_y_burke_get_option( $name, $default = false ) {
	if ( get_option('michelle_y_burke-theme') ) {
		$options = get_option('michelle_y_burke-theme');
	}

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	} else {
		return $default;
	}
}

function michelle_y_burke_return_footer_text() {
	$footer_text = sprintf(
		'<a href="%1$s" title="%2$s" rel="generator">WordPress</a> <a href="%3$s">%4$s</a>',
		esc_url( 'http://wordpress.org' ),
		__( 'A Semantic Personal Publishing Platform', 'michelle_y_burke' ),
		esc_url( 'http://burkesoftware.com/' ),
		__( 'Theme designed by Burke Software and Consulting', 'michelle_y_burke' )
    );
    return $footer_text;
}

function michelle_y_burke_footer_text() {
    $footer_text = michelle_y_burke_get_option( 'footer_text', michelle_y_burke_return_footer_text() );
    echo $footer_text;
}

add_action( 'michelle_y_burke_footer_text', 'michelle_y_burke_footer_text' );