<?php
/**
 * DesignStage Framework.
 *
 * Info:
 * - Responsage: https://github.com/iamspacehead/responsage
 * - TimThumb Alternative: https://github.com/MatthewRuddy/Wordpress-Timthumb-alternative
 * - TimThumb Alternative: https://github.com/derdesign/mr-image-resize
 *
 * @package DesignStage
 * @subpackage dsPress
 *
 * @since 1.0.0
 */
class DSPress {

    /**
     * Initializes the theme framework by loading
     * required files and functions for the theme.
     *
     * @since 1.0.0
     *
     * @param $options
     */
    public static function init( $options = array() ) {
        self::constants( $options );

        self::plugins();
        self::classes();
        self::functions();

        self::actions();
        self::filters();
        self::supports();
        self::locale();
        self::admin();
        self::variables();
    }

    /**
     * Theme constant definitions.
     *
     * @since 1.0.0
     *
     * @param $options
     */
    private static function constants( $options ) {
        # constants
        define( 'THEME_DEBUG', isset( $options['theme_debug'] ) ? $options['theme_debug'] : false );

        define( 'THEME_NAME', isset( $options['theme_name'] ) ? $options['theme_name'] : '' );
        define( 'THEME_SLUG', get_template() );
        define( 'THEME_VERSION', isset( $options['theme_version'] ) ? $options['theme_version'] : '' );
        define( 'STYLE_NAME', isset( $options['style_name'] ) ? $options['style_name'] : '' );
        define( 'STYLE_VERSION', isset( $options['style_version'] ) ? $options['style_version'] : '' );

        define( 'DS_PREFIX', 'ds' );
        define( 'DS_PREFIX_MOBILE', DS_PREFIX . 'm' );

        define( 'DS_TEXTDOMAIN', THEME_SLUG );
        define( 'DS_ADMIN_TEXTDOMAIN', THEME_SLUG . '_admin' );

        $settings_prefix = DS_PREFIX . '_' . THEME_SLUG;
        define( 'DS_SETTINGS', $settings_prefix . '_options' );
        define( 'DS_INTERNAL_SETTINGS', $settings_prefix . '_internal_options' );

        define( 'THEME_DIR', get_template_directory() );
        define( 'THEME_URI', get_template_directory_uri() );
        define( 'STYLE_DIR', get_stylesheet_directory() );
        define( 'STYLE_URI', get_stylesheet_directory_uri() );

        define( 'THEME_CACHE', THEME_DIR . '/.cache' );

        define( 'THEME_ASSETS', THEME_URI . '/assets' );
        define( 'STYLE_ASSETS', STYLE_URI . '/assets' );

        define( 'THEME_LIBRARY', THEME_DIR . '/lib' );
        define( 'THEME_LIBRARY_URI', THEME_URI . '/lib' );
        define( 'STYLE_LIBRARY', STYLE_DIR . '/lib' );
        define( 'STYLE_LIBRARY_URI', STYLE_URI . '/lib' );

        define( 'THEME_JS', THEME_ASSETS . '/js' );
        define( 'STYLE_JS', STYLE_ASSETS . '/js' );
        define( 'THEME_CSS', THEME_ASSETS . '/css' );
        define( 'STYLE_CSS', STYLE_ASSETS . '/css' );
        define( 'THEME_IMAGES', THEME_ASSETS . '/img' );

        define( 'THEME_CLASSES', THEME_LIBRARY . '/classes' );
        define( 'THEME_FUNCTIONS', THEME_LIBRARY . '/functions' );
        define( 'THEME_SHORTCODES', THEME_LIBRARY . '/shortcodes' );
        define( 'STYLE_SHORTCODES', STYLE_LIBRARY . '/shortcodes' );

        define( 'THEME_PLUGINS', THEME_DIR . '/plugins' );
        define( 'THEME_WIDGETS', THEME_LIBRARY . '/widgets' );

        # Template definitions
        define( 'THEME_TEMPLATES', THEME_DIR . '/templates' );
        define( 'THEME_TEMPLATES_URI', THEME_URI . '/templates' );
        define( 'STYLE_TEMPLATES', STYLE_DIR . '/templates' );

        # Admin definitions
        define( 'THEME_ADMIN', THEME_LIBRARY . '/admin' );
        define( 'THEME_ADMIN_URI', THEME_LIBRARY_URI . '/admin' );
        define( 'THEME_ADMIN_JS', THEME_ADMIN_URI . '/js' );
        define( 'THEME_ADMIN_FUNCTIONS', THEME_ADMIN . '/functions' );
        define( 'THEME_ADMIN_FUNCTIONS_URI', THEME_ADMIN_URI . '/functions' );

        # Component definitions
        define( 'JS_COMPONENTS', THEME_URI . '/bower_components' );
        define( 'PHP_COMPONENTS', THEME_DIR . '/composer_components' );
    }

