<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    gui_for_lcp
 * @subpackage gui_for_lcp/includes
 * @author     Klemens Starybrat
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

    wp_enqueue_style(
      $this->plugin_name . '-admin',
      plugin_dir_url( __FILE__ ) . 'assets/css/admin.css',
      array(),
      $this->version,
      'all'
    );

  }

  /**
   * Register the script and styles for media JavaScript API.
   *
   * @since    1.0.0
   */
  public function enqueue_media() {

    $ajax_nonce = wp_create_nonce( 'gui-for-lcp' );

    wp_enqueue_style(
      $this->plugin_name . '-jquery-ui',
      plugin_dir_url( __FILE__ ) . 'assets/vendors/jquery-ui/jquery-ui.css',
      array(),
      $this->version,
      'all'
    );

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
