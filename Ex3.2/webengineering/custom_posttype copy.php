<?php
// custom_post_type.php

// information sources: 
// http://php.net/manual/de/function.include.php
// http://blog.teamtreehouse.com/create-your-first-wordpress-custom-post-type



// https://codex.wordpress.org/Function_Reference/add_theme_support

add_theme_support('post-thumbnails', ['post', 'portfolio']);

if (! function_exists("create_portfolio_post_type")) :
    function create_portfolio_post_type() {
        $labels = array(
            'name' => 'My Portfolio',
            'singular_name' => 'Portfolio Item',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Portfolio Item',
            'edit_item' => 'Edit Portfolio Item',
            'new_item' => 'New Portfolio Item',
            'view_item' => 'View Portfolio Item',
            'search_items' => 'Search Portfolio',
            'not_found' => 'Nothing found',
            'not_found_in_trash' => 'Nothing found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'My Portfolio'
        );
    
        $args = array(
            'label' => 'portfolio',
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'query_var' => true,
            //'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => 5,   // null
            'supports' => ['title','editor','thumbnail'],
            'register_meta_box_cb' => 'add_portfolio_posttype_metabox',
            'has_archive' => true,
        ); 
 
	    register_post_type( 'portfolio' , $args );
    
        register_taxonomy('custom_category', 'portfolio',  
            ["hierarchical" => true, "label" => "Types"]);
            
        
    }
    
    add_action('init', 'create_portfolio_post_type');
   
endif;   

////////// Metabox stuff ////////////

function add_portfolio_posttype_metabox() {
    add_meta_box('portfolio_metabox', 'Portfolio Data', 'portfolio_metabox', 'portfolio', 'normal');
}

function portfolio_metabox() {
    global $post;           // current post in "the loop"
    echo $post->ID . " " . $post->post_title;
    
    // this stuff is written to wp_postmeta with met_key = 'project_name' and the value, etc.
    $custom = get_post_custom($post->ID);
    $project_name = $custom['project_name'][0];
    $port_type = $custom['port_type'][0];
    /*
    $thumbnail = $custom['thumbnail'][0];
    $description = $custom['description'][0]; 
    */
?>
    
    <div class='portfolio'>
        <p> <label>Project Name<br><input type="text" name ="project_name" size="50"
            value="<?php echo $project_name; ?>"> </label>
        </p>
        <p> <label>Portfolio Type<br><input type="text" name ="port_type" size="50"
            value="<?php echo $port_type; ?>"> </label>
        </p>
        <!--
        <p> <label>Thumbnail<br><input type="text" name ="thumbnail" size="50"
            value="<?php echo $thumbnail; ?>"> </label>
        </p>
        <p> <label>Description<br><input type="text" name ="description" size="50"
            value="<?php echo $description; ?>"> </label>
        </p>
        -->
<?php
}

function portfolio_post_save_meta ($post_id, $post) {
    // editing allowed?
    if ( ! current_user_can( 'edit_post', $post->ID )) {
        return $post->ID;
    }
    
    $portfolio_post_meta['project_name'] = $_POST['project_name'];
    $portfolio_post_meta['port_type'] = $_POST['port_type'];
    $portfolio_post_meta['thumbnail'] = $_POST['thumbnail'];
    $portfolio_post_meta['description'] = $_POST['description'];
    
    // add values as custom fields
    foreach ($portfolio_post_meta as $key => $value) {
        if (get_post_meta($post->ID, $key, FALSE )) {
            update_post_meta($post->ID, $key, $value);
        }
        else {
            add_post_meta($post->ID, $key, $value);
        }
        if (! $value ) {
            // delete if blank
            delete_post_meta($post->ID, $key);
        }
    }
}

add_action('save_post', 'portfolio_post_save_meta', 1, 2);     // priority, nof args

// taken from: https://developer.wordpress.org/reference/functions/get_the_terms/

function the_portfolio_category( $id = false ) {
    $terms = get_the_terms(get_the_ID(), 'custom_category');
    if ( $terms && ! is_wp_error($terms)) {
        $cats = [];
        foreach ($terms as $term) {
            $cats[] = $term->name;
        }
        $catstr = join(',', $cats );
        //echo '<p>T: ' . $catstr . '</p>';
        return $catstr;
    }
    return '';
} 

function get_portfolio_categories($asString = false) {
    $categories = get_categories( [
        'taxonomy' => 'custom_category',
    ]);
    $res = [];
    if ($categories && ! is_wp_error($categories)) {
        foreach ($categories as $cat) {
            $res[] = $cat->name;
        }
        //$catstr = join(',', $res);
    }
    if ($asString) {
        return join(',', $res);
    }
    else {
        return $res;
    }
}

?>