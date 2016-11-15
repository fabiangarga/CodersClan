<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'manage_slides_posts_custom_column' , array( $this, 'custom_columns') , 10, 2 );
		add_action( 'manage_slides_posts_custom_column' , array( $this, 'display_posts_shortcode'), 10, 2 );
		add_filter( 'manage_slides_posts_columns' , array( $this, 'add_shortcode_column') );
		
		parent::__construct();
	}

	function register_post_types() {
		// Sliders Custom Post
		$labels = array(
			'name'               => _x( 'Slides', 'post type general name', 'coders-clan' ),
			'singular_name'      => _x( 'Slide', 'post type singular name', 'coders-clan' ),
			'menu_name'          => _x( 'Slides', 'admin menu', 'coders-clan' ),
			'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'coders-clan' ),
			'add_new'            => _x( 'Add New', 'Slide', 'coders-clan' ),
			'add_new_item'       => __( 'Add New Slide', 'coders-clan' ),
			'new_item'           => __( 'New Slide', 'coders-clan' ),
			'edit_item'          => __( 'Edit Slide', 'coders-clan' ),
			'view_item'          => __( 'View Slide', 'coders-clan' ),
			'all_items'          => __( 'All Slides', 'coders-clan' ),
			'search_items'       => __( 'Search Slides', 'coders-clan' ),
			'parent_item_colon'  => __( 'Parent Slides:', 'coders-clan' ),
			'not_found'          => __( 'No Slides found.', 'coders-clan' ),
			'not_found_in_trash' => __( 'No Slides found in Trash.', 'coders-clan' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'coders-clan' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'slide' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'slides', $args );
	}

	// Custom Column to display the Shortcode for the Slides
	function custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'slides':
				echo $post_id;
				break;
		}
	}

	function display_posts_shortcode( $column, $post_id ) {
		if ($column == 'shortcode'){
			echo '<pre>[client-slider id="'. $post_id .'"]</pre>';
		}
	}

	function add_shortcode_column( $columns ) {
		return array_merge( $columns, 
			array( 'shortcode' => __( 'Shortcode', 'codersclan' ) ) );
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		$context['options'] = [
			'header_logo' 	=> get_field('codersclan_logo', 'option'),
			'social'		=> get_field('codersclan_social','option'),
			'copyright'		=> get_field('codersclan_copyright','option'),
			'check_menu'	=> get_field('show_menu','option'),
			'menu'			=> new TimberMenu(2)
		];
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

}

new StarterSite();

/**
 * CodersClan Includes
 *
 * $cc_includes array determines includes in the theme.
 *
 */	
$cc_includes = [
    'src/admin.php',
	'src/setup.php'
];
array_walk($cc_includes, function ($f) {
    if (!locate_template($f, true, true)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $f), E_USER_ERROR);
    }
});


