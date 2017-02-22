<?php
	
/**
 * Site configuration for DRM usage
 * 
 * 
 *
 * @package drm
 */
 
 
if ( ! function_exists( 'drm_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function drm_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on drm, use a find and replace
	 * to change 'drm' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'drm', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'drm-featured', '656', '300', true );
	add_image_size( 'drm-site-logo', '300', '300' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'drm' ),
	) );

	add_editor_style( array( 'editor-style.css', drm_fonts_url(), get_template_directory_uri() . '/genericons/genericons.css' ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'drm_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	
	/*
	 * Uninstall all default widgets
	 * 
	 */
	unregister_widget('WP_Widget_Pages');     
	unregister_widget('WP_Widget_Calendar');     
	unregister_widget('WP_Widget_Archives');     
	unregister_widget('WP_Widget_Links');     
	unregister_widget('WP_Widget_Meta');     
	unregister_widget('WP_Widget_Search');     
	unregister_widget('WP_Widget_Text');     
	unregister_widget('WP_Widget_Categories');     
	unregister_widget('WP_Widget_Recent_Posts');     
	unregister_widget('WP_Widget_Recent_Comments');     
	unregister_widget('WP_Widget_RSS');     
	unregister_widget('WP_Widget_Tag_Cloud');     
	//unregister_widget('WP_Nav_Menu_Widget');     // TODO remove this. Left in place incase we need still need it. Controls the presence of the custom menu widget.
	unregister_widget('Twenty_Eleven_Ephemera_Widget'); 
	
	
	
// End of the drm_secup function
} endif;
add_action( 'after_setup_theme', 'drm_theme_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function drm_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'drm_content_width', 640 );
}
add_action( 'after_setup_theme', 'drm_content_width', 0 );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function drm_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'drm' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'drm_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function drm_scripts() {
	wp_enqueue_style( 'drm-style', get_stylesheet_uri() );

	wp_enqueue_style( 'drm-fonts', drm_fonts_url(), array(), null );

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );

	wp_enqueue_script( 'drm-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'drm-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array( 'jquery' ), '1.0', true  );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'drm_scripts' );


/**
 * Register Google Fonts
 */
function drm_fonts_url() {
    $fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Roboto Slab, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$font_families = array();
	
	$heading_font_family = get_theme_mod( 'drm_google_fonts_heading_font', null );
	$body_font_family = get_theme_mod( 'drm_google_fonts_body_font', null );

	if ( !empty( $heading_font_family ) && $heading_font_family !== 'none' ) {
		$heading_font = _x( 'on', $heading_font_family . ' font: on or off', 'drm' );
		if ( 'off' !== $heading_font ) {
			$font_families[] = $heading_font_family;
		}
	}

	if ( !empty( $body_font_family ) && $body_font_family !== 'none' && $body_font_family !== $heading_font_family ) {
		$body_font = _x( 'on', $body_font_family . ' font: on or off', 'drm' );
		if ( 'off' !== $body_font ) {
			$font_families[] = $body_font_family;
		}
	}


	if ( count( $font_families ) === 4 ) {
		array_slice( $font_families, 2 );
	}

	if ( !empty( $font_families ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

function drm_load_theme_fonts()
{
	$heading = get_theme_mod( 'drm_google_fonts_heading_font' );
	$body = get_theme_mod( 'drm_google_fonts_body_font' );
	if ( ( !empty( $heading ) && $heading != 'none' ) || ( !empty( $body ) && $body != 'none' ) ) {
		echo '<style type="text/css">';
		$imports = array();
		$styles = array();
		if ( !empty( $heading ) && $heading != 'none' ) {
			$imports[] = '@import url(//fonts.googleapis.com/css?family=' . urlencode( $heading ) . ');';
			$styles[] = 'h1, h2, h3, h4, h5, h6 { font-family: "' . $heading . '" !important }';
		}
		if ( !empty( $body ) && $body != 'none' ) {
			$imports[] = '@import url(//fonts.googleapis.com/css?family=' . urlencode( $body ) . ');';
			$styles[] = 'body, .herotext, .herobuttons .button { font-family: "' . $body . '" !important }';
		}

		echo implode( "\r\n", $imports );
		echo implode( "\r\n", $styles );
		echo '</style>';

	}
}
add_action( 'wp_head', 'drm_load_theme_fonts' );

/**
 * Enqueue Google Fonts for custom headers
 */
function drm_admin_styles() {

	wp_enqueue_style( 'drm-fonts', drm_fonts_url(), array(), null );

}
add_action( 'admin_print_styles-appearance_page_custom-header', 'drm_admin_styles' );


 
 ?>