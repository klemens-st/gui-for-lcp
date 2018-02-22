<?php
//AJAX
add_action( 'wp_ajax_lcp_gui_setup', 'lcp_gui_setup' );
function lcp_gui_setup() {
	check_ajax_referer( 'lcp-gui', 'security' );
  
  $categories = lcp_prepare_categories();
  $tags = lcp_prepare_tags();
  $taxonomies = lcp_prepare_taxonomies();
  $users = get_users(['fields' => [
             'display_name',
             'user_nicename'
           ]]);
  $post_types = get_post_types(array('public' => true));
  
  $response = json_encode([
    'categories' => $categories,
    'users' => $users,
    'tags' => $tags,
    'taxonomies' => $taxonomies,
    'post_types' => $post_types
  ]);
  echo $response;
	wp_die();
}

add_action( 'wp_ajax_lcp_load_terms', 'lcp_load_terms' );
function lcp_load_terms() {
  check_ajax_referer( 'lcp-gui', 'security' );
  
  $taxonomies = $_POST['taxonomies'];
  $output = [];
  
  $terms = lcp_prepare_terms($taxonomies);
  
  
  echo json_encode(['taxonomies' => $terms]);
  wp_die();
}

//helper functions
function lcp_prepare_categories() {
  $categories = get_categories(['hide_empty' => false]);
  $output = [];
  
  foreach ($categories as $cat) {
    $newcat = (object) ['cat_name' => $cat->cat_name,
                        'cat_ID' => $cat->cat_ID];
    $output[] = $newcat;
  }
  return $output;
}

function lcp_prepare_tags() {
  $tags = get_tags(['hide_empty' => false]);
  $output = [];
  
  foreach ($tags as $tag) {
    $newtag = (object) ['name' => $tag->name,
                        'slug' => $tag->slug];
    $output[] = $newtag;
  }
  return $output;
}

function lcp_prepare_taxonomies() {
  $output = [];
  
  $args = [
    'public'   => true,
    '_builtin' => false
  ];
  $taxonomies = get_taxonomies($args, 'objects');
  
  foreach ($taxonomies as $tax) {
    $newtax = (object) ['slug' => $tax->name,
                        'name' => $tax->label];
    $output[] = $newtax;
  }
  return $output;
}

function lcp_prepare_terms($taxonomies) {
  $output = [];
  $newterms = [];
  
  foreach ($taxonomies as $taxonomy) {
    $newterms = [];
    $terms = get_terms([
      'taxonomy' => $taxonomy,
      'hide_empty' => false,
    ]);
  
    foreach ($terms as $term) {
      $newterm = (object) ['name' => $term->name,
                          'slug' => $term->slug];
      $newterms[] = $newterm;
    }
    $output[$taxonomy] = $newterms;
  }
  return $output;
}