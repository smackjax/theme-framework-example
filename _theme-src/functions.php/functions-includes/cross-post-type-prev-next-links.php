<?php

function custom_posttype_get_adjacent_ID($direction = 'next', $type = 'post', $current) {

    // Ensure type won't break the SQL query
    $type_as_array = is_array($type) ? $type : [$type];

    // Get all posts with this custom post type
    $posts = get_posts('posts_per_page=-1&order=DESC&post_type IN ' . $type);

    $postsLength = sizeof($posts)-1;
    $currentIndex = 0;
    $index = 0;
    $result = 0;

    // Iterate all posts in order to find the current one
    foreach($posts as $p){
        if($p->ID == $current) $currentIndex = $index;
        $index++;
    }

    // Figure out needed index
    $new_index = 0;
    if($direction == 'prev') {
        $new_index = !$currentIndex ? $postsLength : $currentIndex - 1;
    } else {
        $new_index = $currentIndex == $postsLength ? 0 : $currentIndex + 1;
    }

    // Return post ID
    return $posts[$new_index]->ID;
}

// Get next link
function next_post_link($type = 'post', $current_id) {
    $found_post = custom_posttype_get_adjacent_ID('next', $type, $current_id);
    return get_permalink($found_post);
}

// Get previous link
function prev_post_link($type = 'post', $current_id) {
    $found_post = custom_posttype_get_adjacent_ID('prev', $type, $current_id);
    return get_permalink($found_post);
}


