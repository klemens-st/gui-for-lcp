<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    gui_for_lcp
 * @subpackage gui_for_lcp/includes
 * @author     Funcacja "Pro Novitate"
 */
class Gflcp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		

	}

	/**
	 * Register the script and styles for media JavaScript API.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_media() {

    $ajax_nonce = wp_create_nonce( 'gui-for-lcp' );

    wp_enqueue_style( $this->plugin_name . '-jquery-ui',
                      plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css',
                      array(),
                      $this->version,
                      'all' );

    wp_enqueue_script( $this->plugin_name,
                       plugin_dir_url( __FILE__ ) . 'js/gflcp-admin.js',
                       array( 'jquery', 'jquery-ui-datepicker' ),
                       $this->version,
                       false );

    wp_localize_script( $this->plugin_name,
                        'ajax_object',
                        array( 'ajax_url' => admin_url( 'admin-ajax.php' ),
                               'nonce' => $ajax_nonce ));

	}
  
  /**
	 * Register the media button.
	 *
	 * @since    1.0.0
	 */
	public function add_media_button() {
    echo '<a href="#" class="insert-lcp button">Add LCP</a>';
  }
  
  /**
	 * Register media templates.
	 *
	 * @since    1.0.0
	 */
	public function print_media_templates() {
    require_once 'partials/templates.php';
  }
}