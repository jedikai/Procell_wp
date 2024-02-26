<?php
/**
 * procellui functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package procellui
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function procellui_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on procellui, use a find and replace
		* to change 'procellui' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'procellui', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'procellui' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'procellui_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'procellui_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function procellui_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'procellui_content_width', 640 );
}
add_action( 'after_setup_theme', 'procellui_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function procellui_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'procellui' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'procellui' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'procellui_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function procellui_scripts() {
	wp_enqueue_style( 'procellui-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'procellui-style', 'rtl', 'replace' );

	wp_enqueue_script( 'procellui-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'procellui_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


//===================Show featured image Start====================//
add_action('rest_api_init', 'register_rest_images' );
function register_rest_images(){
    register_rest_field( array('post','the-sciences'),
        'fimg_url',
        array(
            'get_callback'    => 'get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
function get_rest_featured_image( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
        return $img[0];
    }
    return false;
}

//===================Show featured image ENd====================//

//==========================Blog Details Start=========================//

add_action( 'rest_api_init', function (){

	register_rest_route( 'custom-api', '/blog-posts-details', array(
	    'methods'  => 'GET',
	    'callback' => 'custom_api_blog_post_details',
	) );
});

function custom_api_blog_post_details($request) {

	 $post_id = $request['post_id'];

	 //$relatedposts = get_posts(
       $args = array(
            'post_type' => 'post',
            'post__in'   => array($post_id),
        );

        $the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post(); 

			$blogg_post_title = get_the_title();
			$blogg_post_date = get_the_date();
			$blogg_post_author = get_the_author();
			$blogg_post_description = get_the_content();
			$blogg_post_image = wp_get_attachment_url( get_post_thumbnail_id() );
			$blogg_post_practitioner = get_field('practitioner_details');

			$blogg_post_set[] = (object) array(
				
				'post_title' => $blogg_post_title,
				'post_description' => $blogg_post_description,
				'post_date' => $blogg_post_date,
				'post_author' => $blogg_post_author,
	    		'post_image' => $blogg_post_image,
	    		'post_practioner' => $blogg_post_practitioner,

			);

		endwhile;endif; wp_reset_query();

		return $blogg_post_set;

}


//==========================Blog Details End=========================//


//============================Related Posts Start========================//
function related_posts_endpoint( $request_data ) {

	global $wpdb;

	$related_prod_set = array();

    $post_id = $request_data['post_id'];

    //$relatedposts = get_posts(
       $args = array(
            'post_type' => 'post',
            'category__in'   => wp_get_post_categories($post_id),
            'posts_per_page' => 3,
            'post__not_in'   => array($post_id),
        );
    //);

       $the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post(); 

			$related_post_id = get_the_ID();
			$related_post_title = get_the_title();
			$related_post_description = wp_trim_words( get_the_content(), 15);
			$related_post_image = wp_get_attachment_url( get_post_thumbnail_id() );
			$related_post_date = get_the_date();
			$related_post_author = get_the_author();

			$related_prod_set[] = (object) array(
				
				'related_post_id' => $related_post_id,
				'related_post_title' => $related_post_title,
				'related_post_description' => $related_post_description,
	    		'related_post_image' => $related_post_image,
	    		'related_post_date' => $related_post_date,
	    		'related_post_author' => $related_post_author,

			);



		endwhile;endif; wp_reset_query();



    return $related_prod_set;
}

add_action( 'rest_api_init', function () {

    register_rest_route( 'custom-api', '/related-post/', array(
            'methods' => 'GET',
            'callback' => 'related_posts_endpoint'
    ));

});

//============================Related Posts End========================//


//============================The Science Search post API Start====================//
add_action( 'rest_api_init', function () {

    register_rest_route( 'custom-api', '/search-post/', array(
            'methods' => 'GET',
            'callback' => 'search_result_posts_endpoint'
    ));

});


function search_result_posts_endpoint( $request_data ) {

	global $wpdb;

	$searched_post_set = array();

	$post_title = $request_data['search_title'];	


	$args = array("post_type" => "the-sciences", "s" => $post_title);

	 $the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post(); 

		$searched_post_id = get_the_ID();
		$searched_post_title = get_the_title();
		$searched_post_date = get_the_date();
		$searched_post_excerpt_content = get_the_content();
		$searched_post_author_name = get_field('author_name');
		$searched_post_external_link = get_field('blogs_links');
		$searched_post_image = wp_get_attachment_url( get_post_thumbnail_id() );

		$searched_post_set[] = (object) array(
				
				'searched_post_id' => $searched_post_id,
				'searched_post_title' => $searched_post_title,
				'searched_post_date' => $searched_post_date,
				'searched_post_excerpt_content' => $searched_post_excerpt_content,
				'searched_post_external_link' => $searched_post_external_link,
				'searched_post_author_name' => $searched_post_author_name,
				'searched_post_image' => $searched_post_image,

			);

		endwhile;endif; wp_reset_query();


		return $searched_post_set;
}

//============================The Science Search post API End====================//

//===================================Popular Post View Count API Start================================//

add_action( 'rest_api_init', function () {

    register_rest_route( 'custom-api', '/popular-post-view-count/', array(
            'methods' => 'GET',
            'callback' => 'popular_posts_view_count_endpoint'
    ));

});

function popular_posts_view_count_endpoint( $request_data ) {

	global $wpdb;

	$post_id = $request_data['post_id'];	

	$countKey = 'post_views_count';
    $count = get_post_meta($post_id, $countKey, true);
    if($count==''){
        $count = 0;
        delete_post_meta($post_id, $countKey);
        add_post_meta($post_id, $countKey, '0');
    }else{
        $count++;
        update_post_meta($post_id, $countKey, $count);
    }

    return $count;
}

//===================================Popular Post View Count API End================================//

//===================================Popular Post for Science API Start================================//

add_action( 'rest_api_init', function () {

    register_rest_route( 'custom-api', '/popular-post/', array(
            'methods' => 'GET',
            'callback' => 'popular_posts_endpoint'
    ));

});

function popular_posts_endpoint( $request_data ) {

	global $wpdb;

	//$post_id = $request_data['post_id'];	

	$args = array(
            'post_type'         => 'the-sciences',
            'meta_key'          => 'post_views_count',
            'orderby'           => 'meta_value_num',
            'post_status'       => array( 'publish' ),
            'posts_per_page'    => 4
        );

	$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post(); 

		$popular_post_id = get_the_ID();
		$popular_post_title = get_the_title();
		$popular_post_date = get_the_date();

		$popular_post_set[] = (object) array(
				
				'popular_post_id' => $popular_post_id,
				'popular_post_title' => $popular_post_title,
				'popular_post_date' => $popular_post_date,

			);

		endwhile;endif; wp_reset_query();


		return $popular_post_set;
}


//==========================The Science Details Start=========================//

add_action( 'rest_api_init', function (){

	register_rest_route( 'custom-api', '/science-posts-details', array(
	    'methods'  => 'GET',
	    'callback' => 'custom_api_science_post_details',
	) );
});

function custom_api_science_post_details($request) {

	 $post_id = $request['post_id'];

	 //$relatedposts = get_posts(
       $args = array(
            'post_type' => 'the-sciences',
            'post__in'   => array($post_id),
        );

        $the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post(); 

			$science_post_title = get_the_title();
			$science_post_date = get_the_date();
			$science_post_author = get_the_author();
			$science_post_description = get_the_content();
			$science_post_image = wp_get_attachment_url( get_post_thumbnail_id() );
			$science_post_practitioner = get_field('practitioner_details');

			$science_post_set[] = (object) array(
				
				'post_title' => $science_post_title,
				'post_description' => $science_post_description,
				'post_date' => $science_post_date,
				'post_author' => $science_post_author,
	    		'post_image' => $science_post_image,
	    		'post_practioner' => $science_post_practitioner,

			);

		endwhile;endif; wp_reset_query();

		return $science_post_set;

}


//==========================Blog Details End=========================//