    /**
     * Theme classes loading.
     *
     * @since 1.0.0
     */
    public static function classes() {
        /** @noinspection PhpIncludeInspection */
        require_once( THEME_CLASSES . '/post.php' );

        /** @noinspection PhpIncludeInspection */
        require_once( THEME_CLASSES . '/image.php' );

        /** @noinspection PhpIncludeInspection */
        require_once( THEME_CLASSES . '/layout.php' );
    }

    /**
     * Theme functions loading.
     *
     * @since 1.0.0
     */
    public static function functions() {
        /** @noinspection PhpIncludeInspection
         *
         * Utilities...
         *
         */
        require_once( THEME_FUNCTIONS . '/utilities.php' );

        /** @noinspection PhpIncludeInspection
         *
         * Core...
         *
         */
        require_once( THEME_FUNCTIONS . '/core.php' );

        /** @noinspection PhpIncludeInspection
         *
         * Theme...
         *
         */
        require_once( THEME_FUNCTIONS . '/theme.php' );

        /** @noinspection PhpIncludeInspection
         *
         * Scripts...
         *
         */
        require_once( THEME_FUNCTIONS . '/scripts.php' );

        /** @noinspection PhpIncludeInspection
         *
         * Image...
         *
         */
        require_once( THEME_FUNCTIONS . '/image.php' );

        /** @noinspection PhpIncludeInspection
         *
         * Hooks...
         *
         */
        require_once( THEME_FUNCTIONS . '/hooks.php' );

        /** @noinspection PhpIncludeInspection
         *
         * Plugins...
         *
         */
        require_once( THEME_FUNCTIONS . '/plugins.php' );
    }

    /**
     * @since 1.0.0
     */
    public static function plugins() {
        /**
         * Cuztom Helper: This helper can be used to quickly register Custom Post Types,
         * Taxonomies, Meta Boxes, Menu Pages and Sidebars
         */
        add_filter( 'cuztom_theme_mode', '__return_true' );

        /**
         * OptionTree: Theme Options UI Builder to create & save Theme Options and Meta Boxes
         */
        add_filter( 'ot_theme_mode', '__return_true' );
        add_filter( 'ot_show_docs', '__return_false' );
        add_filter( 'ot_show_pages', '__return_false' );
        add_filter( 'ot_show_options_ui', '__return_false' );
        add_filter( 'ot_show_new_layout', '__return_false' );
        add_filter( 'ot_use_theme_options', '__return_true' );
        add_filter( 'ot_show_settings_import', '__return_false' );
        add_filter( 'ot_show_settings_export', '__return_false' );

        /**
         * NextGEN Gallery: Remove the commented-out meta tag
         */
        add_filter( 'show_nextgen_version', '__return_null' );

        /** @noinspection PhpIncludeInspection
         *
         * Composer components autoload.
         */
        require_once( PHP_COMPONENTS . '/autoload.php' );

        if ( !class_exists( 'Timber' ) )
            /** @noinspection PhpIncludeInspection
             *
             * Load timber plugin.
             */
            require_once( THEME_PLUGINS . '/timber/timber.php' );
    }

