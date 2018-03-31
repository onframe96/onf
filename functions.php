<?php
/**
 * Primer functions and definitions.
 *
 * Set up the theme and provide some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Functions
 * @since   1.0.0
 */

/**
 * Primer theme version.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'PRIMER_VERSION', '1.8.2' );

/**
 * Minimum WordPress version required for Primer.
 *
 * @since 1.0.0
 *
 * @var string
 */
if ( ! defined( 'PRIMER_MIN_WP_VERSION' ) ) {

	define( 'PRIMER_MIN_WP_VERSION', '4.4' );

}

/**
 * Define the Primer child theme version if undefined.
 *
 * @since 1.5.0
 *
 * @var string
 */
if ( ! defined( 'PRIMER_CHILD_VERSION' ) ) {

	define( 'PRIMER_CHILD_VERSION', '' );

}

/**
 * Load theme translations.
 *
 * Translations can be filed in the /languages/ directory. If you're
 * building a theme based on Primer, use a find and replace to change
 * 'primer' to the name of your theme in all the template files.
 *
 * @link  https://codex.wordpress.org/Function_Reference/load_theme_textdomain
 * @since 1.0.0
 */
load_theme_textdomain( 'primer', get_template_directory() . '/languages' );

/**
 * Enforce the minimum WordPress version requirement.
 *
 * @since 1.0.0
 */
if ( version_compare( get_bloginfo( 'version' ), PRIMER_MIN_WP_VERSION, '<' ) ) {

	require_once get_template_directory() . '/inc/compat/wordpress.php';

}

/**
 * Load deprecated hooks and functions for this theme.
 *
 * @since 1.6.0
 */
require_once get_template_directory() . '/inc/compat/deprecated.php';

/**
 * Load functions for handling special child theme compatibility conditions.
 *
 * @since 1.6.0
 */
require_once get_template_directory() . '/inc/compat/child-themes.php';

/**
 * Load custom helper functions for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/helpers.php';

/**
 * Load custom template tags for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Load custom primary nav menu walker.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/walker-nav-menu.php';

/**
 * Load template parts and override some WordPress defaults.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/hooks.php';

/**
 * Load Beaver Builder compatibility file.
 *
 * @since 1.0.0
 */
if ( class_exists( 'FLBuilder' ) ) {

	require_once get_template_directory() . '/inc/compat/beaver-builder.php';

}

/**
 * Load Jetpack compatibility file.
 *
 * @since 1.0.0
 */
if ( class_exists( 'Jetpack' ) ) {

	require_once get_template_directory() . '/inc/compat/jetpack.php';

}

/**
 * Load WooCommerce compatibility file.
 *
 * @since 1.0.0
 */
if ( class_exists( 'WooCommerce' ) ) {

	require_once get_template_directory() . '/inc/compat/woocommerce.php';

}

/**
 * Load Customizer class (must be required last).
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the 'after_setup_theme' hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @global array $primer_image_sizes
 * @since  1.0.0
 */
