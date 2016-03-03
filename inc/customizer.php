<?php
/**
 * michelle-y-burke Theme Customizer.
 *
 * @package michelle-y-burke
 */



/**
 * Enable options in the theme customizer
 * Adapted from https://wordpress.org/themes/visual/
 */

function michelle_y_burke_customizer_register( $wp_customize ) {

	class Michelle_Y_Burke_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>>
	        	<?php echo esc_textarea( $this->value() ); ?>
	        </textarea>
	        </label>
	        <?php
	    }
	}


	// Footer
	$wp_customize->add_section( 'michelle_y_burke_footer', array(
		'title' => __( 'Footer Text', 'michelle_y_burke' ),
        'priority' => 200
    ) );

	$footer_text = sprintf(
		'<a href="%1$s" title="%2$s" rel="generator">WordPress</a> <a href="%3$s">%4$s</a>',
		esc_url( 'http://wordpress.org' ),
		__( 'A Semantic Personal Publishing Platform', 'michelle_y_burke' ),
		esc_url( 'http://burkesoftware.com/' ),
		__( 'Theme designed by Burke Software and Consulting', 'michelle_y_burke' )
    );

    $wp_customize->add_setting( 'michelle_y_burke-theme[footer_text]', array(
    	'default' => $footer_text,
    	'type' => 'option'
	) );

    $wp_customize->add_control( new Michelle_Y_Burke_Textarea_Control (
    	$wp_customize, 'michelle_y_burke_footer',
    		array(
		    	'label'   => __( 'Footer Text', 'michelle_y_burke' ),
		    	'section' => 'michelle_y_burke_footer',
		    	'settings' => 'michelle_y_burke-theme[footer_text]'
			)
		)
	);

}

add_action( 'customize_register', 'michelle_y_burke_customizer_register' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function michelle_y_burke_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'michelle_y_burke_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function michelle_y_burke_customize_preview_js() {
	wp_enqueue_script( 'michelle_y_burke_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'michelle_y_burke_customize_preview_js' );
