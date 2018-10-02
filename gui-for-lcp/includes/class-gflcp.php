<?php
/**
 * GUI for LCP: Gflcp class.
 *
 * This file defines the Gflcp class.
 *
 * @author     Klemens Starybrat
 *
 * @package gui_for_lcp\includes
 * @since 1.0.0
 */

/**
 * The core plugin class.
 *
 * This is used to define hooks and load dependencies.
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 */
class Gflcp {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Gflcp_Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct() {
    if ( defined( 'GUI_FOR_LCP_VERSION' ) ) {
      $this->version = GUI_FOR_LCP_VERSION;
    } else {
      $this->version = '1.0.0';
    }
    $this->plugin_name = 'gui-for-lcp';

    $this->load_dependencies();
    $this->define_admin_hooks();
    $this->define_ajax_hooks();

  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - Gflcp_Loader. Orchestrates the hooks of the plugin.
   * - Gflcp_Admin. Defines all hooks for the admin area.
   * - Gflcp_Ajax. Defines all ajax handlers.
   * - Gflcp_Walker_Category Checklist. Formats term checklists.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gflcp-loader.php';

    /**
     * The class responsible for defining all actions that occur in the admin area.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gflcp-admin.php';

    /**
     * The class responsible for handling admin ajax requests.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gflcp-ajax.php';

    /**
     * Custom Walker class for category checklists.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gflcp-walker-category-checklist.php';

    $this->loader = new Gflcp_Loader();

  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks() {

    $plugin_admin = new Gflcp_Admin( $this->get_plugin_name(), $this->get_version() );

    $this->loader->add_action( 'wp_enqueue_media', $plugin_admin, 'enqueue_media' );
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
    $this->loader->add_action( 'print_media_templates', $plugin_admin, 'print_media_templates' );

  }

  /**
   * Register all of the hooks related to the admin ajax functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_ajax_hooks() {

    $plugin_ajax = new Gflcp_Ajax();

    $this->loader->add_action( 'wp_ajax_gflcp_setup', $plugin_ajax, 'gui_setup' );
    $this->loader->add_action( 'wp_ajax_gflcp_load_terms', $plugin_ajax, 'load_terms' );

  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run() {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress.
   *
   * @since     1.0.0
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     1.0.0
   * @return    Gflcp_Loader    Orchestrates the hooks of the plugin.
   */
  public function get_loader() {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since     1.0.0
   * @return    string    The version number of the plugin.
   */
  public function get_version() {
    return $this->version;
  }

}
