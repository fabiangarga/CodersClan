<?php 

// Styles & Scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 

add_action('wp_enqueue_scripts', 'load_css_files');
function load_css_files() {

    wp_register_style( 'codersclan-css', get_template_directory_uri() . '/static/app.css');
	wp_register_style( 'owl-css', get_template_directory_uri() . '/static/plugins/owl/assets/owl.carousel.css');
	wp_register_style( 'fa-css', get_template_directory_uri() . '/static/plugins/fa/css/font-awesome.min.css');
	wp_register_style( 'animate-css', get_template_directory_uri() . '/static/plugins/animate.css');
	wp_register_script( 'codersclan-js', get_template_directory_uri() . '/static/site.js', array('jquery'), '1.0', true );
	wp_register_script( 'owl-js', get_template_directory_uri() . '/static/plugins/owl/owl.carousel.min.js', array('jquery'), '1.0', true );
	wp_register_script( 'wow-js', get_template_directory_uri() . '/static/plugins/wow.min.js', array('jquery'), '1.0', true );

    wp_enqueue_style( 'codersclan-css' );
	wp_enqueue_style( 'owl-css' );
	wp_enqueue_style( 'fa-css' );
	wp_enqueue_style( 'animate-css' );
	wp_enqueue_script( 'codersclan-js' );
	wp_enqueue_script( 'owl-js' );
	wp_enqueue_script( 'wow-js' );

}

// Options Page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'CodersClan Settings',
		'menu_title'	=> 'CodersClan Settings',
		'menu_slug' 	=> 'codersclan-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

// Shortcodes
add_shortcode( 'client-slider', 'cc_sliders_func' );
function cc_sliders_func( $atts ) {
	$atts = shortcode_atts( array(
		'id' => '1',
		
	), $atts, 'client-slider' );
	
	$post = new TimberPost( $atts['id'] );
	$context['post'] = $post;
	
	Timber::render('widgets/slider.twig', $context);
}