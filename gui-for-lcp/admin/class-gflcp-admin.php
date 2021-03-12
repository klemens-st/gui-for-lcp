<?php
/**
 * GUI for LCP: Gflcp_Admin class.
 *
 * This file defines the Gflcp_Admin class.
 *
 * @author     Klemens Starybrat
 *
 * @package gui_for_lcp\admin
 * @since 1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * This is used to define admin hooks and load admin area templates.
 * Also enqueues 'ajax_object' for later use in JavaScript.
 *
 * @since 1.0.0
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
   * @param      string $plugin_name       The name of this plugin.
   * @param      string $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version     = $version;

  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {
    /*
     * The main CSS file of the Backbone app has been removed from this function
     * and is now managed by webpack. TODO: Move jquery-ui.css to webpack as well.
     */
    wp_enqueue_style(
      $this->plugin_name . '-jquery-ui',
      plugin_dir_url( __FILE__ ) . 'assets/vendors/jquery-ui/jquery-ui.css',
      array(),
      $this->version,
      'all'
    );

  }

  /**
   * Register the scripts for media JavaScript API.
   *
   * @since    1.0.0
   */
  public function enqueue_media() {

    $ajax_nonce = wp_create_nonce( 'gui-for-lcp' );

    wp_enqueue_script(
      $this->plugin_name,
      plugin_dir_url( __FILE__ ) . 'assets/js/dist/admin.min.js',
      array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-tabs', 'jquery-ui-accordion' ),
      $this->version,
      true
    );

    wp_localize_script(
      $this->plugin_name,
      'ajax_object',
      array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => $ajax_nonce,
      )
    );
  }

  /**
   * Register media templates.
   *
   * @since    1.0.0
   */
  public function print_media_templates() {

    require_once 'templates/tmpl-modal-content.php';
    require_once 'templates/tmpl-select-options.php';
    require_once 'templates/tmpl-display-options.php';
    require_once 'templates/tmpl-taxonomy-terms.php';
  }
}