    /**
     * @since 1.0.0
     */
    private static function actions() {
        /**
         * Allows custom page header with image.
         */
        add_action( 'after_setup_theme', 'ds_custom_header' );

        /**
         * Initialize menus.
         */
        add_action( 'init', 'ds_menu_init' );

        /**
         * Initialize Shortcodes.
         *
         * Shortcodes will be initialized by filename and function name.
         * File: 01-tabs.php results in dsTabs and registers containing functions
         * as separated shortcodes. The function names containing _ will be converted to -.
         */
        add_action( 'init', 'ds_shortcode_init' );

        /**
         * Integrate google analytics code.
         */
        add_action( 'wp_footer', 'ds_google_analytics' );

        /**
         * Initialize css and javascript files.
         */
        add_action( 'wp_enqueue_scripts', 'ds_register_style' );
        add_action( 'wp_enqueue_scripts', 'ds_register_script' );
        add_action( 'wp_enqueue_scripts', 'ds_register_ie_script' );

        /**
         * Initialize widgets, sidebars and custom post types.
         */
        add_action( 'widgets_init', 'ds_widget_init' );
        add_action( 'widgets_init', 'ds_sidebar_init' );
        add_action( 'widgets_init', 'ds_posttype_init' );

        /**
         * Post query hook gives access to the $query object by reference.
         */
        add_action( 'pre_get_posts', 'ds_pre_get_posts' );

        /**
         * Ajax actions.
         */
//        add_action( 'init', 'ds_js_config', 11 );
//        add_action( 'init', 'ds_ajax_image_resize', 11 );
        add_action( 'wp_ajax_flexslider_slides', array( 'dsSliders', 'flexslider_get_slides' ) );
        add_action( 'wp_ajax_nopriv_flexslider_slides', array( 'dsSliders', 'flexslider_get_slides' ) );

        /**
         * Singular post after actions.
         */
        add_action( 'ds_singular-post_after_post', 'ds_post_module' );
        add_action( 'ds_singular-post_after_post', 'ds_post_comment' );


//        add_action( 'init', 'ds_image_init' );
//        add_action( 'init', 'ds_is_mobile_device' );

        /**
         * Image resize functionality.
         * Remove resized images who's original
         * attachment image would be deleted.
         */
//        add_filter( 'updated_postmeta', array( 'DSImage', 'delete' ) );
        add_action( 'delete_attachment', array( 'DSImage', 'delete' ) );

//        add_action( 'ds_body_end', 'ds_image_preloading' );
    }

