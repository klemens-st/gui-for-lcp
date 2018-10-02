<?php
/**
 * GUI for LCP: Gflcp_Ajax class.
 *
 * This file defines the Gflcp_Ajax class.
 *
 * @author     Klemens Starybrat
 *
 * @package gui_for_lcp\admin
 * @since 1.0.0
 */

/**
 * The admin ajax functionality of the plugin.
 *
 * Handles all plugin's ajax requests.
 * Public methods of this class are used as callbacks in ajax action hooks.
 *
 * @since 1.0.0
 *
 * @see Gflcp_Walker_Category_Checklist
 */
class Gflcp_Ajax {

  /**
   * Retrieves the data required to build the GUI and send it as JSON.
   *
   * Uses Walker instances, built in WordPress functions and private helper methods
   * to create final output.
   *
   * @since    1.0.0
   */
  public function gui_setup() {
    check_ajax_referer( 'gui-for-lcp', 'security' );
    if ( ! current_user_can( 'edit_posts' ) ) {
      die();
    }

    $categories = wp_terms_checklist(
      0,
      [
        'echo'   => false,
        'walker' => new Gflcp_Walker_Category_Checklist(),
      ]
    );

    $tags = wp_terms_checklist(
      0,
      [
        'echo'     => false,
        'taxonomy' => 'post_tag',
        'walker'   => new Gflcp_Walker_Category_Checklist( 'tag', 'slug' ),
      ]
    );

    $taxonomies = $this->prepare_taxonomies();

    $users = get_users(
      [
        'fields' => [
          'display_name',
          'user_nicename',
        ],
      ]
    );

    $post_types = get_post_types(
      array( 'public' => true ),
      'objects'
    );

    $response = [
      'data' => [
        'categories' => $categories,
        'users'      => $users,
        'tags'       => $tags,
        'taxonomies' => $taxonomies,
        'post_types' => $post_types,
      ],
    ];

    wp_send_json( $response );
  }

  /**
   * Retrieves the taxonomy terms based on the submitted taxonomies
   * and send them as JSON.
   *
   * User input is properly sanitized and validated.
   *
   * @since    1.0.0
   */
  public function load_terms() {
    check_ajax_referer( 'gui-for-lcp', 'security' );
    if ( ! current_user_can( 'edit_posts' ) ) {
      die();
    }

    // Validate array key.
    if ( isset( $_POST['taxonomies'] ) ) { // Input var okay.
      // Sanitize form input.
      $taxonomies = array_map(
        'sanitize_text_field',
        wp_unslash( $_POST['taxonomies'] ) // Input var okay.
      );
    } else {
      die();
    }

    $output = [];

    foreach ( $taxonomies as $taxonomy ) {
      // Validate the taxonomy
      if ( ! taxonomy_exists( $taxonomy ) ) {
        continue;
      }

      $output[ $taxonomy ] = wp_terms_checklist(
        0,
        [
          'echo'     => false,
          'taxonomy' => $taxonomy,
          'walker'   => new Gflcp_Walker_Category_Checklist( "$taxonomy-term", 'slug' ),
        ]
      );
    }

    wp_send_json( [ 'taxonomies' => $output ] );
  }

  /**
   * Get all taxonomies from the database and limit the properties
   * to name and label only.
   *
   * @since    1.0.0
   * @access   private
   * @return   array    The collection of objects.
   */
  private function prepare_taxonomies() {
    $output = [];

    $args       = [
      'public'   => true,
      '_builtin' => false,
    ];
    $taxonomies = get_taxonomies( $args, 'objects' );

    foreach ( $taxonomies as $tax ) {
      $newtax   = (object) [
        'slug' => $tax->name,
        'name' => $tax->label,
      ];
      $output[] = $newtax;
    }
    return $output;
  }
}