function primer_setup() {

	global $primer_image_sizes;

	/**
	 * Filter registered image sizes.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$primer_image_sizes = (array) apply_filters( 'primer_image_sizes',
		array(
			'primer-featured' => array(
				'width'  => 1600,
				'height' => 9999,
				'crop'   => false,
				'label'  => esc_html__( 'Featured', 'primer' ),
			),
			'primer-hero' => array(
				'width'  => 2400,
				'height' => 1300,
				'crop'   => array( 'center', 'center' ),
				'label'  => esc_html__( 'Hero', 'primer' ),
			),
		)
	);

	foreach ( $primer_image_sizes as $name => &$args ) {

		if ( empty( $name ) || empty( $args['width'] ) || empty( $args['height'] ) ) {

			unset( $primer_image_sizes[ $name ] );

			continue;

		}

		$args['crop']  = ! empty( $args['crop'] ) ? $args['crop'] : false;
		$args['label'] = ! empty( $args['label'] ) ? $args['label'] : ucwords( str_replace( array( '-', '_' ), ' ', $name ) );

		add_image_size(
			sanitize_key( $name ),
			absint( $args['width'] ),
			absint( $args['height'] ),
			$args['crop']
		);

	}

	if ( $primer_image_sizes ) {

		add_filter( 'image_size_names_choose', 'primer_image_size_names_choose' );

	}

	/**
	 * Enable support for Automatic Feed Links.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#feed-links
	 * @since 1.0.0
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for plugins and themes to manage the document title tag.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
	 * @since 1.0.0
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
	 * @since 1.0.0
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable support for customizer selective refresh.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
	 * @since 1.0.0
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Register custom Custom Navigation Menus.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/register_nav_menus/
	 * @since 1.0.0
	 */
	register_nav_menus(
		/**
		 * Filter registered nav menus.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		(array) apply_filters( 'primer_nav_menus',
			array(
				'primary' => esc_html__( 'Primary Menu', 'primer' ),
				'social'  => esc_html__( 'Social Menu', 'primer' ),
				'footer'  => esc_html__( 'Footer Menu', 'primer' ),
			)
		)
	);

	/**
	 * Enable support for HTML5 markup.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
	 * @since 1.0.0
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
		)
	);

	/**
	 * Enable support for Post Formats.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
	 * @since 1.0.0
	 */
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		)
	);

}
add_action( 'after_setup_theme', 'primer_setup' );

/**
 * Register image size labels.
 *
 * @filter image_size_names_choose
 * @since  1.0.0
 *
 * @param  array $size_names Array of image sizes and their names.
 *
 * @return array
 */
function primer_image_size_names_choose( $size_names ) {

	global $primer_image_sizes;

	$labels = array_combine(
		array_keys( $primer_image_sizes ),
		wp_list_pluck( $primer_image_sizes, 'label' )
	);

	return array_merge( $size_names, $labels );

}

/**
 * Sets the content width in pixels, based on the theme layout.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @action after_setup_theme
 * @global int $content_width
 * @since  1.0.0
 */
function primer_content_width() {

	$layout        = primer_get_layout();
	$content_width = ( 'one-column-wide' === $layout ) ? 1068 : 688;

	/**
	 * Filter the content width in pixels.
	 *
	 * @since 1.0.0
	 *
	 * @param string $layout
	 *
	 * @var int
	 */
	$GLOBALS['content_width'] = (int) apply_filters( 'primer_content_width', $content_width, $layout );

}
add_action( 'after_setup_theme', 'primer_content_width', 0 );

/**
 * Enable support for custom editor style.
 *
 * @link  https://developer.wordpress.org/reference/functions/add_editor_style/
 * @since 1.0.0
 */
add_action( 'admin_init', 'add_editor_style', 10, 0 );

/**
 * Register sidebar areas.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 * @since 1.0.0
 */