    /**
     * @since 1.0.0
     */
    private static function filters() {
        /**
         * Timber twig integration.
         */
        add_filter( 'twig_apply_filters', 'ds_get_twig' );

        /**
         * Timber context initialization.
         */
        add_filter( 'timber_context', 'ds_timber_context' );

        /**
         *
         */
//        add_filter( 'body_class', 'ds_body_class' );
//        add_filter( 'main_class', 'ds_main_class' );
//        add_filter( 'sidebar_left_class', 'ds_sidebar_left_class', 10, 2 );
//        add_filter( 'sidebar_right_class', 'ds_sidebar_right_class', 10, 2 );

//        add_filter( 'post_class', 'ds_post_class' );
//        add_filter( 'image_container_class', 'ds_image_container_class' );
//        add_filter( 'image_class', 'ds_image_class' );
//        add_filter( 'content_class', 'ds_content_class' );

        # Search Form
        add_filter( 'get_search_form', 'ds_get_search_form' );
        add_filter( 'search_form_format', 'ds_search_form_format' );

        #add_filter( 'the_content', 'ds_before_page_content' );

        # Remove default content formatter and add custom one
//        remove_filter( 'the_content', 'wpautop' );
//        remove_filter( 'the_content', 'wptexturize' );
//        add_filter( 'the_content', 'ds_formatter', 99 );

        # Post preview (excerpt)
//        add_filter( 'ds_post_preview', 'ds_post_preview' );

        # Post content
//        add_filter( 'ds_post_content', 'ds_post_content' );

        # Post more link
        add_filter( 'ds_read_more', 'ds_read_more' );

        # Post excerpt length
//        add_filter( 'ds_excerpt_length', 'ds_excerpt_length_medium' );
//        add_filter( 'ds_excerpt_length_long', 'ds_excerpt_length_long' );
//        add_filter( 'ds_excerpt_length_short', 'ds_excerpt_length_short' );
//        add_filter( 'ds_excerpt_length_medium', 'ds_excerpt_length_medium' );

        # WordPress filters
        add_filter( 'query_vars', 'ds_queryvars' );
        add_filter( 'rewrite_rules_array', 'ds_rewrite_rules', 10, 2 );

        add_filter( 'prepare_image', 'ds_prepare_image' );
        add_filter( 'ds_image_dimensions', 'ds_get_image_dimensions' );

        function special_nav_class( $classes, $item ) {
            if ( $item->current )
                $classes[] = 'active';

            return $classes;
        }

        add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
    }

    /**
     * @since 1.0.0
     */
    private static function supports() {
        /**
         * Add support for menu registration.
         */
        add_theme_support( 'menus' );

        /**
         * Add support for widget initialization.
         */
        add_theme_support( 'widgets' );

        /**
         * Add support for the Aside Post Formats
         */
        add_theme_support( 'post-formats', array( 'aside' ) );

        /**
         * Enable support for Featured Images
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support( 'automatic-feed-links' );
    }

    /**
     * @since 1.0.0
     */
    private static function locale() {
        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on DesignStage, use a find and replace
         * to change 'ds' to the name of your theme in all the template files
         */

        $locale = get_locale();

        if ( is_admin() ) {
            load_theme_textdomain( DS_ADMIN_TEXTDOMAIN, THEME_ADMIN . '/languages' );
            $locale_file = THEME_ADMIN . "/languages/$locale.php";
        } else {
            load_theme_textdomain( DS_TEXTDOMAIN, THEME_DIR . '/languages' );
            $locale_file = THEME_DIR . "/languages/$locale.php";
        }

        if ( is_readable( $locale_file ) )
            /** @noinspection PhpIncludeInspection */
            require_once( $locale_file );
    }

    /**
     * @since 1.0.0
     */
    private static function admin() {
        if ( !is_admin() )
            return;

        /** @noinspection PhpIncludeInspection
         *
         * Load and initialize DesignStage Admin Framework.
         *
         */
        require_once( THEME_ADMIN . '/admin.php' );
        DSAdmin::init();
    }

    /**
     * @since 1.0.0
     */
    private static function variables() {
        if ( !file_exists( THEME_CACHE ) )
            wp_mkdir_p( THEME_CACHE );

        /**
         *
         */
        global $ds;

        $ds = new stdClass();
        $ds->offset = false;

        $ds->devices = array(
            'desktop' => array(
                'label' => 'Desktop',
                'prefix' => DS_PREFIX . '-',
                'suffix' => ''
            ),
            'tablet' => array(
                'label' => 'Tablet',
                'prefix' => DS_PREFIX . '-',
                'suffix' => '-t'
            ),
            'mobile' => array(
                'label' => 'Mobile',
                'prefix' => DS_PREFIX . '-',
                'suffix' => '-m'
            )
        );

        if ( class_exists( 'Mobile_Detect' ) ) {
            $mobile = new Mobile_Detect();
            $ds->is_mobile = $mobile->isMobile();
            $ds->is_tablet = $mobile->isTablet();
        }
    }
}