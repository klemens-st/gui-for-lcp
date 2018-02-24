<?php

/**
 * The admin ajax functionality of the plugin.
 *
 * @package    gui_for_lcp
 * @subpackage gui_for_lcp/includes
 * @author     Funcacja "Pro Novitate"
 */
class Gflcp_Ajax {

  /**
	 * Retrieve the data required to build the GUI and send it as JSON.
	 *
	 * @since    1.0.0
	 */
  public function gui_setup() {
    check_ajax_referer( 'gui-for-lcp', 'security' );

    $categories = $this->prepare_categories();
    $tags = $this->prepare_tags();
    $taxonomies = $this->prepare_taxonomies();
    $users = get_users( [ 'fields' => [
               'display_name',
               'user_nicename'
             ] ] );
    $post_types = get_post_types( array( 'public' => true ) );

    $response = json_encode( [
      'categories' => $categories,
      'users' => $users,
      'tags' => $tags,
      'taxonomies' => $taxonomies,
      'post_types' => $post_types
    ] );
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

    $terms = $this->prepare_terms( $taxonomies );


    echo json_encode( [ 'taxonomies' => $terms ] );
    wp_die();
  }

  /**
	 * Get all categories from the database and limit the properties
   * to name and id only.
	 *
	 * @since    1.0.0
   * @access   private
   * @return   array    The collection of objects.
	 */
  private function prepare_categories() {
    $categories = get_categories( [ 'hide_empty' => false ] );
    $output = [];

    foreach ($categories as $cat) {
      $newcat = ( object ) [ 'cat_name' => $cat->cat_name,
                             'cat_ID' => $cat->cat_ID ];
      $output[] = $newcat;
    }
    return $output;
  }

  /**
	 * Get all tags from the database and limit the properties
   * to name and slug only.
	 *
	 * @since    1.0.0
   * @access   private
   * @return   array    The collection of objects.
	 */
  private function prepare_tags() {
    $tags = get_tags( [ 'hide_empty' => false ] );
    $output = [];

    foreach ( $tags as $tag ) {
      $newtag = ( object ) [ 'name' => $tag->name,
                             'slug' => $tag->slug ];
      $output[] = $newtag;
    }
    return $output;
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

  /**
	 * Get all categories from the database and limit the properties
   * to name and id only.
	 *
	 * @since    1.0.0
   * @access   private
   * @param    array  $taxonomies  An array of taxonomies submitted by the user.
   * @return   array               Contains arrays of taxonomy terms.
	 */
  private function prepare_terms( $taxonomies ) {
    $output = [];
    $newterms = [];

    foreach ( $taxonomies as $taxonomy ) {
      $newterms = [];
      $terms = get_terms( [
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
      ] );

      foreach ( $terms as $term ) {
        $newterm = ( object ) [ 'name' => $term->name,
                                'slug' => $term->slug ];
        $newterms[] = $newterm;
      }
      $output[ $taxonomy ] = $newterms;
    }
    return $output;
  }
}