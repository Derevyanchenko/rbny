<?php 
/*
Plugin Name: Elementor gallery module 
Plugin URI: #
Description: Block in Elementor which will output the gallery with images
Version: 1.0
Author: ArtMyWeb
Author URI: #
Licence: GPLv2 or later
Text Domain: rbny
*/ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// include tgm plugin activation (for auto installing contact form 7)
require_once untrailingslashit( dirname( __FILE__ ) ) . '/vendor/tgm-config.php';

// elementor extension 
final class Elementor_Test_Extension {

	const VERSION = '1.0.0';

	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);

	}

	public function i18n() {

		load_plugin_textdomain( 'rbny' );

	}

	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

	public function init() {
	
		$this->i18n();

		// Register Widget Styles
		add_action('wp_enqueue_scripts', [$this, 'widget_styles']);

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

	}

	public function widget_styles() {

		wp_enqueue_style( 'slick-css', plugins_url( 'assets/css/slick.css', __FILE__ ) );
		wp_enqueue_style( 'main-css', plugins_url( 'assets/css/main.css', __FILE__ ) );

		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', plugins_url( 'assets/js/jquery-3.0.0.min.js', __FILE__ ) );
		wp_enqueue_script( 'slick', plugins_url( 'assets/js/slick.min.js', __FILE__ ), [ 'jquery' ] );
		wp_enqueue_script( 'main', plugins_url( 'assets/js/main.js', __FILE__ ), [ 'jquery' ] );

		wp_localize_script('main', 'dd_ajax_object',  // main-script - name in main js include
		array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'templ_dir_uri' => get_template_directory_uri(),
			'uploads_dir_uri' => wp_upload_dir()['baseurl'],
			'home_url' => home_url(),
			'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('_wpnonce')
		));

	}

	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/gallery-widget.php' );

		// Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Rbny_Gallery_Widget() );

	}


	public function init_controls() {

		// Include Control files
		// require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
		// \Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

	}
	
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'rbny' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'rbny' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'rbny' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'rbny' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'rbny' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'rbny' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'rbny' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'rbny' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'rbny' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'rbny',
            array(
                'title' => esc_html('rbny'),
                'icon' => 'fa fa-plug',
            )
        );
    }

}

Elementor_Test_Extension::instance();