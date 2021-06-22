<?php

/* =======================
    Page links
    These are referenced wherever a link is needed on a page
=========================*/
// I hate wordpress so much
function get_page_link_by_slug($slug){
    return esc_url(get_permalink(get_page_by_path($slug)->ID));
}
// Send contact email endpoint
$link_send_contact_email = $server_actions . 'send-contact-email.php';


/* ==========================================
	Reset stupid Wordpress defaults
============================================ */
function remove_block_css(){
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );

/* ===============================
    Url references
=============================== */
$page_titles = [
    'blog' => 'Cast notes',
];
$blog_category_id = '7';
$actor_category_id = '8';

/* =====================================
    Set helpful sytem folder paths
====================================== */
// Get site root folder
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$site_root = str_replace('\\', '/', $doc_root);
// Home brew trailingslashit
if(substr($site_root, -1) !== '/') {
    $site_root = $site_root . '/';
}
$theme_path = trailingslashit(get_stylesheet_directory_uri());
$css_path = ($theme_path . 'css');
$js_path = ($theme_path . 'js');
$images_path = ($theme_path . 'images');

/* =====================================
    Set helpful page folder paths
====================================== */
$page_link_blog = get_page_link_by_slug($page_slugs['blog']);
$page_link_writing_page = '/'; 

/* ===============================
    Simpler load functions
=============================== */
function load_script($file_label, $file_name) {
    global $js_path;
    wp_enqueue_script($file_label, "$js_path/$file_name", false, [], true);
}
function load_style($file_label, $file_name) {
    global $css_path;
    wp_enqueue_style($file_label, "$css_path/$file_name");
}
function super_simple_load($file_label_prefix, $file_name) {
    load_style(($file_label_prefix.'_style'), "$file_name.style.css");
    load_script(($file_label_prefix.'_script'), "$file_name.script.js");
}

/* ===============================
    Enqueue page resources
=============================== */
// Loads common scripts and conditionally loads page specific scripts
function load_page_scripts(){
    global $post;
    global $page_titles;

    $lowercase_page_title = get_the_title($post);

    /* ==========================================
       Load common styles
    ========================================== */
    load_style('commons_style', 'common.style.css');
    load_script('commons_script', 'common.script.js');

    /* ===================================================
        TODO  Pages that need the base post styles
    ===================================================== */
    // if() {
    //     load_style('all_base_post_styles', 'post-styles.style.css');
    // }
    
    /* ==========================================
       Front page
    ========================================== */
    // // TODO Delete this
    // foreach($post as $key => $value) {
    //     echo "<h1>$key:</h1> <h2>$value</h2><br/>";

    // }
    // echo (is_home() ? "PAGE IS HOME.": "Is not home" );

    if(is_front_page() || is_page_template( 'front-page' ) || is_home()){
        super_simple_load('template_home', 'front-page');
    }
    /* =================================
       TODO(point to correct archive) Articles
    ================================= */
    // Supporting cast search
    else if(is_archive('todo-article-archive')) {
        // TODO Load 
        super_simple_load('single_supporting_cast', 'single-supporting-cast');
    }
    else if (is_single()) {
        super_simple_load('base_single', 'single');
    }
    // Supporting cast single 
    else if (get_post_type($post) === 'short-story' || get_post_type($post) === 'flash-fiction'){
        // TODO Load 
        super_simple_load('base_story', 'single-short-story');
    }
    

    /* =================================
        About
    ================================= */
    else if ($post->post_name  === $page_slugs['about']){
        super_simple_load('template_about', 'template-about');
    }
    /* =================================
        Contact
    ================================= */
    else if ($post->post_name  === $page_slugs['quiz']){
        super_simple_load('template_quiz', 'template-contact');
    }
}
// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'load_page_scripts' );


/* ==========================================
	NAVIGATION
============================================ */
function get_stripped_nav_items($theme_location) {
    // Returns responsive header html
    $nav_opts = [
        'container' => false,
        'theme_location' => 'main_menu',
        'echo' => false,
        'items_wrap' => '%3$s',
        'item_spacing' => 'discard',
        'fallback_cb' => false
    ];
    $wp_nav_items = wp_nav_menu($nav_opts);

    // Returns nav items only allowing <a> and <span>
    return strip_tags($wp_nav_items, '<a> <span>');
}

// Yes, I know you can pass this as one array. This is more straight forward to me.
if (function_exists('register_nav_menu')) 
{ 
    register_nav_menu('main_menu', 'Header');
}

/* ======================================
    ACTOR ARCHIVE
====================================== */
function search_cast($template)   
{    
  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search && $post_type == 'supporting-cast' )   
  {
    
    return locate_template('archive-supporting-cast.php'); 
  }   
  return $template;   
}
add_filter('template_include', 'search_cast');    

// $cast_per_page = 6;
// function custom_posts_per_page( $query ) {
//     global $cast_per_page;
//     if ( $query->is_archive('supporting-cast') ) {

//         set_query_var('posts_per_page', $cast_per_page);
//     }
// }
// add_action( 'pre_get_posts', 'custom_posts_per_page' );



