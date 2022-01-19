<?php
add_theme_support( 'post-thumbnails' );

function wbiyoka_style_and_scripts() {
	wp_enqueue_style('custom_style', get_template_directory_uri() . '/assets/css/common.css', array(), '' );
	wp_enqueue_style('common_style', get_template_directory_uri() . '/assets/css/style.css', array(), '' );
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), null, true);
	wp_enqueue_script('index_script', get_template_directory_uri() . '/assets/js/index.js', array(), '' );
}
add_action( 'wp_enqueue_scripts' , 'wbiyoka_style_and_scripts' );





function get_data() {
	$args = array(
		'post_type' => 'animate',
		'post_status' => 'publish',
		'orderby' => 'title',
		'order' => 'ASC',
		'posts_per_page' => '-1'
	);

	$loop = new WP_Query($args);
	$items = array();

	while($loop->have_posts()) : $loop->the_post();
		
		$item['index'] = get_field('index');;
		$item['img_url'] = get_field('img_url');
		$item['url'] = get_field('url');
		$item['category'] = get_field('category');

		$items[] = $item;
		unset($item);
	endwhile;

	$items = json_encode($items);
    echo  $items;
    die();
}

add_action( 'wp_ajax_nopriv_get_data', 'get_data' );
add_action( 'wp_ajax_get_data', 'get_data' );








function print_log( $filename = "", $functionname = "", $tagname = "", $message = 'default') {
	global $wpdb;

	ob_start();
	var_dump($message);
	$result = ob_get_clean();

	$wpdb->insert(
		'wp_debug',
		array(
			'file' 		=> $filename,
			'tag' 		=> $functionname,
			'name' 		=> $tagname,
			'message' 	=> $result,
		)
	);
}

add_action("rest_insert_animate", function ($post, $request, $creating) {
    $metas = $request->get_param("meta");
    if (is_array($metas)) {
		$category = $metas['category'];
		$url = $metas['url'];
		update_post_meta($post->ID, $name, $value);
		update_field('category', $category, $post->ID);
		update_field('index', $metas['index'], $post->ID);
		update_field('url', $metas['url'], $post->ID);
		update_field('img_url', $metas['img_url'], $post->ID);
    }
}, 10, 3);
