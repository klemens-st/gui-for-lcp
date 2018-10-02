<?php
/**
 * GUI for LCP: Gflcp_Walker_Category_Checklist class.
 *
 * This file defines the Gflcp_Walker_Category_Checklist class.
 *
 * @author     Klemens Starybrat
 *
 * @package gui_for_lcp\includes
 * @since 1.0.0
 */

/**
 * Walker_Category_Checklist class that is extended in this file.
 */
require_once ABSPATH . '/wp-admin/includes/class-walker-category-checklist.php';

/**
 * Specialized Walker class for categories, tags and custom taxonomies.
 *
 * WordPress Walker classes make creating terms checklists pretty straightforward.
 * This is why this plugin uses this functionality to build some of its checklists.
 * All other checklists that don't fit into one of the included WP Walkers are built
 * on the front-end with JavaScript.
 *
 * @since 1.0.0
 *
 * @see Walker_Category_Checklist
 * @see Gflcp_Ajax
 */
class Gflcp_Walker_Category_Checklist extends Walker_Category_Checklist {
  /**
   * Summary.
   *
   * Description.
   *
   * @since 1.0.0
   *
   * @param string $input_name Options. 'name' attribute of checkboxes. Default 'cat'.
   * @param string $value      Optional.'value' attribute of checkboxes. Default 'term_id'.
   */
  public function __construct( $input_name = 'cat', $value = 'term_id' ) {
    $this->input_name = $input_name;
    $this->value      = $value;
  }

  /**
   * Start the element output.
   *
   * @see Walker::start_el()
   *
   * @since 1.0.0
   *
   * @param string $output   Used to append additional content (passed by reference).
   * @param object $category The current term object.
   * @param int    $depth    Depth of the term in reference to parents. Default 0.
   * @param array  $args     An array of arguments. @see wp_terms_checklist().
   * @param int    $id       ID of the current term.
   */
  public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
    if ( empty( $args['taxonomy'] ) ) {
      $taxonomy = 'category';
    } else {
      $taxonomy = $args['taxonomy'];
    }

      $args['popular_cats'] = empty( $args['popular_cats'] ) ? array() : $args['popular_cats'];
      $class                = in_array( $category->term_id, $args['popular_cats'], true ) ? ' class="popular-category"' : '';

      $args['selected_cats'] = empty( $args['selected_cats'] ) ? array() : $args['selected_cats'];

      /** This filter is documented in wp-includes/category-template.php */
      $output .= "\n<li$class>" .
        '<label class="selectit"><input value="' . esc_attr( $category->{$this->value} ) . '" type="checkbox" name="' . esc_attr( $this->input_name ) . '"' .
        checked( in_array( $category->term_id, $args['selected_cats'], true ), true, false ) .
        disabled( empty( $args['disabled'] ), false, false ) . ' /> ' .
        esc_html( $category->name ) . '</label>';

  }
}