/* ======================================
   REMOVE ITEMS FROM ADMIN BAR
====================================== */
function remove_admin_menu_pages() {
    //Posts
    remove_menu_page( 'edit.php' );
    //Comments
    remove_menu_page( 'edit-comments.php' );
    //Appearance
    remove_menu_page( 'themes.php' );
    //Users
    remove_menu_page( 'users.php' );
    //Tools
    remove_menu_page( 'tools.php' );
    //Settings
    remove_menu_page( 'options-general.php' );
    // Pages
    remove_menu_page( 'edit.php?post_type=page' );
    // Plugins
    remove_menu_page( 'plugins.php' );
};

function remove_admin_toolbar_buttons($wp_admin_bar) {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('search');
    $wp_admin_bar->remove_menu('edit');
}

// Check if user is admin
if( !current_user_can('administrator') ) { 
    // Remove side bar buttons
    add_action( 'admin_init', 'remove_admin_menu_pages' );
    // Remove toolbar buttons
    add_action('wp_before_admin_bar_render', 'remove_admin_toolbar_buttons', 999);
    // Remove custom field groups
    add_filter('acf/settings/show_admin', '__return_false');

}

/* ======================================
   ADMIN AREA CSS
====================================== */

// Article
function custom_admin_area() {
    add_editor_style('css/post-styles.style.css');
    add_editor_style('css/custom-admin-area.style.css');
}
add_action( 'after_setup_theme', 'custom_admin_area' );


// Custom login area
function custom_login_area() {
    load_style('login_custom_style', "custom-login.style.css");
}
add_action( 'login_enqueue_scripts', 'custom_login_area' );

// Remove site health dashboard
function remove_site_health_dashboard_widget()
{
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'remove_site_health_dashboard_widget');



/* ===============================================
    Change hardcode 'width' caption images to 
    'max-width' props
=============================================== */

/**
 * Filter to replace the [caption] shortcode text with HTML5 compliant code
 *
 * @return text HTML content describing embedded figure
 **/
function my_img_caption_shortcode_filter($val, $attr, $content = null)
{
    // Combine new attributes
    $new_attr = shortcode_atts([
            'id'    => '',
            'align' => '',
            'width' => '',
            'caption' => ''
        ], 
        $attr
    );

    // Extract variables
    $id =       $new_attr['id'];
    $align =    $new_attr['align'];
    $width =    $new_attr['width'];
    $caption =  $new_attr['caption'];

    // Catch no set width or no caption
    if ( 1 > (int) $width || empty($caption) ) return $val;

    // Build caption id
    $capid = '';
    if ( $id ) {
        $id = esc_attr($id);
        $capid = "id='figcaption_$id' ";
        $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
    }

    // Build max-width style from width
    $width_style = '';
    if ($width ) {
        $width_style = "style='max-width:" . $width . "px' ";
    }

    $final_html = "<figure $id $width_style class='wp-caption $align' >" .
        do_shortcode( $content ) . 
        "<figcaption $capid class='wp-caption-text'>$caption</figcaption>" .
    "</figure>";

    return $final_html;
}
add_filter('img_caption_shortcode', 'my_img_caption_shortcode_filter',10,3);



/* ==========================================================
    SEARCH ONLY POST TITLES 
    Kudos to this answer. 
    Surprisingly hard to find documentation for this.
========================================================== */
/**
 * Search SQL filter for matching against post title only.
 *
 * @link    http://wordpress.stackexchange.com/a/11826/1685
 *
 * @param   string      $search
 * @param   WP_Query    $wp_query
 */
function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}

add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );


// Custom function for "previous" and "next" post links being cross post-type
function custom_posttype_get_adjacent_ID($direction = 'next', $post_type = 'post', $current_post_id) {

    // Make sure post type is an array
    if( !is_array($post_type) ) $post_type = [$post_type];
    

    // Grab global wp_query
    global $wp_query;
    // Save current query
    $original_query = $wp_query;
    // Query args
    $query = [
        'post_type' => $post_type,
        'posts_per_page' => -1, 
        'orderby' => 'publish_date',
        'order' => 'DESC'
    ];
    // Run query
    $returned_query = new WP_Query( $query );

    $posts = $returned_query->posts;

    $postsLength = (count($posts) - 1);
    $currentIndex = 0;
    $index = 0;
    $result = 0;

    // Iterate all posts in order to find the current one
    foreach($posts as $p){
        if($p->ID == $current_post_id) $currentIndex = $index;
        $index++;
    }

    // Figure out needed index
    $new_index = 0;
    if($direction == 'prev') {
        $new_index = !$currentIndex ? $postsLength : $currentIndex - 1;
    } else {
        $new_index = $currentIndex == $postsLength ? 0 : $currentIndex + 1;
    }

     // Reset wp_query
     $wp_query = null;
     $wp_query = $original_query;
     wp_reset_postdata();  

    // Return post ID
    return $posts[$new_index]->ID;
}

// Get next link
function custom_next_post_link($current_post_id) {
    $found_post = custom_posttype_get_adjacent_ID('next', ['flash-fiction', 'short-story'], $current_post_id);
    return get_permalink($found_post);
}

// Get previous link
function custom_prev_post_link($current_post_id) {
    $found_post = custom_posttype_get_adjacent_ID('prev', ['flash-fiction', 'short-story'], $current_post_id);
    return get_permalink($found_post);
}