function primer_register_sidebars() {

	/**
	 * Filter registered sidebars areas.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$sidebars = (array) apply_filters( 'primer_sidebars',
		array(
			'sidebar-1' => array(
				'name'          => esc_html__( 'Sidebar', 'primer' ),
				'description'   => esc_html__( 'The primary sidebar appears alongside the content of every page, post, archive, and search template.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'sidebar-2' => array(
				'name'          => esc_html__( 'Secondary Sidebar', 'primer' ),
				'description'   => esc_html__( 'The secondary sidebar will only appear when you have selected a three-column layout.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'footer-1' => array(
				'name'          => esc_html__( 'Footer 1', 'primer' ),
				'description'   => esc_html__( 'This sidebar is the first column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'footer-2' => array(
				'name'          => esc_html__( 'Footer 2', 'primer' ),
				'description'   => esc_html__( 'This sidebar is the second column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'footer-3' => array(
				'name'          => esc_html__( 'Footer 3', 'primer' ),
				'description'   => esc_html__( 'This sidebar is the third column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			'hero' => array(
				'name'          => esc_html__( 'Hero', 'primer' ),
				'description'   => esc_html__( 'Hero widgets appear over the header image on the front page.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			),
		)
	);

	foreach ( $sidebars as $id => $args ) {

		register_sidebar( array_merge( array( 'id' => $id ), $args ) );

	}

}
add_action( 'widgets_init', 'primer_register_sidebars' );

/**
 * Register Primer widgets.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_widget
 * @since 1.6.0
 */
function primer_register_widgets() {

	require_once get_template_directory() . '/inc/hero-text-widget.php';

	register_widget( 'Primer_Hero_Text_Widget' );

}
add_action( 'widgets_init', 'primer_register_widgets' );

/**
 * Enqueue theme scripts and styles.
 *
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since 1.0.0
 */
function primer_scripts() {

	$stylesheet = get_stylesheet();
	$suffix     = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( $stylesheet, get_stylesheet_uri(), false, defined( 'PRIMER_CHILD_VERSION' ) ? PRIMER_CHILD_VERSION : PRIMER_VERSION );

	wp_style_add_data( $stylesheet, 'rtl', 'replace' );

	$nav_dependencies = ( is_front_page() && function_exists( 'has_header_video' ) && has_header_video() ) ? array( 'jquery', 'wp-custom-header' ) : array( 'jquery' );

	wp_enqueue_script( 'primer-navigation', get_template_directory_uri() . "/assets/js/navigation{$suffix}.js", $nav_dependencies, PRIMER_VERSION, true );
	wp_enqueue_script( 'primer-skip-link-focus-fix', get_template_directory_uri() . "/assets/js/skip-link-focus-fix{$suffix}.js", array(), PRIMER_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

		wp_enqueue_script( 'comment-reply' );

	}
	if ( primer_has_hero_image() ) {

		$css = sprintf(
			SCRIPT_DEBUG ? '%s { background-image: url(%s); }' : '%s{background-image:url(%s);}',
			primer_get_hero_image_selector(),
			esc_url( primer_get_hero_image() )
		);

		wp_add_inline_style( $stylesheet, $css );
	}

}
add_action( 'wp_enqueue_scripts', 'primer_scripts' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 *
 * It removes the need to call `the_post()` and `rewind_posts()`
 * in an author template to print information about the author.
 *
 * @action wp
 * @global WP_Query $wp_query
 * @global WP_User  $authordata
 * @since  1.0.0
 */
function primer_setup_author() {

	global $wp_query, $authordata;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {

		$authordata = get_userdata( $wp_query->post->post_author ); // override ok.

	}

}
add_action( 'wp', 'primer_setup_author' );

/**
 * Reset the transient for the active categories check.
 *
 * @action create_category
 * @action edit_category
 * @action delete_category
 * @action save_post
 * @see    primer_has_active_categories()
 * @since  1.0.0
 */
function primer_has_active_categories_reset() {

	delete_transient( 'primer_has_active_categories' );

}
add_action( 'create_category', 'primer_has_active_categories_reset' );
add_action( 'edit_category',   'primer_has_active_categories_reset' );
add_action( 'delete_category', 'primer_has_active_categories_reset' );
add_action( 'save_post',       'primer_has_active_categories_reset' );

//去除window._wpemojiSettings
remove_action( 'admin_print_scripts',    'print_emoji_detection_script');
remove_action( 'admin_print_styles',    'print_emoji_styles');

remove_action( 'wp_head',        'print_emoji_detection_script',    7);
remove_action( 'wp_print_styles',    'print_emoji_styles');

remove_filter( 'the_content_feed',    'wp_staticize_emoji');
remove_filter( 'comment_text_rss',    'wp_staticize_emoji');
remove_filter( 'wp_mail',        'wp_staticize_emoji_for_email');

/* 移除不必要的存档页面 */
add_action('template_redirect', 'meks_remove_wp_archives');
function meks_remove_wp_archives(){
  //If we are on category or tag or date or author archive
  if( is_category() || is_tag() || is_date() || is_author() ) {
    global $wp_query;
    $wp_query->set_404(); //set to 404 not found page
  }
}

// 删除 wp_head 输入到模板中的feed地址链接
add_action( 'wp_head', 'wpse33072_wp_head', 1 );
function wpse33072_wp_head() {
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
}

foreach( array( 'rdf', 'rss', 'rss2', 'atom' ) as $feed ) {
    add_action( 'do_feed_' . $feed, 'wpse33072_remove_feeds', 1 );
}
unset( $feed );

// 当执行 do_feed action 时重定向到首页
function wpse33072_remove_feeds() {
    wp_redirect( home_url(), 302 );
    exit();
}

// 删除feed的重定向规则
add_action( 'init', 'wpse33072_kill_feed_endpoint', 99 );

function wpse33072_kill_feed_endpoint() {
    global $wp_rewrite;
    $wp_rewrite->feeds = array();
    
    // 运行一次后，记得删除下面的代码
}
remove_action( 'wp_head', 'wp_generator' );

//离线编辑器
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * WordPress disable Google Open Sans
 */
add_filter( 'gettext_with_context', 'wpdx_disable_open_sans', 888, 4 );
function wpdx_disable_open_sans( $translations, $text, $context, $domain ) {
 if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
 $translations = 'off';
 }
 return $translations;
}

remove_action('wp_head','wp_shortlink_wp_head',10,0);
remove_action('template_redirect','wp_shortlink_header',11,0);

// 只搜索文章标题
function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;
        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';
        $search = array();
        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";
        $search = ' AND ' . implode( ' AND ', $search );
    }
    return $search;
}
add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );

//禁用REST API/移除wp-json链接
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

//embed移除
function disable_embeds_init() {  
    /* @var WP $wp */  
    global $wp;  
   
    // Remove the embed query var.  
    $wp->public_query_vars = array_diff( $wp->public_query_vars, array(  
        'embed',  
    ) );  
   
    // Remove the REST API endpoint.  
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );  
   
    // Turn off  
    add_filter( 'embed_oembed_discover', '__return_false' );  
   
    // Don't filter oEmbed results.  
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );  
   
    // Remove oEmbed discovery links.  
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );  
   
    // Remove oEmbed-specific JavaScript from the front-end and back-end.  
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );  
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );  
   
    // Remove all embeds rewrite rules.  
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );  
}  
   
add_action( 'init', 'disable_embeds_init', 9999 );  
   
/** 
 * Removes the 'wpembed' TinyMCE plugin. 
 * 
 * @since 1.0.0 
 * 
 * @param array $plugins List of TinyMCE plugins. 
 * @return array The modified list. 
 */  
function disable_embeds_tiny_mce_plugin( $plugins ) {  
    return array_diff( $plugins, array( 'wpembed' ) );  
}  
   
/** 
 * Remove all rewrite rules related to embeds. 
 * 
 * @since 1.2.0 
 * 
 * @param array $rules WordPress rewrite rules. 
 * @return array Rewrite rules without embeds rules. 
 */  
function disable_embeds_rewrites( $rules ) {  
    foreach ( $rules as $rule => $rewrite ) {  
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {  
            unset( $rules[ $rule ] );  
        }  
    }  
   
    return $rules;  
}     
/** 
 * Remove embeds rewrite rules on plugin activation. 
 * 
 * @since 1.2.0 
 */  
function disable_embeds_remove_rewrite_rules() {  
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );  
    flush_rewrite_rules();  
}  
   
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );  
   
/** 
 * Flush rewrite rules on plugin deactivation. 
 * 
 * @since 1.2.0 
 */  
function disable_embeds_flush_rewrite_rules() {  
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );  
    flush_rewrite_rules();  
}  
   
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );  