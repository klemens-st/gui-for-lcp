<?php

/**
 * The admin ajax functionality of the plugin.
 *
 * @package    gui_for_lcp
 * @subpackage gui_for_lcp/includes
 * @author     Klemens Starybrat
 */
class Gflcp_Ajax {

  /**
	 * Retrieve the data required to build the GUI and send it as JSON.
	 *
	 * @since    1.0.0
	 */
  public function gui_setup() {
    check_ajax_referer( 'gui-for-lcp', 'security' );

    $categories = wp_terms_checklist(0, [
      'echo' => false,
      'walker' => new Gflcp_Walker_Category_Checklist()
    ]);
    $tags = wp_terms_checklist(0, [
      'echo' => false,
      'taxonomy' => 'post_tag',
      'walker' => new Gflcp_Walker_Category_Checklist('tag', 'slug')
    ]);
    $taxonomies = $this->prepare_taxonomies();
    $users = get_users( [ 'fields' => [
               'display_name',
               'user_nicename'
             ] ] );
    $post_types = get_post_types(
      array( 'public' => true ),
      'objects'
    );

    $response = json_encode( ['init' => [
      'categories' => $categories,
      'users' => $users,
      'tags' => $tags,
      'taxonomies' => $taxonomies,
      'post_types' => $post_types
    ]] );
    echo $response;
    wp_die();
  }

  /**
	 * Retrieve the taxonomy terms based on the submitted taxonomies
   * and send them as JSON.
	 *
	 * @since    1.0.0
	 */
  public function load_terms() {
    check_ajax_referer( 'gui-for-lcp', 'security' );

    $taxonomies = $_POST[ 'taxonomies' ];
    $output = [];

    foreach ( $taxonomies as $taxonomy ) {
      $output[ $taxonomy ] = wp_terms_checklist(0, [
        'echo' => false,
        'taxonomy' => $taxonomy,
        'walker' => new Gflcp_Walker_Category_Checklist("$taxonomy-term", 'slug')
      ]);
    }

    echo json_encode( [ 'taxonomies' => $output ] );
    wp_die();
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

    $args = [
      'public'   => true,
      '_builtin' => false
    ];
    $taxonomies = get_taxonomies( $args, 'objects' );

    foreach ( $taxonomies as $tax ) {
      $newtax = (object) [ 'slug' => $tax->name,
                           'name' => $tax->label ];
      $output[] = $newtax;
    }
    return $output;
  }
}