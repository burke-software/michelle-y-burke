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





function myb_the_archive_title( $before = '', $after = '' ) {
    $title = myb_get_the_archive_title();
 
    if ( ! empty( $title ) ) {
        echo $before . $title . $after;
    }
}

function myb_get_the_archive_title() {
    if ( is_category() ) {
        $title = sprintf( single_cat_title( '', false ) );
    } elseif ( is_tag() ) {
        $title = sprintf( __( 'Tag: %s' ), single_tag_title( '', false ) );
    } elseif ( is_author() ) {
        $title = sprintf( __( 'Written by %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
    } elseif ( is_year() ) {
        $title = sprintf( get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
    } elseif ( is_month() ) {
        $title = sprintf( get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
    } elseif ( is_day() ) {
        $title = sprintf( get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
    } elseif ( is_tax( 'post_format' ) ) {
        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
            $title = _x( 'Asides', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
            $title = _x( 'Galleries', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
            $title = _x( 'Images', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
            $title = _x( 'Videos', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
            $title = _x( 'Quotes', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
            $title = _x( 'Links', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
            $title = _x( 'Statuses', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
            $title = _x( 'Audio', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
            $title = _x( 'Chats', 'post format archive title' );
        }
    } elseif ( is_post_type_archive() ) {
        $title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );
    } elseif ( is_tax() ) {
        $tax = get_taxonomy( get_queried_object()->taxonomy );
        /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
        $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
    } else {
        $title = __( 'Archives' );
    }
 
    /**
     * Filter the archive title.
     *
     * @since 4.1.0
     *
     * @param string $title Archive title to be displayed.
     */
    return apply_filters( 'get_the_archive_title', $title );
}